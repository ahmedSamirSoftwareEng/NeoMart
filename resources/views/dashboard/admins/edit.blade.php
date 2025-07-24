@extends('layouts.dashboard-layout')

@section('title', 'Edit Admin')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.admins.index') }}">Admins</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <form action="{{ route('dashboard.admins.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('dashboard.admins._form' ,[
            'button_label' => 'Update Admin',
        ])
    </form>
@endsection
