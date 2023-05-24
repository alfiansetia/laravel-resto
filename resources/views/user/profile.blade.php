@extends('layouts.template')

@push('csslib')
<link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@section('content')
<div class="section-body">
    <h2 class="section-title">Hi, {{ auth()->user()->name }}!</h2>
    <p class="section-lead">
        Change information about yourself on this page.
    </p>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Jump To</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item"><a href="{{ route('user.profile') }}" class="nav-link active">General</a></li>
                        <li class="nav-item"><a href="{{ route('user.password') }}" class="nav-link">Password</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form id="setting-form" method="POST" action="{{ route('user.profile.update') }}">
                @csrf
                <div class="card" id="settings-card">
                    <div class="card-header">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row align-items-center">
                            <label for="name" class="form-control-label col-sm-3 text-md-right">Full Name</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" minlength="4" maxlength="25" placeholder="Please Input Full Name" value="{{ auth()->user()->name }}" autofocus required>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="email" class="form-control-label col-sm-3 text-md-right">Email</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" minlength="4" maxlength="25" placeholder="Please Input Email" value="{{ auth()->user()->email }}" required disabled>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="wa" class="form-control-label col-sm-3 text-md-right">Whatsapp</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="tel" name="wa" class="form-control @error('wa') is-invalid @enderror" id="wa" minlength="3" maxlength="15" placeholder="Please Input Whatsapp" value="{{ auth()->user()->wa }}" required>
                                @error('wa')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="address" class="form-control-label col-sm-3 text-md-right">Address</label>
                            <div class="col-sm-6 col-md-9">
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" maxlength="150" placeholder="Please Input Address" required>{{ auth()->user()->address }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-whitesmoke text-md-right">
                        <button type="submit" class="btn btn-primary" id="btn_save">Save Changes</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {

        $('form').submit(function() {
            $('button').prop('disabled', true);
            block();
        })
    })
</script>
@endpush