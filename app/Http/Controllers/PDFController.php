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

use PDF;

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
            $fileName = 'Product_Report ' . $product->name . '.pdf';
            return $pdf->stream($fileName);

        }     
    }
}
