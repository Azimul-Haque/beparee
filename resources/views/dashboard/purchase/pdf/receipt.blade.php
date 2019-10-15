<html>
<head>
  <title>পিডিএফ | ক্রয় রশিদ</title>
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
    font-size: 15px;
  }
  .bordertable td, th {
      border: 1px solid #A8A8A8;
  }
  .storeWaterMark {
    text-align: center;
    font-size: 30px;
    color: #b8cee3;
    opacity: 0.1 !important;
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
    @if($anysinglestock->product->store->monogram != null)
      @if(file_exists( public_path() . '/images/stores/' . $anysinglestock->product->store->monogram))
        <img src="{{ public_path('images/stores/'. $anysinglestock->product->store->monogram) }}" style="height: 60px; width: auto;">
      @else
        <img src="{{ public_path('images/default_store.png') }}" style="height: 60px; width: auto;">
      @endif
    @else
      <img src="{{ public_path('images/default_store.png') }}" style="height: 60px; width: auto;">
    @endif
    <br/>
    {{ $anysinglestock->product->store->name }}<br/>
    <small>{{ $anysinglestock->product->store->address }}, {{ $anysinglestock->product->store->upazilla }}, {{ $anysinglestock->product->store->district }}</small>
    <br/>
    @if($anysinglestock->product->store->proprietor)
      <small>প্রোঃ {{ $anysinglestock->product->store->proprietor }}</small>
    @endif
    <br/>
    <span align="center" style="color: #397736; border-bottom: 1px solid #397736;">
      ক্রয় রশিদ
    </span>
  </p>

  <table>
    <tr>
      <td>
        ডিলার/ ভেন্ডরঃ {{ $anysinglestock->vendor->name }} <br/>
        যোগাযোগঃ {{ $anysinglestock->vendor->mobile }}
      </td>
      <td align="right">
        <big>ক্রয় রশিদ নম্বরঃ {{ $purchase->code }}</big> <br/>
        তারিখঃ {{ date('F d, Y h:i A', strtotime($purchase->created_at)) }}
      </td>
    </tr>
  </table><br/>

  <table class="bordertable">
    <thead>
      <tr>
        <th>পণ্য</th>
        <th>পরিমাণ</th>
        <th>মূল্য</th>
        <th width="30%">মোট</th>
      </tr>
    </thead>
    <tbody>
      @foreach($purchase->stocks as $stock)
      <tr>
        <td>{{ $stock->product->name }}</td>
        <td align="right">{{ $stock->quantity }} {{ $stock->product->unit }}</td>
        <td align="right">{{ $stock->buying_price }} ৳</td>
        <td align="right">{{ number_format(($stock->quantity * $stock->buying_price), 2, '.', '') }} ৳</td>
      </tr>
      @endforeach
      <tr>
        <td colspan="3"></td>
        <td align="right">
          সর্বমোট পরিমানঃ {{ $purchase->total }} ৳<br/>
          ডিসকাউন্টঃ {{ $purchase->discount }} {{ $purchase->discount_unit }}<br/>
          পরিশোধনীয় মূল্যঃ {{ $purchase->payable }} ৳<br/>
          পরিশোধিতঃ {{ $purchase->paid }} ৳<br/>
          দেনাঃ {{ $purchase->due }} ৳<br/>
        </td>
      </tr>
    </tbody>
  </table>

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
    <div class="storeWaterMark" style="opacity: 0.1;">
      <big>{{ $anysinglestock->product->store->name }}</big>
      @if($anysinglestock->product->store->slogan)
        <br/>** {{ $anysinglestock->product->store->slogan }} ** 
      @endif
    </div><br/>
    <table>
      <tr>
        <td width="70%" align="left">
          <span style="font-size: 11px; color: #525659;">{{ $anysinglestock->product->store->receipt_footer }}</span>
        </td>
        <td align="right">
          <small style="font-family: Calibri; font-size: 11px; color: #3f51b5;">Powered by: http://dokankhata.com<br/>(01515297658)</span>
        </td>
      </tr>
    </table>
  </htmlpagefooter>
</body>
</html>