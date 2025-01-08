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
        <div class="card-header">Detail</div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="d-flex">
                    @foreach($product->images as $image)
                        <div class="col-md-2">
                            <img  src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail" alt="Product Image" width="150px">
                        </div>
                    @endforeach
                </div>
            </div>
                <div>
                    <h1 class="card-title">{{ $product->name }}</h1>
                    <p class="card-text"> {!! $product->description !!}</p>
                    <p class="card-text"><small class="text-muted">Stock : {{ $product->stock }}</small></p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Close</a>
                </div>
            <div>
            
            </div>
        </div>
    </div>
</div>
</body>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body> 

</html>
@endsection