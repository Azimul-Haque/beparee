
export const routes = [
  // public routes
  { path: '/', component: require('./components/Public/PublicIndex.vue').default, meta: { title: 'দোকান খাতা'} },
  { path: '/login', component: require('./components/Public/Login.vue').default, meta: { title: 'লগইন | দোকান খাতা (Dokan Khata)'} },

  // public routes
  { path: '/dashboard', component: require('./components/Auth/Dashboard.vue').default, meta: { title: 'ড্যাশবোর্ড | দোকান খাতা (Dokan Khata)'} },

  { path: '/profile', component: require('./components/Auth/User/Profile.vue').default, meta: { title: 'প্রোফাইল | দোকান খাতা (Dokan Khata)'} },

  { path: '/users', component: require('./components/Auth/Admin/Users.vue').default, meta: { title: 'ব্যবহারকারী তালিকা | দোকান খাতা (Dokan Khata)'}},
  { path: '/roles', component: require('./components/Auth/Admin/Roles.vue').default, meta: { title: 'ব্যবহারকারী ধরন | দোকান খাতা (Dokan Khata)'} },
  { path: '/stores', component: require('./components/Auth/Admin/Stores.vue').default, meta: { title: 'দোকানের তালিকা | দোকান খাতা (Dokan Khata)'} },

  { path: '/store/:token/:code', component: require('./components/Auth/Store/Store.vue').default, meta: { title: 'দোকান | দোকান খাতা (Dokan Khata)'}, name: 'singleStore'},
  
  { path: '/products/:code', component: require('./components/Auth/Product/Products.vue').default, meta: { title: 'মালামাল তালিকা | দোকান খাতা (Dokan Khata)'}, name: 'productsPage'},
  { path: '/product/:id/:code', component: require('./components/Auth/Product/Product.vue').default, meta: { title: 'পণ্য | দোকান খাতা (Dokan Khata)'}, name: 'singleProduct'},
  
  { path: '/purchases/:code', component: require('./components/Auth/Purchase/Purchases.vue').default, meta: { title: 'ক্রয়ের তালিকা | দোকান খাতা (Dokan Khata)'}, name: 'purchasesPage'},
  { path: '/purchase/new/:code', component: require('./components/Auth/Purchase/Purchase.vue').default, meta: { title: 'পণ্য ক্রয়ের করুন | দোকান খাতা (Dokan Khata)'}, name: 'purchasePage'},
  
  { path: '/sales/:code', component: require('./components/Auth/Sales/Sales.vue').default, meta: { title: 'বিক্রয়ের তালিকা | দোকান খাতা (Dokan Khata)'}, name: 'salesPage'},
  { path: '/sale/new/:code', component: require('./components/Auth/Sales/Sale.vue').default, meta: { title: 'পণ্য বিক্রয় করুন | দোকান খাতা (Dokan Khata)'}, name: 'salePage'},

  { path: '/vendors/:code', component: require('./components/Auth/Vendor/Vendors.vue').default, meta: { title: 'ডিলার/ ভেন্ডরের তালিকা | দোকান খাতা (Dokan Khata)'}, name: 'vendorsPage'},
  { path: '/vendor/:id/:code', component: require('./components/Auth/Vendor/Vendor.vue').default, meta: { title: 'ডিলার/ ভেন্ডর | দোকান খাতা (Dokan Khata)'}, name: 'singleVendor'},
  { path: '/dues/:code', component: require('./components/Auth/Due/Dues.vue').default, meta: { title: 'দেনার হিসাব | দোকান খাতা (Dokan Khata)'}, name: 'duesPage'},


  { path: '/staffs/:code', component: require('./components/Auth/Staff/Staffs.vue').default, meta: { title: 'কর্মচারী তালিকা | দোকান খাতা (Dokan Khata)'}, name: 'staffsPage'},
  { path: '/staff/:id/:code', component: require('./components/Auth/Staff/Staff.vue').default, meta: { title: 'কর্মচারী | দোকান খাতা (Dokan Khata)'}, name: 'singleStaff'},

  { path: '/customers/:code', component: require('./components/Auth/Customer/Customers.vue').default, meta: { title: 'কাস্টমার তালিকা | দোকান খাতা (Dokan Khata)'}, name: 'customersPage'},
  { path: '/customer/:id/:code', component: require('./components/Auth/Customer/Customer.vue').default, meta: { title: 'কাস্টমার | দোকান খাতা (Dokan Khata)'}, name: 'singleCustomer'},

  { path: '/expenses/:code', component: require('./components/Auth/Expense/Expenses.vue').default, meta: { title: 'খরচের হিসাব | দোকান খাতা (Dokan Khata)'}, name: 'expensesPage'},
  { path: '/expense/:id/:code', component: require('./components/Auth/Expense/Expense.vue').default, meta: { title: 'খরচ | দোকান খাতা (Dokan Khata)'}, name: 'singleExpense'},

  { path: '/customer-dues/:code', component: require('./components/Auth/Customerdue/Customerdues.vue').default, meta: { title: 'কাস্টমারের বকেয়ার হিসাব | দোকান খাতা (Dokan Khata)'}, name: 'customerduesPage'},
  
  { path: '/accounts/:code', component: require('./components/Auth/Accounts/Account.vue').default, meta: { title: 'হিসাব-নিকাশ একনজরে | দোকান খাতা (Dokan Khata)'}, name: 'accountsPage'},
  
  { path: '/reports/:code', component: require('./components/Auth/Reports/Report.vue').default, meta: { title: 'রিপোর্ট | দোকান খাতা (Dokan Khata)'}, name: 'reportsPage'},

  { path: '*', component: require('./components/404.vue').default, meta: { title: '404 Not Found'} },

];