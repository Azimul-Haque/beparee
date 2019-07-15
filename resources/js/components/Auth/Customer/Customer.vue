<template>
    <div class="content">
      <div class="content-header" v-if="$gate.isAdminOrAssociated('customer-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">কাস্টমার বিবরণ</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#!">স্টোর</a></li>
                  <li class="breadcrumb-item"><a href="#!">কাস্টমার</a></li>
                  <li class="breadcrumb-item active">বিবরণ</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('customer-page', this.$route.params.code)">
        <div class="row">
          <div class="col-md-3">
            <div class="card">
              <div style="background: url('/images/customerscover.jpg') center center;">
                <div class="card-body text-light" style="background: rgba(0, 0, 128, 0.7);">
                  <h5 class="card-title" style="border-bottom: 1px solid #fff;">{{ customer.name }}</h5>
                  <p class="card-text">
                    <i class="fa fa-phone"></i> {{ customer.mobile }} <br/>
                    <i class="fa fa-map-marker"></i> {{ customer.address }} <br/>
                  </p>
                </div>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>মোট ক্রয়ঃ</b> {{ customer.total_purchase }} টি</li>
                <li class="list-group-item"><b>চলতি বকেয়াঃ</b> <span class="badge badge-danger">{{ customer.current_due }} ৳</span></li>
                <li class="list-group-item"><b>সর্বমোট বকেয়াঃ</b> <span class="badge badge-warning">{{ customer.total_due }} ৳</span></li>
                <li class="list-group-item"><b>সর্বমোট বকেয়া পরিশোধঃ</b> <span class="badge badge-primary">{{ customer.total_due_paid }} ৳</span></li>
              </ul>
              <div class="card-body">
                <center>
                  <button type="button" class="btn btn-primary btn-sm" @click="editCustomerModal(customer)" v-tooltip="'তথ্য হালনাগাদ করুন'">
                      <i class="fa fa-edit"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" @click="editModal(customer)" v-tooltip="'বকেয়া পরিশোধ করুন'" :disabled="customer.current_due <= 0">
                      <i class="fa fa-handshake-o"></i>
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
                      <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">বকেয়া তালিকা</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">ক্রয় তালিকা</a>
                  </li>
                </ul>
              </div>

              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                  <p class="card-text">
                    <div class="timeline-centered">
                      <article class="timeline-entry" v-for="customerdue in customerdues.data" :key="customerdue.id">
                        <div class="timeline-entry-inner">
                            <div v-if="customerdue.transaction_type == 0" class="timeline-icon bg-danger" v-tooltip="'বকেয়া'">
                                <i class="fa fa-hourglass-o"></i>
                            </div>
                            <div v-else class="timeline-icon bg-primary" v-tooltip="'পরিশোধ'">
                                <i class="fa fa-handshake-o"></i>
                            </div>

                            <div class="timeline-label shadow">
                                <span>
                                  <big v-if="customerdue.transaction_type == 0" class="text-red"><b>বকেয়া</b></big> 
                                  <big v-else class="text-green"><b>পরিশোধ</b></big> 
                                  | পরিমাণঃ {{ customerdue.amount }} ৳
                                </span><br/>

                                <span class="text-muted"><i class="fa fa-calendar"></i> {{ customerdue.created_at | datetime }}</span>
                            </div>
                          </div>
                      </article>
                    </div>
                  </p>
                  <div class="card-footer">
                    <pagination :data="customerdues" :limit="1" @pagination-change-page="getPaginationDueHistories"></pagination>
                  </div>        
                </div>
                <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
                  <p class="card-text">
                    <div class="card bg-light text-dark" v-for="sale in customerpurchases.data" :key="sale.id">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-10">
                            <div class="row">
                              <div class="col-md-6">
                                <i class="fa fa-ticket text-blue"></i> ক্রয় রশিদ নম্বরঃ <b>{{ sale.code }}</b><br/>
                                <i class="fa fa-calculator text-green"></i> মোট প্রদেয়ঃ <b>{{ sale.total_price }}</b><br/>
                                <i class="fa fa-tag text-orange"></i> ডিসকাউন্টঃ <b>{{ sale.discount }} {{ sale.discount_unit }}</b>
                              </div>
                              <div class="col-md-6">
                                <i class="fa fa-money text-teal"></i> পরিশোধনীয় মূল্যঃ <b>{{ sale.payable }}</b><br/>
                                <i class="fa fa-check-circle text-cyan"></i> পরিশোধিতঃ <b>{{ sale.paid }}</b><br/>
                                <i class="fa fa-clock-o text-red"></i> বকেয়াঃ <b>{{ sale.due }}</b>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <a :href="'/pdf/sale/' + sale.id" class="btn btn-primary btn-sm" data-toggle="tooltip" title="রশিদ ডাউনলোড করুন">
                              <i class="fa fa-download text-light"></i>
                            </a>
                            <button class="btn btn-success btn-sm" style="margin-left: 5px;" data-toggle="tooltip" title="রশিদ প্রিন্ট করুন">
                              <i class="fa fa-print"></i>
                            </button>
                          </div>
                        </div>
                        <small class="text-muted" style="border-top: 1px solid #DDD;"><i class="fa fa-calendar"></i> {{ sale.created_at | datetime }}</small>
                      </div>
                    </div>
                  </p>
                  <div class="card-footer">
                    <pagination :data="customerpurchases" :limit="1" @pagination-change-page="getPaginationPurchases"></pagination>
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
              <h4 class="modal-title" id="addModalLabel">বকেয়া পরিশোধ</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="updateCustomerDue()" @keydown="form.onKeydown($event)">
              <!-- Modal body -->
              <div class="modal-body">
                <div class="form-group">
                  <label>কাস্টমারের নাম</label>
                  <input v-model="form.name" type="text" name="name" placeholder="কাস্টমারের নাম" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" readonly="">
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label>চলতি বক্যেয়া</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">৳</span>
                    </div> 
                    <input v-model="form.current_due" type="number" step="any" name="current_due" placeholder="চলতি বক্যেয়া" 
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

      <!-- The Other Modal -->
      <div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog" aria-labelledby="editCustoemrModalLabel" aria-hidden="true">
        <div class="modal-dialog"> <!-- modal-lg -->
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title" id="editCustoemrModalLabel">কাস্টমার সম্পাদনা করুন</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="updateCustomer()" @keydown="formedit.onKeydown($event)">
              <!-- Modal body -->
              <div class="modal-body">
                <div class="form-group">
                  <label>কাস্টমারের নাম *</label>
                  <input v-model="formedit.name" type="text" name="name" placeholder="কাস্টমারের নাম *" 
                    class="form-control" :class="{ 'is-invalid': formedit.errors.has('name') }">
                  <has-error :form="formedit" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label>যোগাযোগের নম্বর (১১ ডিজিট)</label>
                  <input v-model="formedit.mobile" type="number" name="mobile" placeholder="যোগাযোগের নম্বর" 
                    class="form-control" :class="{ 'is-invalid': formedit.errors.has('mobile') }" onkeypress="if(this.value.length==11) return false;">
                  <has-error :form="formedit" field="mobile"></has-error>
                </div>
                <div class="form-group">
                  <label>ঠিকানা</label>
                  <input v-model="formedit.address" type="text" name="address" placeholder="ঠিকানা" 
                    class="form-control" :class="{ 'is-invalid': formedit.errors.has('address') }">
                  <has-error :form="formedit" field="address"></has-error>
                </div>
                <div class="form-group">
                  <label>জাতীয় পরিচয়পত্র নম্বর (ঐচ্ছিক)</label>
                  <input v-model="formedit.nid" type="number" name="nid" placeholder="জাতীয় পরিচয়পত্র নম্বর" 
                    class="form-control" :class="{ 'is-invalid': formedit.errors.has('nid') }" onkeypress="if(this.value.length==17) return false;">
                  <has-error :form="formedit" field="nid"></has-error>
                </div>
                <input type="hidden" v-model="formedit.code" name="code">
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
      <div v-if="!$gate.isAdminOrAssociated('customer-page', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
              customer: {},
              maxpayable: 0,
              customerdues: {},
              customerpurchases: {},
              // Create a new form instance
              formedit: new Form({
                id: '',
                name: '',
                address: '',
                mobile: '',
                nid: '',
                code: this.$route.params.code,
              }),
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
            loadCustomer() {
                if(this.$gate.isAdminOrAssociated('customer-page', this.$route.params.code)){
                  axios.get('/api/load/single/customer/' + this.$route.params.id + '/' + this.$route.params.code).then(({ data }) => (
                    this.customer = data
                  ));
                }
            },
            loadCustomerdues() {
                if(this.$gate.isAdminOrAssociated('customer-page', this.$route.params.code)){
                  axios.get('/api/load/single/customer/dues/' + this.$route.params.id + '/' + this.$route.params.code).then(({ data }) => (
                    this.customerdues = data
                    // _.orderBy(data, 'id', 'desc')
                  ));
                }
            },
            loadCustomerPurchases() {
                if(this.$gate.isAdminOrAssociated('customer-page', this.$route.params.code)){
                  axios.get('/api/load/single/customer/purchases/' + this.$route.params.id + '/' + this.$route.params.code).then(({ data }) => (
                    this.customerpurchases = data
                    // _.orderBy(data, 'id', 'desc')
                  ));
                }
            },
            getPaginationDueHistories(page = 1) {
              axios.get('/api/load/single/customer/dues/' + this.$route.params.id + '/' + this.$route.params.code + '?page=' + page)
              .then(response => {
                this.customerdues = response.data;
              });
            },
            getPaginationPurchases(page = 1) {
              axios.get('/api/load/single/customer/purchases/' + this.$route.params.id + '/' + this.$route.params.code + '?page=' + page)
              .then(response => {
                this.customerpurchases = response.data;
              });
            },
            editCustomerModal(customer) {
                this.formedit.reset(); // clears fields
                this.formedit.clear(); // clears errors
                $('#editCustomerModal').modal({ show: true, backdrop: 'static', keyboard: false });

                this.formedit.fill(customer);               
            },
            editModal(customer) {
                this.form.reset(); // clears fields
                this.form.clear(); // clears errors
                $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });

                this.form.fill(customer); 
                this.maxpayable = customer.current_due;                
            },
            updateCustomer() {
                this.$Progress.start();
                this.formedit.put('/api/customer/'+ this.formedit.id).then(() => {
                  $('#editCustomerModal').modal('hide')
                  Fire.$emit('AfterCustomerUpdated')
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
            updateCustomerDue() {
                this.$Progress.start();
                this.form.put('/api/load/customer/pay/due/'+ this.form.id).then(() => {
                  $('#addModal').modal('hide')
                  Fire.$emit('AfterCustomerUpdated')
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
            
        },
        created() {
            this.loadCustomer();
            this.loadCustomerdues();
            this.loadCustomerPurchases();

            Fire.$on('AfterCustomerUpdated', () => {
                this.loadCustomer();
                this.loadCustomerdues();
                this.loadCustomerPurchases();
            });
            Fire.$on('changingstorename', () => {
                this.loadCustomer();
                this.loadCustomerdues();
                this.loadCustomerPurchases();
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
            //       this.loadCustomer();
            //       this.loadCustomerdues();
            //       this.loadCustomerPurchases();
            //     }
                
            // });
        },
        beforeDestroy() {
          Fire.$off('AfterCustomerUpdated')
          Fire.$off('changingstorename')
          // Fire.$off('searching')
        }
    }
</script>
