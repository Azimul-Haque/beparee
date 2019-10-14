<template>
    <div class="content">
       <div class="content-header" v-if="$gate.isAdminOrAssociated('purchase-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">পণ্য ক্রয়</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">স্টোর</router-link></li>
                  <li class="breadcrumb-item active">পণ্য ক্রয়</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('purchase-page', this.$route.params.code)">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <form @submit.prevent="createPurchase()" @keydown="form.onKeydown($event)">
                <div class="card-header">
                  <h3 class="card-title">পণ্য ক্রয় করুন</h3>

                  <div class="card-tools">

                  </div>
                </div>
                <!-- /.card-header -->
                
                <div class="card-body">
                  <div v-for="(range, index) in addformrange">
                    <div class="row" v-bind:id="range">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>পণ্য নির্ধারণ করুন <!-- {{ range }} {{ index }} --></label>
                          <v-select placeholder="পণ্য নির্ধারণ করুন" :options="products" :reduce="id => id" label="name" v-model="form.product[index]" ref='productSelect' @input="productSelected(form.product[index], index)">
                            <template #search="{attributes, events}">
                              <input
                                class="vs__search"
                                :required="!form.product[index]"
                                v-bind="attributes"
                                v-on="events"
                              />
                            </template>
                          </v-select>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>পরিমাণ <span v-html="productunit[index]"></span></label>
                          <input v-model="form.quantity[index]" type="number" step="any" name="quantity" placeholder="স্টকের পরিমাণ" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }" @change="calculatePurchase" required="" oninvalid="this.setCustomValidity('স্টকের পরিমাণ লিখুন')" oninput="setCustomValidity('')">
                          <has-error :form="form" field="quantity"></has-error>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label>ক্রয়মূল্য/ ইউনিট</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">৳</span>
                          </div>
                          <input v-model="form.buying_price[index]" type="number" step="any" name="buying_price" placeholder="ক্রয়মূল্য/ ইউনিট" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('buying_price') }" @change="calculatePurchase" required="" oninvalid="this.setCustomValidity('ক্রয়মূল্য/ ইউনিট লিখুন')" oninput="setCustomValidity('')">
                          <has-error :form="form" field="buying_price"></has-error>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label>বিক্রয়মূল্য/ ইউনিট</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">৳</span>
                          </div>
                          <input v-model="form.selling_price[index]" type="number" step="any" name="selling_price" placeholder="বিক্রয়মূল্য/ ইউনিট"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('selling_price') }" required="" oninvalid="this.setCustomValidity('বিক্রয়মূল্য/ ইউনিট লিখুন')" oninput="setCustomValidity('')">
                          <has-error :form="form" field="selling_price"></has-error>
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-group">
                          <label style="color: #fff">.</label><br/>
                          <button v-if="index != 0" class="btn btn-danger btn-sm" type="button" @click="removeProduct(index, range)" v-tooltip="'মুছে দিন'"><i class="fa fa-trash"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-11"></div>
                    <div class="col-md-1">
                      <button class="btn btn-success btn-sm" type="button" @click="appendProduct" v-tooltip="'আরও পণ্য যোগ করুন'"><i class="fa fa-plus"></i></button><br/><br/>
                    </div>
                  </div>
                  
                  <hr/>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>ডিলার/ভেন্ডর নির্ধারণ</label> <!-- taggable kora nai ei muhurte... kore felte hobe (অপশনে না থাকলে লিখুন) -->
                        <v-select placeholder="ডিলার/ভেন্ডর" :options="vendors" :reduce="id => id" label="name" v-model="form.vendor" ref='vendorSelect'>
                          <template #search="{attributes, events}">
                            <input
                              class="vs__search"
                              :required="!form.vendor"
                              v-bind="attributes"
                              v-on="events"
                            />
                          </template>
                        </v-select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label>সর্বমোট মূল্য</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">৳</span>
                        </div>
                        <input v-model="form.total" type="number" step="any" name="total" placeholder="সর্বমোট মূল্য" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('total') }" @change="calculatePayable">
                        <has-error :form="form" field="total"></has-error>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label>ডিসকাউন্ট</label>
                      <div class="input-group mb-3">
                        <input v-model="form.discount" type="number" step="any" name="discount" placeholder="ডিসকাউন্ট"
                          class="form-control" :class="{ 'is-invalid': form.errors.has('discount') }" autocomplete="off" style="width: 60%" @change="calculatePayable">
                        <select class="form-control input-group-append" v-model="form.discount_unit" name="discount_unit" @change="calculatePayable">
                          <option value="%">%</option>
                          <option value="৳">৳</option>
                        </select>
                        <has-error :form="form" field="discount"></has-error>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <label>পরিশোধনীয় মূল্য</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">৳</span>
                        </div>
                        <input v-model="form.payable" type="number" step="any" name="payable" placeholder="পরিশোধনীয় মূল্য" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('payable') }" readonly="">
                        <has-error :form="form" field="payable"></has-error>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label>পরিশোধ</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">৳</span>
                        </div>
                        <input v-model="form.paid" type="number" step="any" name="paid" placeholder="পরিশোধ"
                          class="form-control" :class="{ 'is-invalid': form.errors.has('paid') }" @change="calculatePayable" :max="maxpaid">
                        <has-error :form="form" field="paid"></has-error>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label>দেনা/ পরিশোধনীয়</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">৳</span>
                        </div>
                        <input v-model="form.due" type="number" step="any" name="due" placeholder="দেনা/ পরিশোধনীয়"
                          class="form-control" :class="{ 'is-invalid': form.errors.has('due') }" readonly="">
                        <has-error :form="form" field="due"></has-error>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success">দাখিল করুন</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
      <div v-if="!$gate.isAdminOrAssociated('purchase-page', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
    <!-- /.content -->
</template>

<script>
  export default {
      data () {
          return {
            products: [],
            vendors: [],
            // Create a new form instance
            form: new Form({
              id: '',
              code: this.$route.params.code,
              product: [],
              vendor: '',
              expire_date: [],
              quantity: [],
              buying_price: [],
              selling_price: [],
              total: '',
              discount_unit: '%',
              discount: '',
              payable: '',
              paid: '',
              due: '',
            }),
            productunit: [],
            addformrange: [0],
            maxpaid: 0,
            nativemodal: true,
          }
      },
      methods: {
          loadProducts() {
            if(this.$gate.isAdminOrAssociated('purchase-page', this.$route.params.code)){
              axios.get('/api/load/purchase/product/' + this.$route.params.code).then(({ data }) => (this.products = data));
            }
          },
          loadVendors() {
            if(this.$gate.isAdminOrAssociated('purchase-page', this.$route.params.code)){
              axios.get('/api/load/product/vendor/' + this.$route.params.code).then(({ data }) => (this.vendors = data));  
            }
          },
          appendProduct() {
            this.addformrange.push(parseInt(this.addformrange[this.addformrange.length - 1] || 0) + 1);
            console.log(this.addformrange);  
          },
          removeProduct(index, range) {
            $('#'+range).remove();
            // this.addformrange.splice(index, 1); // splice deletes from the last...
            // this.$delete(this.addformrange, index);
            this.form.product[index] = null;
            this.form.quantity[index] = 0;
            this.form.buying_price[index] = 0;
            this.form.selling_price[index] = 0;
            this.productunit[index] = '';

            this.calculatePurchase();

            // console.log(this.addformrange);
          },
          productSelected(product, index) {
            if(product) {
              this.productunit[index] = '<span style="color: red;">(' + product.unit + ')</span>';
            }
          },
          createPurchase() {
            this.$Progress.start();
            this.form.post('/api/purchase').then(() => {
              // Fire.$emit('AfterPurchaseCreatedOrUpdated')
              this.$router.push({name: 'purchasesPage', params: { code: this.$route.params.code }});
              toast.fire({
                type: 'success',
                title: 'সফলভাবে সংরক্ষণ করা হয়েছে!'
              })
              this.$Progress.finish();
            })
            .catch(() => {
                this.$Progress.fail();
            })
          },
          calculatePurchase() {
            var total = parseFloat(0.00);
            var discounted_total = parseFloat(0.00);
            var quantity = parseFloat(0.00);
            var buying_price = parseFloat(0.00);
            for(var i = 0; i < this.addformrange.length; i++) {
              quantity = parseFloat(this.form.quantity[i]) || 0;
              buying_price = parseFloat(this.form.buying_price[i]) || 0;
              var per_total =  quantity * buying_price;
              total = parseFloat(total) + parseFloat(per_total);
            }
            var discount_unit = this.form.discount_unit;
            var discount = parseFloat(this.form.discount) || 0;
            
            var discount_amount = parseFloat(0);

            if(discount > 0){
                if(discount_unit == '%'){
                    discount_amount = (discount * total) / 100;
                }else if(discount_unit == '৳'){
                    discount_amount = discount;
                }
            }
            discounted_total = total - discount_amount;

            if(total > 0){
              this.form.total =  total.toFixed(2);
              this.form.payable =  discounted_total.toFixed(2);
            } else {
              this.form.total =  0;
              this.form.payable =  0;
            }

            // call the below function to change the value of payable and due...
            this.calculatePayable();
          },
          calculatePayable() {
            var total = parseFloat(this.form.total) || 0;
            var paid = parseFloat(this.form.paid) || 0;

            var discount_unit = this.form.discount_unit;
            var discount = parseFloat(this.form.discount) || 0;
            var discount_amount = parseFloat(0);

            var discounted_total = total;

            if(discount > 0){
                if(discount_unit == '%'){
                    discount_amount = (discount * total) / 100;
                }else if(discount_unit == '৳'){
                    discount_amount = discount;
                }
            }
            discounted_total = total - discount_amount;

            this.form.payable =  discounted_total.toFixed(2);
            this.maxpaid = discounted_total.toFixed(2);

            var due = parseFloat(discounted_total) - parseFloat(paid);

            if(due < 0){
                due = 0;
            }
            this.form.due =  due.toFixed(2);
          },
      },
      computed: {
        
      },
      created() {
          this.loadProducts();
          this.loadVendors();
          
          // Fire.$on('AfterPurchaseCreatedOrUpdated', () => {
          //                 this.loadVendors();
          //                 this.loaVendors();
          // });
      },
      beforeDestroy() {
        // Fire.$off('AfterPurchaseCreatedOrUpdated')
        // Fire.$off('searching')
      }
  }
</script>
