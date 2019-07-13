<template>
    <div class="content">
       <div class="content-header" v-if="$gate.isAdminOrAssociated('sale-page', this.$route.params.code)">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">বিক্রয়ের তালিকা</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><router-link to="/dashboard">স্টোর</router-link></li>
                  <li class="breadcrumb-item active">বিক্রয়ের তালিকা</li>
                </ol>
              </div>
            </div>
          </div>
      </div>
      <!-- Header content -->
      
      <!-- /.content-header -->
      <div class="container-fluid" v-if="$gate.isAdminOrAssociated('sale-page', this.$route.params.code)">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">বিক্রয়সমূহ</h3>

                <div class="card-tools">
                  <!-- <button type="button" class="btn btn-success btn-sm" @click="addModal" v-tooltip="'প্রি-অর্ডার করুন'">
                      <i class="fa fa-user-plus"></i>
                  </button> -->
                  <button type="button" class="btn btn-primary btn-sm" @click="addModal" v-tooltip="'বিক্রয় করুন'">
                      <i class="fa fa-balance-scale"></i>
                  </button>
                  </div>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body table-responsive p-0">

                <table class="table table-hover">
                 <thead>
                  <tr>
                    <!-- <th>ID</th> -->
                    <th>বিক্রয় রশিদ নং</th>
                    <th>কাস্টমার</th>
                    <th>পণ্যসমূহ</th>
                    <th>প্রদেয়</th>
                    <th>পরিশোধিত</th>
                    <th>বকেয়া</th>
                    <th>সময় / তারিখ</th>
                    <th width="15%">ক্রিয়াকলাপ</th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr v-for="sale in sales.data" :key="sale.id">
                    <!-- <td>{{ sale.id }}</td> -->
                    <td>
                      {{ sale.code }}
                    </td>
                    <td>
                      <router-link :to="{ name: 'singleCustomer', params: { id: sale.customer.id, code: code }}" v-tooltip="'বিস্তারিত দেখুন'">
                        {{ sale.customer.name }}
                      </router-link>
                    </td>
                    <td>
                      <small>
                        <span v-for="item in sale.saleitems" class="badge badge-secondary">
                          {{ item.product.name }} ({{ item.quantity }} {{ item.product.unit }})
                        </span>
                      </small>
                    </td>
                    <td>
                      <small>
                        মোটঃ {{ sale.total_price }} ৳ <br/>
                        ডিসকাউন্ট {{ sale.discount }} {{ sale.discount_unit }}<br/>
                        পরিশোধনীয় মূল্যঃ {{ sale.payable }} ৳
                      </small>
                    </td>
                    <td>
                      {{ sale.paid }} ৳
                    </td>
                    <td>
                      {{ sale.due }} ৳
                    </td>
                    <td>
                      <small>{{ sale.created_at | datetime }}</small>
                    </td>
                    <td>
                        <a :href="'/pdf/sale/' + sale.id" class="btn btn-primary btn-sm" v-tooltip="'ডাউনলোড করুন'">
                            <i class="fa fa-download"></i>
                        </a>
                        <button @click="printSale(sale.id, sale.code)" class="btn btn-success btn-sm" v-tooltip="'প্রিন্ট করুন'">
                            <i class="fa fa-print"></i>
                        </button>
                        <!-- <button @click="deleteSale(sale.id)" class="btn btn-danger btn-sm" v-tooltip="'পণ্য ডিলেট করুন'">
                            <i class="fa fa-trash"></i>
                        </button> -->
                        <!-- delete kora jaabe na -->
                    </td>
                  </tr>
                 </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="sales" @pagination-change-page="getPaginationResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title" id="addModalLabel">পণ্য বিক্রয়</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <form @submit.prevent="createSale()" @keydown="form.onKeydown($event)">
                <!-- Modal body -->
                <div class="modal-body">
                  <div v-for="(range, index) in addformrange">
                    <div class="row" v-bind:id="range">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>পণ্য নির্ধারণ করুন <!-- {{ range }} {{ index }} --></label>
                          <v-select placeholder="পণ্য নির্ধারণ করুন" :options="products" :reduce="id => id" label="name" v-model="form.product[index]" ref='productSelect' :class="{ 'is-invalid': form.errors.has('products') }" @input="productSelected(form.product[index], index)"></v-select>
                          <has-error :form="form" field="products"></has-error>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>পরিমাণ <span v-html="productunit[index]"></span></label>
                          <input v-model="form.quantity[index]" type="number" step="any" name="quantity" placeholder="পরিমাণ" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }" @change="calculatePurchase" required="" oninvalid="this.setCustomValidity('পরিমাণ লিখুন')" oninput="setCustomValidity('')" :max="maxquantity[index]">
                          <has-error :form="form" field="quantity"></has-error>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <label>ক্রয়মূল্য/ ইউনিট</label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">৳</span>
                          </div>
                          <input v-model="form.unit_price[index]" type="number" step="any" name="unit_price" placeholder="বিক্রয়মূল্য/ ইউনিট" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('unit_price') }" @change="calculatePurchase" required="" oninvalid="this.setCustomValidity('বিক্রয়মূল্য/ ইউনিট লিখুন')" oninput="setCustomValidity('')">
                          <has-error :form="form" field="unit_price"></has-error>
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-group">
                          <label style="color: #fff">.</label><br/>
                          <button v-if="index != 0" class="btn btn-danger btn-sm" type="button" @click="removeProduct(index, range)" v-tooltip="'মুছে দিন'"><i class="fa fa-trash"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-11"></div>
                    <div class="col-md-1">
                      <button class="btn btn-success btn-sm" type="button" @click="appendProduct" v-tooltip="'আরও পণ্য যোগ করুন'"><i class="fa fa-plus"></i></button><br/><br/>
                    </div>
                  </div>
                  
                  <hr/>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>কাস্টমার নির্ধারণ</label> <!-- taggable kora nai ei muhurte... kore felte hobe (অপশনে না থাকলে লিখুন) -->
                        <v-select placeholder="কাস্টমার (নতুন যোগ করতে নাম লিখুন)" :options="customers" :reduce="id => id" label="name" v-model="form.customer" ref='customerSelect' :class="{ 'is-invalid': form.errors.has('customers') }" taggable></v-select>
                        <has-error :form="form" field="customers"></has-error>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label>সর্বমোট মূল্য</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">৳</span>
                        </div>
                        <input v-model="form.total_price" type="number" step="any" name="total" placeholder="সর্বমোট মূল্য" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('total') }" @change="calculatePayable">
                        <has-error :form="form" field="total"></has-error>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label>ডিসকাউন্ট</label>
                      <div class="input-group mb-3">
                        <input v-model="form.discount" type="number" step="any" name="discount" placeholder="ডিসকাউন্ট"
                          class="form-control" :class="{ 'is-invalid': form.errors.has('discount') }" autocomplete="off" style="width: 60%" @change="calculatePayable">
                        <select class="form-control input-group-append" v-model="form.discount_unit" name="discount_unit" @change="calculatePayable">
                          <option value="%">%</option>
                          <option value="৳">৳</option>
                        </select>
                        <has-error :form="form" field="discount"></has-error>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-3">
                      <label>পরিশোধের মাধ্যম</label>
                      <div class="form-group">
                        <select class="form-control" v-model="form.payment_method" :class="{ 'is-invalid': form.errors.has('payment_method') }" required="" oninvalid="this.setCustomValidity('পরিশোধের মাধ্যম নির্ধারণ করুন')" oninput="setCustomValidity('')">
                          <option value="" selected="" disabled="">পরিশোধের মাধ্যম নির্ধারণ করুন</option>
                          <option value="0">ক্যাশ</option>
                          <option value="1">ব্যাংক</option>
                          <option value="2">চেক</option>
                          <option value="3">বিকাশ</option>
                          <option value="4">রকেট</option>
                          <option value="5">নগদ (ডাকবিভাগ)</option>
                          <option value="6">ইউক্যাশ</option>
                          <option value="7">কিউ-ক্যাশ</option>
                          <option value="8">শিওরক্যাশ</option>
                          <option value="9">মোবিক্যাশ</option>
                          <option value="10">অন্যান্য</option>
                        </select>
                        <has-error :form="form" field="payment_method"></has-error>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label>পরিশোধনীয় মূল্য</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">৳</span>
                        </div>
                        <input v-model="form.payable" type="number" step="any" name="payable" placeholder="পরিশোধনীয় মূল্য" 
                          class="form-control" :class="{ 'is-invalid': form.errors.has('payable') }" readonly="">
                        <has-error :form="form" field="payable"></has-error>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label>পরিশোধ</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">৳</span>
                        </div>
                        <input v-model="form.paid" type="number" step="any" name="paid" placeholder="পরিশোধ"
                          class="form-control" :class="{ 'is-invalid': form.errors.has('paid') }" @change="calculatePayable">
                        <has-error :form="form" field="paid"></has-error>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label>বকেয়া</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">৳</span>
                        </div>
                        <input v-model="form.due" type="number" step="any" name="due" placeholder="বকেয়া"
                          class="form-control" :class="{ 'is-invalid': form.errors.has('due') }" readonly="">
                        <has-error :form="form" field="due"></has-error>
                      </div>
                    </div>
                  </div>
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
      </div><!-- /.container-fluid -->
      <div v-if="!$gate.isAdminOrAssociated('sale-page', this.$route.params.code)">
          <forbidden-403></forbidden-403>
      </div>
    </div>
    <!-- /.content -->
</template>

<script>
  export default {
      data () {
          return {
            sales: {},
            products: [],
            customers: [],
            code: this.$route.params.code,
            // Create a new form instance
            form: new Form({
              id: '',
              code: this.$route.params.code,
              product: [],
              customer: '',
              expire_date: [],
              quantity: [],
              unit_price: [],
              total_price: '',
              discount_unit: '%',
              payment_method: '',
              discount: '',
              payable: '',
              paid: '',
              due: '',
            }),
            maxquantity: [],
            productunit: [],
            addformrange: [0],
          }
      },
      methods: {
          addModal() {
            this.form.reset();
            $('#addModal').modal({ show: true, backdrop: 'static', keyboard: false });
            this.$refs.productSelect[0].clearSelection();
            this.$refs.customerSelect.clearSelection();

            this.addformrange.splice(0, this.addformrange.length);
            this.addformrange.push(0);

            this.loadProducts();
            this.loadCustomers();
          },
          loadProducts() {
            if(this.$gate.isAdminOrAssociated('sale-page', this.$route.params.code)){
              axios.get('/api/load/sale/product/' + this.$route.params.code).then(({ data }) => (this.products = data));
            }
          },
          loadCustomers() {
            if(this.$gate.isAdminOrAssociated('sale-page', this.$route.params.code)){
              axios.get('/api/load/sale/customer/' + this.$route.params.code).then(({ data }) => (this.customers = data));  
            }
          },
          loadSales() {
            if(this.$gate.isAdminOrAssociated('sale-page', this.$route.params.code)){
              axios.get('/api/load/sale/' + this.$route.params.code).then(({ data }) => (this.sales = data));
            }
          },
          appendProduct() {
            this.addformrange.push(parseInt(this.addformrange[this.addformrange.length - 1] || 0) + 1);
            console.log(this.addformrange);  
          },
          removeProduct(index, range) {
            $('#'+range).remove();
            // this.addformrange.splice(index, 1); // splice deletes from the last...
            // this.$delete(this.addformrange, index);
            this.form.product[index] = null;
            this.form.quantity[index] = 0;
            this.form.unit_price[index] = 0;
            this.maxquantity[index] = '';
            this.productunit[index] = '';

            this.calculatePurchase();

            // console.log(this.addformrange);
          },
          productSelected(product, index) {
            if(product) { 
              var maxquantity = 0;
              for(var i=0; i<product.stocks.length; i++) {
                maxquantity = maxquantity + parseFloat(product.stocks[i].quantity);
              }
              this.maxquantity[index] = maxquantity;
              this.productunit[index] = '<small style="color: red;">(স্টকঃ ' + maxquantity + ' ' + product.unit + ')</span>';
              this.form.unit_price[index] = product.stocks[0].selling_price;
            }
          },
          createSale() {
            this.$Progress.start();
            this.form.post('/api/sale').then(() => {
              $('#addModal').modal('hide')
              Fire.$emit('AfterSaleCreated')
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
          calculatePurchase() {
            var total_price = parseFloat(0.00);
            var discounted_total = parseFloat(0.00);
            var quantity = parseFloat(0.00);
            var unit_price = parseFloat(0.00);
            for(var i = 0; i < this.addformrange.length; i++) {
              quantity = parseFloat(this.form.quantity[i]) || 0;
              unit_price = parseFloat(this.form.unit_price[i]) || 0;
              var per_total =  quantity * unit_price;
              total_price = parseFloat(total_price) + parseFloat(per_total);
            }
            var discount_unit = this.form.discount_unit;
            var discount = parseFloat(this.form.discount) || 0;
            
            var discount_amount = parseFloat(0);

            if(discount > 0){
                if(discount_unit == '%'){
                    discount_amount = (discount * total_price) / 100;
                }else if(discount_unit == '৳'){
                    discount_amount = discount;
                }
            }
            discounted_total = total_price - discount_amount;

            if(total_price > 0){
              this.form.total_price =  total_price.toFixed(2);
              this.form.payable =  discounted_total.toFixed(2);
            } else {
              this.form.total_price =  0;
              this.form.payable =  0;
            }

            // call the below function to change the value of payable and due...
            this.calculatePayable();
          },
          calculatePayable() {
            var total_price = parseFloat(this.form.total_price) || 0;
            var paid = parseFloat(this.form.paid) || 0;

            var discount_unit = this.form.discount_unit;
            var discount = parseFloat(this.form.discount) || 0;
            var discount_amount = parseFloat(0);

            var discounted_total = total_price;

            if(discount > 0){
                if(discount_unit == '%'){
                    discount_amount = (discount * total_price) / 100;
                }else if(discount_unit == '৳'){
                    discount_amount = discount;
                }
            }
            discounted_total = total_price - discount_amount;

            this.form.payable =  discounted_total.toFixed(2);

            var due = parseFloat(discounted_total) - parseFloat(paid);

            if(due < 0){
                due = 0;
            }
            this.form.due =  due.toFixed(2);
          },
          deleteSale(id) {
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
                   this.form.delete('/api/purchase/'+ id).then(() => {
                     swal.fire(
                      'ডিলেট',
                      'ডিলেট সফল হয়েছে!',
                      'success'
                      )
                     Fire.$emit('AfterSaleCreated')
                   })
                   .catch(() => {
                     swal('Failed!', 'কিছু সমস্যা হচ্ছে, দুঃখিত!', 'warning');
                   }) 
                }

            })
          },
          printSale(id, code) {            
            // axios({
            //   method: 'get',
            //   url: '/api/pdf/purchase/' + id,
            //   responseType: 'arraybuffer'
            // }).then(function(response) {
            //   let blob = new Blob([response.data], { type: 'application/pdf' })
            //   let link = document.createElement('b')
            //   link.href = window.URL.createObjectURL(blob)
            //   link.download = 'Purchase_Receipt_'+ code +'.pdf'
            //   link.click()
            // })
          },
          getPaginationResults(page = 1) {
            axios.get('/api/load/sale/'+ this.$route.params.code +'?page=' + page)
            .then(response => {
              this.sales = response.data;
            });
          },
      },
      computed: {
        
      },
      created() {
          this.loadSales();
          
          Fire.$on('AfterSaleCreated', () => {
              this.loadSales();
          });

          // Fire.$on('searching', () => {
          //     let query = this.$parent.$parent.search;
          //     if(query != '') {
          //       axios.get('/api/searchpurchase/' + query)
          //       .then((data) => {
          //         this.sales = data.data;
          //       })
          //       .catch(() => {

          //       })
          //     } else {
          //       this.loadSales();
          //     }
              
          // });
      },
      beforeDestroy() {
        Fire.$off('AfterSaleCreated')
        // Fire.$off('searching')
      }
  }
</script>
