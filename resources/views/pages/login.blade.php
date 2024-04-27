@extends('layouts.master')
@section('title', 'Login')

<section class="login-page">
            <div class="login-form-box">
                <div class="login-title">Login</div>
                    <div class="login-form">
                        <form action="{{route('login')}}" method="post">
                            @csrf
                            
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
                                                            <button type="submit" class="btn btn-primary btn-black">Login</button>
                                                        </div>
</form>
                    </div>
            </div>
            
            </div>

    </section>