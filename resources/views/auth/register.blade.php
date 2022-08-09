@extends('backend.layouts.app-auth')
@section('content')
    <!-- Nested Row within Card Body -->
    <div class="row">
        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
        <div class="col-lg-7">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                </div>


                {!! Form::open(['route' => 'register', 'method' => 'post', 'files' => true], ['class' => 'user']) !!}

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        {{ Form::text('name', old('name'), array_merge(['class' => 'form-control form-control-user'], ['placeholder' => 'First Name'])) }}
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        {{ Form::text('username', old('username'), array_merge(['class' => 'form-control form-control-user'], ['placeholder' => 'Last Name'])) }}
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::email('email', old('email'), array_merge(['class' => 'form-control form-control-user'], ['placeholder' => 'Email Address'])) }}
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    {{ Form::number('mobile', old('mobile'), array_merge(['class' => 'form-control form-control-user'], ['placeholder' => 'Number'])) }}
                    @error('number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('user_image', 'User image') !!}
                    {!! Form::file('user_image', ['class' => 'custom-file']) !!}
                    @error('user_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        {{ Form::password('password', array_merge(['class' => 'form-control form-control-user'], ['placeholder' => 'Password'])) }}
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        {{ Form::password('password_confirmation', array_merge(['class' => 'form-control form-control-user'], ['placeholder' => 'Repeat Password'])) }}
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {!! Form::submit('Register Account', ['class' => 'btn btn-primary btn-user btn-block']) !!}
                {!! Form::close() !!}
                <hr>
                <a href="index.html" class="btn btn-google btn-user btn-block">
                    <i class="fab fa-google fa-fw"></i> Register with Google
                </a>
                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                </a>
                <hr>
                <div class="text-center">
                    @if (Route::has('password.request'))
                        <a class="small" href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </div>

                <div class="text-center">
                    <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                </div>

            </div>
        </div>
    </div>
@endsection
