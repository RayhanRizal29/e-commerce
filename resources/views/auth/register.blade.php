<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body >
    
@extends('auth.layout')

@section('content')

        <div class="row justify-content-center mt-5" >
        <div class="col-md-5">

            <div class="row align-items-start">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif

                <div class="card shadow p-3">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="text-center">
                                <h3>Register</h3>
                            </div>
                        </div>

                        <form action="{{ route('store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="">Name</label>
                                <div class="col">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-3 ">
                                <label for="email" class="">Email Address</label>
                                <div class="col">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-3 ">
                                <label for="password" class="">Password</label>
                                <div class="col">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 ">
                                <label for="password_confirmation" class="">Confirm Password</label>
                                <div class="col">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>

                            <div class="mb-3 ">
                                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Register">
                            </div>
                        </form>
                        
                    </div>
                  </div>
              </div>
            </div>
        </div>

@endsection
</body>
</html>
