@extends('web.layout.master')
@section('title','Hebi Store')
{{--meta--}}
@section('meta')
    <meta name="description" content=""/>
    <meta name="keywords" content="Hebi Mobile">
@stop
@section('style_page')
    <link rel="stylesheet" href="dist/home/home.css">
@stop
{{--content of page--}}
@section('content')
    <div class="container">
        @include('web.home.category')
        @include('web.home.flash-sale')
        @include('web.home.product-phone')
        @include('web.home.product-tablet')
        @include('web.home.product-laptop')
        @include('web.home.product-watch')
        @include('web.home.product-home')
        @include('web.home.product-accessory')
        @include('web.home.product-sound')
        @include('web.home.product-accessory-all')
    </div>
@stop
@section('script_page')

@stop
