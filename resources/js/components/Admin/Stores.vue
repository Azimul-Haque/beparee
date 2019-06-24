<template>
    <div class="content">
       <div class="content-header" v-if="$gate.isAuthorized('store-crud')">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">দোকানের তালিকা</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">ড্যাশবোর্ড</router-link></li>
                  <li class="breadcrumb-item active">দোকানের তালিকা</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAuthorized('store-crud')">
        <div class="row">
          <div class="col-12">
            <!-- <img src="images/click_here_2li1.svg" style="max-height: 200px;"> -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Responsive Hover Table</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" @click="addStoreModal">
                      <i class="fa fa-user-plus"></i>
                  </button> <!-- data-toggle="modal" data-target="#addStoreModal" -->
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
                    <th>দোকানের নাম</th>
                    <th>মালিকের নাম</th>
                    <th>দোকান কোড</th>
                    <th>ঠিকানা</th>
                    <th>এক্টিভেশন স্ট্যাটাস</th>
                    <th>পেমেন্ট স্ট্যাটাস</th>
                    <th>মনোগ্রাম</th>
                    <th>যোগদান</th>
                    <th width="15%">Action</th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr v-for="store in stores.data" :key="store.id">
                    <!-- <td>{{ store.id }}</td> -->
                    <td>
                      <router-link :to="{ name: 'singleStore', params: { token: store.token, code: store.code }}">
                        {{ store.name }}
                      </router-link>
                    </td>
                    <td>
                      <span v-for="user in store.users" :key="user.id" class="badge badge-success" style="margin-left: 5px;">{{ user.name }}</span>
                    </td>
                    <td>{{ store.code }}</td>
                    <td>{{ store.address }}</td>
                    <td>{{ store.activation_status | activation_status }}</td>
                    <td>{{ store.payment_status | payment_status }}</td>
                    <td><img :src="getStoreMonogram(store.monogram)" class="img-responsive" style="max-height: 50px; width: auto;"></td>
                    <td>{{ store.created_at | date }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm" @click="editStoreModal(store)">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button @click="deleteStore(store.id)" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                  </tr>
                  
                 </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="stores" @pagination-change-page="getPaginationResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="addStoreModal" tabindex="-1" role="dialog" aria-labelledby="addStoreModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 v-show="editmode" class="modal-title" id="addStoreModalLabel">স্টোর সম্পাদনা করুন</h4>
                <h4 v-show="!editmode" class="modal-title" id="addStoreModalLabel">নতুন স্টোর যোগ করুন</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <form @submit.prevent="editmode ? updateStore() : createStore()" @keydown="form.onKeydown($event)">
                <!-- Modal body -->
                <div class="modal-body">
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
                        <v-select placeholder="মালিক নির্ধারণ করুন" :options="owners" :reduce="id => id" label="name" v-model="form.owners" ref='ownerSelect' multiple></v-select>
                        <has-error :form="form" field="owners"></has-error>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input v-model="form.address" type="text" name="address" placeholder="ঠিকানা" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                        <has-error :form="form" field="address"></has-error>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <v-select placeholder="স্থাপিত" :options="years" :reduce="id => id" v-model="form.established" taggable ref='theSelect' :class="{ 'is-invalid': form.errors.has('established') }"></v-select>
                        <has-error :form="form" field="established"></has-error>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <select v-model="form.activation_status" type="text" name="activation_status" placeholder="এক্টিভেশন স্ট্যাটাস" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('activation_status') }">
                            <option value="" selected="" disabled="">এক্টিভেশন স্ট্যাটাস</option>
                            <option value="0">প্রক্রিয়াধীন</option>
                            <option value="1">অনুমোদিত</option>
                          </select>
                        <has-error :form="form" field="activation_status"></has-error>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <select v-model="form.payment_status" type="text" name="payment_status" placeholder="পেমেন্ট স্ট্যাটাস" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('payment_status') }">
                            <option value="" selected="" disabled="">পেমেন্ট স্ট্যাটাস</option>
                            <option value="0">অপরিশোধিত</option>
                            <option value="1">পরিশোধিত</option>
                          </select>
                        <has-error :form="form" field="payment_status"></has-error>
                      </div>
                    </div>
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
                        <img :src="getMonogramOnModal()" class="img-responsive" style="max-height: 150px; width: auto;">
                      </center>
                    </div>
                  </div>
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
      <div v-if="!$gate.isAuthorized('store-crud')">
          <forbidden-403></forbidden-403>
      </div>
    </div>
    <!-- /.content -->
</template>

<script>
    export default {
        data () {
            return {
              stores: {},
              owners: [],
              years: [],
              // Create a new form instance
              form: new Form({
                id: '',
                token: '',
                code: '',
                name: '',
                established: '',
                address: '',
                activation_status: '',
                payment_status: '',
                // payment_method: '',
                // smsbalance: '',
                // smsrate: '',
                monogram: '',
                owners: ''
              }),
              editmode: false
            }
        },
        methods: {
            addStoreModal() {
                this.editmode = false;
                this.form.reset();
                this.$refs.monogramInput.value = null;
                $('#addStoreModal').modal('show');
                this.$refs.ownerSelect.clearSelection();
                this.$refs.theSelect.clearSelection();

                this.loadOwners();
                this.loadYears();
            },
            editStoreModal(store) {
                this.editmode = true;
                this.form.reset(); // clears fields
                this.form.clear(); // clears errors
                this.$refs.monogramInput.value = null;
                $('#addStoreModal').modal('show');
                this.$refs.ownerSelect.clearSelection();
                this.$refs.theSelect.clearSelection();

                this.loadOwners();
                this.loadYears();

                this.form.fill(store);                
            },
            loadOwners() {
                axios.get('/api/owners').then(({ data }) => {
                  (this.owners = data);
                });
            },
            loadYears() {
                var sub_array = [];
                var thisyear = new Date();
                for (var i = 1990; i <= thisyear.getFullYear(); i++) {
                    this.years.push(i);
                }
                // console.log(this.years);
            },
            loadStores() {
                if(this.$gate.isAuthorized('store-crud')){
                  axios.get('/api/store').then(({ data }) => (this.stores = data));  
                }
            },
            createStore() {
                this.$Progress.start();
                this.form.post('/api/store').then(() => {
                  $('#addStoreModal').modal('hide')
                  Fire.$emit('AfterCreated')
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
            updateStore() {
                this.$Progress.start();
                this.form.put('/api/store/'+ this.form.id).then(() => {
                  $('#addStoreModal').modal('hide')
                  Fire.$emit('AfterCreated')
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
            deleteStore(id) {
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
                       this.form.delete('/api/store/'+ id).then(() => {
                         swal.fire(
                          'Deleted!',
                          'Store has been deleted.',
                          'success'
                          )
                         Fire.$emit('AfterCreated')
                       })
                       .catch(() => {
                         swal('Failed!', 'There was something wrong', 'warning');
                       }) 
                    }

                })
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
            getMonogramOnModal() {
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
            getPaginationResults(page = 1) {
              axios.get('/api/store?page=' + page)
              .then(response => {
                this.stores = response.data;
              });
            }
        },
        created() {
            this.loadStores();
            
            Fire.$on('AfterCreated', () => {
                this.loadStores();
            });

            Fire.$on('searching', () => {
                let query = this.$parent.search;
                if(query != '') {
                  axios.get('/api/searchstore/' + query)
                  .then((data) => {
                    this.stores = data.data;
                  })
                  .catch(() => {

                  })
                } else {
                  this.loadStores();
                }
                
            });
        }
    }
</script>
