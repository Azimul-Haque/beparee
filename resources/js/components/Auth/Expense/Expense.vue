<template>
    <div class="content">
      <div class="content-header" v-if="$gate.isAdminOrAssociated('expense-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">খরচের বিবরণ</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#!">স্টোর</a></li>
                  <li class="breadcrumb-item"><a href="#!">খরচ</a></li>
                  <li class="breadcrumb-item active">বিবরণ</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('expense-page', this.$route.params.code)">
        <div class="row">
          <div class="col-md-3">
            <div class="card">
              <div style="background: url('/images/expensecover.jpg') center center;">
                <div class="card-body text-light" style="background: rgba(200, 66, 10, 0.75);">
                  <h5 class="card-title" style="border-bottom: 1px solid #fff;">{{ expensecategory.name }}</h5>
                  <p class="card-text">
       
                  </p>
                </div>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>খরচের সংখ্যাঃ</b> {{ totalexpensecount }} টি</li>
                <li class="list-group-item"><b>মোট খরচঃ</b> <span class="badge badge-warning">{{ totalexpenseamount }} ৳</span></li>
              </ul>
              <!-- <div class="card-body">
                
              </div> -->
            </div>
          </div>
          <div class="col-md-9">
            <!-- <img src="images/click_here_2li1.svg" style="max-height: 200px;"> -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ expensecategory.name }}-এর সময়রেখা</h3>

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
                  <article class="timeline-entry" v-for="expense in expenses.data" :key="expense.id">
                      <div class="timeline-entry-inner">
                          <div v-if="expensecategory.id == 1" class="timeline-icon bg-success" v-tooltip="expensecategory.name">
                              <i class="fa fa-user-o"></i>
                          </div>
                          <div v-else-if="expensecategory.id == 2" class="timeline-icon bg-primary" v-tooltip="expensecategory.name">
                              <i class="fa fa-plug"></i>
                          </div>
                          <div v-else-if="expensecategory.id == 3" class="timeline-icon bg-info" v-tooltip="expensecategory.name">
                              <i class="fa fa-fire"></i>
                          </div>
                          <div v-else-if="expensecategory.id == 4" class="timeline-icon bg-warning" v-tooltip="expensecategory.name">
                              <i class="fa fa-truck"></i>
                          </div>
                          <div v-else-if="expensecategory.id == 5" class="timeline-icon bg-danger" v-tooltip="expensecategory.name">
                              <i class="fa fa-home"></i>
                          </div>
                          <div v-else-if="expensecategory.id == 6" class="timeline-icon bg-secondary" v-tooltip="expensecategory.name">
                              <i class="fa fa-motorcycle"></i>
                          </div>
                          <div v-else-if="expensecategory.id == 7" class="timeline-icon bg-dark" v-tooltip="expensecategory.name">
                              <i class="fa fa-coffee"></i>
                          </div>
                          <div v-else class="timeline-icon bg-primary" v-tooltip="expensecategory.name">
                              <i class="fa fa-star"></i>
                          </div>

                          <div class="timeline-label shadow">
                              <span v-if="expensecategory.id == 1">
                                <span class="text-green">
                                  <router-link :to="{ name: 'singleStaff', params: { id: expense.staff.id, code: code }}" v-tooltip="'প্রোফাইল দেখুন'">
                                    <b>{{ expense.staff.name }}</b>
                                  </router-link>
                                </span>
                                | পরিমাণঃ <b>{{ expense.amount }}</b> ৳ <span v-if="expense.remark">({{ expense.remark }})</span></span>
                              <span v-else>
                                পরিমাণঃ <b>{{ expense.amount }}</b> ৳ <span v-if="expense.remark">({{ expense.remark }})</span>
                              </span>
                              <div style="float: right">
                                <button class="btn btn-success btn-sm" v-tooltip="'সম্পাদনা করুন'" @click="editModal(expense)"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm" v-tooltip="'ডিলেট করুন'" @click="deleteExpense(expense.id)"><i class="fa fa-trash"></i></button>
                              </div>
                              <br/>
                              <span class="text-muted"><i class="fa fa-calendar"></i> {{ expense.created_at | datetime }}</span>
                          </div>
                      </div>
                  </article>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="expenses" :limit="1" @pagination-change-page="getPaginationExpenseHistories"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>

      <!-- The Modal -->
      <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog"> <!-- modal-lg -->
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title" id="addModalLabel">খরচ সম্পাদনা করুন</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="updateExpense()" @keydown="form.onKeydown($event)">
              <!-- Modal body -->
              <div class="modal-body">
                <div class="form-group">
                  <label>খাত {{ expensecategory.name }}</label>
                  <input type="text" class="form-control" :value="expensecategory.name" readonly="">
                </div>
                <div class="form-group" v-if="expensecategory.id == 1">
                  <label>কর্মচারী</label>
                  <input type="text" class="form-control" v-model="form.staffname" readonly="">
                </div>
                <div class="form-group">
                  <label>পরিমাণ</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">৳</span>
                    </div> 
                    <input v-model="form.amount" type="number" step="any" name="amount" placeholder="পরিমাণ" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('amount') }">
                    <has-error :form="form" field="amount"></has-error>
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
      <div v-if="!$gate.isAdminOrAssociated('expense-page', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
              expensecategory: {},
              expenses: {},
              totalexpenseamount: '',
              totalexpensecount: '',
              code: this.$route.params.code,
              // Create a new form instance
              form: new Form({
                id: '',
                staffname: '',
                amount: '',
                remark: '',
              }),
              // editmode: false
            }
        },
        methods: {
            editModal(expense) {
              this.form.reset(); // clears fields
              this.form.clear(); // clears errors
              $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });

              this.form.fill(expense);
              if(this.expensecategory.id == 1) {
                this.form.staffname = expense.staff.name;
              }         
            },
            loadExpenseCategory() {
              if(this.$gate.isAdminOrAssociated('expense-page', this.$route.params.code)){
                axios.get('/api/load/single/category/expense/' + this.$route.params.id + '/' + this.$route.params.code).then(({ data }) => (
                  this.expensecategory = data
                ));
              }
            },
            loadExpenses() {
              if(this.$gate.isAdminOrAssociated('expense-page', this.$route.params.code)){
                axios.get('/api/load/single/category/expenses/store/wise/' + this.$route.params.id + '/' + this.$route.params.code).then(({ data }) => (
                  this.expenses = data
                ));
              }
            },
            loadExpensesTotals() {
              if(this.$gate.isAdminOrAssociated('expense-page', this.$route.params.code)){
                axios.get('/api/load/single/category/expenses/totals/' + this.$route.params.id + '/' + this.$route.params.code).then(({ data }) => (
                  this.totalexpenseamount = data.totalamount ? data.totalamount.toFixed(2) : 0,
                  this.totalexpensecount = data.count
                ));
              }
            },
            updateExpense() {
              this.$Progress.start();
              this.form.post('/api/expense/'+ this.form.id).then(() => {
                $('#addModal').modal('hide')
                Fire.$emit('AfterExpenseUpdated')
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
            deleteExpense(id) {
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
                     this.form.delete('/api/expense/'+ id).then(() => {
                       swal.fire(
                        'ডিলেট',
                        'ডিলেট সফল হয়েছে!',
                        'success'
                        )
                       Fire.$emit('AfterExpenseUpdated')
                     })
                     .catch(() => {
                       swal('Failed!', 'কিছু সমস্যা হচ্ছে, দুঃখিত!', 'warning');
                     }) 
                  }

              })
            },
            getPaginationExpenseHistories(page = 1) {
              axios.get('/api/load/single/category/expenses/store/wise/' + this.$route.params.id + '/' + this.$route.params.code + '?page=' + page)
              .then(response => {
                this.expenses = response.data;
              });
            },
        },
        created() {
          this.loadExpenseCategory();
          this.loadExpenses();
          this.loadExpensesTotals();

          Fire.$on('AfterExpenseUpdated', () => {
              this.loadExpenseCategory();
              this.loadExpenses();
              this.loadExpensesTotals();
          });
          Fire.$on('changingstorename', () => {
              this.loadExpenseCategory();
              this.loadExpenses();
              this.loadExpensesTotals();
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
          //       this.loadExpenseCategory();
          //       this.loadExpenses();
          //       this.loadExpensesTotals();
          //     }
              
          // });
        },
        beforeDestroy() {
          Fire.$off('AfterExpenseUpdated')
          Fire.$off('changingstorename')
          // Fire.$off('searching')
        }
    }
</script>
