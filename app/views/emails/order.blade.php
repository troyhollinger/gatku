@extends('layouts.email')


@section('content')

<h1>New Order</h1>

<h2>Products</h2>


@foreach($items as $item)

<h2>{{ $item['name'] }}</h2>
<p>${{ $item['price'] / 100}}</p>

@endforeach


<h2>Shipping</h2>
<p>{{ $shipping / 100 }}</p>

<h2>Total</h2>
<p>{{ $total / 100 }}</p>

@stop