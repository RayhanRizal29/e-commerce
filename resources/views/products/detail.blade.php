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
   
</head>

<body style="background: lightgray">
    <div class="">
    <div class="card">
        <div class="card-header">Detail</div>
        <div class="card-body">
            <div class="d-flex">
                @foreach($product->productImages as $image)
                    <div class="col-md-2">
                        <img  src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail" alt="Product Image" width="150px">
                    </div>
                @endforeach
                <div>
                    <h1 class="card-title">{{ $product->name }}</h1>
                    <p class="card-text"> {!! $product->description !!}</p>
                    <p class="card-text"><small class="text-muted">Stock : {{ $product->stock }}</small></p>
                </div>
            </div>
            <div>
            
            </div>
        </div>
    </div>
</div>
</body>
{{-- <body style="background: lightgray">

    <div class="card" style="max-width: 1000px;">
        <div class="card border-0 shadow rounded">
            <div class="row g-0">
            {{-- <div class="col-md-4">

                <img src="{{ asset('storage/' . $product->cover_image) }}" class="img-fluid rounded-start" alt="...">
            </div> --}}
           
            {{-- <div class="col-md-8">
                <div class="card-body">
                    <div class="row">
                        @foreach($product->productImages as $image)
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="rounded float-start" alt="Product Image" width="150px">
                            </div>
                        @endforeach
                    </div>
                <h1 class="card-title">{{ $product->name }}</h1>
                <p class="card-text"> {!! $product->description !!}</p>
                <p class="card-text"><small class="text-muted">Stock : {{ $product->stock }}</small></p>
                </div>
            </div>
            </div>
            </div>
        </div> --}}


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body> 

</html>
@endsection