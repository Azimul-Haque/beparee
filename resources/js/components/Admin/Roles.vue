<template>
    <div class="content">
       <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">ব্যবহারকারী ধরন</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">ড্যাশবোর্ড</router-link></li>
                  <li class="breadcrumb-item active">ব্যবহারকারী ধরন</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8">
            <!-- <img src="images/click_here_2li1.svg" style="max-height: 200px;"> -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">ধরন তালিকা</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" @click="addRole">
                      <i class="fa fa-user-plus"></i>
                  </button> 
                </div>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body table-responsive p-0">

                <table class="table table-hover">
                 <thead>
                  <tr>
                    <!-- <th>আইডি</th> -->
                    <th>নাম</th>
                    <th>ডিসপ্লে নাম</th>
                    <th>বিবরণ</th>
                    <th>অনুমতিসমূহ</th>
                    <th width="15%">Action</th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr v-for="role in roles.data" :key="role.id">
                    <!-- <td>{{ role.id }}</td> -->
                    <td>{{ role.name }}</td>
                    <td>{{ role.display_name }}</td>
                    <td>{{ role.description }}</td>
                    <td>
                      <span v-for="permission in role.permissions" :key="permission.id" class="badge badge-success" style="margin-left: 5px;">{{ permission.display_name }}</span>
                    </td>
                    <!-- <td>{{ role.created_at | date }}</td> -->
                    <td>
                      <button type="button" class="btn btn-success btn-sm" @click="editRole(role)">
                          <i class="fa fa-edit"></i>
                      </button>
                      <button @click="deleteRole(role.id)" class="btn btn-danger btn-sm">
                          <i class="fa fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                  
                 </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="roles" @pagination-change-page="getPaginationResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>

          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h3 v-show="editmode" class="card-title">{{ form.display_name }}-সম্পাদনা করুন</h3>
                <h3 v-show="!editmode" class="card-title">নতুন ধরন যোগ করুন</h3>

                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body">
                <form @submit.prevent="editmode ? updateRole() : createRole()" @keydown="form.onKeydown($event)">
                    <div class="form-group">
                        <input v-model="form.name" type="text" name="name" placeholder="নাম" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                        <input v-model="form.display_name" type="text" name="display_name" placeholder="ডিসপ্লে নাম" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('display_name') }">
                        <has-error :form="form" field="display_name"></has-error>
                    </div>
                    <div class="form-group">
                        <input v-model="form.description" type="text" name="description" placeholder="বিবরণ" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                        <has-error :form="form" field="description"></has-error>
                    </div>
                    <div class="form-group">
                        <!-- <select v-model="form.roles" name="roles[]" class="form-control" :class="{ 'is-invalid': form.errors.has('roles') }" multiple="multiple" id="roles">
                            <option value="" selected="" disabled="">ধরণ সিলেক্ট করুন</option>
                            <option v-for="role in roles" v-bind:value="role.id" :selected="role.id == 1">{{ role.display_name }}</option>
                        </select>
                        <has-error :form="form" field="roles"></has-error> -->
                        <v-select placeholder="অনুমতি প্রদান" :options="permissions" :reduce="id => id" label="display_name" multiple v-model="form.permissions" ref='theSelect'></v-select>
                    </div>

                    <button v-show="editmode" type="submit" class="btn btn-success">হালনাগাদ করুন</button>
                    <button v-show="!editmode" type="submit" class="btn btn-success">দাখিল করুন</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</template>

<script>
    export default {
        data () {
            return {
              roles: {},
              permissions: [],
              // Create a new form instance
              form: new Form({
                id: '',
                name: '',
                display_name: '',
                description: '',
                permissions: []
              }),
              editmode: false
            }
        },
        methods: {
            addRole() {
                this.editmode = false;
                this.form.reset();
                this.$refs.theSelect.clearSelection();
            },
            editRole(user) {
                this.editmode = true;
                this.form.reset(); // clears fields
                this.form.clear(); // clears errors
                this.form.fill(user);
                this.$refs.theSelect.clearSelection();
            },
            loadPermissions() {
                axios.get('api/permissions').then(({ data }) => {
                    (this.permissions = data);
                });
            },
            loadRoles() {
                axios.get('api/roles/list').then(({ data }) => (this.roles = data));
            },
            createRole() {
                if(this.form.permissions.length == 0) {
                   toast.fire({
                      type: 'warning',
                      title: 'অনুমতি প্রদান করুন!'
                    });
                    this.form.prevent;
                }
                this.$Progress.start();
                this.form.post('api/role/create').then(() => {
                    Fire.$emit('AfterCreated')
                    toast.fire({
                      type: 'success',
                      title: 'সফলভাবে সংরক্ষণ হয়েছে!'
                    })
                    this.$Progress.finish();
                    this.addRole();
                    // this.$refs.theSelect.clearSelection();
                })
                .catch(() => {
                    this.$Progress.fail();
                })
            },
            updateRole() {
                this.$Progress.start();
                this.form.put('api/role/update/'+ this.form.id).then(() => {
                    Fire.$emit('AfterCreated')
                    toast.fire({
                      type: 'success',
                      title: 'সফলভাবে হালনাগাদ করা হয়েছে!'
                    })
                    this.$Progress.finish();
                    this.addRole();
                    // this.$refs.theSelect.clearSelection();
                })
                .catch(() => {
                    this.$Progress.fail();
                    // swal('Failed!', 'There was something wrong', 'warning');
                })
            },
            deleteRole(id) {
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
                       this.form.delete('api/role/delete/'+ id).then(() => {
                         swal.fire(
                          'Deleted!',
                          'সফলভাবে ডিলেট করা হয়েছে!',
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
        
            getPaginationResults(page = 1) {
              axios.get('api/roles/list?page=' + page)
              .then(response => {
                this.roles = response.data;
              });
            }
        },
        created() {
            this.loadRoles();
            this.loadPermissions();
            
            Fire.$on('AfterCreated', () => {
                this.loadRoles();
            });

            Fire.$on('searching', () => {
                let query = this.$parent.search;
                if(query != '') {
                  axios.get('api/searchrole/' + query)
                  .then((data) => {
                    this.roles = data.data;
                  })
                  .catch(() => {

                  })
                } else {
                  this.loadRoles();
                }
                
            });
        }
    }
</script>
