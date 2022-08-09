@extends('frontend.layouts.app')
@section('content')
    <p>Edit Profile</p>






    {{-- {!! Form::open(['route' => 'user.update' . Crypt::encryptString(auth()->user()->id), 'method' => 'post', 'files' => true]) !!} --}}
    {!! Form::open(['route' => ['user.update', Crypt::encryptString(auth()->user()->id)], 'method' => 'post', 'files' => true]) !!}

    <div class="account__form">
        <div class="input__box">
            {!! Form::label('name', 'Name *') !!}
            {!! Form::text('name', old('name', auth()->user()->name)) !!}
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="input__box">
            {!! Form::label('username', 'Username *') !!}
            {!! Form::text('username', old('username',auth()->user()->username)) !!}
            @error('username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="input__box">
            {!! Form::label('email', 'Email *') !!}
            {!! Form::email('email', old('email',auth()->user()->email)) !!}
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="input__box">
            {!! Form::label('mobile', 'Mobile *') !!}
            {!! Form::text('mobile', old('mobile',auth()->user()->mobile)) !!}
            @error('mobile')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="input__box">
            {!! Form::label('password', 'Password *') !!}
            {!! Form::password('password') !!}
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="input__box">
            {!! Form::label('password_confirmation', 'Re-Password *') !!}
            {!! Form::password('password_confirmation') !!}
            @error('password_confirmation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="input__box">
            {!! Form::label('user_image', 'User image') !!}
            {!! Form::file('user_image', ['class' => 'custom-file']) !!}
            @error('user_image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form__btn">
            {!! Form::button('Create account', ['type' => 'submit']) !!}
        </div>


    </div>
    {!! Form::close() !!}
@endsection
@section('script')
@endsection
