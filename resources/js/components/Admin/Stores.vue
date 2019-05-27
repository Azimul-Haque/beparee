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
                    <th>যোগদান</th>
                    <th>Action</th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr v-for="store in stores.data" :key="store.id">
                    <!-- <td>{{ store.id }}</td> -->
                    <td>{{ store.name }}</td>
                    <td></td>
                    <td>{{ store.code }}</td>
                    <td>{{ store.address }}</td>
                    <td>{{ store.activation_status | activation_status }}</td>
                    <td>{{ store.payment_status | payment_status }}</td>
                    <!-- <td><img :src="getStoreMonogram(store.image)" class="img-responsive" style="max-height: 50px; width: auto;"></td> -->
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
                          <input v-model="form.name" type="text" name="name" placeholder="Name" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <input v-model="form.email" type="text" name="email" placeholder="Email" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                          <has-error :form="form" field="email"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        
                      </div>
                      <div class="col-md-6">
                        
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        
                      </div>
                      <div class="col-md-6">
                        
                      </div>
                    </div>
                    
                    
                    <div class="form-group">
                      <input type="file" v-on:change="uploadMonogram" name="image" placeholder="Image" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('image') }" ref="imageInput">
                      <has-error :form="form" field="image"></has-error>
                    </div>
                    <div class="form-group">
                      <input v-model="form.password" type="password" name="password" placeholder="Password" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                      <has-error :form="form" field="password"></has-error>
                    </div>
                    <center>
                      <img :src="getMonogramOnModal()" class="img-responsive" style="max-height: 150px; width: auto;">
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
                payment_method: '',
                // smsbalance: '',
                // smsrate: '',
                monogram: ''
              }),
              editmode: false
            }
        },
        methods: {
            addStoreModal() {
                this.editmode = false;
                this.form.reset();
                this.$refs.imageInput.value = null;
                $('#addStoreModal').modal('show');
            },
            editStoreModal(store) {
                this.editmode = true;
                this.form.reset(); // clears fields
                this.form.clear(); // clears errors
                this.$refs.imageInput.value = null;
                $('#addStoreModal').modal('show');
                this.form.fill(store);
            },
            loadStores() {
                if(this.$gate.isAuthorized('store-crud')){
                  axios.get('api/store').then(({ data }) => (this.stores = data));  
                }
            },
            createStore() {
                this.$Progress.start();
                this.form.post('api/store').then(() => {
                    $('#addStoreModal').modal('hide')
                    Fire.$emit('AfterCreated')
                    toast.fire({
                      type: 'success',
                      title: 'Store created successfully'
                    })
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                })
            },
            updateStore() {
                this.$Progress.start();
                this.form.put('api/store/'+ this.form.id).then(() => {
                    $('#addStoreModal').modal('hide')
                    Fire.$emit('AfterCreated')
                    toast.fire({
                      type: 'success',
                      title: 'Store updated successfully'
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
                       this.form.delete('api/store/'+ id).then(() => {
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
                )
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
            getMonogramOnModal() {
              if(this.form.image == null) {
                return '/images/profile.png';
              } else {
                if(this.form.image.length > 200) {
                  return this.form.image;
                } else if(this.form.image.length == 0) {
                  return '/images/profile.png';
                } else {
                  return '/images/stores/' + this.form.image;
                }
              }
            },
            getStoreMonogram(image) {
              if(image == null) {
                return '/images/grocery.png';
              } else {
                if(image.length > 0) {
                  return '/images/stores/' + image;
                } else {
                  return '/images/grocery.png';
                }
              }
            },
            getPaginationResults(page = 1) {
              axios.get('api/store?page=' + page)
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
                  axios.get('api/searchstore/' + query)
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
