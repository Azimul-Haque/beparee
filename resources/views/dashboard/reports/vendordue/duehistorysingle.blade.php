<html>
<head>
  <title>পিডিএফ | দেনা পরিশোধ রশিদ</title>
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
    দেনা পরিশোধ রশিদ
  </h2>

  <table>
    <tr>
      <td>
        ডিলার/ ভেন্ডরঃ {{ $duehistory->vendor->name }} <br/>
        যোগাযোগঃ {{ $duehistory->vendor->mobile }}
      </td>
      <td align="right">
        তারিখঃ {{ date('F d, Y h:i A', strtotime($duehistory->created_at)) }}
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
        <td>দেনা পরিশোধ</td>
        <td align="center"><big><b>{{ number_format(($duehistory->amount), 2, '.', '') }} ৳</b></big></td>
        <td align="center">{{ date('F d, Y', strtotime($duehistory->created_at)) }}</td>
      </tr>
    </tbody>
  </table><br/>

  <table class="bordertable">
    <thead>
      <tr>
        <th colspan="2"><u>{{ $duehistory->vendor->name }}-এর দেনা সারসংক্ষেপ</u></th>
      </tr>
      <tr>
        <th>ধরণ</th>
        <th>পরিমাণ</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>মোট দেনা</td>
        <td align="right">{{ number_format(($duehistory->vendor->total_due), 2, '.', '') }} ৳</td>
      </tr>
      <tr>
        <td>মোট পরিশোধ</td>
        <td align="right">{{ number_format(($duehistory->vendor->total_due_paid), 2, '.', '') }} ৳</td>
      </tr>
      <tr>
        <td>চলতি দেনা</td>
        <td align="right">{{ number_format(($duehistory->vendor->current_due), 2, '.', '') }} ৳</td>
      </tr>
    </tbody>
  </table>


  <htmlpagefooter name="page-footer">
    <small>ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
    <small style="font-family: Calibri; color: #3f51b5;">Powered by: http://dokankhata.com</span>
  </htmlpagefooter>
</body>
</html>