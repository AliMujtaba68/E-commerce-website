@extends('layouts.master')
@section('title', 'Home Page')
@section('content')
   <main class="homepage">

   @include('pages.components.home.header')
   @auth
   <form action="{{route('logout')}}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">Logout</button>
</form>
   @endauth

   </main>

@endsection