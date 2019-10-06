<html>
<head>
  <title>পিডিএফ | ক্রয়ের তালিকা</title>
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
    padding: 5px;
    font-family: 'kalpurush', sans-serif;
    font-size: 14px;
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
    ক্রয়ের তালিকা ({{ bangla(date('F d, Y', strtotime($start))) }} - {{ bangla(date('F d, Y', strtotime($end))) }})
  </h2>

  <table class="bordertable">
    <thead>
      <tr>
        <th width="10%">ক্রয় আইডি</th>
        <th>ভেন্ডর/ ডিলার</th>
        <th>পণ্যের নাম</th>
        <th width="7%">পরিমাণ</th>
        <th width="7%">ইউনিট মূল্য</th>
        <th width="7%">মূল্য</th>
        <th width="7%">ডিস্কাউন্ট</th>
        <th width="7%">পরিশোধনীয় মূল্য</th>
        <th width="7%">পরিশোধিত</th>
        <th width="7%">দেনা</th>
        <th width="20%">সমকাল</th>
      </tr>
    </thead>
    <tbody>
      @foreach($purchases as $purchase)
        <tr>
          <td rowspan="{{ $purchase->stocks->count() }}">{{ $purchase->code }}</td>
          @php
            $columncount = $purchase->stocks->count();
            $columnadded1 = 0;
            $columnadded2 = 0;
          @endphp
          @foreach($purchase->stocks as $stock)
            @if($columnadded1 == 0) {{-- when it will be 1 columns will be added --}}
              <td rowspan="{{ $purchase->stocks->count() }}">{{ $stock->vendor->name }}</td>
              @php
                $columnadded1 = 1;
              @endphp
            @endif
            <td>{{ $stock->product->name }}</td>
            <td align="center">{{ $stock->quantity }} {{ $stock->product->unit }}</td>
            <td align="center">{{ $stock->buying_price }}</td>
            @if($columnadded2 == 0) {{-- when it will be 1 columns will be added --}}
              <td rowspan="{{ $purchase->stocks->count() }}">{{ $purchase->total }} ৳</td>
              <td rowspan="{{ $purchase->stocks->count() }}">{{ $purchase->discount }} {{ $purchase->discount_unit }}</td>
              <td rowspan="{{ $purchase->stocks->count() }}">{{ $purchase->payable }} ৳</td>
              <td rowspan="{{ $purchase->stocks->count() }}">{{ $purchase->paid }} ৳</td>
              <td rowspan="{{ $purchase->stocks->count() }}">{{ $purchase->due }} ৳</td>
              <td rowspan="{{ $purchase->stocks->count() }}">{{ date('F d, Y H:i A', strtotime($purchase->created_at)) }}</td>
              @php
                $columnadded2 = 1;
              @endphp
            @endif
            @if($columncount > 1)
              </tr><tr>
            @endif
            @php
              $columncount--;
            @endphp
          @endforeach
          
        </tr>
      @endforeach
    </tbody>
  </table>


  <htmlpagefooter name="page-footer">
    <small>ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
    <small style="font-family: Calibri; color: #3f51b5;">Powered by: http://dokankhata.com</span>
  </htmlpagefooter>
</body>
</html>