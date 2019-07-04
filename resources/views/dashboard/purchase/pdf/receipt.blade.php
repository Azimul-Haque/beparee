<html>
<head>
  <title>পিডিএফ | ক্রয় রশিদ</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
  body {
    font-family: 'kalpurush', sans-serif;
    background-image: url({{ public_path('images/background_demo.png') }});
    background-size: cover;              
    background-repeat: no-repeat;
    background-position: center center;
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
  }
  </style>
</head>
<body>
  <h2 align="center">
    {{-- <img src="{{ public_path('images/logo.png') }}" style="height: 100px; width: auto;"><br/> --}}
    {{ $purchase->stock->product->store->name }}<br/>
    <small>{{ $purchase->stock->product->store->address }}</small>
  </h2>
  <h1 align="center" style="color: #397736; border-bottom: 1px solid #397736;">
    ক্রয় রশিদ
  </h1>

  <table>
    <tr>
      <td>
        ডিলার/ ভেন্ডরঃ {{ $purchase->stock->vendor->name }} <br/>
        যোগাযোগঃ {{ $purchase->stock->vendor->mobile }}
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
      <tr>
        <td>{{ $purchase->stock->product->name }}</td>
        <td align="right">{{ $purchase->stock->quantity }}</td>
        <td align="right">{{ $purchase->stock->buying_price }} ৳</td>
        <td align="right">{{ $purchase->total }} ৳</td>
      </tr>
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
    Powered by: beparee
  </htmlpagefooter>
</body>
</html>