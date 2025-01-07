@extends('layouts.app')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Detail</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    
   
</head>

<body style="background: lightgray"> 
<div class="">
    <div class="card">
        <div class="card-header">
            Detail Order
        </div>
                <div class="card-body">
                {{-- <h5 class="card-title">Total Price = {{ $orders->total_price }}</h5> --}}
                {{-- <p class="card-title">Product Id = {{ $orders->product_id }}</p> --}}
                <p class="card-text">Info User by Order :  {{$orders->user_id}}</p>
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->product->price, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                            </tr>
                            <tr>
                                <td>{{ $orders->total_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('orders.index') }}" class="btn btn-primary">Close</a>
                </div>
            </div>
            </div>
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
@endsection