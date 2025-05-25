@extends('layouts.dashboard-layout')

@section('title', 'Edit Product')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">Products</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <form action="{{ route('dashboard.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('dashboard.products._form' ,[
            'button_label' => 'Update Product',
        ])
    </form>
@endsection
