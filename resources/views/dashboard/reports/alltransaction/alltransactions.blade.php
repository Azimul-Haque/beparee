<html>
<head>
  <title>পিডিএফ | সকল লেন-দেন তালিকা ({{ bangla(date('F d, Y', strtotime($date))) }})</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
  body {
    font-family: 'kalpurush', sans-serif;
  }

  table {
      border-collapse: collapse;
      width: 100%;
  }
  th, td{
    padding: 7px;
    font-family: 'kalpurush', sans-serif;
    font-size: 13.5px;
  }
  .bordertable td, th {
      border: 1px solid #A8A8A8;
  }
  @page {
    header: page-header;
    footer: page-footer;
    background: url({{ public_path('images/background_demo.png') }});
    background-size: cover;              
    background-repeat: no-repeat;
    background-position: center center;
  }
  </style>
</head>
<body>
  <p align="center" style="line-height: 1.2;">
    @if($store->monogram != null)
      @if(file_exists( public_path() . '/images/stores/' . $store->monogram))
        <img src="{{ public_path('images/stores/'. $store->monogram) }}" style="height: 60px; width: auto;">
      @else
        <img src="{{ public_path('images/default_store.png') }}" style="height: 60px; width: auto;">
      @endif
    @else
      <img src="{{ public_path('images/default_store.png') }}" style="height: 60px; width: auto;">
    @endif
    <br/>
    {{ $store->name }}<br/>
    <small>{{ $store->address }}, {{ $store->upazilla }}, {{ $store->district }}</small>
    <br/>
    @if($store->slogan)
      <small style="color: #525659;">** {{ $store->slogan }} **</small>
    @endif
    <br/>
    @if($store->proprietor)
      <small>প্রোঃ {{ $store->proprietor }}</small>
    @endif
    <br/>
    <span align="center" style="color: #397736; border-bottom: 1px solid #397736;">
      সকল লেন-দেন তালিকা ({{ bangla(date('F d, Y', strtotime($date))) }})
    </span>
  </p>

  <table class="bordertable">
   {{--  <thead>
      <tr>
        <th width="9%">ক্রয় আইডি</th>
        <th>ভেন্ডর/ ডিলার</th>
        <th>পণ্যের নাম</th>
        <th width="8%">পরিমাণ</th>
        <th width="9%">ইউনিট মূল্য</th>
        <th width="9%">মূল্য</th>
        <th width="7%">ডিস্কাউন্ট</th>
        <th width="10%">পরিশোধনীয় মূল্য</th>
        <th width="10%">পরিশোধিত</th>
        <th width="9%">দেনা</th>
        <th width="13%">সময়কাল</th>
      </tr>
    </thead> --}}
    <tbody>
      @foreach($alltransactions as $transaction)
        @if($transaction->transaction_type == 'purchase')
          <tr>
            <td>সময়ঃ {{ date('h:i A', strtotime($transaction->created_at)) }}</td>
            <td width="7%" align="center">ক্রয়</td>
            <td>ডিলার/ ভেন্ডরঃ {{ $transaction->stocks->first()->vendor->name }}</td>
            <td>মোটঃ {{ $transaction->total }} ৳</td>
            <td>ডিসকাউন্টঃ {{ $transaction->discount }} {{ $transaction->discount_unit }}</td>
            <td>পরিশোধনীয়ঃ  {{ $transaction->payable }} ৳</td>
            <td>পরিশোধিতঃ {{ $transaction->paid }} ৳</td>
            <td>দেনাঃ {{ $transaction->due }} ৳</td>
          </tr>
        @elseif($transaction->transaction_type == 'sale')
          <tr>
            <td>সময়ঃ {{ date('h:i A', strtotime($transaction->created_at)) }}</td>
            <td align="center">বিক্রয়</td>
            <td>কাস্টমারঃ {{ $transaction->customer->name }}</td>
            <td>মোটঃ {{ $transaction->total_price }} ৳</td>
            <td>ডিসকাউন্টঃ {{ $transaction->discount }} {{ $transaction->discount_unit }}</td>
            <td>পরিশোধনীয়ঃ  {{ $transaction->payable }} ৳</td>
            <td>পরিশোধিতঃ {{ $transaction->paid }} ৳</td>
            <td>বকেয়াঃ {{ $transaction->due }} ৳</td>
          </tr>
        @elseif($transaction->transaction_type == 'expense')
          <tr>
            <td>সময়ঃ {{ date('h:i A', strtotime($transaction->created_at)) }}</td>
            <td align="center">খরচ</td>
            <td>খাতঃ {{ $transaction->expensecategory->name }}</td>
            <td>
              @if($transaction->expensecategory->id == 1)
                কর্মচারীঃ {{ $transaction->staff->name }}
              @endif
            </td>
            <td colspan="2">পরিমাণঃ {{ $transaction->amount }} ৳</td>
            <td colspan="2">মন্তব্যঃ  {{ $transaction->remark }}</td>
          </tr>
        @endif
        
      @endforeach
    </tbody>
  </table>

  @if($alltransactions->count() == 0)
    <h3 align="center">এই তারিখে কোন লেন-দেন নেই!</h3>
  @endif


  <htmlpageheader name="page-header">
    <table>
      <tr>
        <td width="50%">
          <small style="font-size: 12px; color: #525659;">ডাউনলোডের সময়কালঃ <span style="font-family: Calibri; font-size: 12px;">{{ date('F d, Y, h:i A') }}</span></small>
        </td>
        <td align="right" style="color: #525659;">
          <small>প্রস্তুতকারকঃ 
          @if(Auth::check())
            {{ Auth::user()->name }} 
          @else
            গেস্ট 
          @endif
          | পাতাঃ {PAGENO}/{nbpg}
          </small>
        </td>
      </tr>
    </table>
  </htmlpageheader>


  <htmlpagefooter name="page-footer">
    <table>
      <tr>
        <td width="70%" align="left">
          <span style="font-size: 11px; color: #525659;">{{ $store->receipt_footer }}</span>
        </td>
        <td align="right">
          <small style="font-family: Calibri; font-size: 11px; color: #3f51b5;">Powered by: http://dokankhata.com<br/>(01515297658)</span>
        </td>
      </tr>
    </table>
  </htmlpagefooter>
</body>
</html>