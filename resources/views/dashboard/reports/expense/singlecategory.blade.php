<html>
<head>
  <title>পিডিএফ | {{ $category->name }}-বাবদ খরচের রিপোর্ট</title>
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
    @if($store->slogan)
      <small style="color: #525659;">** {{ $store->slogan }} **</small>
    @endif
    <br/>
    @if($store->proprietor)
      <small>প্রোঃ {{ $store->proprietor }}</small>
    @endif
    <br/>
    <span align="center" style="color: #397736; border-bottom: 1px solid #397736;">
      {{ $category->name }}-বাবদ খরচের রিপোর্ট ({{ bangla(date('F d, Y', strtotime($start))) }}-{{ bangla(date('F d, Y', strtotime($end))) }})
    </span>
  </p>

  <table class="bordertable">
    <thead>
      <tr>
        @if($category->id == 1)
          <th width="35%">কর্মচারী</th>
          <th width="25%">তারিখ</th>
        @else
          <th width="35%">তারিখ</th>
        @endif
        <th>খরচের পরিমাণ</th>
        <th>মন্তব্য</th>
      </tr>
    </thead>
    <tbody>
      @foreach($expenses as $expense)
      <tr>
        @if($expense->expensecategory->id == 1)
          <td>
            {{ $expense->staff->name }} <small>({{ $expense->staff->mobile }})</small>
          </td>
        @endif

        <td align="center">{{ bangla(date('F d, Y', strtotime($expense->created_at))) }}</td>
        <td align="right">{{ $expense->amount }} ৳</td>
        <td align="center">{{ $expense->remark }}</td>
      </tr>
      @endforeach
      <tr>
        @if($category->id == 1)
          <td></td>
        @endif
        <td align="right">মোট</td>
        <td align="right">{{ number_format(($expenses->sum('amount')), 2, '.', '') }} ৳</td>
        <td></td>
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