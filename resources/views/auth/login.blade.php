@extends('auth.layout')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">

            <div class="card shadow p-3">
                <div class="card-body">
                    <div class="card-title">
                        <div class="text-center">
                            <h3>Login</h3>
                        </div>
                    </div>
                    <form action="{{ route('authenticate') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="email" >Email Address</label>
                            <div class="col">
                                <input type="email" class="form-control" @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" >Password</label>
                            <div class="col">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Login">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection