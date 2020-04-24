@extends('projects.layout')
@section('content')

<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Login</h2>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if(!empty($error))
     <div class="alert alert-danger"> {{ $error }}</div>
    @endif


    @if(!empty($success))
     <div class="alert alert-success"> {{ $success }}</div>
    @endif
   
    <form action="{{ route('loginauthenticate') }}" method="POST">
    @csrf
    
    <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    

                        <div class="form-group row mb-0">
                            <div class="col-md-5"><h1></h1></div>
                            <div class="col-md-7">
                                <div class="col-md-8 offset-md-4">
                                   

                                    <a class="btn btn-link" href="{{route('/users/register')}}">
                                        {{ __('Register') }}
                                    </a>

                                
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('resetPassword'))
                                        <a class="btn btn-link" href="{{ route('resetPassword') }}">
                                            {{ __('Reset Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

    </form>    
      
@endsection