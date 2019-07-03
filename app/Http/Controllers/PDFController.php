<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Store;
use App\Vendor;
use App\Product;
use App\Stock;
use App\Purchase;

use PDF;

class PDFController extends Controller
{
    public function singlePurchaseReceiptPDF($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->load('stock');
        $purchase->load('stock')->load('stock.product', 'stock.vendor');

        $pdf = PDF::loadView('dashboard.purchase.pdf.receipt', ['purchase' => $purchase]);
        $fileName = 'Purchase_Receipt_' . $purchase->code . '.pdf';
        return $pdf->stream($fileName);
    }
}
