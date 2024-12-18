@extends('layouts.master')
@section('title', 'Register')
@section('content')
    <section class="login-page">
        <div class="login-form-box">
            <div class="login-title">Register</div>
            <div class="login-form">
                <form action="{{route('register')}}" method="post">
                    @csrf

                    <div class="field">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="@error('name') has-error @enderror" placeholder="Your Name" value="{{ old('name') }}">
                        @error('name')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="@error('email') has-error @enderror" placeholder="Your Email" value="{{ old('email') }}">
                        @error('email')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="@error('password') has-error @enderror" placeholder="******">
                        @error('password')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                    </div>

                    <div class="field">
                        <button type="submit" class="btn btn-primary btn-black">Register</button>
                    </div>
                    <a href="{{route('login')}}" class="link">already a user? Login..</a>
                </form>
            </div>
        </div>
    </section>
@endsection
