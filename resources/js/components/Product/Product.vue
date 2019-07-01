<template>
    <div class="content">
      <div class="content-header" v-if="$gate.isAuthorized('product-page')">
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
      <div class="container-fluid" v-if="$gate.isAuthorized('product-page')">
        <div class="row">
          <div class="col-md-3">
            <div class="card">
              <div style="background: url('/images/storecover.jpg') center center;">
                <div class="card-body text-light" style="background: rgba(0, 0, 128, 0.7);">
                  <h5 class="card-title" style="border-bottom: 1px solid #fff;">{{ product.name }}</h5>
                  <p class="card-text">
                    <b>ব্র্যান্ড/ মার্কাঃ</b> {{ product.brand }} <br/>
                    <b>ধরণঃ</b> <span v-if="product.productcategory">{{ product.productcategory.name }}</span>
                          <span v-else>loading...</span><br/>
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
                          <div class="col-md-9">
                            <div class="row">
                              <div class="col-md-6">
                                <i class="fa fa-industry text-blue"></i> ডিলার/ ভেন্ডরঃ <b>{{ stock.vendor.name }}</b><br/>
                                <i class="fa fa-archive text-green"></i> স্টকের পরিমাণঃ <big>{{ stock.quantity }}</big> {{ product.unit }}
                              </div>
                              <div class="col-md-6">
                                <i class="fa fa-money text-blue"></i> ক্রয়মূল্যঃ {{ stock.buying_price }} ৳/{{ product.unit }}<br/>
                                <i class="fa fa-shopping-bag text-orange"></i> বিক্রয়মূল্যঃ {{ stock.selling_price }} ৳/{{ product.unit }}
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <button class="btn btn-sm btn-primary"><i class="fa fa-edit" v-tooltip="'স্টকটি সম্পাদনা করুন'"></i></button>
                            <button class="btn btn-sm btn-success"><i class="fa fa-retweet"  v-tooltip="'স্টকটি ফেরত দিন'"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"  v-tooltip="'স্টকটি ডিলেট করে দিন'"></i></button>
                          </div>
                        </div><br/>
                        <small class="text-muted" style="border-top: 1px solid #DDD;">
                          সিস্টেমে প্রবেশের তারিখঃ {{ stock.created_at | datetime }}
                        </small>
                      </div>
                    </div>
                  </p>         
                </div>
                <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
                  <p class="card-text"> on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>              
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="!$gate.isAuthorized('product-page')">
          <forbidden-403></forbidden-403>
      </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
              product: {},
              // Create a new form instance
              // form: new Form({
              //   id: '',
              //   name: '',
              //   address: '',
              //   mobile: '',
              //   code: this.$route.params.id,
              // }),
              // editmode: false
            }
        },
        methods: {
            loadProduct() {
                if(this.$gate.isAuthorized('vendor-page')){
                  axios.get('/api/load/single/product/' + this.$route.params.id).then(({ data }) => (this.product = data));  
                }
            },

            addModal() {
                this.editmode = false;
                this.form.reset();
                $('#addModal').modal('show');
            },
            editModal(vendor) {
                this.editmode = true;
                this.form.reset(); // clears fields
                this.form.clear(); // clears errors
                $('#addModal').modal('show');

                this.form.fill(vendor);                
            },
            
            
            // createVendor() {
            //     this.$Progress.start();
            //     this.form.post('/api/vendor').then(() => {
            //       $('#addModal').modal('hide')
            //       Fire.$emit('AfterProductStockUpdated')
            //       toast.fire({
            //         type: 'success',
            //         title: 'সফলভাবে সংরক্ষণ করা হয়েছে!'
            //       })
            //       this.$Progress.finish();
            //     })
            //     .catch(() => {
            //         this.$Progress.fail();
            //     })
            // },
            // updateVendor() {
            //     this.$Progress.start();
            //     this.form.put('/api/vendor/'+ this.form.id).then(() => {
            //       $('#addModal').modal('hide')
            //       Fire.$emit('AfterProductStockUpdated')
            //       toast.fire({
            //         type: 'success',
            //         title: 'সফলভাবে হালনাগাদ করা হয়েছে!'
            //       })
            //       this.$Progress.finish();
            //     })
            //     .catch(() => {
            //         this.$Progress.fail();
            //         // swal('Failed!', 'There was something wrong', 'warning');
            //     })
            // },
            // deleteVendor(id) {
            //     swal.fire({
            //       title: 'Are you sure?',
            //       text: "You won't be able to revert this!",
            //       type: 'warning',
            //       showCancelButton: true,
            //       confirmButtonColor: '#3085d6',
            //       cancelButtonColor: '#d33',
            //       confirmButtonText: 'Yes, delete it!'
            //     }).then((result) => {
            //         if (result.value) {
            //            this.form.delete('/api/vendor/'+ id).then(() => {
            //              swal.fire(
            //               'Wait...!',
            //               'এই মুহূর্তে ডিলেট বন্ধ আছে!',
            //               'success'
            //               )
            //              Fire.$emit('AfterProductStockUpdated')
            //            })
            //            .catch(() => {
            //              swal('Failed!', 'There was something wrong', 'warning');
            //            }) 
            //         }

            //     })
            // },
            // getPaginationResults(page = 1) {
            //   axios.get('/api/vendor?page=' + page)
            //   .then(response => {
            //     this.product = response.data;
            //   });
            // }
        },
        created() {
            this.loadProduct();
            
            Fire.$on('AfterProductStockUpdated', () => {
                this.loadProduct();
            });
            Fire.$on('changingstorename', () => {
                this.loadProduct();
            });

            Fire.$on('searching', () => {
                let query = this.$parent.search;
                if(query != '') {
                  axios.get('/api/searchstore/' + query)
                  .then((data) => {
                    this.product = data.data;
                  })
                  .catch(() => {

                  })
                } else {
                  this.loadVendors();
                }
                
            });
        },
        beforeDestroy() {
          Fire.$off('AfterProductStockUpdated')
          Fire.$off('changingstorename')
          // Fire.$off('searching')
        }
    }
</script>
