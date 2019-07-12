<template>
    <div class="content">
       <div class="content-header" v-if="$gate.isAdminOrAssociated('product-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">মালামালের তালিকা</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">স্টোর</router-link></li>
                  <li class="breadcrumb-item active">মালামালের তালিকা</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('product-page', this.$route.params.code)">
        <div class="row">
          <div class="col-md-9">
            <!-- <img src="images/click_here_2li1.svg" style="max-height: 200px;"> -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">মালামাল</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" @click="addProductModal" v-tooltip="'নতুন পণ্য যোগ করুন'">
                      <i class="fa fa-user-plus"></i>
                  </button> <!-- data-toggle="modal" data-target="#addProductModal" -->
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
                    <th>পণ্য</th>
                    <th>ধরণ</th>
                    <th>ডিলার/ ভেন্ডর</th>
                    <th>বর্তমান স্টক</th>
                    <th width="20%">ক্রিয়াকলাপ</th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr v-for="product in products.data" :key="product.id">
                    <!-- <td>{{ product.id }}</td> -->
                    <td>
                      <router-link :to="{ name: 'singleProduct', params: { id: product.id, code: code }}" v-tooltip="'বিস্তারিত দেখুন'">
                        {{ product.name }}
                      </router-link>
                      <br/>
                      <small class="text-muted">{{ product.brand }}</small>
                    </td>
                    <td>
                      {{ product.productcategory.name }}
                    </td>
                    <td v-html="removeDuplicateVendor(product.stocks)">
                      
                    </td>
                    <td>
                      <big><b>{{ product.stocks | totalquantity }}</b></big> {{ product.unit }}
                    </td>
                    <td>
                        <router-link :to="{ name: 'singleProduct', params: { id: product.id, code: code }}" class="btn btn-info btn-sm" v-tooltip="'বিস্তারিত দেখুন'">
                          <i class="fa fa-eye"></i>
                        </router-link>
                        <button type="button" class="btn btn-success btn-sm" @click="editProductModal(product)" v-tooltip="'পণ্য সম্পাদনা করুন'">
                            <i class="fa fa-edit"></i>
                        </button>
                        <!-- <button @click="deleteProduct(product.id)" class="btn btn-danger btn-sm" v-tooltip="'পণ্য ডিলেট করুন'">
                            <i class="fa fa-trash"></i>
                        </button> -->
                        <!-- delete korte deoa jaabe na -->
                    </td>
                  </tr>
                  
                 </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="products" @pagination-change-page="getPaginationResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-3">
            <!-- <img src="images/click_here_2li1.svg" style="max-height: 200px;"> -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">মালামাল ধরণ</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" @click="addCategoryModal" v-tooltip="'নতুন ধরণ যোগ করুন'">
                      <i class="fa fa-user-plus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body table-responsive p-0">

                <table class="table table-hover">
                 <thead>
                  <tr>
                    <!-- <th>ID</th> -->
                    <th>ধরণের নাম</th>
                    <th width="15%">Action</th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr v-for="category in categories" :key="category.id">
                    <!-- <td>{{ store.id }}</td> -->
                    <td>
                      <!-- <router-link :to="{ name: 'singleStore', params: { token: store.token, code: store.code }}">
                        
                      </router-link> -->
                      {{ category.name }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm" @click="editCategoryModal(category)" v-tooltip="'ধরণ সম্পাদনা করুন'">
                            <i class="fa fa-edit"></i>
                        </button>
                    </td>
                  </tr>
                 </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <!-- <pagination :data="categories" @pagination-change-page="getPaginationResults"></pagination> -->
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 v-show="editmode" class="modal-title" id="addProductModalLabel">পণ্য সম্পাদনা করুন</h4>
                <h4 v-show="!editmode" class="modal-title" id="addProductModalLabel">নতুন পণ্য যোগ করুন</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <form @submit.prevent="editmode ? updateProduct() : createProduct()" @keydown="form.onKeydown($event)">
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>পণ্যের নাম *</label>
                        <input v-model="form.name" type="text" name="name" placeholder="পণ্যের নাম *" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>পণ্যের ব্র্যান্ড/ মার্কা</label>
                        <input v-model="form.brand" type="text" name="brand" placeholder="পণ্যের ব্র্যান্ড/ মার্কা" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('brand') }">
                        <has-error :form="form" field="brand"></has-error>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>পন্যের ধরণ নির্ধারণ (অপশনে না থাকলে লিখুন) *</label>
                        <v-select placeholder="পন্যের ধরণ নির্ধারণ (অপশনে না থাকলে লিখুন) *" :options="categories" taggable label="name" v-model="form.productcategory" ref='categorySelect'></v-select>
                        <has-error :form="form" field="categories"></has-error>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>ইউনিট *</label>
                        <select v-model="form.unit" name="unit" placeholder="ইউনিট *" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('unit') }">
                          <option value="" selected="" disabled="">পণ্যের ইউনিট নির্ধারণ *</option>
                          <option value="কেজি">কেজি</option>
                          <option value="লিটার">লিটার</option>
                          <option value="পিস">পিস</option>
                          <option value="প্যাকেট">প্যাকেট</option>
                          <option value="ডজন">ডজন</option>
                          <option value="কার্টন">কার্টন</option>
                          <option value="রোল">রোল</option>
                          <option value="বস্তা">বস্তা</option>
                          <option value="প্রযোজ্য নয়">প্রযোজ্য নয়</option>
                        </select>
                        <has-error :form="form" field="unit"></has-error>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>পণ্যের কোড (ঐচ্ছিক)</label>
                        <input v-model="form.sku" type="text" name="sku" placeholder="পণ্যের কোড" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('sku') }">
                        <has-error :form="form" field="sku"></has-error>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>যে পরিমানের নিচে হলে এলার্ট চান</label>
                        <input v-model="form.stock_alert" type="number" step="any" name="stock_alert" placeholder="যে পরিমানের নিচে হলে এলার্ট চান" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('stock_alert') }">
                        <has-error :form="form" field="stock_alert"></has-error>
                      </div>
                    </div>
                  </div>

                  <div v-show="!editmode">
                    <hr/>
                    <p>বিদ্যমান স্টক প্রবেশ করাতে চাইলে</p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>ডিলার/ভেন্ডর নির্ধারণ (অপশনে না থাকলে লিখুন)</label>
                          <v-select placeholder="ডিলার/ভেন্ডর নির্ধারণ (অপশনে না থাকলে লিখুন)" :options="vendors" label="name" v-model="form.vendor" taggable ref='vendorSelect' :class="{ 'is-invalid': form.errors.has('vendors') }"></v-select>
                          <has-error :form="form" field="vendors"></has-error>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>নতুন স্টকের পরিমাণ</label>
                          <input v-model="form.quantity" type="number" step="any" name="quantity" placeholder="নতুন স্টকের পরিমাণ" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                          <has-error :form="form" field="quantity"></has-error>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label>ইউনিট প্রতি ক্রয়মূল্য</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">৳</span>
                          </div>
                          <input v-model="form.buying_price" type="number" step="any" name="buying_price" placeholder="ইউনিট প্রতি ক্রয়মূল্য" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('buying_price') }">
                          <has-error :form="form" field="buying_price"></has-error>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label>ইউনিট প্রতি বিক্রয়মূল্য</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">৳</span>
                          </div>
                          <input v-model="form.selling_price" type="number" step="any" name="selling_price" placeholder="ইউনিট প্রতি বিক্রয়মূল্য"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('selling_price') }">
                          <has-error :form="form" field="selling_price"></has-error>
                        </div>
                      </div>
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

        <!-- The Category Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 v-show="categoryeditmode" class="modal-title" id="addCategoryModalLabel">ধরণ সম্পাদনা করুন</h4>
                <h4 v-show="!categoryeditmode" class="modal-title" id="addCategoryModalLabel">নতুন ধরণ যোগ করুন</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <form @submit.prevent="categoryeditmode ? updateCategory() : createCategory()" @keydown="form.onKeydown($event)">
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="form-group">
                    <label>ধরণের নাম</label>
                    <input type="hidden" v-model="categoryform.code" name="code">
                    <input v-model="categoryform.name" type="text" name="name" placeholder="ধরণের নাম" 
                      class="form-control" :class="{ 'is-invalid': categoryform.errors.has('name') }">
                    <has-error :form="categoryform" field="name"></has-error>
                  </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                  <button v-show="categoryeditmode" type="submit" class="btn btn-success">হালনাগাদ করুন</button>
                  <button v-show="!categoryeditmode" type="submit" class="btn btn-success">দাখিল করুন</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">ফিরে যান</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
      <div v-if="!$gate.isAdminOrAssociated('product-page', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
    <!-- /.content -->
</template>

<script>
    export default {
        data () {
            return {
              products: {},
              categories: [],
              vendors: [],
              code: this.$route.params.code,
              // Create a new form instance
              form: new Form({
                id: '',
                code: this.$route.params.code,
                productcategory: '',
                vendor: '',
                name: '',
                brand: '',
                unit: '',
                sku: '',
                expire_date: '',
                stock_alert: '',
                quantity: '',
                buying_price: '',
                selling_price: ''
              }),
              // Create a category form instance
              categoryform: new Form({
                id: '',
                code: this.$route.params.code,
                name: '',
              }),
              editmode: false,
              categoryeditmode: false,
            }
        },
        methods: {
            addProductModal() {
                this.editmode = false;
                this.form.reset();
                $('#addProductModal').modal({ show: true, backdrop: 'static', keyboard: false });
                this.$refs.categorySelect.clearSelection();
                this.$refs.vendorSelect.clearSelection();

                this.loadCategories();
                this.loadVendors();
            },
            editProductModal(product) {
                this.editmode = true;
                this.form.reset(); // clears fields
                this.form.clear(); // clears errors
                $('#addProductModal').modal({ show: true, backdrop: 'static', keyboard: false });
                this.$refs.categorySelect.clearSelection();
                this.$refs.vendorSelect.clearSelection();

                this.loadCategories();
                this.loadVendors();

                this.form.fill(product);                             
            },
            addCategoryModal() {
                this.categoryeditmode = false;
                this.categoryform.reset();
                $('#addCategoryModal').modal({ show: true, backdrop: 'static', keyboard: false });
            },
            editCategoryModal(category) {
                this.categoryeditmode = true;
                this.categoryform.reset(); // clears fields
                this.categoryform.clear(); // clears errors
                $('#addCategoryModal').modal({ show: true, backdrop: 'static', keyboard: false });

                this.categoryform.fill(category);                
            },
            loadVendors() {
                if(this.$gate.isAdminOrAssociated('product-page', this.$route.params.code)){
                  axios.get('/api/load/product/vendor/' + this.$route.params.code).then(({ data }) => (this.vendors = data));  
                }
            },
            loadProducts() {
                if(this.$gate.isAdminOrAssociated('product-page', this.$route.params.code)){
                  axios.get('/api/load/product/' + this.$route.params.code).then(({ data }) => (this.products = data));
                }
            },
            removeDuplicateVendor(stocks) {
              var vendors = [];
              var markup = '';
              if(stocks) {
                for(var i=0; i<stocks.length; i++) {
                  vendors.push(stocks[i].vendor.name);
                }
              }
              let unique = [...new Set(vendors)];
              unique.map(function(value, key) {
                markup += '<span class="badge badge-pill badge-info"> '+ value +' </span>'
              });
              return markup;
            },
            createProduct() {
                this.$Progress.start();
                this.form.post('/api/product').then(() => {
                  $('#addProductModal').modal('hide')
                  Fire.$emit('AfterProductCreatedOrUpdated')
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
            updateProduct() {
                this.$Progress.start();
                this.form.put('/api/product/'+ this.form.id).then(() => {
                  $('#addProductModal').modal('hide')
                  Fire.$emit('AfterProductCreatedOrUpdated')
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
            deleteProduct(id) {
                swal.fire({
                  title: 'আপনি কি নিশ্চিত?',
                  text: "ডিলেট করলে আর ফেরত পাওয়া যাবে না!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'নিশ্চিত করছি',
                  cancelButtonText: 'ফিরে যান'
                }).then((result) => {
                    if (result.value) {
                       this.form.delete('/api/product/'+ id).then(() => {
                         swal.fire(
                          'ডিলেট',
                          'ডিলেট সফল হয়েছে!',
                          'success'
                          )
                         Fire.$emit('AfterProductCreatedOrUpdated')
                       })
                       .catch(() => {
                         swal('Failed!', 'কিছু সমস্যা হচ্ছে, দুঃখিত!', 'warning');
                       }) 
                    }

                })
            },
            getPaginationResults(page = 1) {
              axios.get('/api/load/product/'+ this.$route.params.code +'?page=' + page)
              .then(response => {
                this.products = response.data;
              });
            },
            loadCategories() {
                if(this.$gate.isAdminOrAssociated('product-page', this.$route.params.code)){
                  axios.get('/api/product/category/' + this.$route.params.code).then(({ data }) => (this.categories = data));  
                }
            },
            createCategory() {
                this.$Progress.start();
                this.categoryform.post('/api/product/category/store').then(() => {
                  $('#addCategoryModal').modal('hide')
                  Fire.$emit('AfterCategoryCreatedOrUpdated')
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
            updateCategory() {
                this.$Progress.start();
                this.categoryform.put('/api/product/category/update/'+ this.categoryform.id).then(() => {
                  $('#addCategoryModal').modal('hide')
                  Fire.$emit('AfterCategoryCreatedOrUpdated')
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
        },
        computed: {
          
        },
        created() {
            this.loadProducts();            
            this.loadCategories()
            
            Fire.$on('AfterProductCreatedOrUpdated', () => {
                this.loadProducts();
            });
            Fire.$on('AfterCategoryCreatedOrUpdated', () => {
                this.loadCategories();
                this.loadProducts();
            });

            Fire.$on('searching', () => {
                let query = this.$parent.$parent.search;
                if(query != '') {
                  axios.get('/api/searchproduct/' + query)
                  .then((data) => {
                    this.products = data.data;
                  })
                  .catch(() => {

                  })
                } else {
                  this.loadProducts();
                }
                
            });
        },
        beforeDestroy() {
          Fire.$off('AfterProductCreatedOrUpdated')
          Fire.$off('AfterCategoryCreatedOrUpdated')
          // Fire.$off('searching')
        }
    }
</script>
