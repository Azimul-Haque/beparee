<template>
    <div class="content">
       <div class="content-header" v-if="$gate.isAdminOrAssociated('vendor-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">ডিলার/ ভেন্ডরের তালিকা</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">স্টোর</router-link></li>
                  <li class="breadcrumb-item active">ডিলারের তালিকা</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('vendor-page', this.$route.params.code)">
        <div class="row">
          <div class="col-md-12">
            <!-- <img src="images/click_here_2li1.svg" style="max-height: 200px;"> -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">ডিলার/ ভেন্ডর</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" @click="addModal" v-tooltip="'নতুন ডিলার / ভেন্ডর যোগ করুন'">
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
                    <th>ডিলার/ ভেন্ডরের নাম</th>
                    <th>ঠিকানা</th>
                    <th>যোগাযোগের নম্বর</th>
                    <th>মোট ক্রয় সংখ্যা</th>
                    <th>চলতি দেনা</th>
                    <th>সর্বমোট দেনা</th>
                    <th>সর্বমোট দেনা পরিশোধ</th>
                    <th width="15%">ক্রিয়াকলাপ</th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr v-for="vendor in vendors.data" :key="vendor.id">
                    <!-- <td>{{ store.id }}</td> -->
                    <td>
                      <router-link :to="{ name: 'singleVendor', params: { id: vendor.id, code: code }}" v-tooltip="'বিস্তারিত দেখুন'">
                        {{ vendor.name }}
                      </router-link>
                    </td>
                    <td>{{ vendor.address }}</td>
                    <td>{{ vendor.mobile }}</td>
                    <td>{{ vendor.total_purchase }}</td>
                    <td><span class="badge badge-danger">{{ vendor.current_due }} ৳</span></td>
                    <td><span class="badge badge-warning">{{ vendor.total_due }} ৳</span></td>
                    <td><span class="badge badge-primary">{{ vendor.total_due_paid }} ৳</span></td>
                    <td>
                        <router-link :to="{ name: 'singleVendor', params: { id: vendor.id, code: code }}" class="btn btn-info btn-sm" v-tooltip="'বিস্তারিত দেখুন'">
                          <i class="fa fa-eye"></i>
                        </router-link>
                        <button type="button" class="btn btn-success btn-sm" @click="editModal(vendor)" v-tooltip="'সম্পাদনা করুন'">
                            <i class="fa fa-edit"></i>
                        </button><!-- 
                        <button @click="deleteVendor(vendor.id)" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </button> -->
                    </td>
                  </tr>
                  
                 </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="vendors" :limit="1" @pagination-change-page="getPaginationResults"></pagination>
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
                <h4 v-show="editmode" class="modal-title" id="addModalLabel">ডিলার/ ভেন্ডর সম্পাদনা করুন</h4>
                <h4 v-show="!editmode" class="modal-title" id="addModalLabel">নতুন ডিলার/ ভেন্ডর যোগ করুন</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <form @submit.prevent="editmode ? updateVendor() : createVendor()" @keydown="form.onKeydown($event)">
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="form-group">
                    <label>ডিলার/ ভেন্ডরের নাম</label>
                    <input v-model="form.name" type="text" name="name" placeholder="ডিলার/ ভেন্ডরের নাম" 
                      class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                  </div>
                  <div class="form-group">
                    <label>যোগাযোগের নম্বর</label>
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
                    <label>পূর্বের দেনা (যদি থাকে)</label>
                    <input v-model="form.ldue" type="number" name="ldue" placeholder="পূর্বের দেনা" 
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
      <div v-if="!$gate.isAdminOrAssociated('vendor-page', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
    <!-- /.content -->
</template>

<script>
    export default {
        data () {
            return {
              vendors: {},
              code: this.$route.params.code,
              // Create a new form instance
              form: new Form({
                id: '',
                name: '',
                address: '',
                mobile: '',
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
            editModal(vendor) {
                this.editmode = true;
                this.form.reset(); // clears fields
                this.form.clear(); // clears errors
                $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });

                this.form.fill(vendor);                
            },
            
            loadVendors() {
                if(this.$gate.isAdminOrAssociated('vendor-page', this.$route.params.code)){
                  axios.get('/api/load/vendor/' + this.$route.params.code).then(({ data }) => (this.vendors = data));  
                }
            },
            createVendor() {
                this.$Progress.start();
                this.form.post('/api/vendor').then(() => {
                  $('#addModal').modal('hide')
                  Fire.$emit('AfterVendorsCreatedOrUpdated')
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
            updateVendor() {
                this.$Progress.start();
                this.form.post('/api/vendor/'+ this.form.id).then(() => {
                  $('#addModal').modal('hide')
                  Fire.$emit('AfterVendorsCreatedOrUpdated')
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
                         Fire.$emit('AfterVendorsCreatedOrUpdated')
                       })
                       .catch(() => {
                         swal('Failed!', 'There was something wrong', 'warning');
                       }) 
                    }

                })
            },
            getPaginationResults(page = 1) {
              axios.get('/api/load/vendor/'+ this.$route.params.code +'?page=' + page)
              .then(response => {
                this.vendors = response.data;
              });
            }
        },
        created() {
            this.loadVendors();
            
            Fire.$on('AfterVendorsCreatedOrUpdated', () => {
                this.loadVendors();
            });
            Fire.$on('changingstorename', () => {
                this.loadVendors();
            });

            Fire.$on('searching', () => {
                let query = this.$parent.$parent.search;
                if(query != '') {
                  axios.get('/api/searchvendor/' + query)
                  .then((data) => {
                    this.vendors = data.data;
                  })
                  .catch(() => {

                  })
                } else {
                  this.loadVendors();
                }
                
            });
        },
        beforeDestroy() {
          Fire.$off('AfterVendorsCreatedOrUpdated')
          Fire.$off('changingstorename')
          // Fire.$off('searching')
        }
    }
</script>
