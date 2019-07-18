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
              <div class="card-header">
                <h3 class="card-title text-primary"><i class="fa fa-cubes"></i> মালামাল রিপোর্ট</h3>
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
              <div class="card-header">
                <h3 class="card-title text-success"><i class="fa fa-briefcase"></i> ক্রয়ের রিপোর্ট</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                The body of the card
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-outline card-info">
              <div class="card-header text-info">
                <h3 class="card-title"><i class="fa fa-hourglass-start"></i> দেনার রিপোর্ট</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                The body of the card
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-outline card-warning">
              <div class="card-header text-warning">
                <h3 class="card-title"><i class="fa fa-balance-scale"></i> বিক্রয় রিপোর্ট</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                The body of the card
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="card card-outline card-primary">
              <div class="card-header text-primary">
                <h3 class="card-title"><i class="fa fa-users"></i> কাস্টমার রিপোর্ট</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                The body of the card
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-outline card-success">
              <div class="card-header text-success">
                <h3 class="card-title"><i class="fa fa-book"></i> বকেয়ার রিপোর্ট</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                The body of the card
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-outline card-info">
              <div class="card-header text-success">
                <h3 class="card-title"><i class="fa fa-cogs"></i> খরচের রিপোর্ট</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                The body of the card
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-outline card-warning">
              <div class="card-header text-success">
                <h3 class="card-title"><i class="fa fa-truck"></i> ডিলার/ ভেন্ডর রিপোর্ট</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: block;">
                The body of the card
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
        productform: new Form({
          product: '',
          report_type: '',
          code: this.$route.params.code,
        }),
      }
    },
    methods: {
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
    },
    created() {
      this.loadProducts();
    },
    beforeDestroy() {
      
    }
  }
</script>
