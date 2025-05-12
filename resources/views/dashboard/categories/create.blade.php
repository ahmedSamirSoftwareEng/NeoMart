@extends('layouts.dashboard-layout')

@section('title', 'Create Category')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <form action="{{ route('dashboard.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('dashboard.categories._form' ,[
            'button_label' => 'Create Category',
        ])
    </form>
@endsection
