<html>
<head>
  <title>পিডিএফ | কাস্টমার বকেয়া পরিশোধ রশিদ</title>
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
      কাস্টমার বকেয়া পরিশোধ রশিদ
    </span>
  </p>
  <table>
    <tr>
      <td>
        কাস্টমারঃ {{ $customerdue->customer->name }} <br/>
        যোগাযোগঃ {{ $customerdue->customer->mobile }}
      </td>
      <td align="right">
        তারিখঃ {{ date('F d, Y h:i A', strtotime($customerdue->created_at)) }}
      </td>
    </tr>
  </table><br/>

  <table class="bordertable">
    <thead>
      <tr>
        <th>ধরণ</th>
        <th width="30%">পরিমাণ</th>
        <th width="30%">তারিখঃ</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>বকেয়া পরিশোধ</td>
        <td align="center"><big><b>{{ number_format(($customerdue->amount), 2, '.', '') }} ৳</b></big></td>
        <td align="center">{{ date('F d, Y', strtotime($customerdue->created_at)) }}</td>
      </tr>
    </tbody>
  </table><br/>

  <table class="bordertable">
    <thead>
      <tr>
        <th colspan="2"><u>{{ $customerdue->customer->name }}-এর বকেয়ার সারসংক্ষেপ</u></th>
      </tr>
      <tr>
        <th>ধরণ</th>
        <th>পরিমাণ</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>মোট বকেয়া</td>
        <td align="right">{{ number_format(($customerdue->customer->total_due), 2, '.', '') }} ৳</td>
      </tr>
      <tr>
        <td>মোট পরিশোধ</td>
        <td align="right">{{ number_format(($customerdue->customer->total_due_paid), 2, '.', '') }} ৳</td>
      </tr>
      <tr>
        <td>চলতি বকেয়া</td>
        <td align="right">{{ number_format(($customerdue->customer->current_due), 2, '.', '') }} ৳</td>
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