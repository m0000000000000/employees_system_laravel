@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
@section('button')
    <a href="{{route('backend.dashboard')}}" class="btn btn-primary">Go Home</a>
@endsection
