<html>
<head>
  <title>পিডিএফ | লাভের রিপোর্ট</title>
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
  .present {
    color: #218838;
  }
  .absent {
    color: #F03A17;
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
  <p align="center">
    @if($store->monogram != null)
      @if(file_exists( public_path() . '/images/stores/' . $store->monogram))
        <img src="{{ public_path('images/stores/'. $store->monogram) }}" style="height: 65px; width: auto;">
      @else
        <img src="{{ public_path('images/default_store.png') }}" style="height: 65px; width: auto;">
      @endif
    @else
      <img src="{{ public_path('images/default_store.png') }}" style="height: 65px; width: auto;">
    @endif
    <br/>
    {{ $store->name }}<br/>
    <small>{{ $store->address }}, {{ $store->upazilla }}, {{ $store->district }}</small>
    <br/>
    @if($store->slogan)
      <small style="color: #525659;">** {{ $store->slogan }} **</small>
    @endif
    <br/>
    <span align="center" style="color: #397736; border-bottom: 1px solid #397736;">
      লাভের রিপোর্ট ({{ bangla(date('F d, Y', strtotime($start))) }}-{{ bangla(date('F d, Y', strtotime($end))) }})
    </span>
  </p>

  <table class="bordertable">
    <thead>
      <tr>
        <th width="40%">তারিখ</th>
        <th>মোট বিক্রয় (৳)</th>
        <th width="25%">মোট লাভ (৳)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($profits as $profit)
      <tr>
        <td align="center">{{ bangla(date('F d, Y', strtotime($profit->date))) }}</td>
        <td align="right">{{ number_format($profit->totalsale, 2, '.', '') }} ৳</td>
        <td align="right">{{ number_format(($profit->totalsale - $profit->totalcost), 2, '.', '') }} ৳</td>
      </tr>
      @endforeach
      <tr>
        <td align="right">মোট</td>
        <td align="right">{{ number_format(($profits->sum('totalsale')), 2, '.', '') }} ৳</td>
        <td align="right">
          {{ number_format(($profits->sum('totalsale') - $profits->sum('totalcost')), 2, '.', '') }} ৳
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