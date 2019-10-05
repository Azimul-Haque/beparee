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
  <h2 align="center">
    @if($anysinglestock->product->store->monogram != null)
      @if(file_exists( public_path() . '/images/stores/' . $anysinglestock->product->store->monogram))
        <img src="{{ public_path('images/stores/'. $anysinglestock->product->store->monogram) }}" style="height: 80px; width: auto;">
      @else
        <img src="{{ public_path('images/default_store.png') }}" style="height: 80px; width: auto;">
      @endif
    @else
      <img src="{{ public_path('images/default_store.png') }}" style="height: 80px; width: auto;">
    @endif
    <br/>
    {{ $anysinglestock->product->store->name }}<br/>
    <small>{{ $anysinglestock->product->store->address }}, {{ $anysinglestock->product->store->upazilla }}, {{ $anysinglestock->product->store->district }}</small>
  </h2>
  <h2 align="center" style="color: #397736; border-bottom: 1px solid #397736;">
    ক্রয় রশিদ
  </h2>

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

  <htmlpagefooter name="page-footer">
    <small>ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
    <span style="font-family: Calibri; color: #3f51b5;">Powered by: http://dokankhata.com</span>
  </htmlpagefooter>
</body>
</html>