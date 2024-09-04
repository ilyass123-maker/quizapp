<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
    <Dashboard :questions="{{ json_encode($questions) }}"></Dashboard>
@endsection
