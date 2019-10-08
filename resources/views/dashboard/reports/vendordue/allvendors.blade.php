<html>
<head>
  <title>পিডিএফ | সকল দেনা রিপোর্ট</title>
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
    সকল ডিলার/ ভেন্ডরের দেনা রিপোর্ট
  </h2>

  <table class="bordertable">
    <thead>
      <tr>
        <th>ডিলার/ ভেন্ডর</th>
        <th width="15%">মোট ক্রয় সংখ্যা</th>
        <th width="15%">সর্বমোট দেনা</th>
        <th width="15%">সর্বমোট দেনা পরিশোধ</th>
        <th width="15%">চলতি দেনা</th>
      </tr>
    </thead>
    <tbody>
      @foreach($vendors as $vendor)
        <tr>
          <td>{{ $vendor->name }}</td>
          <td align="center">{{ intval($vendor->total_purchase) }}</td>
          <td align="right">{{ number_format(($vendor->total_due), 2, '.', '') }} ৳</td>
          <td align="right">{{ number_format(($vendor->total_due_paid), 2, '.', '') }} ৳</td>
          <td align="right">{{ number_format(($vendor->current_due), 2, '.', '') }} ৳</td>
        </tr>
      @endforeach
    </tbody>
  </table><br/>

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