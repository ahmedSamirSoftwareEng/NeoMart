@extends('layouts.dashboard-layout')

@section('title', 'Create Role')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.roles.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <form action="{{ route('dashboard.roles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('dashboard.roles._form' ,[
            'button_label' => 'Create Role',
        ])
    </form>
@endsection
