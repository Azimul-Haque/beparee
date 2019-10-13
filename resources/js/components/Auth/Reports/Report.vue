<template>
    <div class="content">
       <div class="content-header" v-if="$gate.isAdminOrAssociated('reports-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">রিপোর্ট</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">স্টোর</router-link></li>
                  <li class="breadcrumb-item active">রিপোর্ট</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('reports-page', this.$route.params.code)">
        <div class="row">
          <div class="col-md-3">
            <div class="card card-outline card-primary">
              <div class="card-header text-primary">
                <i class="fa fa-cubes"></i> মালামাল রিপোর্ট
                <div class="card-tools">
                  
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                <form @submit.prevent="generateProductReport()" @keydown="productform.onKeydown($event)">
                  <div class="form-group">
                    <!-- <label>পণ্য নির্ধারণ করুন</label> -->
                    <v-select placeholder="পণ্য নির্ধারণ করুন" :options="products" :reduce="id => id" label="name" v-model="productform.product" ref='productSelect'>
                      <template #search="{attributes, events}">
                        <input
                          class="vs__search"
                          :required="!productform.product"
                          v-bind="attributes"
                          v-on="events"
                        />
                      </template>
                    </v-select>
                  </div>
                  <div class="form-group">
                    <!-- <label>রিপোর্টের ধরণ</label> -->
                    <select v-model="productform.report_type" name="report_type" placeholder="রিপোর্টের ধরণ" 
                      class="form-control" :class="{ 'is-invalid': productform.errors.has('report_type') }" required="" oninvalid="this.setCustomValidity('রিপোর্টের ধরণ নির্ধারণ করুন')" oninput="setCustomValidity('')">
                      <option value="" selected="" disabled="">রিপোর্টের ধরণ</option>
                      <option value="stock_list">স্টক তালিকা</option>
                      <option value="sales_list">বিক্রয়য়ের তালিকা</option>
                    </select>
                    <has-error :form="productform" field="report_type"></has-error>
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> রিপোর্ট ডাউনলোড</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-outline card-success">
              <div class="card-header text-success">
                <i class="fa fa-briefcase"></i> ক্রয়ের রিপোর্ট
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                <form @submit.prevent="generatePurchaseReport()" @keydown="purchaseform.onKeydown($event)">
                  <div class="form-group">
                    <v-select placeholder="ভেন্ডর/ ডিলার নির্ধারণ করুন" :options="vendors" :reduce="id => id" label="name" v-model="purchaseform.vendor" ref='productSelect'>
                      <template #search="{attributes, events}">
                        <input
                          class="vs__search"
                          :required="!purchaseform.vendor"
                          v-bind="attributes"
                          v-on="events"
                        />
                      </template>
                    </v-select>
                  </div>
                  <div class="form-group">
                    <vc-date-picker
                      v-model="purchaseform.start"
                      :input-props='{
                        placeholder: "শুরু তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': purchaseform.errors.has('date') }"
                    />
                    <has-error :form="purchaseform" field="date"></has-error>
                  </div>
                  <div class="form-group">
                    <vc-date-picker
                      v-model="purchaseform.end"
                      :input-props='{
                        placeholder: "শেষ তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': purchaseform.errors.has('date') }"
                    />
                    <has-error :form="purchaseform" field="date"></has-error>
                  </div>
                  <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-download"></i> রিপোর্ট ডাউনলোড</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-outline card-info">
              <div class="card-header text-info">
                <i class="fa fa-hourglass-start"></i> দেনার রিপোর্ট
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                <form @submit.prevent="generateDueReport()" @keydown="dueform.onKeydown($event)">
                  <div class="form-group">
                    <v-select placeholder="ভেন্ডর/ ডিলার নির্ধারণ করুন" :options="vendors" :reduce="id => id" label="name" v-model="dueform.vendor" ref='productSelect' v-on:input="checkCategoryIfAllForDueReport(dueform.vendor)">
                      <template #search="{attributes, events}">
                        <input
                          class="vs__search"
                          :required="!dueform.vendor"
                          v-bind="attributes"
                          v-on="events"
                        />
                      </template>
                    </v-select>
                  </div>
                  <div class="form-group" v-if="duereportallvendormode">
                    <vc-date-picker
                      v-model="dueform.start"
                      :input-props='{
                        placeholder: "শুরু তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': dueform.errors.has('date') }"
                    />
                    <has-error :form="dueform" field="date"></has-error>
                  </div>
                  <div class="form-group" v-if="duereportallvendormode">
                    <vc-date-picker
                      v-model="dueform.end"
                      :input-props='{
                        placeholder: "শেষ তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': dueform.errors.has('date') }"
                    />
                    <has-error :form="dueform" field="date"></has-error>
                  </div>
                  <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-download"></i> রিপোর্ট ডাউনলোড</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-outline card-warning">
              <div class="card-header text-warning">
                <i class="fa fa-balance-scale"></i> বিক্রয় রিপোর্ট
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                <form @submit.prevent="generateSaleReport()" @keydown="saleform.onKeydown($event)">
                  <div class="form-group">
                    <v-select placeholder="পণ্য নির্ধারণ করুন" :options="productsforsale" :reduce="id => id" label="name" v-model="saleform.product" ref='productSelect'>
                      <template #search="{attributes, events}">
                        <input
                          class="vs__search"
                          :required="!saleform.product"
                          v-bind="attributes"
                          v-on="events"
                        />
                      </template>
                    </v-select>
                  </div>
                  <div class="form-group">
                    <vc-date-picker
                      v-model="saleform.start"
                      :input-props='{
                        placeholder: "শুরু তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': saleform.errors.has('date') }"
                    />
                    <has-error :form="saleform" field="date"></has-error>
                  </div>
                  <div class="form-group">
                    <vc-date-picker
                      v-model="saleform.end"
                      :input-props='{
                        placeholder: "শেষ তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': saleform.errors.has('date') }"
                    />
                    <has-error :form="saleform" field="date"></has-error>
                  </div>
                  <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-download"></i> রিপোর্ট ডাউনলোড</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="card card-outline card-primary">
              <div class="card-header text-primary">
                <i class="fa fa-users"></i> কাস্টমার রিপোর্ট
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                <form @submit.prevent="generateCustomerReport()" @keydown="customerform.onKeydown($event)">
                  <div class="form-group">
                    <v-select placeholder="কাস্টমার নির্ধারণ করুন" :options="customers" :reduce="id => id" label="name" v-model="customerform.customer" ref='productSelect'>
                      <template #search="{attributes, events}">
                        <input
                          class="vs__search"
                          :required="!customerform.customer"
                          v-bind="attributes"
                          v-on="events"
                        />
                      </template>
                    </v-select>
                  </div>
                  <div class="form-group">
                    <vc-date-picker
                      v-model="customerform.start"
                      :input-props='{
                        placeholder: "শুরু তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': customerform.errors.has('date') }"
                    />
                    <has-error :form="customerform" field="date"></has-error>
                  </div>
                  <div class="form-group">
                    <vc-date-picker
                      v-model="customerform.end"
                      :input-props='{
                        placeholder: "শেষ তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': customerform.errors.has('date') }"
                    />
                    <has-error :form="customerform" field="date"></has-error>
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> রিপোর্ট ডাউনলোড</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-outline card-success">
              <div class="card-header text-success">
                <i class="fa fa-book"></i> বকেয়া/ হালখাতা রিপোর্ট
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                <form @submit.prevent="generateCustomerDueReport()" @keydown="customerdueform.onKeydown($event)">
                  <div class="form-group">
                    <v-select placeholder="কাস্টমার নির্ধারণ করুন" :options="customers" :reduce="id => id" label="name" v-model="customerdueform.customer" ref='productSelect' v-on:input="checkCategoryIfAllForCustomerDueReport(customerdueform.customer)">
                      <template #search="{attributes, events}">
                        <input
                          class="vs__search"
                          :required="!customerdueform.customer"
                          v-bind="attributes"
                          v-on="events"
                        />
                      </template>
                    </v-select>
                  </div>
                  <div class="form-group" v-if="customerduereportallmode">
                    <vc-date-picker
                      v-model="customerdueform.start"
                      :input-props='{
                        placeholder: "শুরু তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': customerdueform.errors.has('date') }"
                    />
                    <has-error :form="customerdueform" field="date"></has-error>
                  </div>
                  <div class="form-group" v-if="customerduereportallmode">
                    <vc-date-picker
                      v-model="customerdueform.end"
                      :input-props='{
                        placeholder: "শেষ তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': customerdueform.errors.has('date') }"
                    />
                    <has-error :form="customerdueform" field="date"></has-error>
                  </div>
                  <center v-if="!customerduereportallmode">
                    <h4>হালখাতার রিপোর্ট</h4>
                  </center>
                  <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-download"></i> রিপোর্ট ডাউনলোড</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-outline card-info">
              <div class="card-header text-info">
                <i class="fa fa-cogs"></i> খরচের রিপোর্ট
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                <form @submit.prevent="generateExpenseReport()" @keydown="expenseform.onKeydown($event)">
                  <div class="form-group">
                    <v-select placeholder="খরচের খাত নির্ধারণ করুন" :options="expensecategories" :reduce="id => id" label="name" v-model="expenseform.category" ref='productSelect'>
                      <template #search="{attributes, events}">
                        <input
                          class="vs__search"
                          :required="!expenseform.category"
                          v-bind="attributes"
                          v-on="events"
                        />
                      </template>
                    </v-select>
                  </div>
                  <div class="form-group">
                    <vc-date-picker
                      v-model="expenseform.start"
                      :input-props='{
                        placeholder: "শুরু তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': expenseform.errors.has('date') }"
                    />
                    <has-error :form="expenseform" field="date"></has-error>
                  </div>
                  <div class="form-group">
                    <vc-date-picker
                      v-model="expenseform.end"
                      :input-props='{
                        placeholder: "শেষ তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': expenseform.errors.has('date') }"
                    />
                    <has-error :form="expenseform" field="date"></has-error>
                  </div>
                  <center v-if="!customerduereportallmode">
                    <h4>হালখাতার রিপোর্ট</h4>
                  </center>
                  <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-download"></i> রিপোর্ট ডাউনলোড</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-outline card-warning">
              <div class="card-header text-warning">
                <i class="fa fa-vcard-o"></i> কর্মচারী বেতন রিপোর্ট
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                <form @submit.prevent="generateSalaryReport()" @keydown="staffsaralyform.onKeydown($event)">
                  <div class="form-group">
                    <v-select placeholder="কর্মচারী নির্ধারণ করুন" :options="staffsforatt" :reduce="id => id" label="name" v-model="staffsaralyform.staff" ref='productSelect'>
                      <template #search="{attributes, events}">
                        <input
                          class="vs__search"
                          :required="!staffsaralyform.staff"
                          v-bind="attributes"
                          v-on="events"
                        />
                      </template>
                    </v-select>
                  </div>
                  <div class="form-group">
                    <vc-date-picker
                      v-model="staffsaralyform.start"
                      :input-props='{
                        placeholder: "শুরু তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': staffsaralyform.errors.has('date') }"
                    />
                    <has-error :form="staffsaralyform" field="date"></has-error>
                  </div>
                  <div class="form-group">
                    <vc-date-picker
                      v-model="staffsaralyform.end"
                      :input-props='{
                        placeholder: "শেষ তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': staffsaralyform.errors.has('date') }"
                    />
                    <has-error :form="staffsaralyform" field="date"></has-error>
                  </div>
                  <center v-if="!customerduereportallmode">
                    <h4>হালখাতার রিপোর্ট</h4>
                  </center>
                  <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-download"></i> রিপোর্ট ডাউনলোড</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <div class="card card-outline card-primary">
              <div class="card-header text-primary">
                <i class="fa fa-vcard-o"></i> কর্মচারী উপস্থিতি রিপোর্ট
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                <form @submit.prevent="generateStaffReport()" @keydown="form.onKeydown($event)">
                  <div class="form-group">
                    <v-select placeholder="কর্মচারী নির্ধারণ করুন" :options="staffsforatt"  label="name" v-model="staffform.staff">
                      <template #search="{attributes, events}">
                        <input
                          class="vs__search"
                          :required="!staffform.staff"
                          v-bind="attributes"
                          v-on="events"
                        />
                      </template>
                    </v-select>
                  </div>
                  
                  <div class="form-group">
                    <v-select placeholder="মাস নির্ধারণ করুন" :options="months"  label="name" v-model="staffform.month">
                      <template #search="{attributes, events}">
                        <input
                          class="vs__search"
                          :required="!staffform.month"
                          v-bind="attributes"
                          v-on="events"
                        />
                      </template>
                    </v-select>
                  </div>
                  <div class="form-group">
                    <v-select placeholder="বছর নির্ধারণ করুন" :options="years"  label="name" v-model="staffform.year">
                      <template #search="{attributes, events}">
                        <input
                          class="vs__search"
                          :required="!staffform.year"
                          v-bind="attributes"
                          v-on="events"
                        />
                      </template>
                    </v-select>
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> রিপোর্ট ডাউনলোড</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-outline card-success">
              <div class="card-header text-success">
                <i class="fa fa-calendar-check-o"></i> দিনভিত্তিক লাভের রিপোর্ট
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                <form @submit.prevent="generateProfitReport()" @keydown="form.onKeydown($event)">
                  <div class="form-group">
                    <vc-date-picker
                      v-model="profitform.start"
                      :input-props='{
                        placeholder: "শুরু তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': profitform.errors.has('date') }"
                    />
                    <has-error :form="profitform" field="date"></has-error>
                  </div>
                  <div class="form-group">
                    <vc-date-picker
                      v-model="profitform.end"
                      :input-props='{
                        placeholder: "শেষ তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': profitform.errors.has('date') }"
                    />
                    <has-error :form="profitform" field="date"></has-error>
                  </div>
                  <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-download"></i> রিপোর্ট ডাউনলোড</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-outline card-info">
              <div class="card-header text-info">
                <i class="fa fa-calendar-check-o"></i> দৈনিক লেন-দেন রিপোর্ট
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                <form @submit.prevent="generateDailyReport()" @keydown="form.onKeydown($event)">
                  <div class="form-group">
                    <vc-date-picker
                      v-model="dailyform.date"
                      :input-props='{
                        placeholder: "তারিখ নির্ধারণ করুন",
                        readonly: true
                      }'
                      :masks='{ input: "MMMM DD, YYYY" }'
                      :class="{ 'form-control is-invalid': dailyform.errors.has('date') }"
                    />
                    <has-error :form="dailyform" field="date"></has-error>
                  </div>
                  <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-download"></i> রিপোর্ট ডাউনলোড</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
      <div v-if="!$gate.isAdminOrAssociated('reports-page', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
    <!-- /.content -->
</template>

<script>
  import moment from 'moment'
  export default {
    data () {
      return {
        products: [],
        vendors: [],
        productsforsale: [],
        customers: [],
        expensecategories: [],
        staffsforatt: [],
        years: [],
        months: ['জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'],
        productform: new Form({
          product: '',
          report_type: '',
          code: this.$route.params.code,
        }),
        purchaseform: new Form({
          vendor: '',
          start: '',
          end: '',
          code: this.$route.params.code,
        }),
        saleform: new Form({
          product: '',
          start: '',
          end: '',
          code: this.$route.params.code,
        }),
        dueform: new Form({
          vendor: '',
          start: '',
          end: '',
          code: this.$route.params.code,
        }),
        customerform: new Form({
          customer: '',
          start: '',
          end: '',
          code: this.$route.params.code,
        }),
        customerdueform: new Form({
          customer: '',
          start: '',
          end: '',
          code: this.$route.params.code,
        }),
        expenseform: new Form({
          category: '',
          start: '',
          end: '',
          code: this.$route.params.code,
        }),
        staffsaralyform: new Form({
          staff: '',
          start: '',
          end: '',
          code: this.$route.params.code,
        }),
        staffform: new Form({
          staff: '',
          month: '',
          year: ''
        }),
        profitform: new Form({
          start: '',
          end: '',
          code: this.$route.params.code,
        }),
        dailyform: new Form({
          date: '',
          code: this.$route.params.code,
        }),
        duereportallvendormode: true,
        customerduereportallmode: true,
      }
    },
    methods: {
      // product report...
      loadProducts() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          axios.get('/api/load/purchase/product/' + this.$route.params.code).then(({ data }) => (this.products = data));
        }
      },
      generateProductReport() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          window.location.href = '/pdf/product/report/' + this.productform.product['id'] + '/' + this.productform.report_type + '/' + this.$route.params.code;
        }
      },

      // purchase report...
      loadVendors() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          axios.get('/api/load/vendors/for/report/' + this.$route.params.code).then(({ data }) => (this.vendors = data));
        }
      },
      generatePurchaseReport() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          if(this.purchaseform.start == '' || this.purchaseform.end == '') {
            toast.fire({
              type: 'warning',
              title: 'তারিখ পূরণ করুন'
            })
          } else {
            window.location.href = '/pdf/purchase/report/' + this.purchaseform.vendor['id'] + '/' + moment(this.purchaseform.start).format('YYYY-MM-DD') + '/' + moment(this.purchaseform.end).format('YYYY-MM-DD') + '/' + this.$route.params.code;
          }
        }
      },
      // due report...
      generateDueReport() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          if(this.dueform.vendor.id != 0 && (this.dueform.start == '' || this.dueform.end == '')) {
            toast.fire({
              type: 'warning',
              title: 'তারিখ পূরণ করুন'
            })
          } else {
            window.location.href = '/pdf/due/report/' + this.dueform.vendor['id'] + '/' + moment(this.dueform.start).format('YYYY-MM-DD') + '/' + moment(this.dueform.end).format('YYYY-MM-DD') + '/' + this.$route.params.code;
          }
        }
      },
      checkCategoryIfAllForDueReport(vendor) {
        if(vendor && vendor.id == 0) {
          this.duereportallvendormode = false;
        } else {
          this.duereportallvendormode = true;
        }
      },
      // sale report...
      generateSaleReport() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          if(this.saleform.start == '' || this.saleform.end == '') {
            toast.fire({
              type: 'warning',
              title: 'তারিখ পূরণ করুন'
            })
          } else {
            window.location.href = '/pdf/sale/report/' + this.saleform.product['id'] + '/' + moment(this.saleform.start).format('YYYY-MM-DD') + '/' + moment(this.saleform.end).format('YYYY-MM-DD') + '/' + this.$route.params.code;
          }
        }
      },
      loadProductsForSale() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          axios.get('/api/load/product/for/sale/report/' + this.$route.params.code).then(({ data }) => (this.productsforsale = data));
        }
      },
      // customer report...
      generateCustomerReport() {
        if(this.customerform.start == '' || this.customerform.end == '') {
          toast.fire({
            type: 'warning',
            title: 'তারিখ পূরণ করুন'
          })
        } else {
          window.location.href = '/pdf/customer/report/' + + this.customerform.customer['id'] + '/' + moment(this.customerform.start).format('YYYY-MM-DD') + '/' + moment(this.customerform.end).format('YYYY-MM-DD') + '/' + this.$route.params.code;
        }
      },
      loadCustomerForReport() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          axios.get('/api/load/customers/for/report/' + this.$route.params.code).then(({ data }) => (this.customers = data));
        }
      },
      // customer due report
      generateCustomerDueReport() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          if(this.customerdueform.customer.id != 0 && (this.customerdueform.start == '' || this.customerdueform.end == '')) {
            toast.fire({
              type: 'warning',
              title: 'তারিখ পূরণ করুন'
            })
          } else {
            window.location.href = '/pdf/customer/due/report/' + this.customerdueform.customer['id'] + '/' + moment(this.customerdueform.start).format('YYYY-MM-DD') + '/' + moment(this.customerdueform.end).format('YYYY-MM-DD') + '/' + this.$route.params.code;
          }
        }
      },
      checkCategoryIfAllForCustomerDueReport(customer) {
        if(customer && customer.id == 0) {
          this.customerduereportallmode = false;
        } else {
          this.customerduereportallmode = true;
        }
      },
      // expense report
      generateExpenseReport() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          if(this.expenseform.start == '' || this.expenseform.end == '') {
            toast.fire({
              type: 'warning',
              title: 'তারিখ পূরণ করুন'
            })
          } else {
            window.location.href = '/pdf/expense/report/' + this.expenseform.category['id'] + '/' + moment(this.expenseform.start).format('YYYY-MM-DD') + '/' + moment(this.expenseform.end).format('YYYY-MM-DD') + '/' + this.$route.params.code;
          }
        }
      },
      loadExpenseCategories() 
      {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          axios.get('/api/load/expense/categories/for/report/' + this.$route.params.code).then(({ data }) => (this.expensecategories = data));
        }
      },
      // salary report
      generateSalaryReport() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          if(this.staffsaralyform.start == '' || this.staffsaralyform.end == '') {
            toast.fire({
              type: 'warning',
              title: 'তারিখ পূরণ করুন'
            })
          } else {
            window.location.href = '/pdf/salary/report/' + this.staffsaralyform.staff['id'] + '/' + moment(this.staffsaralyform.start).format('YYYY-MM-DD') + '/' + moment(this.staffsaralyform.end).format('YYYY-MM-DD') + '/' + this.$route.params.code;
          }
        }
      },
      // salary report
      generateProfitReport() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          if(this.profitform.start == '' || this.profitform.end == '') {
            toast.fire({
              type: 'warning',
              title: 'তারিখ পূরণ করুন'
            })
          } else {
            window.location.href = '/pdf/profit/report/' + moment(this.profitform.start).format('YYYY-MM-DD') + '/' + moment(this.profitform.end).format('YYYY-MM-DD') + '/' + this.$route.params.code;
          }
        }
      },
      // daily report
      generateDailyReport() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          if(this.dailyform.date == '') {
            toast.fire({
              type: 'warning',
              title: 'তারিখ পূরণ করুন'
            })
          } else {
            window.location.href = '/pdf/daily/report/' + moment(this.dailyform.date).format('YYYY-MM-DD') + '/' + this.$route.params.code;
          }
        }
      },
      // staff report...
      loadStaffsForAtt() {
          if(this.$gate.isAdminOrAssociated('staff-page', this.$route.params.code)){
            axios.get('/api/load/staff/for/attendance/report/' + this.$route.params.code).then(({ data }) => (this.staffsforatt = data));  
          }
      },
      loadYears() {
          var thisyear = new Date();
          for (var i = thisyear.getFullYear(); i >= 1990; i--) {
              this.years.push(i);
          }
      },
      generateStaffReport() {
        if(this.$gate.isAdminOrAssociated('reports-page', this.$route.params.code)){
          window.location.href = '/pdf/staff/report/' + this.staffform.staff['id'] + '/' + this.staffform.month + '/' + this.staffform.year + '/' + this.$route.params.code;
        }
      },

    },
    created() {
      this.loadProducts();
      this.loadVendors();
      this.loadProductsForSale();
      this.loadCustomerForReport();
      this.loadExpenseCategories();
      this.loadStaffsForAtt();
      this.loadYears();
    },
    beforeDestroy() {
      
    }
  }
</script>
