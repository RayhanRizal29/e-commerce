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
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
</head>
<body style="background: lightgrey">
    <div class="justify-content">
        <div class="">
            <div class="card" >
                <div class="card-header">
                    Riwayat Order
                </div>
                <div class="card-body">
                    @foreach ($user->orders as $order)
                        <h3 class="card-title">Total Belanja : Rp{{ ($order->total_price) }}</h3>
                        <p class="card-text">{{ $order->created_at->format('d M Y H:i') }}</p>
                        <a href="{{ route('users.index') }}" class="btn btn-primary">Close</a>

                @endforeach
                </div>
            </div>
            </div>
        </div>

</body>
</html>

@endsection
