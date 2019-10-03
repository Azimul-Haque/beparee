<template>
    <div class="content">
      <div class="content-header" v-if="$gate.isAdminOrAssociated('product-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">পণ্যের বিবরণ</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#!">স্টোর</a></li>
                  <li class="breadcrumb-item"><a href="#!">পণ্য</a></li>
                  <li class="breadcrumb-item active">পণ্যের বিবরণ</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('product-page', this.$route.params.code)">
        <div class="row">
          <div class="col-md-3">
            <div class="card">
              <div style="background: url('/images/storecover.jpg') center center;">
                <div class="card-body text-light" style="background: rgba(0, 0, 128, 0.7);">
                  <h5 class="card-title" style="border-bottom: 1px solid #fff;">{{ product.name }}</h5>
                  <p class="card-text">
                    <b>ব্র্যান্ড/ মার্কাঃ</b> {{ product.brand }} <br/>
                    <b>ধরণঃ</b> 
                      <span v-if="product.productcategory">{{ product.productcategory.name }}</span>
                      <span v-else>লোড হচ্ছে...</span><br/>
                    <b>কোডঃ</b> {{ product.sku }}<br/>
                    <b>এককঃ</b> {{ product.unit }}<br/>
                  </p>
                </div>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>স্টকঃ</b> {{ product.stocks | totalquantity }} {{ product.unit }}</li>
                <li class="list-group-item"><b>ক্রয়মূল্যঃ</b> </li>
                <li class="list-group-item"><b>বিক্রয়যোগ্য মোট মূল্যঃ</b> </li>
              </ul>
              <div class="card-body">
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="card">
              <div class="card-header tab-card-header">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">স্টক তালিকা</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">বিক্রয়ের ইতিবৃত্ত</a>
                  </li>
                </ul>
              </div>

              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                  <p class="card-text">
                    <div class="card bg-light text-dark" v-for="stock in product.stocks">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-10">
                            <div class="row">
                              <div class="col-md-6">
                                <i class="fa fa-industry text-blue"></i> ডিলার/ ভেন্ডরঃ <b>{{ stock.vendor.name }}</b><br/>
                                <i class="fa fa-truck text-secondary"></i> প্রাথমিক স্টকঃ <big>{{ stock.quantity }}</big> {{ product.unit }}<br/>
                                <i class="fa fa-archive text-green"></i> স্টকের পরিমাণঃ <big>{{ stock.current_quantity }}</big> {{ product.unit }}
                              </div>
                              <div class="col-md-6">
                                <i class="fa fa-money text-blue"></i> ক্রয়মূল্যঃ {{ stock.buying_price }} ৳/{{ product.unit }}<br/>
                                <i class="fa fa-shopping-bag text-orange"></i> বিক্রয়মূল্যঃ {{ stock.selling_price }} ৳/{{ product.unit }}
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <button @click="editModal(stock)" class="btn btn-sm btn-primary"><i class="fa fa-edit" v-tooltip="'স্টকটি সম্পাদনা করুন'"></i></button>
                            <button class="btn btn-sm btn-success"><i class="fa fa-retweet"  v-tooltip="'স্টকটি ফেরত দিন'"></i></button>
                            <!-- <button @click="deleteStock(stock.id)" class="btn btn-sm btn-danger"><i class="fa fa-trash"  v-tooltip="'স্টকটি ডিলেট করে দিন'"></i></button> -->
                          </div>
                        </div>
                        <small class="text-muted" style="border-top: 1px solid #DDD;">
                          সিস্টেমে প্রবেশের তারিখঃ {{ stock.created_at | datetime }}
                        </small>
                      </div>
                    </div>
                  </p>         
                </div>
                <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
                  <p class="card-text">
                    <div class="card bg-light text-dark" v-for="item in productsales.data" :key="item.id">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-10">
                            <div class="row">
                              <div class="col-md-6">
                                <i class="fa fa-ticket text-blue"></i> ক্রয় রশিদ নম্বরঃ <b>{{ item.sale.code }}</b><br/>
                                <i class="fa fa-user text-green"></i> কাস্টমারঃ 
                                <b>
                                  <router-link :to="{ name: 'singleCustomer', params: { id: item.sale.customer.id, code: code }}" v-tooltip="'বিস্তারিত দেখুন'">
                                    {{ item.sale.customer.name }}
                                  </router-link>
                                </b><br/>
                              </div>
                              <div class="col-md-6">
                                <i class="fa fa-balance-scale text-cyan"></i> পরিমাণঃ <b>{{ item.quantity }} {{ product.unit }}</b><br/>
                                <i class="fa fa-tag text-orange"></i> বিক্রয়মূল্যঃ <b>{{ item.unit_price }} ৳/{{ product.unit }}</b>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <a :href="'/pdf/sale/' + item.sale.id" class="btn btn-primary btn-sm" v-tooltip="'রশিদ ডাউনলোড করুন'">
                              <i class="fa fa-download text-light"></i>
                            </a>
                            <button class="btn btn-success btn-sm" style="margin-left: 5px;" v-tooltip="'রশিদ প্রিন্ট করুন'">
                              <i class="fa fa-print"></i>
                            </button>
                          </div>
                        </div>
                        <small class="text-muted" style="border-top: 1px solid #DDD;"><i class="fa fa-calendar"></i> {{ item.sale.created_at | datetime }}</small>
                      </div>
                    </div>
                  </p>
                  <div class="card-footer">
                    <pagination :data="productsales" :limit="1" @pagination-change-page="getPaginationProductSales"></pagination>
                  </div>      
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- The Modal -->
      <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog"> <!-- modal-lg -->
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title" id="addModalLabel">স্টক সম্পাদনা করুন</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="updateStock()" @keydown="form.onKeydown($event)">
              <!-- Modal body -->
              <div class="modal-body">
                <div class="form-group">
                  <label class="form-label semibold">বিক্রয়মূল্য/ {{ product.unit }}</label>
                  <input v-model="form.selling_price" type="text" name="selling_price" placeholder="ঠিকানা" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('selling_price') }">
                  <has-error :form="form" field="selling_price"></has-error>
                </div>
                <!-- <div class="form-group">
                  <input v-model="form.expiry_date" type="number" name="expiry_date" placeholder="যোগাযোগের নম্বর" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('expiry_date') }" onkeypress="if(this.value.length==11) return false;">
                  <has-error :form="form" field="expiry_date"></has-error>
                </div> -->
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">হালনাগাদ করুন</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">ফিরে যান</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div v-if="!$gate.isAdminOrAssociated('product-page', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
              product: {},
              productsales: {},
              code: this.$route.params.code,
              // Create a new form instance
              form: new Form({
                id: '',
                expiry_date: '',
                selling_price: ''
              }),
              // editmode: false
            }
        },
        methods: {
            loadProduct() {
                if(this.$gate.isAdminOrAssociated('product-page', this.$route.params.code)){
                  axios.get('/api/load/single/product/' + this.$route.params.id + '/' + this.$route.params.code).then(({ data }) => (
                    this.product = data
                    // _.reverse(this.product.stocks)
                    // _.orderBy(this.product.stocks, ['id'], ['desc'])
                  ));  
                }
            },
            loadProductSales() {
                if(this.$gate.isAdminOrAssociated('product-page', this.$route.params.code)){
                  axios.get('/api/load/single/product/sales/' + this.$route.params.id + '/' + this.$route.params.code).then(({ data }) => (
                    this.productsales = data
                  ));  
                }
            },
            getPaginationProductSales(page = 1) {
              axios.get('/api/load/single/product/sales/' + + this.$route.params.id + '/' + this.$route.params.code + '?page=' + page)
              .then(response => {
                this.productsales = response.data;
              });
            },
            editModal(stock) {
                this.form.reset(); // clears fields
                this.form.clear(); // clears errors
                $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });

                this.form.fill(stock);                
            },
            updateStock() {
                this.$Progress.start();
                this.form.post('/api/single/product/stock/update/'+ this.form.id).then(() => {
                  $('#addModal').modal('hide')
                  Fire.$emit('AfterProductStockUpdated')
                  toast.fire({
                    type: 'success',
                    title: 'সফলভাবে হালনাগাদ করা হয়েছে!'
                  })
                  this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                    // swal('Failed!', 'There was something wrong', 'warning');
                })
            },
            deleteStock(id) {
                swal.fire({
                  title: 'নিশ্চিত ভাবে স্টক ডিলেট করতে চান?',
                  text: "ডিলেট নিশ্চিতকরণ",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'হ্যাঁ, নিশ্চিত করছি',
                  cancelButtonText: 'ফিরে যান'
                }).then((result) => {
                    if (result.value) {
                       this.form.delete('/api/single/product/stock/delete/'+ id).then(() => {
                         swal.fire(
                          'সফল!',
                          'সফলভাবে ডিলেট করা হয়েছে!',
                          'success'
                          )
                         Fire.$emit('AfterProductStockUpdated')
                       })
                       .catch(() => {
                         swal('Failed!', 'কিছু সমস্যা হয়েছে, দুঃখিত!', 'warning');
                       }) 
                    }

                })
            },
        },
        created() {
            this.loadProduct();
            this.loadProductSales();

            Fire.$on('AfterProductStockUpdated', () => {
                this.loadProduct();
                this.loadProductSales();
            });
            Fire.$on('changingstorename', () => {
                this.loadProduct();
                this.loadProductSales();
            });

            // Fire.$on('searching', () => {
            //     let query = this.$parent.search;
            //     if(query != '') {
            //       axios.get('/api/searchstore/' + query)
            //       .then((data) => {
            //         this.product = data.data;
            //       })
            //       .catch(() => {

            //       })
            //     } else {
            //       this.loadProduct();
            //       this.loadProductSales();
            //     }
                
            // });
        },
        beforeDestroy() {
          Fire.$off('AfterProductStockUpdated')
          Fire.$off('changingstorename')
          // Fire.$off('searching')
        }
    }
</script>
