<template>
    <div class="content">
       <div class="content-header" v-if="$gate.isAdminOrAssociated('purchase-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">ক্রয়ের তালিকা</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">স্টোর</router-link></li>
                  <li class="breadcrumb-item active">ক্রয়ের তালিকা</li>
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
              <div class="card-header">
                <h3 class="card-title">ক্রয়সমূহ</h3>

                <div class="card-tools">
                  <!-- <button type="button" class="btn btn-success btn-sm" @click="addModal" v-tooltip="'প্রি-অর্ডার করুন'">
                      <i class="fa fa-user-plus"></i>
                  </button> -->
                  <button type="button" class="btn btn-primary btn-sm" @click="addModal" v-tooltip="'নতুন পণ্য ক্রয় করুন'">
                      <i class="fa fa-cart-plus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body table-responsive p-0">

                <table class="table table-hover">
                 <thead>
                  <tr>
                    <!-- <th>ID</th> -->
                    <th>ক্রয় রশিদ নং</th>
                    <th width="15%">পণ্যসমূহ</th>
                    <th>ডিলার/ ভেন্ডর</th>
                    <th>প্রদেয়</th>
                    <th>পরিশোধিত</th>
                    <th>দেনা/ পরিশোধনীয়</th>
                    <th>সময় / তারিখ</th>
                    <th width="10%">ক্রিয়াকলাপ</th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr v-for="purchase in purchases.data" :key="purchase.id">
                    <!-- <td>{{ purchase.id }}</td> -->
                    <td>
                      {{ purchase.code }}
                    </td>
                    <td>
                      <span class="badge badge-pill badge-warning" v-for="stock in purchase.stocks" :key="stock.id">
                        {{ stock.product.name }} [{{ stock.buying_price }} ৳]
                      </span>
                    </td>
                    <td v-html="removeDuplicateVendor(purchase.stocks)">
                      
                    </td>
                    <td>
                      <small>
                        মোটঃ {{ purchase.total }} ৳ <br/>
                        ডিসকাউন্ট {{ purchase.discount }} {{ purchase.discount_unit }}<br/>
                        পরিশোধনীয় মূল্যঃ {{ purchase.payable }} ৳
                      </small>
                    </td>
                    <td>
                      {{ purchase.paid }} ৳
                    </td>
                    <td>
                      {{ purchase.due }} ৳
                    </td>
                    <td>
                      <small>{{ purchase.created_at | datetime }}</small>
                    </td>
                    <td>
                        <a :href="'/pdf/purchase/' + purchase.id" class="btn btn-primary btn-sm" v-tooltip="'ডাউনলোড করুন'">
                            <i class="fa fa-download"></i>
                        </a>
                        <!-- <button @click="printPurchase(purchase.id, purchase.code)" class="btn btn-success btn-sm" v-tooltip="'প্রিন্ট করুন'">
                            <i class="fa fa-print"></i>
                        </button> -->
                        <!-- <button @click="deletePurchase(purchase.id)" class="btn btn-danger btn-sm" v-tooltip="'পণ্য ডিলেট করুন'">
                            <i class="fa fa-trash"></i>
                        </button> -->
                        <!-- delete kora jaabe na -->
                    </td>
                  </tr>
                 </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="purchases" :limit="1" @pagination-change-page="getPaginationResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title" id="addModalLabel">পণ্য ক্রয়</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <form @submit.prevent="createPurchase()" @keydown="form.onKeydown($event)">
                <!-- Modal body -->
                <div class="modal-body">
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

                  <hr/>

                  <div class="row">
                    <div class="col-md-12">
                      <big>অতিরিক্ত খরচঃ (যদি থাকে)</big>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>খাত</label>
                        <select class="form-control" v-model="form.extraexpensecategory_id" name="extraexpensecategory_id"
                         :class="{ 'is-invalid': form.errors.has('extraexpensecategory_id') }">
                          <option value="" selected="" disabled="">খাত নির্ধারণ করুন</option>   
                          <option value="4">পণ্য পরিবহন খরচ</option>   
                          <option value="8">অন্যান্য</option>   
                        </select>
                        <has-error :form="form" field="extraexpensecategory_id"></has-error>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label>অতিরিক্ত খরচের পরিমাণ</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">৳</span>
                        </div>
                        <input v-model="form.extraexpenseamount" type="number" step="any" name="extraexpenseamount" placeholder="পরিশোধ"
                          class="form-control" :class="{ 'is-invalid': form.errors.has('extraexpenseamount') }">
                        <has-error :form="form" field="extraexpenseamount"></has-error>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">দাখিল করুন</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">ফিরে যান</button>
                </div>
              </form>
            </div>
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
            purchases: {},
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
              extraexpensecategory_id: '',
              extraexpenseamount: '',
            }),
            productunit: [],
            addformrange: [0],
            maxpaid: 0,
            nativemodal: true,
          }
      },
      methods: {
          addModal() {
            this.form.reset();
            $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });
            if(this.nativemodal) {
              this.$refs.productSelect[0].clearSelection();
              this.$refs.vendorSelect.clearSelection();
            }

            this.addformrange.splice(0, this.addformrange.length);
            this.addformrange.push(0);
            this.productunit[0] = '';

            this.loadProducts();
            this.loadVendors();
          },
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
          loadPurchases() {
            if(this.$gate.isAdminOrAssociated('purchase-page', this.$route.params.code)){
              axios.get('/api/load/purchase/' + this.$route.params.code).then(({ data }) => (this.purchases = data));
            }
          },
          removeDuplicateVendor(stocks) {
            var vendors = [];
            var markup = '';
            if(stocks) {
              for(var i=0; i<stocks.length; i++) {
                vendors.push(stocks[i].vendor.name);
              }
            }
            let unique = [...new Set(vendors)];
            unique.map(function(value, key) {
              markup += '<span class="badge badge-pill badge-info"> '+ value +'</span>'
            });
            return markup;
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
              $('#addModal').modal('hide')
              Fire.$emit('AfterPurchaseCreatedOrUpdated')
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
          deletePurchase(id) {
            swal.fire({
              title: 'আপনি কি নিশ্চিত?',
              text: "ডিলেট করলে আর ফেরত পাওয়া যাবে না!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'নিশ্চিত করছি',
              cancelButtonText: 'ফিরে যান'
            }).then((result) => {
                if (result.value) {
                   this.form.delete('/api/purchase/'+ id).then(() => {
                     swal.fire(
                      'ডিলেট',
                      'ডিলেট সফল হয়েছে!',
                      'success'
                      )
                     Fire.$emit('AfterPurchaseCreatedOrUpdated')
                   })
                   .catch(() => {
                     swal('Failed!', 'কিছু সমস্যা হচ্ছে, দুঃখিত!', 'warning');
                   }) 
                }

            })
          },
          printPurchase(id, code) {            
            // axios({
            //   method: 'get',
            //   url: '/api/pdf/purchase/' + id,
            //   responseType: 'arraybuffer'
            // }).then(function(response) {
            //   let blob = new Blob([response.data], { type: 'application/pdf' })
            //   let link = document.createElement('b')
            //   link.href = window.URL.createObjectURL(blob)
            //   link.download = 'Purchase_Receipt_'+ code +'.pdf'
            //   link.click()
            // })
          },
          getPaginationResults(page = 1) {
            axios.get('/api/load/purchase/'+ this.$route.params.code +'?page=' + page)
            .then(response => {
              this.purchases = response.data;
            });
          },
      },
      computed: {
        
      },
      created() {
          this.loadPurchases();
          
          Fire.$on('AfterPurchaseCreatedOrUpdated', () => {
              this.loadPurchases();
          });
          // Fire.$on('purchaseFromNavOpenModal', () => {
          //   this.nativemodal = false;
          //   setTimeout(() => this.addModal(), 500);
          // });

          Fire.$on('searching', () => {
              let query = this.$parent.$parent.search;
              if(query != '') {
                axios.get('/api/searchpurchase/' + query)
                .then((data) => {
                  this.purchases = data.data;
                })
                .catch(() => {

                })
              } else {
                this.loadPurchases();
              }
              
          });
      },
      beforeDestroy() {
        Fire.$off('AfterPurchaseCreatedOrUpdated')
        // Fire.$off('searching')
      }
  }
</script>
