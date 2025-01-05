@extends('layouts.app')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Order</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body style="background: lightgrey">
    <div class="justify-content">
        <div class="col-md-3 col-sm-6">
            <div class="card" >
                <div class="card-header">
                    Riwayat Order
                </div>
                <div class="card-body">
                    @foreach ($user->orders as $order)
                        <h5 class="card-title">Rp{{ ($order->total_price) }}</h5>
                        <p class="card-text">{{ $order->created_at->format('d M Y H:i') }}</p>
                        <a href="#" class="btn btn-primary">Close</a>
                @endforeach
                </div>
            </div>
            </div>
        </div>

</body>
</html>

@endsection
