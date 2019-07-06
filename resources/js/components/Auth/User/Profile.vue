<template>
    <div class="content">
      <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">প্রোফাইল</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">ড্যাশবোর্ড</router-link></li>
                  <li class="breadcrumb-item active">প্রোফাইল</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
              <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-info-active" style="background: url('/images/coverphoto.jpg') center center;">
                  
                </div>
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" :src="getUserProfilePhoto(user.image)" alt="User Avatar">
                </div>
                <div class="card-footer">
                  <div class="description-block">
                    <h3 class="description-header">{{ user.name }}</h3>
                    <h6 class="widget-user-desc">{{ user.mobile }}</h6>
                    <span class="description-text">{{ user.address }}</span>
                  </div>
                  <ul class="list-group">
                    <li class="list-group-item" v-for="store in user.stores" :key="store.id">
                      <router-link :to="{ name: 'singleStore', params: { token: store.token, code: store.code }}">
                        {{ store.name }}
                      </router-link>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><i class="fa fa-pencil"></i> প্রোফাইল সম্পাদনা</div>
                    <div class="card-body">
                      <form @submit.prevent="updateUser()" @keydown="form.onKeydown($event)">
                        <div class=row>
                          <div class="col-md-6">
                            <div class="form-group">
                              <input v-model="form.name" type="text" name="name" placeholder="নাম" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                              <has-error :form="form" field="name"></has-error>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <input v-model="form.mobile" type="text" name="mobile" placeholder="১১ ডিজিট মোবাইল নম্বর" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }" onkeypress="if(this.value.length==11) return false;">
                              <has-error :form="form" field="mobile"></has-error>
                            </div>
                          </div>
                        </div>
                        <div class=row>
                          <div class="col-md-6">
                            <div class="form-group">
                              <input v-model="form.email" type="text" name="email" placeholder="ইমেইল (যদি থাকে)" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                              <has-error :form="form" field="email"></has-error>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <input v-model="form.address" type="text" name="address" placeholder="ঠিকানা" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                              <has-error :form="form" field="address"></has-error>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <input type="file" v-on:change="uploadImage" name="image" placeholder="Image" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('image') }" ref="imageInput">
                          <has-error :form="form" field="image"></has-error>
                        </div>
                        <div class="form-group">
                          <input v-model="form.password" type="password" name="password" placeholder="Password" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                          <has-error :form="form" field="password"></has-error>
                        </div>
                        <center>
                          <img :src="getProfilePhotoOnModal()" class="img-responsive" style="max-height: 150px; width: auto;">
                        </center>
                        <button type="submit" class="btn btn-success">হালনাগাদ করুন</button>
                      </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
              user: {},
              // Create a new form instance
              form: new Form({
                id: '',
                name: '',
                email: '',
                mobile: '',
                address: '',
                image: '',
                password: ''
              }),
            }
        },
        methods: {
            loadUser() {
              var user_parsed = JSON.parse(this.$user);
              var user_id = user_parsed.id;
              axios.get('/api/user/'+user_id).then(
                ({ data }) => 
                (
                  this.user = data, 
                  this.form.fill(this.user),
                  this.profileNavImageLink = '/images/users/'+this.user.image
                ));
            },
            updateUser() {
                this.$Progress.start();
                this.form.put('/api/user/'+ this.form.id).then(() => {
                  Fire.$emit('AfterUserProfileUpdated');
                  Fire.$emit('updateuserdpinnav');
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
                );
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
                return '/images/profile.png';
              } else {
                if(this.form.image.length > 200) {
                  return this.form.image;
                } else if(this.form.image.length == 0) {
                  return '/images/profile.png';
                } else {
                  return '/images/users/' + this.form.image;
                }
              }
            },
            getUserProfilePhoto(image) {
              if(image == null) {
                return '/images/profile.png';
              } else {
                if(image.length > 0) {
                  return '/images/users/' + image;
                } else {
                  return '/images/profile.png';
                }
              }
            }
        },
        created() {
            this.loadUser();
            Fire.$on('AfterUserProfileUpdated', () => {
                this.loadUser();
                // this.$refs.imageInput.value = null; // giving an error
                // setTimeout(function(){
                //     location.reload();
                // }, 3000);

            });
        },
        beforeDestroy() {
          Fire.$off('AfterUserProfileUpdated')
          Fire.$off('updateuserdpinnav')
        }
    }
</script>
