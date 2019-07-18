<html>
<head>
  <title>পিডিএফ | স্টক তালিকাঃ {{ $product->name }}</title>
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
    @if($store->monogram != null)
      @if(file_exists( public_path() . '/images/stores/' . $store->monogram))
        <img src="{{ public_path('images/stores/'. $store->monogram) }}" style="height: 80px; width: auto;">
      @else
        <img src="{{ public_path('images/default_store.png') }}" style="height: 80px; width: auto;">
      @endif
    @else
      <img src="{{ public_path('images/default_store.png') }}" style="height: 80px; width: auto;">
    @endif
    <br/>
    {{ $store->name }}<br/>
    <small>{{ $store->address }}</small>
  </h2>
  <h1 align="center" style="color: #397736; border-bottom: 1px solid #397736;">
    স্টক তালিকাঃ {{ $product->name }}
  </h1>

  <table class="bordertable">
    <thead>
      <tr>
        <th>ডিলার/ ভেন্ডর</th>
        <th width="13%">ক্রয়কৃত স্টক ({{ $product->unit }})</th>
        <th width="13%">বর্তমান স্টক ({{ $product->unit }})</th>
        <th width="13%">ক্রয়মূল্য</th>
        <th width="13%">বিক্রয়মূল্য</th>
        <th>তারিখ</th>
      </tr>
    </thead>
    <tbody>
      @foreach($stocks as $stock)
      <tr>
        <td>{{ $stock->vendor->name }}</td>
        <td align="center">{{ $stock->quantity }}</td>
        <td align="center">{{ $stock->current_quantity }}</td>
        <td align="right">{{ $stock->buying_price }} ৳</td>
        <td align="right">{{ $stock->selling_price }} ৳</td>
        <td >{{ date('F d, Y', strtotime($stock->created_at)) }}</td>
      </tr>
      @endforeach
      <tr>
        <td colspan="2" align="right">মোট বর্তমান স্টক</td>
        <td align="center">{{ $stocks->sum('current_quantity') }}</td>
        <td colspan="3"></td>
      </tr>
    </tbody>
  </table>


  <htmlpagefooter name="page-footer">
    <small>ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
    <small style="font-family: Calibri; color: #3f51b5;">Powered by: beparee</span>
  </htmlpagefooter>
</body>
</html>