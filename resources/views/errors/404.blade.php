@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
@section('button')
         <a href="{{route('backend.dashboard')}}" class="btn btn-primary">Go Home</a>
     @endsection
