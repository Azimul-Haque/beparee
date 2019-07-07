<template>
    <div class="content">
      <div class="content-header" v-if="$gate.isAuthorized('vendor-page')">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">ডিলার/ ভেন্ডর বিবরণ</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#!">স্টোর</a></li>
                  <li class="breadcrumb-item"><a href="#!">ডিলার</a></li>
                  <li class="breadcrumb-item active">বিবরণ</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAuthorized('vendor-page')">
        <div class="row">
          <div class="col-md-3">
            <div class="card">
              <div style="background: url('/images/vendorscover.jpg') center center;">
                <div class="card-body text-light" style="background: rgba(80, 0, 0, 0.75);">
                  <h5 class="card-title" style="border-bottom: 1px solid #fff;">{{ vendor.name }}</h5>
                  <p class="card-text">
                    <i class="fa fa-phone"></i> {{ vendor.mobile }} <br/>
                    <i class="fa fa-map-marker"></i> {{ vendor.address }} <br/>
                  </p>
                </div>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>মোট ক্রয়ঃ</b> {{ vendor.total_purchase }} টি</li>
                <li class="list-group-item"><b>চলতি দেনাঃ</b> <span class="badge badge-danger">{{ vendor.current_due }} ৳</span></li>
                <li class="list-group-item"><b>সর্বমোট দেনাঃ</b> <span class="badge badge-warning">{{ vendor.total_due }} ৳</span></li>
                <li class="list-group-item"><b>সর্বমোট দেনা পরিশোধঃ</b> <span class="badge badge-primary">{{ vendor.total_due_paid }} ৳</span></li>
              </ul>
              <div class="card-body">
                <center>
                  <button type="button" class="btn btn-success btn-sm" @click="editModal(vendor)" v-tooltip="vendor.name+'-কে পরিশোধ করুন'" :disabled="vendor.current_due <= 0">
                      <i class="fa fa-handshake-o"></i> দেনা পরিশোধ করুন
                  </button>
                </center>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <div class="card">
              <div class="card-header tab-card-header">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">দেনা তালিকা</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">ক্রয় তালিকা</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="Two" aria-selected="false">ফেরত তালিকা</a>
                  </li>
                </ul>
              </div>

              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                  <p class="card-text">
                    <div class="timeline-centered">
                      <article class="timeline-entry" v-for="duehistory in duehistories" :key="duehistory.id">
                        <div class="timeline-entry-inner">
                            <div v-if="duehistory.transaction_type == 0" class="timeline-icon bg-danger" v-tooltip="'দেনা'">
                                <i class="fa fa-hourglass-o"></i>
                            </div>
                            <div v-else class="timeline-icon bg-primary" v-tooltip="'পরিশোধ'">
                                <i class="fa fa-handshake-o"></i>
                            </div>

                            <div class="timeline-label shadow">
                                <!-- <h2>
                                  <a href="#"><b>{{ vendor.name }}</b></a>
                                  <span></span>
                                </h2> -->
                                <span>
                                  <big v-if="duehistory.transaction_type == 0" class="text-red"><b>দেনা</b></big> 
                                  <big v-else class="text-green"><b>পরিশোধ</b></big> 
                                  | পরিমাণঃ {{ duehistory.amount }} ৳
                                </span><br/>

                                <span class="text-muted"><i class="fa fa-calendar"></i> {{ duehistory.created_at | datetime }}</span>
                            </div>
                          </div>
                      </article>
                    </div>
                  </p>         
                </div>
                <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
                  <p class="card-text" v-html="removeDuplicatePurchase(vendor.stocks)">
                    
                  </p>
                </div>
                <div class="tab-pane fade p-3" id="three" role="tabpanel" aria-labelledby="three-tab">
                  <p class="card-text">
                    <center>
                      কাজ চলছে...<br/><br/>
                      <img src="/images/in_progress.svg" class="img-fluid" style="height: 300px; width: auto;">
                    </center>
                  </p>          
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
              <h4 class="modal-title" id="addModalLabel">বকেয়া পরিশোধ করুন</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="updateVendor()" @keydown="form.onKeydown($event)">
              <!-- Modal body -->
              <div class="modal-body">
                <div class="form-group">
                  <label>ডিলার/ ভেন্ডরের নাম</label>
                  <input v-model="form.name" type="text" name="name" placeholder="ডিলার/ ভেন্ডরের নাম" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" readonly="">
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label>চলতি দেনা</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">৳</span>
                    </div> 
                    <input v-model="form.current_due" type="number" step="any" name="current_due" placeholder="চলতি দেনা" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('current_due') }" readonly="">
                    <has-error :form="form" field="current_due"></has-error>
                  </div>
                </div>
                <div class="form-group">
                  <label>পরিশোধের পরিমাণ</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">৳</span>
                    </div> 
                    <input v-model="form.amount_paying" type="number" step="any" name="amount_paying" placeholder="পরিশোধের পরিমাণ" 
                      class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paying') }" :min="0" :max="this.maxpayable">
                    <has-error :form="form" field="amount_paying"></has-error>
                  </div>
                </div>
                <div class="form-group">
                  <label>মন্তব্য (ঐচ্ছিক)</label>
                  <input v-model="form.remark" type="text" name="remark" placeholder="মন্তব্য (ঐচ্ছিক)" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('remark') }">
                  <has-error :form="form" field="remark"></has-error>
                </div>
                <input type="hidden" v-model="form.code" name="code">
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
      <div v-if="!$gate.isAuthorized('vendor-page')">
          <forbidden-403></forbidden-403>
      </div>
    </div>
</template>

<script>
    import moment from 'moment'   

    export default {
        data () {
            return {
              vendor: {},
              maxpayable: 0,
              duehistories: [],
              // Create a new form instance
              form: new Form({
                id: '',
                name: '',
                current_due: '',
                amount_paying: '',
                remark: '',
                code: this.$route.params.code,
              }),
              // editmode: false
            }
        },
        methods: {
            loadVendor() {
                if(this.$gate.isAuthorized('vendor-page')){
                  axios.get('/api/load/single/vendor/' + this.$route.params.id + '/' + this.$route.params.code).then(({ data }) => (
                    this.vendor = data,
                    this.duehistories = _.orderBy(data.duehistories, 'id', 'desc')
                  ));
                }
            },
            editModal(vendor) {
                this.form.reset(); // clears fields
                this.form.clear(); // clears errors
                $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });

                this.form.fill(vendor); 
                this.maxpayable = vendor.current_due;                
            },
            updateVendor() {
                this.$Progress.start();
                this.form.put('/api/load/vendor/pay/due/'+ this.form.id).then(() => {
                  $('#addModal').modal('hide')
                  Fire.$emit('AfterVendorUpdated')
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
            removeDuplicatePurchase(stocks) {
                        var purchases = [];
                        var markup = '';
                        if(stocks) {
                          for(var i=0; i<stocks.length; i++) {
                            purchases.push(stocks[i].purchase);
                          }
                        }
                        // uniquify array of OBJECTS, then orders it, it's lodash!
                        var uniqueArray = _.map(
                            _.uniq(
                                _.map(purchases, function(obj){
                                    return JSON.stringify(obj);
                                })
                            ), function(obj) {
                                return JSON.parse(obj);
                            }
                        );
                        uniqueArray = _.orderBy(uniqueArray, 'id', 'desc');

                        uniqueArray.map(function(purchase, key) {
                          markup += '<div class="card bg-light text-dark" >'
                                    +'<div class="card-body">'
                                      +'<div class="row">'
                                        +'<div class="col-md-10">'
                                          +'<div class="row">'
                                            +'<div class="col-md-6">'
                                              +'<i class="fa fa-ticket text-blue"></i> ক্রয় রশিদ নম্বরঃ <b>'+ purchase.code +'</b><br/>'
                                              +'<i class="fa fa-calculator text-green"></i> মোট প্রদেয়ঃ <b>'+ purchase.total +'</b><br/>'
                                              +'<i class="fa fa-tag text-orange"></i> ডিসকাউন্টঃ <b>'+ purchase.discount +' '+ purchase.discount_unit +'</b>'
                                            +'</div>'
                                            +'<div class="col-md-6">'
                                              +'<i class="fa fa-money text-teal"></i> পরিশোধনীয় মূল্যঃ <b>'+ purchase.payable +'</b><br/>'
                                              +'<i class="fa fa-check-circle text-cyan"></i> পরিশোধিতঃ <b>'+ purchase.paid +'</b><br/>'
                                              +'<i class="fa fa-clock-o text-red"></i> দেনা/ পরিশোধনীয়ঃ <b>'+ purchase.due +'</b>'
                                            +'</div>'
                                          +'</div>'
                                        +'</div>'
                                        +'<div class="col-md-2">'
                                          +'<a href="/pdf/purchase/'+ purchase.id +'" class="btn btn-primary btn-sm" data-toggle="tooltip" title="রশিদ ডাউনলোড করুন">'
                                              +'<i class="fa fa-download text-light"></i>'
                                          +'</a>'
                                          +'<button class="btn btn-success btn-sm" style="margin-left: 5px;" data-toggle="tooltip" title="রশিদ প্রিন্ট করুন">'
                                              +'<i class="fa fa-print"></i>'
                                          +'</button>'
                                        +'</div>'
                                      +'</div>'
                                      +'<small class="text-muted" style="border-top: 1px solid #DDD;">'
                                        +'<i class="fa fa-calendar"></i> '+ moment(purchase.created_at).format('MMMM DD, YYYY hh:mm A')
                                      +'</small>'
                                    +'</div>'
                                  +'</div>'
                        });

                        return markup;
                      },
        },
        created() {
            this.loadVendor();

            Fire.$on('AfterVendorUpdated', () => {
                this.loadVendor();
            });
            Fire.$on('changingstorename', () => {
                this.loadVendor();
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
            //       this.loadVendor();
            //     }
                
            // });
        },
        beforeDestroy() {
          Fire.$off('AfterVendorUpdated')
          Fire.$off('changingstorename')
          // Fire.$off('searching')
        }
    }
</script>
