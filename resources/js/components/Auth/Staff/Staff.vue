<template>
    <div class="content">
      <div class="content-header" v-if="$gate.isAdminOrAssociated('staff-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">কর্মচারী বিবরণ</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#!">স্টোর</a></li>
                  <li class="breadcrumb-item"><a href="#!">কর্মচারী</a></li>
                  <li class="breadcrumb-item active">বিবরণ</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('staff-page', this.$route.params.code)">
        <div class="row">
          <div class="col-md-3">
            <div class="card">
              <div style="background: url('/images/staffcover.jpg') center center;">
                <div class="card-body p-3 text-light" style="background: rgba(0, 90, 100, 0.80);">
                  <div class="media">
                    <img v-if="staff.image" :src="'/images/users/' + staff.image" alt="User Avatar" class="img-size-50 mr-3 img-circle elevation-2">
                    <img v-else src="/images/staff_demo.png" alt="User Avatar" class="img-size-50 mr-3 img-circle elevation-2">
                    <div class="media-body">
                      <h3 class="dropdown-item-title">
                        {{ staff.name }}
                      </h3>
                      <small>
                        <i class="fa fa-phone"></i> {{ staff.mobile }}<br/>
                        <i class="fa fa-map-marker"></i> {{ staff.address }}
                      </small>
                    </div>
                  </div>
                  <!-- <p class="card-text">
                    <i class="fa fa-map-marker"></i> {{ staff.address }}
                  </p> -->
                </div>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>মোট বেতনঃ</b> {{ salarycount }} বার</li>
                <li class="list-group-item"><b>সর্বমোট বেতন পরিশোধঃ</b> <span class="badge badge-primary">{{ totalsalary }} ৳</span></li>
              </ul>
              <div class="card-body">
                <center>
                  <button type="button" class="btn btn-primary btn-sm" @click="editStaffModal(staff)" v-tooltip="'তথ্য হালনাগাদ করুন'" :disabled="staff.current_due <= 0">
                      <i class="fa fa-edit"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" @click="editModal(staff)" v-tooltip="'বেতন পরিশোধ করুন'" :disabled="staff.current_due <= 0">
                      <i class="fa fa-money"></i>
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
                      <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">বেতন তালিকা</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">বিক্রয় তালিকা</a>
                  </li>
                </ul>
              </div>

              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                  <p class="card-text">
                    <div class="timeline-centered">
                      <article class="timeline-entry" v-for="salaryhistory in salaryhistories.data" :key="salaryhistory.id">
                          <div class="timeline-entry-inner">
                            <div class="timeline-icon bg-success" v-tooltip="'বেতন'">
                                <i class="fa fa-user-o"></i>
                            </div>
                            
                            <div class="timeline-label shadow">
                                <span>
                                  পরিমাণঃ <b>{{ salaryhistory.amount }}</b> ৳
                                  <span v-if="salaryhistory.remark">({{ salaryhistory.remark }})</span>
                                </span>
                                <br/>
                                <span class="text-muted"><i class="fa fa-calendar"></i> {{ salaryhistory.created_at | datetime }}</span>
                            </div>
                          </div>
                      </article>
                    </div>
                  </p>
                  <div class="card-footer">
                    <pagination :data="salaryhistories" @pagination-change-page="getPaginationSalaryHistories"></pagination>
                  </div>       
                </div>
                <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
                  <p class="card-text">
                    
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
              <h4 class="modal-title" id="addModalLabel">বেতন পরিশোধ করুন</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="payStaffSalary()" @keydown="form.onKeydown($event)">
              <!-- Modal body -->
              <div class="modal-body">
                <div class="form-group">
                  <label>বেতন পরিশোধের পরিমাণ</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">৳</span>
                    </div> 
                    <input v-model="form.amount" type="number" step="any" name="amount" placeholder="বেতন পরিশোধের পরিমাণ" 
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
                <input type="hidden" v-model="form.expensecategory_id" name="code">
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

      <!-- The Modal -->
      <div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title" id="editStaffModalLabel">কর্মচারী হালনাগাদ করুন</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form @submit.prevent="updateStaff()" @keydown="form.onKeydown($event)">
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="form-group">
                    <label>নাম</label>
                    <input v-model="formedit.name" type="text" name="name" placeholder="নাম" 
                      class="form-control" :class="{ 'is-invalid': formedit.errors.has('name') }">
                    <has-error :form="formedit" field="name"></has-error>
                  </div>
                  <div class="form-group">
                    <label>মোবাইল নম্বর (১১ ডিজিট)</label>
                    <input v-model="formedit.mobile" type="text" name="mobile" placeholder="১১ ডিজিট মোবাইল নম্বর" 
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
                    <label>ছবি (যদি থাকে)</label>
                    <input type="file" v-on:change="uploadImage" name="image" placeholder="Image" 
                      class="form-control" :class="{ 'is-invalid': formedit.errors.has('image') }" ref="imageInput">
                    <has-error :form="formedit" field="image"></has-error>
                  </div>
                  <center>
                    <img :src="getProfilePhotoOnModal()" class="img-responsive" style="max-height: 150px; width: auto;">
                  </center>
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
      <div v-if="!$gate.isAdminOrAssociated('staff-page', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
</template>

<script>
    import moment from 'moment'   

    export default {
        data () {
          return {
            staff: {},
            salaryhistories: {},
            totalsalary: '',
            salarycount: '',
            // Create a new form instance
            formedit: new Form({
              id: '',
              name: '',
              mobile: '',
              address: '',
              image: '',
              code: this.$route.params.code
            }),
            form: new Form({
              code: this.$route.params.code,
              staff_id: '',
              amount: '',
              remark: ''
            }),
            // editmode: false
          }
        },
        methods: {
          editStaffModal(staff) {
              this.formedit.reset(); // clears fields
              this.formedit.clear(); // clears errors
              this.$refs.imageInput.value = null;
              $('#editStaffModal').modal({ show: true, backdrop: 'static', keyboard: false });
              this.formedit.fill(staff);
          },
          updateStaff() {
              this.$Progress.start();
              this.formedit.put('/api/staff/'+ this.formedit.id).then(() => {
                  $('#editStaffModal').modal('hide')
                  Fire.$emit('AfterStaffUpdated')
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
          editModal(staff) {
            this.form.reset(); // clears fields
            this.form.clear(); // clears errors
            $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });

            this.form.fill(staff);             
            this.form.code = this.$route.params.code;            
            this.form.staff_id = staff.id;             
          },
          loadStaff() {
            if(this.$gate.isAdminOrAssociated('staff-page', this.$route.params.code)){
              axios.get('/api/load/single/staff/' + this.$route.params.id + '/' + this.$route.params.code).then(({ data }) => (
                this.staff = data
              ));
            }
          },
          loadSalaryHistories() {
          if(this.$gate.isAdminOrAssociated('staff-page', this.$route.params.code)){
            axios.get('/api/load/single/staff/salary/history/' + this.$route.params.id + '/' + this.$route.params.code).then(({ data }) => (
              this.salaryhistories = data
            ));
          }
          },
          loadSalaryTotals() {
            if(this.$gate.isAdminOrAssociated('staff-page', this.$route.params.code)){
              axios.get('/api/load/single/staff/salary/history/totals/' + this.$route.params.id + '/' + this.$route.params.code).then(({ data }) => (
                this.totalsalary = data.totalsalary.toFixed(2),
                this.salarycount = data.salarycount
              ));
            }
          },
          payStaffSalary() {
            this.$Progress.start();
            this.form.post('/api/load/staff/pay/salary').then(() => {
              $('#addModal').modal('hide')
              Fire.$emit('AfterStaffUpdated')
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
                this.formedit.image = reader.result;
              }
              reader.readAsDataURL(file);
            }
          },
          getProfilePhotoOnModal() {
            if(this.formedit.image == null) {
              return '/images/staff_demo.png';
            } else {
              if(this.formedit.image.length > 200) {
                return this.formedit.image;
              } else if(this.formedit.image.length == 0) {
                return '/images/staff_demo.png';
              } else {
                return '/images/users/' + this.formedit.image;
              }
            }
          },
          getPaginationSalaryHistories(page = 1) {
            axios.get('/api/load/single/staff/salary/history/' + this.$route.params.id + '/' + this.$route.params.code + '?page=' + page)
            .then(response => {
              this.salaryhistories = response.data;
            });
          },
        },
        created() {
          this.loadStaff();
          this.loadSalaryHistories();
          this.loadSalaryTotals();

          Fire.$on('AfterStaffUpdated', () => {
              this.loadStaff();
              this.loadSalaryHistories();
              this.loadSalaryTotals();
          });
          Fire.$on('changingstorename', () => {
              this.loadStaff();
              this.loadSalaryHistories();
              this.loadSalaryTotals();
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
          //       this.loadStaff();
          //       this.loadSalaryHistories();
          //       this.loadSalaryTotals();
          //     }
              
          // });
        },
        beforeDestroy() {
          Fire.$off('AfterStaffUpdated')
          Fire.$off('changingstorename')
          // Fire.$off('searching')
        }
    }
</script>
