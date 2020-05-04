@extends('layouts.front')

@section('content')
<div class="card my-4">
  <img class="card-img-top img-fluid" src="{{ $product->photo->url ?? 'http://placehold.it/900x400' }}" alt="">
  <div class="card-body">
    <h3 class="card-title">{{ $product->name }}</h3>
    <h4>${{ $product->price }}</h4>
    <p class="card-text">{{ $product->description }}</p>
  </div>
</div>
@endsection
