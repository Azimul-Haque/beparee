
export const routes = [
  // public routes
  { path: '/', component: require('./components/Public/PublicIndex.vue').default, meta: { title: 'ব্যাপারী'} },
  { path: '/login', component: require('./components/Public/Login.vue').default, meta: { title: 'লগইন'} },

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
  
  { path: '/sales/:code', component: require('./components/Auth/Sales/Sales.vue').default, meta: { title: 'বিক্রয়ের তালিকা'}, name: 'salesPage'},

  { path: '/vendors/:code', component: require('./components/Auth/Vendor/Vendors.vue').default, meta: { title: 'ডিলার/ ভেন্ডরের তালিকা'}, name: 'vendorsPage'},
  { path: '/vendor/:id/:code', component: require('./components/Auth/Vendor/Vendor.vue').default, meta: { title: 'ডিলার/ ভেন্ডর'}, name: 'singleVendor'},
  { path: '/dues/:code', component: require('./components/Auth/Due/Dues.vue').default, meta: { title: 'দেনার হিসাব'}, name: 'duesPage'},


  { path: '/staffs/:code', component: require('./components/Auth/Staff/Staffs.vue').default, meta: { title: 'কর্মচারী তালিকা'}, name: 'staffsPage'},
  { path: '/staff/:id/:code', component: require('./components/Auth/Staff/Staff.vue').default, meta: { title: 'কর্মচারী'}, name: 'singleStaff'},

  { path: '/customers/:code', component: require('./components/Auth/Customer/Customers.vue').default, meta: { title: 'কাস্টমার তালিকা'}, name: 'customersPage'},
  { path: '/customer/:id/:code', component: require('./components/Auth/Customer/Customer.vue').default, meta: { title: 'কাস্টমার'}, name: 'singleCustomer'},

  { path: '/expenses/:code', component: require('./components/Auth/Expense/Expenses.vue').default, meta: { title: 'খরচের হিসাব'}, name: 'expensesPage'},
  { path: '/expense/:id/:code', component: require('./components/Auth/Expense/Expense.vue').default, meta: { title: 'খরচ'}, name: 'singleExpense'},

  { path: '/customer-dues/:code', component: require('./components/Auth/Customerdue/Customerdues.vue').default, meta: { title: 'কাস্টমারের বকেয়ার হিসাব'}, name: 'customerduesPage'},
  
  { path: '/accounts/:code', component: require('./components/Auth/Accounts/Account.vue').default, meta: { title: 'হিসাব-নিকাশ'}, name: 'accountsPage'},
  
  { path: '/reports/:code', component: require('./components/Auth/Reports/Report.vue').default, meta: { title: 'রিপোর্ট'}, name: 'reportsPage'},

  { path: '*', component: require('./components/404.vue').default, meta: { title: '404 Not Found'} },

];