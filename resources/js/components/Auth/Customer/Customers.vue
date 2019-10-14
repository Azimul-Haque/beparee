<template>
    <div class="content">
       <div class="content-header" v-if="$gate.isAdminOrAssociated('customer-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">কাস্টমার তালিকা</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">স্টোর</router-link></li>
                  <li class="breadcrumb-item active">কাস্টমার তালিকা</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('customer-page', this.$route.params.code)">
        <div class="row">
          <div class="col-md-12">
            <!-- <img src="images/click_here_2li1.svg" style="max-height: 200px;"> -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">কাস্টমারগণ</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" @click="addModal" v-tooltip="'নতুন কাস্টমার যোগ করুন'">
                      <i class="fa fa-user-plus"></i>
                  </button> <!-- data-toggle="modal" data-target="#addModal" -->
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
                    <th>কাস্টমারের নাম</th>
                    <th>ঠিকানা</th>
                    <th>যোগাযোগের নম্বর</th>
                    <th width="15%">ক্রিয়াকলাপ</th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr v-for="customer in customers.data" :key="customer.id">
                    <!-- <td>{{ store.id }}</td> -->
                    <td>
                      <router-link :to="{ name: 'singleCustomer', params: { id: customer.id, code: code }}" v-tooltip="'বিস্তারিত দেখুন'">
                        {{ customer.name }}
                      </router-link>
                    </td>
                    <td>{{ customer.address }}</td>
                    <td>{{ customer.mobile }}</td>
                    <td>
                        <router-link :to="{ name: 'singleCustomer', params: { id: customer.id, code: code }}" class="btn btn-info btn-sm" v-tooltip="'বিস্তারিত দেখুন'">
                          <i class="fa fa-eye"></i>
                        </router-link>
                        <button type="button" class="btn btn-success btn-sm" @click="editModal(customer)" v-tooltip="'সম্পাদনা করুন'">
                            <i class="fa fa-edit"></i>
                        </button><!-- 
                        <button @click="deleteCustomer(customer.id)" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </button> -->
                    </td>
                  </tr>
                  
                 </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="customers" :limit="1" @pagination-change-page="getPaginationResults"></pagination>
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
                <h4 v-show="editmode" class="modal-title" id="addModalLabel">কাস্টমার সম্পাদনা করুন</h4>
                <h4 v-show="!editmode" class="modal-title" id="addModalLabel">নতুন কাস্টমার যোগ করুন</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <form @submit.prevent="editmode ? updateCustomer() : createCustomer()" @keydown="form.onKeydown($event)">
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="form-group">
                    <label>কাস্টমারের নাম *</label>
                    <input v-model="form.name" type="text" name="name" placeholder="কাস্টমারের নাম *" 
                      class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                  </div>
                  <div class="form-group">
                    <label>যোগাযোগের নম্বর (১১ ডিজিট)</label>
                    <input v-model="form.mobile" type="number" name="mobile" placeholder="যোগাযোগের নম্বর" 
                      class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }" onkeypress="if(this.value.length==11) return false;">
                    <has-error :form="form" field="mobile"></has-error>
                  </div>
                  <div class="form-group">
                    <label>ঠিকানা</label>
                    <input v-model="form.address" type="text" name="address" placeholder="ঠিকানা" 
                      class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                    <has-error :form="form" field="address"></has-error>
                  </div>
                  <div class="form-group">
                    <label>জাতীয় পরিচয়পত্র নম্বর (ঐচ্ছিক)</label>
                    <input v-model="form.nid" type="number" name="nid" placeholder="জাতীয় পরিচয়পত্র নম্বর" 
                      class="form-control" :class="{ 'is-invalid': form.errors.has('nid') }" onkeypress="if(this.value.length==17) return false;">
                    <has-error :form="form" field="nid"></has-error>
                  </div>
                  <div class="form-group">
                    <label>পূর্বের বাকী (যদি থাকে)</label>
                    <input v-model="form.ldue" type="number" name="ldue" placeholder="পূর্বের বাকী" 
                      class="form-control" :class="{ 'is-invalid': form.errors.has('ldue') }">
                    <has-error :form="form" field="ldue"></has-error>
                  </div>
                  <input type="hidden" v-model="form.code" name="code">
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                  <button v-show="editmode" type="submit" class="btn btn-success">হালনাগাদ করুন</button>
                  <button v-show="!editmode" type="submit" class="btn btn-success">দাখিল করুন</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">ফিরে যান</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
      <div v-if="!$gate.isAdminOrAssociated('customer-page', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
    <!-- /.content -->
</template>

<script>
    export default {
        data () {
            return {
              customers: {},
              code: this.$route.params.code,
              // Create a new form instance
              form: new Form({
                id: '',
                name: '',
                address: '',
                mobile: '',
                nid: '',
                ldue: '',
                code: this.$route.params.code,
              }),
              editmode: false
            }
        },
        methods: {
            addModal() {
                this.editmode = false;
                this.form.reset();
                $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });
            },
            editModal(customer) {
                this.editmode = true;
                this.form.reset(); // clears fields
                this.form.clear(); // clears errors
                $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });

                this.form.fill(customer);                
            },
            
            loadCustomers() {
                if(this.$gate.isAdminOrAssociated('customer-page', this.$route.params.code)){
                  axios.get('/api/load/customer/' + this.$route.params.code).then(({ data }) => (this.customers = data));  
                }
            },
            createCustomer() {
                this.$Progress.start();
                this.form.post('/api/customer').then(() => {
                  $('#addModal').modal('hide')
                  Fire.$emit('AfterCustomerCreatedOrUpdated')
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
            updateCustomer() {
                this.$Progress.start();
                this.form.post('/api/customer/'+ this.form.id).then(() => {
                  $('#addModal').modal('hide')
                  Fire.$emit('AfterCustomerCreatedOrUpdated')
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
            deleteCustomer(id) {
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
                       this.form.delete('/api/customer/'+ id).then(() => {
                         swal.fire(
                          'Wait...!',
                          'এই মুহূর্তে ডিলেট বন্ধ আছে!',
                          'success'
                          )
                         Fire.$emit('AfterCustomerCreatedOrUpdated')
                       })
                       .catch(() => {
                         swal('Failed!', 'There was something wrong', 'warning');
                       }) 
                    }

                })
            },
            getPaginationResults(page = 1) {
              axios.get('/api/load/customer/'+ this.$route.params.code +'?page=' + page)
              .then(response => {
                this.customers = response.data;
              });
            }
        },
        created() {
            this.loadCustomers();
            
            Fire.$on('AfterCustomerCreatedOrUpdated', () => {
                this.loadCustomers();
            });
            Fire.$on('changingstorename', () => {
                this.loadCustomers();
            });

            Fire.$on('searching', () => {
                let query = this.$parent.$parent.search;
                if(query != '') {
                  axios.get('/api/searchcustomer/' + query)
                  .then((data) => {
                    this.customers = data.data;
                  })
                  .catch(() => {

                  })
                } else {
                  this.loadCustomers();
                }
                
            });
        },
        beforeDestroy() {
          Fire.$off('AfterCustomerCreatedOrUpdated')
          Fire.$off('changingstorename')
          // Fire.$off('searching')
        }
    }
</script>