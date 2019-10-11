<html>
<head>
  <title>পিডিএফ | {{ $staff->name }}-এর বেতন রিপোর্ট</title>
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
    {{ $staff->name }}-এর বেতন রিপোর্ট ({{ bangla(date('F d, Y', strtotime($start))) }}-{{ bangla(date('F d, Y', strtotime($end))) }})
  </h2>

  <table>
    <tbody>
      <tr>
        <td width="50%">কর্মচারীঃ {{ $staff->name }}</td>
        <td>যোগাযোগঃ {{ $staff->mobile }}</td>
      </tr>
      <tr>
        <td colspan="2">ঠিকানাঃ {{ $staff->address }}</td>
      </tr>
    </tbody>
  </table>

  <table class="bordertable">
    <thead>
      <tr>
        <th width="50%">তারিখ</th>
        <th>পরিশোধ পরিমাণ</th>
      </tr>
    </thead>
    <tbody>
      @foreach($salaries as $salary)
        <tr>
          <td align="center">{{ bangla(date('F d, Y', strtotime($salary->created_at))) }}</td>
          <td align="right">
           {{ number_format(($salary->amount), 2, '.', '') }} ৳
          </td>
        </tr>
      @endforeach
      <tr>
        <td align="right">মোট</td>
        <td align="right">{{ number_format($salaries->sum('amount'), 2, '.', '') }} ৳</td>
      </tr>
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