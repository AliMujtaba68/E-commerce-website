@extends('layouts.master')
@section('title', 'Account')
@section('content')

<div class="account-page">
    <div class="container">
        @auth
            <form action="{{route('logout')}}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Logout</button>
            </form>
        @endauth

    </div>
</div>
@endsection
