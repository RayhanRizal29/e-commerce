@extends('layouts.app')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Document</title>
</head>
<body style="background-color: #eeeeee">
    <div class="card-header">
        <h4>Edit Product</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('categories.update', $categories) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name" class="font-weight-bold">Category Name</label>
                <input class="form-control" id="name" type="text" name="name" value="{{ $categories->name }}" required>
                {{-- <button type="submit">Update category</button> --}}
            </div>

            <div class="form-group mb-0">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
@endsection

