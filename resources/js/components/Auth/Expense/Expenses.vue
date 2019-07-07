<template>
    <div class="content">
       <div class="content-header" v-if="$gate.isAdminOrAssociated('due-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">খরচের হিসাব</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">স্টোর</router-link></li>
                  <li class="breadcrumb-item active">খরচের হিসাব</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('due-page', this.$route.params.code)">
        <div class="row">
          <div class="col-md-8">
            <!-- <img src="images/click_here_2li1.svg" style="max-height: 200px;"> -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">খরচ তালিকা</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" @click="addModal" v-tooltip="'নতুন খরচ যোগ করুন'">
                      <i class="fa fa-user-plus"></i>
                  </button>
                  <!-- data-toggle="modal" data-target="#addModal" -->
                  <!-- <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  </div> -->
                </div>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                 <thead>
                  <tr>
                    <!-- <th>ID</th> -->
                    <th>খাতের নাম</th>
                    <th>মোট খরচের পরিমাণ</th>
                    <th>সর্বমোট খরচ</th>
                    <th width="10%">ক্রিয়াকলাপ</th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr v-for="expense in expenses.data" :key="expense.id">
                    <!-- <td>{{ store.id }}</td> -->
                    <td>
                      <!-- <router-link :to="{ name: 'singleStore', params: { token: store.token, code: store.code }}">
                        {{ store.name }}
                      </router-link> -->
                      <router-link :to="{ name: 'singleVendor', params: { id: expense.id, code: code }}" v-tooltip="'বিস্তারিত দেখুন'">
                        {{ expense.expensecategory.name }}
                      </router-link>
                    </td>
                    <td><span class="badge badge-warning">{{ expense.totalamount.toFixed(2) }} ৳</span></td>
                    <td>{{ expense.count }} বার</td>
                    <td>
                      <router-link :to="{ name: 'singleVendor', params: { id: expense.id, code: code }}" class="btn btn-success btn-sm" v-tooltip="'বিস্তারিত দেখুন'">
                        <i class="fa fa-eye"></i>
                      </router-link>
                    </td>
                  </tr>
                  
                 </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="expenses" @pagination-change-page="getPaginationResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-4">
            <!-- <img src="images/click_here_2li1.svg" style="max-height: 200px;"> -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">খরচ সময়রেখা</h3>

                <div class="card-tools">
                  <!-- <button type="button" class="btn btn-primary btn-sm" @click="addModal" v-tooltip="'নতুন ডিলার / ভেন্ডর যোগ করুন'">
                      <i class="fa fa-user-plus"></i>
                  </button> --> <!-- data-toggle="modal" data-target="#addModal" -->
                  <!-- <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  </div> -->
                </div>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body p-2">
                <div class="timeline-centered">
                  <article class="timeline-entry" v-for="expense in expensehistories.data" :key="expense.id">
                      <div class="timeline-entry-inner">
                          <div v-if="expense.expensecategory_id == 1" class="timeline-icon bg-success" v-tooltip="expense.expensecategory.name">
                              <i class="fa fa-user-o"></i>
                          </div>
                          <div v-else-if="expense.expensecategory_id == 2" class="timeline-icon bg-primary" v-tooltip="expense.expensecategory.name">
                              <i class="fa fa-plug"></i>
                          </div>
                          <div v-else-if="expense.expensecategory_id == 3" class="timeline-icon bg-info" v-tooltip="expense.expensecategory.name">
                              <i class="fa fa-fire"></i>
                          </div>
                          <div v-else-if="expense.expensecategory_id == 4" class="timeline-icon bg-warning" v-tooltip="expense.expensecategory.name">
                              <i class="fa fa-truck"></i>
                          </div>
                          <div v-else-if="expense.expensecategory_id == 5" class="timeline-icon bg-danger" v-tooltip="expense.expensecategory.name">
                              <i class="fa fa-home"></i>
                          </div>
                          <div v-else-if="expense.expensecategory_id == 6" class="timeline-icon bg-secondary" v-tooltip="expense.expensecategory.name">
                              <i class="fa fa-motorcycle"></i>
                          </div>
                          <div v-else-if="expense.expensecategory_id == 7" class="timeline-icon bg-dark" v-tooltip="expense.expensecategory.name">
                              <i class="fa fa-coffee"></i>
                          </div>
                          <div v-else class="timeline-icon bg-primary" v-tooltip="expense.expensecategory.name">
                              <i class="fa fa-star"></i>
                          </div>

                          <div class="timeline-label shadow">
                              <span v-if="expense.expensecategory_id == 1">
                                <big class="text-secondary">{{ expense.expensecategory.name }}</big> |
                                <span class="text-green"><b>{{ expense.staff.name }}</b></span>
                                | পরিমাণঃ <b>{{ expense.amount }}</b> ৳</span>
                              <span v-else><big class="text-secondary">{{ expense.expensecategory.name }}</big> | পরিমাণঃ <b>{{ expense.amount }}</b> ৳</span><br/>
                              <span class="text-muted"><i class="fa fa-calendar"></i> {{ expense.created_at | datetime }}</span>
                          </div>
                      </div>
                  </article>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="expensehistories" @pagination-change-page="getPaginationExpensehistories"></pagination>
              </div>
            </div>
            <!-- /.card -->
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
      </div><!-- /.container-fluid -->
      <div v-if="!$gate.isAdminOrAssociated('due-page', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
    <!-- /.content -->
</template>

<script>
    export default {
        data () {
            return {
              expenses: {},
              expensehistories: {},
              maxpayable: 0,
              code: this.$route.params.code,
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
            addModal() {
                this.form.reset();
                $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });

                // this.loadCategories();
                // this.loadStaff();
            },
            editModal(vendor) {
                this.form.reset(); // clears fields
                this.form.clear(); // clears errors
                $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });

                this.form.fill(vendor); 
                this.maxpayable = vendor.current_due;             
            },
            
            loadExpenses() {
                if(this.$gate.isAdminOrAssociated('due-page', this.$route.params.code)){
                  axios.get('/api/load/expense/' + this.$route.params.code).then(({ data }) => (this.expenses = data));  
                }
            },
            updateVendor() {
                this.$Progress.start();
                this.form.put('/api/load/vendor/pay/due/'+ this.form.id).then(() => {
                  $('#addModal').modal('hide')
                  Fire.$emit('AfterExpensesCreatedOrUpdated')
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
            deleteVendor(id) {
                swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                       this.form.delete('/api/vendor/'+ id).then(() => {
                         swal.fire(
                          'Wait...!',
                          'এই মুহূর্তে ডিলেট বন্ধ আছে!',
                          'success'
                          )
                         Fire.$emit('AfterExpensesCreatedOrUpdated')
                       })
                       .catch(() => {
                         swal('Failed!', 'There was something wrong', 'warning');
                       }) 
                    }

                })
            },
            getPaginationResults(page = 1) {
              axios.get('/api/load/expense/' + this.$route.params.code + '?page=' + page)
              .then(response => {
                this.expenses = response.data;
              });
            },
            loadExpensehistories() {
              if(this.$gate.isAdminOrAssociated('due-page', this.$route.params.code)){
                axios.get('/api/load/expense/history/' + this.$route.params.code).then(({ data }) => (this.expensehistories = data));  
              }
            },
            getPaginationExpensehistories(page = 1) {
              axios.get('/api/load/expense/history/' + this.$route.params.code + '?page=' + page)
              .then(response => {
                this.expensehistories = response.data;
              });
            },
        },
        created() {
            this.loadExpenses();
            this.loadExpensehistories();
            
            Fire.$on('AfterExpensesCreatedOrUpdated', () => {
                this.loadExpenses();
                this.loadExpensehistories();
            });
            Fire.$on('changingstorename', () => {
                this.loadExpenses();
                this.loadExpensehistories();
            });

            Fire.$on('searching', () => {
                let query = this.$parent.$parent.search;
                if(query != '') {
                  axios.get('/api/searchvendor/' + query)
                  .then((data) => {
                    this.expenses = data;
                  })
                  .catch(() => {

                  })
                } else {
                  this.loadExpenses();
                }
                
            });
        },
        beforeDestroy() {
          Fire.$off('AfterExpensesCreatedOrUpdated')
          Fire.$off('changingstorename')
          // Fire.$off('searching')
        }
    }
</script>