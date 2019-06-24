<template>
    <div class="content">
      <div class="content-header" v-if="$gate.isShopOwnerOrAdmin('store-profile', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ this.store.name }}</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#!">স্টোর</a></li>
                  <li class="breadcrumb-item active">স্টোর</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isShopOwnerOrAdmin('store-profile', this.$route.params.code)">
        <div class="row">
            <div class="col-md-6">
              <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-info-active" style="background: url('/images/storecover.jpg') center center;">
                  
                </div>
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" :src="getStoreMonogram(store.monogram)" alt="User Avatar">
                </div>
                <div class="card-footer">
                  <div class="description-block">
                    <h3 class="description-header">{{ store.name }}</h3>
                    <h6 class="widget-user-desc">দোকান কোডঃ {{ store.code }}</h6>
                    <span class="description-text">{{ store.address }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header"><i class="fa fa-pencil"></i> দোকানের প্রোফাইল সম্পাদনা</div>

                <div class="card-body">
                  <form @submit.prevent="updateStore()" @keydown="form.onKeydown($event)">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input v-model="form.name" type="text" name="name" placeholder="নাম" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <v-select placeholder="স্থাপিত" :options="years" :reduce="id => id" v-model="form.established" taggable ref='theSelect' :class="{ 'is-invalid': form.errors.has('established') }" :rules="[(v) => !!v || 'সাল নির্ধারণ করুন']" required></v-select>
                          <has-error :form="form" field="established"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <input v-model="form.address" type="text" name="address" placeholder="ঠিকানা" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                      <has-error :form="form" field="address"></has-error>
                    </div>
                    

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="file" v-on:change="uploadMonogram" name="monogram" placeholder="মনোগ্রাম" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('monogram') }" ref="monogramInput">
                          <has-error :form="form" field="monogram"></has-error>
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
      <div v-if="!$gate.isShopOwnerOrAdmin('store-profile', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
</template>

<script>
  export default {
    data () {
        return {
          store: {},
          years: [],
          // Create a new form instance
          form: new Form({
            id: '',
            name: '',
            established: '',
            address: '',
            monogram: ''
          }),
        }
    },
    methods: {
      loadStore() {
        if(this.$gate.isShopOwnerOrAdmin('store-profile', this.$route.params.code)){
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
      updateStore() {
          this.$Progress.start();
          this.form.put('/api/store/update/by/user/'+ this.form.id).then(() => {
            Fire.$emit('AfterUpdated')
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
      getStoreMonogram(monogram) {
        if(monogram == null) {
          return '/images/grocery.png';
        } else {
          if(monogram.length > 0) {
            return '/images/stores/' + monogram;
          } else {
            return '/images/grocery.png';
          }
        }
      },
      uploadMonogram(e) {
        let file = e.target.files[0];
        // console.log(file);
        let reader = new FileReader();
        if((file['size'] / 1024) > 250) {
          swal.fire(
           'Ops!',
           'The size of the intended file is <b>' + parseInt(file['size'] / 1024) + 'KB</b>, try uploading under <b>250KB</b>!',
           'warning'
          );
          this.$refs.monogramInput.value = null;
        } else {
          reader.onloadend = (file) => {
            this.form.monogram = reader.result;
          }
          reader.readAsDataURL(file);
        }
      },
      getMonogramOnEditCard() {
        if(this.form.monogram == null) {
          return '/images/grocery.png';
        } else {
          if(this.form.monogram.length > 200) {
            return this.form.monogram;
          } else if(this.form.monogram.length == 0) {
            return '/images/grocery.png';
          } else {
            return '/images/stores/' + this.form.monogram;
          }
        }
      },
      loadYears() {
          var sub_array = [];
          var thisyear = new Date();
          for (var i = 1990; i <= thisyear.getFullYear(); i++) {
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

      Fire.$on('AfterUpdated', () => {
          this.loadStore();
      });
      
      // console.log(this.$route.params.code);
    }
  }
</script>
