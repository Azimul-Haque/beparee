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
            $fileName = 'Product_Report ' . $product->name . '.pdf';
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
}
