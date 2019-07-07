
export const routes = [
  // public routes
  { path: '/', component: require('./components/Public/PublicIndex.vue').default, meta: { title: 'ব্যাপারী'} },

  // public routes
  { path: '/dashboard', component: require('./components/Auth/Dashboard.vue').default, meta: { title: 'ড্যাশবোর্ড'} },

  { path: '/profile', component: require('./components/Auth/User/Profile.vue').default, meta: { title: 'প্রোফাইল'} },

  { path: '/users', component: require('./components/Auth/Admin/Users.vue').default, meta: { title: 'ব্যবহারকারী তালিকা'}},
  { path: '/roles', component: require('./components/Auth/Admin/Roles.vue').default, meta: { title: 'ব্যবহারকারী ধরন'} },
  { path: '/stores', component: require('./components/Auth/Admin/Stores.vue').default, meta: { title: 'দোকানের তালিকা'} },

  { path: '/store/:token/:code', component: require('./components/Auth/Store/Store.vue').default, meta: { title: 'দোকান'}, name: 'singleStore'},
  
  { path: '/products/:code', component: require('./components/Auth/Product/Products.vue').default, meta: { title: 'মালামাল তালিকা'}, name: 'productsPage'},
  { path: '/product/:id/:code', component: require('./components/Auth/Product/Product.vue').default, meta: { title: 'পণ্য'}, name: 'singleProduct'},
  
  { path: '/purchases/:code', component: require('./components/Auth/Purchase/Purchases.vue').default, meta: { title: 'ক্রয়ের তালিকা'}, name: 'purchasesPage'},
  
  { path: '/vendors/:code', component: require('./components/Auth/Vendor/Vendors.vue').default, meta: { title: 'ডিলার/ ভেন্ডরের তালিকা'}, name: 'vendorsPage'},
  { path: '/vendor/:id/:code', component: require('./components/Auth/Vendor/Vendor.vue').default, meta: { title: 'ডিলার/ ভেন্ডর'}, name: 'singleVendor'},
  { path: '/dues/:code', component: require('./components/Auth/Due/Dues.vue').default, meta: { title: 'দেনার হিসাব'}, name: 'duesPage'},


  { path: '/staffs/:code', component: require('./components/Auth/Staff/Staffs.vue').default, meta: { title: 'কর্মচারী তালিকা'}, name: 'staffsPage'},

  { path: '/customers/:code', component: require('./components/Auth/Customer/Customers.vue').default, meta: { title: 'কাস্টমার তালিকা'}, name: 'customersPage'},
  { path: '/customer/:id/:code', component: require('./components/Auth/Customer/Customer.vue').default, meta: { title: 'কাস্টমার'}, name: 'singleCustomer'},

  { path: '/expenses/:code', component: require('./components/Auth/Expense/Expenses.vue').default, meta: { title: 'খরচের হিসাব'}, name: 'expensesPage'},
  { path: '/expense/:id/:code', component: require('./components/Auth/Expense/Expense.vue').default, meta: { title: 'খরচ'}, name: 'singleExpense'},

  { path: '*', component: require('./components/404.vue').default, meta: { title: '404 Not Found'} },

];