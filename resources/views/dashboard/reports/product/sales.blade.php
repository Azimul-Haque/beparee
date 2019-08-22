<html>
<head>
  <title>পিডিএফ | বিক্রয় তালিকাঃ {{ $product->name }}</title>
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
    <small>{{ $store->address }}, {{ $store->upazilla }}, {{ $store->district }}</small>
  </h2>
  <h2 align="center" style="color: #397736; border-bottom: 1px solid #397736;">
    বিক্রয় তালিকাঃ {{ $product->name }}
  </h2>

  <table class="bordertable">
    <thead>
      <tr>
        <th>ক্রয় রশিদ নম্বর</th>
        <th>কাস্টমার</th>
        <th width="13%">পরিমাণ ({{ $product->unit }})</th>
        <th width="13%">বিক্রয়মূল্য (প্রতি {{ $product->unit }})</th>
        <th>তারিখ</th>
      </tr>
    </thead>
    <tbody>
      @foreach($saleitems as $item)
      <tr>
        <td>{{ $item->sale->code }}</td>
        <td>{{ $item->sale->customer->name }}</td>
        <td align="center">{{ $item->quantity }}</td>
        <td align="right">{{ $item->unit_price }} ৳</td>
        <td align="center">{{ bangla(date('F d, Y', strtotime($item->created_at))) }}</td>
      </tr>
      @endforeach
      {{-- <tr>
        <td colspan="2" align="right">মোট বর্তমান স্টক</td>
        <td align="center">{{ $stocks->sum('current_quantity') }}</td>
        <td colspan="3"></td>
      </tr> --}}
    </tbody>
  </table>


  <htmlpagefooter name="page-footer">
    <small>ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
    <small style="font-family: Calibri; color: #3f51b5;">Powered by: beparee</span>
  </htmlpagefooter>
</body>
</html>