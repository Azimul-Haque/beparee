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
    @if($store->proprietor)
      <small>প্রোঃ {{ $store->proprietor }}</small>
    @endif
    <br/>
    <span align="center" style="color: #397736; border-bottom: 1px solid #397736;">
      বিক্রয় তালিকাঃ {{ $product->name }} ({{ bangla(date('F d, Y', strtotime($start))) }}-{{ bangla(date('F d, Y', strtotime($end))) }})
    </span>
  </p>


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
      <big>{{ $store->name }}</big>
      @if($store->slogan)
        <br/>** {{ $store->slogan }} ** 
      @endif
    </div><br/>
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