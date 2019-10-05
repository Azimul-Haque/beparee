<html>
<head>
  <title>পিডিএফ | সকল পণ্য তালিকা</title>
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
    সকল স্টক তালিকা
  </h2>

  <table class="bordertable">
    <thead>
      <tr>
        <th>পণ্যের নাম</th>
        <th width="15%">ক্রয়কৃত স্টক</th>
        <th width="15%">বর্তমান স্টক</th>
        <th width="20%">SKU</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $product)
      <tr>
        <td>{{ $product->name }}</td>
        @php 
          $quantity = 0;
          $current_quantity = 0;
          foreach ($product->stocks as $stock) {
            $quantity = $quantity + $stock->quantity;
            $current_quantity = $current_quantity + $stock->current_quantity;
          }
        @endphp
        <td align="center">{{ $quantity }} {{ $product->unit }}</td>
        <td align="center">{{ $current_quantity }} {{ $product->unit }}</td>
        <td align="center">{{ $product->sku }}</td>
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