<html>
<head>
  <title>পিডিএফ | স্টাফ পরিশোধ রশিদ</title>
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
    {{ $singlepayment->staff->name }}-এর পরিশোধ রশিদ
  </h2>

  <table>
    <tr>
      <td>
        স্টাফঃ {{ $singlepayment->staff->name }} <br/>
        যোগাযোগঃ {{ $singlepayment->staff->mobile }}
      </td>
      <td align="right">
        তারিখঃ {{ date('F d, Y h:i A', strtotime($singlepayment->created_at)) }}
      </td>
    </tr>
  </table><br/>

  <table class="bordertable">
    <thead>
      <tr>
        <th>সময়</th>
        <th width="30%">পরিমাণ</th>
        <th width="30%">মন্তব্য</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ date('F d, Y h:i A', strtotime($singlepayment->created_at)) }}</td>
        <td align="center"><big><b>{{ number_format(($singlepayment->amount), 2, '.', '') }} ৳</b></big></td>
        <td align="center">{{ $singlepayment->remark }}</td>
      </tr>
    </tbody>
  </table>

  <htmlpagefooter name="page-footer">
    <small>ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
    <small style="font-family: Calibri; color: #3f51b5;">Powered by: http://dokankhata.com</span>
  </htmlpagefooter>
</body>
</html>