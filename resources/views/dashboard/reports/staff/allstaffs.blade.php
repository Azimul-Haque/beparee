<html>
<head>
  <title>পিডিএফ | সকল স্টাফ উপস্থিতি {{ $month }} {{ $year }}</title>
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
    কমচারীগণের উপস্থিতি ({{ $month }} {{ bangla($year) }})
  </h2>

  <table class="bordertable">
    <thead>
      <tr>
        <th>তারিখ</th>
        <th>কর্মচারীগণ</th>
      </tr>
    </thead>
    <tbody>
      @foreach($attendances as $date => $staffs)
      <tr>
        <td align="center">{{ bangla(date('F d, Y', strtotime($date))) }}</td>
        <td>
          @for($i=0; $i < $staffs->count(); $i++)
            {{ $staffs[$i]->staff->name }} - 
            @if($staffs[$i]->type == 0)
              <span class="present">উপস্থিত</span>
            @elseif($staffs[$i]->type == 1)
              ছুটি
            @elseif($staffs[$i]->type == 2)
              <span class="absent">অনুপস্থিত</span>
            @endif
            <br/>
          @endfor
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  


  <htmlpagefooter name="page-footer">
    <small>ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
    <small style="font-family: Calibri; color: #3f51b5;">Powered by: beparee</span>
  </htmlpagefooter>
</body>
</html>