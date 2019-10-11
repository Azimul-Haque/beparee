<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Store;
use App\Vendor;
use App\Product;
use App\Stock;
use App\Purchase;
use App\Sale;
use App\Saleitem;
use App\Staff;
use App\Staffattendance;
use App\Duehistory;
use App\Customerdue;
use App\Expensecategory;
use App\Expense;
use App\Customer;

use PDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PDFController extends Controller
{
    public function singlePurchaseReceiptPDF($id)
    {
        $purchase = Purchase::findOrFail($id);

        $anysinglestock = Stock::where('purchase_id', $purchase->id)->first();

        $pdf = PDF::loadView('dashboard.purchase.pdf.receipt', ['purchase' => $purchase, 'anysinglestock' => $anysinglestock]);
        $fileName = 'Purchase_Receipt_' . $purchase->code . '.pdf';
        return $pdf->download($fileName);
    }

    public function singleSaleReceiptPDF($id)
    {
        $sale = Sale::findOrFail($id);

        $anysinglesaleitem = Saleitem::where('sale_id', $sale->id)->first();

        $pdf = PDF::loadView('dashboard.sale.pdf.receipt', ['sale' => $sale, 'anysinglesaleitem' => $anysinglesaleitem]);
        $fileName = 'Sale_Receipt_' . $sale->code . '.pdf';
        return $pdf->download($fileName);
    }

    public function productReportPDF($id, $type, $code)
    {
        $product = Product::findOrFail($id);
        $store = Store::where('code', $code)->first();

        if($type == 'stock_list') {
            $stocks = Stock::where('product_id', $id)
                           ->orderBy('id', 'DESC')
                           ->get();

            $pdf = PDF::loadView('dashboard.reports.product.stocks', ['stocks' => $stocks, 'product' => $product, 'store' => $store]);
            $fileName = 'Product_Report_' . $product->name . '.pdf';
            return $pdf->stream($fileName);

        } elseif ($type == 'sales_list') {
            $saleitems = Saleitem::where('product_id', $id)
                             ->orderBy('id', 'desc')
                             ->get();

            $pdf = PDF::loadView('dashboard.reports.product.sales', ['saleitems' => $saleitems, 'product' => $product, 'store' => $store]);
            $fileName = 'Product_Report_' . $product->name . '.pdf';
            return $pdf->stream($fileName);
        }     
    }

    public function purchaseReportPDF($id, $start, $end, $code)
    {
        $store = Store::where('code', $code)->first();

        if($id == 0) {
            $purchases = Purchase::where('store_id', $store->id)
                                ->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end . '+1 day'))])
                                ->get();              
            // dd($purchases);         
            $pdf = PDF::loadView('dashboard.reports.purchase.allvendors', ['purchases' => $purchases, 'store' => $store, 'start' => $start, 'end' => $end], [] ,['mode' => 'utf-8', 'format' => 'A4-L']);
            $fileName = 'Purchase_Report_'. date('F_d_Y', strtotime($start)). '_to_' .date('F_d_Y', strtotime($end)).'.pdf';
            return $pdf->stream($fileName);
        } else {
            $purchases = Purchase::whereHas('stocks', function($q) use($id, $start, $end) {
                        $q->where('vendor_id', $id);
                        $q->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end . '+1 day'))]);
                    })->get();

            $vendor = Vendor::findOrFail($id);

            $pdf = PDF::loadView('dashboard.reports.purchase.singlevendor', ['purchases' => $purchases, 'vendor' => $vendor, 'store' => $store, 'start' => $start, 'end' => $end], [] ,['mode' => 'utf-8', 'format' => 'A4-L']);
            $fileName = 'Purchase_Report_'. date('F_d_Y', strtotime($start)). '_to_' .date('F_d_Y', strtotime($end)).'.pdf';
            return $pdf->stream($fileName);
        }     
    }

    public function dueReportPDF($id, $start, $end, $code)
    {
        $store = Store::where('code', $code)->first();

        if($id == 0) {
            $vendors = Vendor::where('store_id', $store->id)->get();              
            // dd($purchases);         
            $pdf = PDF::loadView('dashboard.reports.vendordue.allvendors', ['vendors' => $vendors, 'store' => $store]);
            $fileName = 'Due_Report_All_'. $store->code .'.pdf';
            return $pdf->stream($fileName);
        } else {
            $duehistories = Duehistory::where('vendor_id', $id)
                                      ->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end . '+1 day'))])
                                      ->get();

            $vendor = Vendor::findOrFail($id);

            $pdf = PDF::loadView('dashboard.reports.vendordue.vendorduehistories', ['duehistories' => $duehistories, 'vendor' => $vendor, 'store' => $store, 'start' => $start, 'end' => $end]);
            $fileName = 'Due_Report_'. date('F_d_Y', strtotime($start)). '_to_' .date('F_d_Y', strtotime($end)).'.pdf';
            return $pdf->stream($fileName);
        }     
    }

    public function saleReportPDF($id, $start, $end, $code)
    {
        $store = Store::where('code', $code)->first();

        if($id == 0) {
            $sales = Sale::where('store_id', $store->id)
                         ->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end . '+1 day'))])
                         ->get();

            $pdf = PDF::loadView('dashboard.reports.sale.allproducts', ['sales' => $sales, 'store' => $store, 'start' => $start, 'end' => $end], [] ,['mode' => 'utf-8', 'format' => 'A4-L']);
            $fileName = 'Sale_Report_All_'. $store->code .'.pdf';
            return $pdf->stream($fileName);
        } else {
            $product = Product::findOrFail($id);
            $saleitems = Saleitem::where('product_id', $id)
                                 ->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end . '+1 day'))])
                                 ->orderBy('id', 'desc')
                                 ->get();

            $pdf = PDF::loadView('dashboard.reports.sale.singleproduct', ['saleitems' => $saleitems, 'product' => $product, 'store' => $store, 'start' => $start, 'end' => $end]);
            $fileName = 'Single_Product_Sale_Report_' . $store->code . '.pdf';
            return $pdf->stream($fileName);
        }     
    }

    public function customerReportPDF($id, $start, $end, $code)
    {
        $store = Store::where('code', $code)->first();

        if($id == 0) {
            // completely used the saleReportPDF method's first aproach
            // completely used the saleReportPDF method's first aproach
            $sales = Sale::where('store_id', $store->id)
                         ->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end . '+1 day'))])
                         ->get();

            $pdf = PDF::loadView('dashboard.reports.sale.allproducts', ['sales' => $sales, 'store' => $store, 'start' => $start, 'end' => $end], [] ,['mode' => 'utf-8', 'format' => 'A4-L']);
            $fileName = 'Sale_Report_All_'. $store->code .'.pdf';
            return $pdf->stream($fileName);
        } else {
            $customer = Customer::findOrFail($id);
            $sales = Sale::where('customer_id', $id)
                                 ->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end . '+1 day'))])
                                 ->orderBy('id', 'desc')
                                 ->get();

            $pdf = PDF::loadView('dashboard.reports.customer.singlecustomer', ['sales' => $sales, 'customer' => $customer, 'store' => $store, 'start' => $start, 'end' => $end], [] ,['mode' => 'utf-8', 'format' => 'A4-L']);
            $fileName = 'Single_Customer_Sale_Report_' . $store->code . '.pdf';
            return $pdf->stream($fileName);
        }     
    }

    public function customerDueReportPDF($id, $start, $end, $code)
    {
        $store = Store::where('code', $code)->first();

        if($id == 0) {
            $customers = Customer::where('store_id', $store->id)->get();

            $pdf = PDF::loadView('dashboard.reports.customerdue.allcustomers', ['customers' => $customers, 'store' => $store]);
            $fileName = 'HALKHATA_Report_'. $store->code .'.pdf';
            return $pdf->stream($fileName);
        } else {
            $customerdues = Customerdue::where('customer_id', $id)
                                      ->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end . '+1 day'))])
                                      ->get();

            $customer = Customer::findOrFail($id);

            $pdf = PDF::loadView('dashboard.reports.customerdue.singlecustomerdues', ['customerdues' => $customerdues, 'customer' => $customer, 'store' => $store, 'start' => $start, 'end' => $end]);
            $fileName = 'Customer_Due_Report_'. date('F_d_Y', strtotime($start)). '_to_' .date('F_d_Y', strtotime($end)).'.pdf';
            return $pdf->stream($fileName);
        }     
    }

    public function expenseReportPDF($id, $start, $end, $code)
    {
        $store = Store::where('code', $code)->first();

        if($id == 0) {
            $expenses = Expense::where('store_id', $store->id)
                               ->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end . '+1 day'))])
                               ->get();

            $pdf = PDF::loadView('dashboard.reports.expense.allcategories', ['expenses' => $expenses, 'store' => $store, 'start' => $start, 'end' => $end]);
            $fileName = 'Expense_Report_'. $store->code .'.pdf';
            return $pdf->stream($fileName);
        } else {
            $expenses = Expense::where('store_id', $store->id)
                               ->where('expensecategory_id', $id)
                               ->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end . '+1 day'))])
                               ->get();

            $category = Expensecategory::findOrFail($id);

            $pdf = PDF::loadView('dashboard.reports.expense.singlecategory', ['expenses' => $expenses, 'category' => $category, 'store' => $store, 'start' => $start, 'end' => $end]);
            $fileName = 'Single_Expense_Report_'. date('F_d_Y', strtotime($start)). '_to_' .date('F_d_Y', strtotime($end)).'.pdf';
            return $pdf->stream($fileName);
        }     
    }

    public function salaryReportPDF($id, $start, $end, $code)
    {
        $store = Store::where('code', $code)->first();

        if($id == 0) {
            $salaries = Expense::where('store_id', $store->id)
                               ->where('expensecategory_id', 1) // 1 for salary
                               ->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end . '+1 day'))])
                               ->get();

            $pdf = PDF::loadView('dashboard.reports.salary.allstaffs', ['salaries' => $salaries, 'store' => $store, 'start' => $start, 'end' => $end]);
            $fileName = 'Salary_Report_'. $store->code .'.pdf';
            return $pdf->stream($fileName);
        } else {
            $salaries = Expense::where('store_id', $store->id)
                               ->where('expensecategory_id', 1) // 1 for salary
                               ->where('staff_id', $id)
                               ->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end . '+1 day'))])
                               ->get();

            $staff = Staff::findOrFail($id);

            $pdf = PDF::loadView('dashboard.reports.salary.singlesalary', ['salaries' => $salaries, 'staff' => $staff, 'store' => $store, 'start' => $start, 'end' => $end]);
            $fileName = 'Single_Salary_Report_'. date('F_d_Y', strtotime($start)). '_to_' .date('F_d_Y', strtotime($end)).'.pdf';
            return $pdf->stream($fileName);
        }     
    }

    public function staffReportPDF($staff_id, $month, $year, $code)
    {   
        $store = Store::where('code', $code)->first();
        $year_month = $year.'-'.str_pad(bangla_month_to_eng_month($month), 2, "0", STR_PAD_LEFT);


        if($staff_id == 0) {
            $attendances = Staffattendance::where('store_id', $store->id)
                                          ->where(DB::raw("DATE_FORMAT(date, '%Y-%m')"), "=", Carbon::parse($year_month)->format('Y-m'))
                                          ->orderBy('date', 'asc')
                                          ->get();
            
            $groupedattendance = $attendances->groupBy('date');


            $pdf = PDF::loadView('dashboard.reports.staff.allstaffs', ['attendances' => $groupedattendance, 'month' => $month, 'year' => $year, 'store' => $store]);
            $fileName = 'All_Staff_Report_' . $year_month . '.pdf';
            return $pdf->stream($fileName);
        } else {
            $attendances = Staffattendance::where('store_id', $store->id)
                                          ->where('staff_id', $staff_id)
                                          ->where(DB::raw("DATE_FORMAT(date, '%Y-%m')"), "=", Carbon::parse($year_month)->format('Y-m'))
                                          ->groupBy('date')
                                          ->orderBy('date', 'asc')
                                          ->get();
            $staff = Staff::findOrFail($staff_id);
            
            $pdf = PDF::loadView('dashboard.reports.staff.singlestaff', ['attendances' => $attendances, 'staff' => $staff, 'month' => $month, 'year' => $year, 'store' => $store]);
            $fileName = $staff->name . ' Report_' . $year_month . '.pdf';
            return $pdf->stream($fileName);
        }
    }

    public function profitReportPDF($start, $end, $code)
    {   
        $store = Store::where('code', $code)->first();
        $profits = Sale::where('store_id', $store->id)
                          ->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end . '+1 day'))])
                          ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"), DB::raw('SUM(payable) as totalsale'), DB::raw('SUM(total_cost) as totalcost')) // payable is used, as total_price is discounted later
                          ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                          ->orderBy('created_at', 'ASC')
                          ->get();

        $pdf = PDF::loadView('dashboard.reports.profit.dailyprofit', ['profits' => $profits, 'store' => $store, 'start' => $start, 'end' => $end]);
        $fileName = 'Profit_Report_'. date('F_d_Y', strtotime($start)). '_to_' .date('F_d_Y', strtotime($end)).'.pdf';
        return $pdf->stream($fileName);
    }

    public function dailyReportPDF($date, $code)
    {   
        $store = Store::where('code', $code)->first();
        
        $purchases = Purchase::where('store_id', $store->id)
                             ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($date)), date('Y-m-d 23:59:59', strtotime($date . '+1 day'))])
                             ->get();
        foreach ($purchases as $purchase) {
            $purchase->transaction_type = 'purchase';
        }

        $sales = Sale::where('store_id', $store->id)
                     ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($date)), date('Y-m-d 23:59:59', strtotime($date . '+1 day'))])
                     ->get();
        foreach ($sales as $sale) {
            $sale->transaction_type = 'sale';
        }

        $expenses = Expense::where('store_id', $store->id)
                           ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($date)), date('Y-m-d 23:59:59', strtotime($date . '+1 day'))])
                           ->get();
        foreach ($expenses as $expense) {
            $expense->transaction_type = 'expense';
        }

        $alltransactions = $purchases->merge($sales)->merge($expenses)->sortBy('created_at');

        $pdf = PDF::loadView('dashboard.reports.alltransaction.alltransactions', ['alltransactions' => $alltransactions, 'store' => $store, 'date' => $date], [] ,['mode' => 'utf-8', 'format' => 'A4-L']);
        $fileName = 'All_Transaction_Report_'. date('F_d_Y', strtotime($date)). '.pdf';
        return $pdf->stream($fileName);
    }

    public function allProductsReportPDF($code)
    {   
        $store = Store::where('code', $code)->first();
        $products = Product::where('store_id', $store->id)
                                      ->orderBy('id', 'asc')
                                      ->get();

        $pdf = PDF::loadView('dashboard.reports.product.allproducts', ['products' => $products, 'store' => $store]);
        $fileName = 'All_Products_Report_' . $store->code . '.pdf';
        return $pdf->download($fileName);
    }

    public function duePayementReportPDF($id, $code)
    {   
        $store = Store::where('code', $code)->first();
        $duehistory = Duehistory::findOrFail($id);

        $pdf = PDF::loadView('dashboard.reports.vendordue.duehistorysingle', ['duehistory' => $duehistory, 'store' => $store]);
        $fileName = 'Due_Payment_Report_' . $duehistory->id . '.pdf';
        return $pdf->download($fileName);
    }

    public function customerDuePayementReportPDF($id, $code)
    {   
        $store = Store::where('code', $code)->first();
        $customerdue = Customerdue::findOrFail($id);

        $pdf = PDF::loadView('dashboard.reports.customerdue.singlepayment', ['customerdue' => $customerdue, 'store' => $store]);
        $fileName = 'Customer_Due_Payment_Report_' . $customerdue->id . '.pdf';
        return $pdf->download($fileName);
    }    

    public function staffPayementReportPDF($id, $code)
    {   
        $store = Store::where('code', $code)->first();
        $singlepayment = Expense::findOrFail($id);

        $pdf = PDF::loadView('dashboard.reports.staff.singlepayment', ['singlepayment' => $singlepayment, 'store' => $store]);
        $fileName = 'Staff_Payment_Report_' . $singlepayment->id . '.pdf';
        return $pdf->download($fileName);
    }
}
