@extends('layouts.app')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Detail</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
   
</head>

<body style="background: lightgray">

    <div class="card" style="max-width: 500px;">
        <div class="card border-0 shadow rounded">
            <div class="row g-0">
           
            <div class="col-md-8">
                <div class="card-body">
                <h1 class="card-title">User = {{ $users->name }}</h1>
                <h1 class="card-title">email = {{ $users->email }}</h1>
                <h1 class="card-title">Total Shopping = {{ $users->orders}}</h1>

                {{-- @foreach ($users->orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach --}}

              

                {{-- <h1 class="card-title">Product Id = {{ $users->product_id }}</h1> --}}
                
                {{-- <p class="card-text">Info User by Order :  {!! $users->user_id!!}</p> --}}
                </div>
            </div>
            </div>
            </div>
        </div>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
@endsection