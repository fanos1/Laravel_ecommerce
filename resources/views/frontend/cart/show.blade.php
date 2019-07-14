@extends('master')
@section('title', 'View a cart')
@section('content')

    <div class="container col-md-8 col-md-offset-2">
        <div class="col-12">
            <h2>show cart content</h2>
            <h1>{{ $cart->id }}</h1>
        </div>
    </div>

@endsection
