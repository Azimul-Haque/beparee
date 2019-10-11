<template>
    <div class="content">
      <div class="content-header" v-if="$gate.isAdminOrAssociated('store-profile', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ this.store.name }}</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#!">স্টোর</a></li>
                  <li class="breadcrumb-item active">প্রোফাইল</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('store-profile', this.$route.params.code)">
        <div class="row">
            <div class="col-md-6">
              <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-info-active" style="background: url('/images/storecover.jpg') center center;">
                  <p class="shadow text-light" style="background: rgba(251, 251, 251, 0.35); padding: 5px;">{{ store.slogan }}</p>
                </div>
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" :src="getStoreMonogram(store.monogram)" alt="User Avatar">
                </div>
                <div class="card-footer">
                  <div class="description-block">
                    <h3 class="description-header">{{ store.name }}</h3>
                    <h6 class="widget-user-desc">দোকান কোডঃ {{ store.code }}</h6>
                    <span class="description-text">
                      {{ store.address }}<br/>
                      {{ store.upazilla }}, {{ store.district }}<br/><br/>
                      <big>
                        বাকি দিন<span class="badge badge-till badge-primary" v-html="loadPaidTillDays(store.paid_till)">0</span>
                      </big>
                    </span>
                  </div>
                </div>
              </div>

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"><b>{{ store.name }}</b>-এর পরিশোধসমূহ</h3>
                  <div class="card-tools">
                    
                  </div>
                </div>
                <!-- /.card-header -->
                
                <div class="card-body table-responsive p-0">

                  <table class="table table-hover">
                   <thead>
                    <tr>
                      <th>তারিখ</th>
                      <th>পরিমাণ</th>
                      <th width="10%">রশিদ</th>
                    </tr>
                   </thead>
                   <tbody>
                    <tr>
                      <td>August 17, 2019</td>
                      <td>10000.00 ৳</td>
                      <td>
                        <button class="btn btn-warning btn-sm" v-tooltip="'পরিশোধ রশিদ ডাউনলোড করুন'">
                            <i class="fa fa-download"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>October 11, 2019</td>
                      <td>1500.00 ৳</td>
                      <td>
                        <button class="btn btn-warning btn-sm" v-tooltip="'পরিশোধ রশিদ ডাউনলোড করুন'">
                            <i class="fa fa-download"></i>
                        </button>
                      </td>
                    </tr>
                   </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                </div>
              </div>
              <!-- /.card -->
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header"><i class="fa fa-pencil"></i> দোকানের প্রোফাইল সম্পাদনা</div>

                <div class="card-body">
                  <form @submit.prevent="updateStore()" @keydown="form.onKeydown($event)">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>দোকানের নাম</label>
                          <input v-model="form.name" type="text" name="name" placeholder="দোকানের নাম" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>স্থাপিত</label>
                          <v-select placeholder="স্থাপিত" :options="years" label="year" v-model="form.established" taggable ref='theSelect' :class="{ 'is-invalid': form.errors.has('established') }" :error-messages="errors.collect('type')" v-validate="'required'" data-vv-name="type" :rules="[(v) => !!v || 'সাল নির্ধারণ করুন']" required></v-select>
                          <has-error :form="form" field="established"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>ঠিকানা</label>
                      <input v-model="form.address" type="text" name="address" placeholder="ঠিকানা" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                      <has-error :form="form" field="address"></has-error>
                      <br/>
                      <b>উপজেলাঃ</b> {{ store.upazilla }}, 
                      <b>জেলাঃ</b> {{ store.district }}
                    </div>
                    <div class="form-group">
                      <label>দোকান / ব্যবসা প্রতিষ্ঠানের স্লোগান</label>
                      <input v-model="form.slogan" type="text" name="slogan" placeholder="দোকান / ব্যবসা প্রতিষ্ঠানের স্লোগান" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('slogan') }">
                      <has-error :form="form" field="slogan"></has-error>
                    </div>
                    

                    <div class="row">
                      <div class="col-md-6">
                        <label>মনোগ্রাম</label>
                        <div class="custom-file mb-3">
                          <input type="file" v-on:change="uploadMonogram" name="monogram" placeholder="মনোগ্রাম" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('monogram') }" ref="monogramInput" id="monogram">
                          <has-error :form="form" field="monogram"></has-error>
                          <label class="custom-file-label" for="monogram" v-html="imgfiletext">ছবি নির্বাচন করুন</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <center>
                          <img :src="getMonogramOnEditCard()" class="img-responsive" style="max-height: 150px; width: auto;">
                        </center>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-success">হালনাগাদ করুন</button>
                  </form>
                </div>
              </div>
            </div>
        </div>
      </div>
      <div v-if="!$gate.isAdminOrAssociated('store-profile', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
</template>

<script>
  import moment from 'moment'
  export default {
    data () {
        return {
          store: {},
          years: [],
          imgfiletext: '',
          // Create a new form instance
          form: new Form({
            id: '',
            name: '',
            established: '',
            address: '',
            monogram: '',
            slogan: '',
          }),
        }
    },
    methods: {
      loadStore() {
        if(this.$gate.isAdminOrAssociated('store-profile', this.$route.params.code)){
          axios.get('/api/load/store/'+ this.$route.params.code).then(({ data }) => (
            this.store = data,

            this.form.reset(), // clears fields
            this.form.clear(), // clears errors
            this.loadYears(),

            this.form.fill(this.store),
            $('#changeNavStoreName'+ this.store.id).text(this.store.name)
          ));
        }
      },
      loadPaidTillDays(paid_till) {
        var date  = moment(paid_till, "YYYY-MM-DD");
        var today = moment().format("YYYY-MM-DD");
        var paid_till_days = date.diff(today, 'days');
        if(paid_till_days < 0) {
          return 0;
        } else {
          return paid_till_days;
        }
      },
      updateStore() {
          this.$Progress.start();
          this.form.post('/api/store/update/by/user/'+ this.form.id).then(() => {
            Fire.$emit('AfterStoreUpdated')
            toast.fire({
              type: 'success',
              title: 'সফলভাবে হালনাগাদ করা হয়েছে!'
            })
            this.$Progress.finish();
            this.imgfiletext = null;
          })
          .catch(() => {
              this.$Progress.fail();
              // swal('Failed!', 'There was something wrong', 'warning');
          })
      },
      getStoreMonogram(monogram) {
        if(monogram == null) {
          return '/images/default_store.png';
        } else {
          if(monogram.length > 0) {
            return '/images/stores/' + monogram;
          } else {
            return '/images/default_store.png';
          }
        }
      },
      uploadMonogram(e) {
        let file = e.target.files[0];
        this.imgfiletext = file.name;
        let reader = new FileReader();
        if((file['size'] / 1024) > 250) {
          swal.fire(
           'Ops!',
           'The size of the intended file is <b>' + parseInt(file['size'] / 1024) + 'KB</b>, try uploading under <b>250KB</b>!',
           'warning'
          );
          this.$refs.monogramInput.value = null;
          this.imgfiletext = null;
        } else {
          reader.onloadend = (file) => {
            this.form.monogram = reader.result;
          }
          reader.readAsDataURL(file);
        }
      },
      getMonogramOnEditCard() {
        if(this.form.monogram == null) {
          return '/images/default_store.png';
        } else {
          if(this.form.monogram.length > 200) {
            return this.form.monogram;
          } else if(this.form.monogram.length == 0) {
            return '/images/default_store.png';
          } else {
            return '/images/stores/' + this.form.monogram;
          }
        }
      },
      loadYears() {
          var sub_array = [];
          var thisyear = new Date();
          for (var i = thisyear.getFullYear(); i >= 1990; i--) {
              this.years.push(i);
          }
          // console.log(this.years);
      },
    },
    created() {
      this.loadStore();
      
      Fire.$on('changingstorename', () => {
          this.loadStore();
      });

      Fire.$on('AfterStoreUpdated', () => {
          this.loadStore();
      });
      
      // console.log(this.$route.params.code);
    },
    beforeDestroy() {
      Fire.$off('changingstorename')
      Fire.$off('AfterStoreUpdated')
    }
  }
</script>
