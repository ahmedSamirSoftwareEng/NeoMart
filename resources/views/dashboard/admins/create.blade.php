@extends('layouts.dashboard-layout')

@section('title', 'Create Admin')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.admins.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <form action="{{ route('dashboard.admins.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('dashboard.admins._form' ,[
            'button_label' => 'Create Admin',
        ])
    </form>
@endsection
