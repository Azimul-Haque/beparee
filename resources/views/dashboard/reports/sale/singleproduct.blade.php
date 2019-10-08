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
    padding: 5px;
    font-family: 'kalpurush', sans-serif;
    font-size: 14px;
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
    বিক্রয় তালিকাঃ {{ $product->name }} ({{ bangla(date('F d, Y', strtotime($start))) }}-{{ bangla(date('F d, Y', strtotime($end))) }})
  </h2>

  <table class="bordertable">
    <thead>
      <tr>
        <th width="15%">বিক্রয় রশিদ নং</th>
        <th>কাস্টমার</th>
        <th width="10%">পরিমাণ ({{ $product->unit }})</th>
        <th width="14%">বিক্রয়মূল্য (প্রতি {{ $product->unit }})</th>
        <th width="14%">সর্বমোট বিক্রয়মূল্য</th>
        <th width="20%">তারিখ</th>
      </tr>
    </thead>
    <tbody>
      @foreach($saleitems as $item)
      <tr>
        <td>{{ $item->sale->code }}</td>
        <td>{{ $item->sale->customer->name }}</td>
        <td align="center">{{ $item->quantity }}</td>
        <td align="right">{{ $item->unit_price }} ৳</td>
        <td align="right">{{ number_format(($item->quantity * $item->unit_price), 2, '.', '') }} ৳</td>
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
    <table>
      <tr>
        <td width="50%">
          <small>ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
          <small style="font-family: Calibri; color: #3f51b5;">Powered by: http://dokankhata.com (01515297658)</span>
        </td>
        <td align="right">
          <small>প্রস্তুতকারকঃ 
          @if(Auth::check())
            {{ Auth::user()->name }}
          @else
            গেস্ট
          @endif
          </small>
        </td>
      </tr>
    </table>
  </htmlpagefooter>
</body>
</html>