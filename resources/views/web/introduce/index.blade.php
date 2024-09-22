@extends('web.layout.master')
@section('title','Hebi Store')
{{--meta--}}
@section('meta')
    <meta name="description" content=""/>
    <meta name="keywords" content="Hebi Mobile">
@stop
@section('style_page')
    <link rel="stylesheet" href="dist/introduce/introduce.css">
@stop
{{--content of page--}}
@section('content')
    <div class="w-100 banner-introduce">
        <p class="title-intro">{{$data->title}}</p>
    </div>
    <div class="container content-introduce">
        {!! $data->content !!}
    </div>
@stop
@section('script_page')

@stop
