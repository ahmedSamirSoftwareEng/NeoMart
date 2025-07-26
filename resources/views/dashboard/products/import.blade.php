@extends('layouts.dashboard-layout')

@section('title', 'import products')
@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}"> import Products
    </a></li>
<li class="breadcrumb-item active">import</li>
@endsection

@section('content')
<form action="{{ route('dashboard.products.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- Products count --}}
    <div class="mb-3">
        <x-form.label id="name"> Products count </x-form.label>
        <x-form.input name="count" :value="old('count')" />
    </div>

    <button type="submit" class="btn btn-primary">Import</button>
</form>
@endsection