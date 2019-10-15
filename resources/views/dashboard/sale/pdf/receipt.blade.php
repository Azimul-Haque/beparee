<html>
<head>
  <title>পিডিএফ | বিক্রয় রশিদ</title>
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
  <p align="center" style="line-height: 1.2;">
    @if($anysinglesaleitem->product->store->monogram != null)
      @if(file_exists( public_path() . '/images/stores/' . $anysinglesaleitem->product->store->monogram))
        <img src="{{ public_path('images/stores/'. $anysinglesaleitem->product->store->monogram) }}" style="height: 60px; width: auto;">
      @else
        <img src="{{ public_path('images/default_store.png') }}" style="height: 60px; width: auto;">
      @endif
    @else
      <img src="{{ public_path('images/default_store.png') }}" style="height: 60px; width: auto;">
    @endif
    <br/>
    {{ $anysinglesaleitem->product->store->name }}<br/>
    <small>{{ $anysinglesaleitem->product->store->address }}, {{ $anysinglesaleitem->product->store->upazilla }}, {{ $anysinglesaleitem->product->store->district }}</small>
    <br/>
    @if($anysinglesaleitem->product->store->slogan)
      <small style="color: #525659;">** {{ $anysinglesaleitem->product->store->slogan }} **</small>
    @endif
    <br/>
    @if($anysinglesaleitem->product->store->proprietor)
      <small>প্রোঃ {{ $anysinglesaleitem->product->store->proprietor }}</small>
    @endif
    <br/>
    <span align="center" style="color: #397736; border-bottom: 1px solid #397736;">
      বিক্রয় রশিদ
    </span>
  </p>


  <table>
    <tr>
      <td>
        কাস্টমারঃ {{ $sale->customer->name }} <br/>
        যোগাযোগঃ {{ $sale->customer->mobile }}
      </td>
      <td align="right">
        <big>ক্রয় রশিদ নম্বরঃ {{ $sale->code }}</big> <br/>
        তারিখঃ {{ date('F d, Y h:i A', strtotime($sale->created_at)) }}
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
      @foreach($sale->saleitems as $item)
      <tr>
        <td>{{ $item->product->name }}</td>
        <td align="right">{{ $item->quantity }} {{ $item->product->unit }}</td>
        <td align="right">{{ $item->unit_price }} ৳</td>
        <td align="right">{{ number_format(($item->quantity * $item->unit_price), 2, '.', '') }} ৳</td>
      </tr>
      @endforeach
      <tr>
        <td colspan="3"></td>
        <td align="right">
          সর্বমোট পরিমানঃ {{ $sale->total_price }} ৳<br/>
          ডিসকাউন্টঃ {{ $sale->discount }} {{ $sale->discount_unit }}<br/>
          পরিশোধনীয় মূল্যঃ {{ $sale->payable }} ৳<br/>
          পরিশোধিতঃ {{ $sale->paid }} ৳<br/>
          দেনাঃ {{ $sale->due }} ৳<br/>
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
          <span style="font-size: 11px; color: #525659;">{{ $anysinglesaleitem->product->store->receipt_footer }}</span>
        </td>
        <td align="right">
          <small style="font-family: Calibri; font-size: 11px; color: #3f51b5;">Powered by: http://dokankhata.com<br/>(01515297658)</span>
        </td>
      </tr>
    </table>
  </htmlpagefooter>
</body>
</html>