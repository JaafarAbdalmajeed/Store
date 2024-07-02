@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Edit Profile</li>
@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="form-row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->profile->first_name }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->profile->last_name }}">
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="birthday">Birthday</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ $user->profile->birthday }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="gender">Gender</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ $user->profile->gender == 'male' ? 'checked' : '' }}>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ $user->profile->gender == 'female' ? 'checked' : '' }}>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="street_address">Street Address</label>
                <input type="text" class="form-control" id="street_address" name="street_address" value="{{ $user->profile->street_address }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ $user->profile->city }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" class="form-control" id="state" name="state" value="{{ $user->profile->state }}">
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="postal_code">Postal Code</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $user->profile->postal_code }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="country">Country</label>
                <select class="form-control" id="country" name="country">
                    @foreach($countries as $code => $name)
                        <option value="{{ $code }}" {{ $user->profile->country == $code ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="locale">Locale</label>
                <select class="form-control" id="locale" name="locale">
                    @foreach($locales as $locale)
                        <option value="{{ $locale }}" {{ $user->profile->locale == $locale ? 'selected' : '' }}>{{ $locale }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>

@endsection
