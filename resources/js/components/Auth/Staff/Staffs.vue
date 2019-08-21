<template>
    <div class="content">
       <div class="content-header" v-if="$gate.isAdminOrAssociated('staff-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">কর্মচারী তালিকা</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="#!">স্টোর</router-link></li>
                  <li class="breadcrumb-item active">কর্মচারী তালিকা</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('staff-page', this.$route.params.code)">
        <div class="row">
          <div class="col-md-8">
            <!-- <img src="images/click_here_2li1.svg" style="max-height: 200px;"> -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">কর্মচারীগণ</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" @click="addModal" v-tooltip="'নতুন কর্মচারী যোগ করুন'">
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
                    <th>নাম</th>
                    <th>যোগাযোগ</th>
                    <th>ছবি</th>
                    <th>যোগদান</th>
                    <th width="20%">ক্রিয়াকলাপ</th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr v-for="staff in staffs.data" :key="staff.id">
                    <!-- <td>{{ staff.id }}</td> -->
                    <td>
                      <router-link :to="{ name: 'singleStaff', params: { id: staff.id, code: code }}" v-tooltip="'প্রোফাইল দেখুন'">
                        {{ staff.name }}
                      </router-link>
                      <br/>
                      <small>বেতনঃ {{ staff.salary }} ৳</small>
                    </td>
                    <td><small>{{ staff.mobile }}<br/>{{ staff.address }}</small></td>
                    <td><img :src="getStaffProfilePhoto(staff.image)" class="img-responsive" style="max-height: 50px; width: auto;"></td>
                    <td>{{ staff.created_at | date }}</td>
                    <td>
                      <router-link :to="{ name: 'singleStaff', params: { id: staff.id, code: code }}" v-tooltip="'প্রোফাইল দেখুন'" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"></i>
                      </router-link>
                      <button type="button" class="btn btn-success btn-sm" @click="editModal(staff)" v-tooltip="'সম্পাদনা করুন'">
                          <i class="fa fa-edit"></i>
                      </button>
                      <!-- <button @click="deleteStaff(staff.id)" class="btn btn-danger btn-sm">
                          <i class="fa fa-trash"></i>
                      </button> -->
                    </td>
                  </tr>
                  
                 </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="staffs" :limit="1" @pagination-change-page="getPaginationResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-4">
            <!-- <img src="images/click_here_2li1.svg" style="max-height: 200px;"> -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">কর্মচারীগণের উপস্থিতি</h3>
              </div>
              <!-- /.card-header -->
              <form @submit.prevent="submitStaffAttendence()" @keydown="form.onKeydown($event)">
              <div class="card-body table-responsive">
                <div class="form-group">
                  <label>কর্মচারী নির্ধারণ করুন</label>
                  <v-select placeholder="কর্মচারী নির্ধারণ করুন" :options="staffsforatt"  label="name" v-model="formforatt.staff">
                    <template #search="{attributes, events}">
                      <input
                        class="vs__search"
                        :required="!formforatt.staff"
                        v-bind="attributes"
                        v-on="events"
                      />
                    </template>
                  </v-select>
                </div>
                <div class="form-group">
                  <label>তারিখ</label>
                  <vc-date-picker
                    v-model="formforatt.date"
                    :input-props='{
                      placeholder: "তারিখ নির্ধারণ করুন",
                      readonly: true
                    }'
                    :masks='{ input: "MMMM DD, YYYY" }'
                    :class="{ 'form-control is-invalid': formforatt.errors.has('date') }"
                  />
                  <has-error :form="formforatt" field="date"></has-error>
                </div>
                <div class="form-group">
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="type" value="0" v-model.number="formforatt.type" :checked="true"> উপস্থিতি
                    </label>
                  </div>
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="type" value="1" v-model.number="formforatt.type"> ছুটি
                    </label>
                  </div>
                  <has-error :form="formforatt" field="type"></has-error>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-success btn-sm">দাখিল করুন</button>
              </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="card" id="calendarDiv">
          <div class="card-header">
            <h3 class="card-title">উপস্থিতি ক্যালেন্ডার</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-primary btn-sm noprint" @click="printDiv" v-tooltip="'প্রিন্ট করুন'">
                  <i class="fa fa-print"></i>
              </button>
            </div>
          </div>
          
          <div class="card-body table-responsive p-0">
            <full-calendar :events="staffsforcal" :config="config"></full-calendar>
          </div>
        </div>
        
        <br/>

        <!-- The Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 v-show="editmode" class="modal-title" id="addModalLabel">কর্মচারী হালনাগাদ করুন</h4>
                <h4 v-show="!editmode" class="modal-title" id="addModalLabel">নতুন কর্মচারী যোগ করুন</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <form @submit.prevent="editmode ? updateStaff() : createStaff()" @keydown="form.onKeydown($event)">
                  <!-- Modal body -->
                  <div class="modal-body">
                    <div class="form-group">
                      <label>নাম</label>
                      <input v-model="form.name" type="text" name="name" placeholder="নাম" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                      <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                      <label>মোবাইল নম্বর (১১ ডিজিট)</label>
                      <input v-model="form.mobile" type="text" name="mobile" placeholder="১১ ডিজিট মোবাইল নম্বর" 
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
                      <label>বেতন</label>
                      <input v-model="form.salary" type="number" step="any" name="salary" placeholder="বেতন" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('salary') }">
                      <has-error :form="form" field="salary"></has-error>
                    </div>
                    
                    <div class="form-group">
                      <label>ছবি (যদি থাকে)</label>
                      <input type="file" v-on:change="uploadImage" name="image" placeholder="Image" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('image') }" ref="imageInput">
                      <has-error :form="form" field="image"></has-error>
                    </div>
                    <center>
                      <img :src="getProfilePhotoOnModal()" class="img-responsive" style="max-height: 150px; width: auto;">
                    </center>
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
      <div v-if="!$gate.isAdminOrAssociated('staff-page', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
    <!-- /.content -->
</template>

<script>
    import moment from 'moment'

    export default {
        data () {
            return {
              staffs: {},
              staffsforatt: [],
              staffsforcal: [],
              date: '',
              code: this.$route.params.code,
              // Create a new form instance
              form: new Form({
                id: '',
                name: '',
                mobile: '',
                address: '',
                salary: '',
                image: '',
                code: this.$route.params.code
              }),
              formforatt: new Form({
                staff: '',
                date: '',
                type: 0
              }),
              editmode: false,
              events: [
                {
                    title  : 'রিফাত',
                    start  : '2019-08-10',
                    color: '#adcadc',
                    textColor: 'white',
                },
              ],
              config: {
                defaultView: 'month',
                editable: false,
                selectHelper: true,
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: ''
                },
                locale: 'bn',
                eventRender: function(event, element) {
                    element.attr('data-title', event.description);
                }
              },
              
            }
        },
        methods: {
            addModal() {
                this.editmode = false;
                this.form.reset();
                this.$refs.imageInput.value = null;
                $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });
            },
            editModal(staff) {
                this.editmode = true;
                this.form.reset(); // clears fields
                this.form.clear(); // clears errors
                this.$refs.imageInput.value = null;
                $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });
                this.form.fill(staff);
            },
            loadStaffs() {
                if(this.$gate.isAdminOrAssociated('staff-page', this.$route.params.code)){
                  axios.get('/api/load/staff/' + this.$route.params.code).then(({ data }) => (this.staffs = data));  
                }
            },
            loadStaffsForAtt() {
                if(this.$gate.isAdminOrAssociated('staff-page', this.$route.params.code)){
                  axios.get('/api/load/staff/for/attendance/' + this.$route.params.code).then(({ data }) => (this.staffsforatt = data));  
                }
            },
            loadStaffsForCal() {
                if(this.$gate.isAdminOrAssociated('staff-page', this.$route.params.code)){
                  axios.get('/api/load/staff/attendance/for/calendar/' + this.$route.params.code).then(({ data }) => (this.staffsforcal = data));
                }
            },
            createStaff() {
                this.$Progress.start();
                this.form.post('/api/staff').then(() => {
                    $('#addModal').modal('hide')
                    Fire.$emit('AfterStaffCreatedOrUpdated')
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
            updateStaff() {
                this.$Progress.start();
                this.form.put('/api/staff/'+ this.form.id).then(() => {
                    $('#addModal').modal('hide')
                    Fire.$emit('AfterStaffCreatedOrUpdated')
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
            submitStaffAttendence() {
                this.$Progress.start();
                this.formforatt.post('/api/post/staff/attendance').then(() => {
                    Fire.$emit('AfterStaffCreatedOrUpdated')
                    toast.fire({
                      type: 'success',
                      title: 'সফলভাবে দাখিল করা হয়েছে!'
                    })
                    this.formforatt.reset();
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                    // swal('Failed!', 'There was something wrong', 'warning');
                })
            },
            deleteStaff(id) {
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
                       this.form.delete('/api/user/'+ id).then(() => {
                         swal.fire(
                          'Deleted!',
                          'User has been deleted.',
                          'success'
                          )
                         Fire.$emit('AfterStaffCreatedOrUpdated')
                       })
                       .catch(() => {
                         swal('Failed!', 'There was something wrong', 'warning');
                       }) 
                    }

                })
            },
            uploadImage(e) {
              let file = e.target.files[0];
              // console.log(file);
              let reader = new FileReader();
              if((file['size'] / 1024) > 250) {
                swal.fire(
                 'Ops!',
                 'The size of the intended file is <b>' + parseInt(file['size'] / 1024) + 'KB</b>, try uploading under <b>250KB</b>!',
                 'warning'
                )
                this.$refs.imageInput.value = null;
              } else {
                reader.onloadend = (file) => {
                  var img = new Image();
                  img.src = file.target.result;

                  img.onload = function() {
                      if(((this.height/this.width) < 0.9375) || ((this.height/this.width) > 1.07142)) {
                        swal.fire(
                         'Ops!',
                         'The ratio of height and width should be same',
                         'warning'
                        )
                        
                      }
                  };
                  this.form.image = reader.result;
                }
                reader.readAsDataURL(file);
              }
            },
            getProfilePhotoOnModal() {
              if(this.form.image == null) {
                return '/images/staff_demo.png';
              } else {
                if(this.form.image.length > 200) {
                  return this.form.image;
                } else if(this.form.image.length == 0) {
                  return '/images/staff_demo.png';
                } else {
                  return '/images/users/' + this.form.image;
                }
              }
            },
            getStaffProfilePhoto(image) {
              if(image == null) {
                return '/images/staff_demo.png';
              } else {
                if(image.length > 0) {
                  return '/images/users/' + image;
                } else {
                  return '/images/staff_demo.png';
                }
              }
            },
            getPaginationResults(page = 1) {
              axios.get('/api/staff/'+ this.$route.params.come +'?page=' + page)
              .then(response => {
                this.staffs = response.data;
              });
            },
            printDiv() {
              this.$htmlToPaper('calendarDiv', () => {
                // console.log('Printing done or got cancelled!');
              });
            }
        },
        created() {
            this.loadStaffs();
            this.loadStaffsForAtt();
            this.loadStaffsForCal();
            Fire.$on('AfterStaffCreatedOrUpdated', () => {
                this.loadStaffs();
                this.loadStaffsForAtt();
                this.loadStaffsForCal();
            });

            Fire.$on('searching', () => {
                let query = this.$parent.$parent.search;
                if(query != '') {
                  axios.get('/api/searchstaff/' + query)
                  .then((data) => {
                    this.staffs = data.data;
                  })
                  .catch(() => {

                  })
                } else {
                  this.loadStaffs();
                }
            });
        },
        beforeDestroy() {
          Fire.$off('AfterStaffCreatedOrUpdated')
          // Fire.$off('searching')
        }
    }
</script>
