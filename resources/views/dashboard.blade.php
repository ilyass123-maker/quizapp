@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <p>Welcome, {{ Auth::user()->name }}!</p>
    <a href="{{ route('quiz') }}">Start Quiz</a>
</div>
@endsection
