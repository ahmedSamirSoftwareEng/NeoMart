@extends('layouts.dashboard-layout')

@section('title', 'Edit Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Profile</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i> Edit Profile</h5>
                    </div>
                    <div class="card-body px-4 py-4">
                        <x-alert type="success" />
                        <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            {{-- Name Section --}}
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input name="first_name" type="text"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        value="{{ old('first_name', $user->profile->first_name) }}">
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input name="last_name" type="text"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        value="{{ old('last_name', $user->profile->last_name) }}">
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Birthday & Gender --}}
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input type="date" name="birthday"
                                        class="form-control @error('birthday') is-invalid @enderror"
                                        value="{{ old('birthday', $user->profile->birthday) }}">
                                    @error('birthday')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Gender</label>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="gender" value="male"
                                                {{ old('gender', $user->profile->gender) === 'male' ? 'checked' : '' }}>
                                            <label class="form-check-label">Male</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" value="female"
                                                {{ old('gender', $user->profile->gender) === 'female' ? 'checked' : '' }}>
                                            <label class="form-check-label">Female</label>
                                        </div>
                                    </div>
                                    @error('gender')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Address Section --}}
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="street_address" class="form-label">Street Address</label>
                                    <input name="street_address" type="text"
                                        class="form-control @error('street_address') is-invalid @enderror"
                                        value="{{ old('street_address', $user->profile->street_address) }}">
                                    @error('street_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="city" class="form-label">City</label>
                                    <input name="city" type="text"
                                        class="form-control @error('city') is-invalid @enderror"
                                        value="{{ old('city', $user->profile->city) }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="state" class="form-label">State</label>
                                    <input name="state" type="text"
                                        class="form-control @error('state') is-invalid @enderror"
                                        value="{{ old('state', $user->profile->state) }}">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Postal, Country, Locale --}}
                            <div class="row mb-4 align-items-end">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="postal_code" class="form-label">Postal Code</label>
                                        <input name="postal_code" type="text"
                                            class="form-control @error('postal_code') is-invalid @enderror"
                                            value="{{ old('postal_code', $user->profile->postal_code) }}">
                                        @error('postal_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country" class="form-label">Country</label>
                                        <select name="country" class="form-select @error('country') is-invalid @enderror">
                                            @foreach ($countries as $key => $label)
                                                <option value="{{ $key }}"
                                                    {{ old('country', $user->profile->country) == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="locale" class="form-label">Locale</label>
                                        <select name="locale" class="form-select @error('locale') is-invalid @enderror">
                                            @foreach ($locales as $key => $label)
                                                <option value="{{ $key }}"
                                                    {{ old('locale', $user->profile->locale) == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('locale')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Save Changes
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
