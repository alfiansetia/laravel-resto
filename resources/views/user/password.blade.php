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
                        <li class="nav-item"><a href="{{ route('user.profile') }}" class="nav-link">General</a></li>
                        <li class="nav-item"><a href="{{ route('user.password') }}" class="nav-link active">Password</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form id="setting-form" method="POST" action="{{ route('user.password.update') }}">
                @csrf
                <div class="card" id="settings-card">
                    <div class="card-header">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row align-items-center">
                            <label for="password" class="form-control-label col-sm-3 text-md-right">New Password</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" minlength="8" placeholder="Please Input Password" autofocus autocomplete="off" required>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="password2" class="form-control-label col-sm-3 text-md-right">Confirm Password</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="password" name="password2" class="form-control @error('password2') is-invalid @enderror" id="password2" minlength="8" placeholder="Please Input Confirm Password" autocomplete="off" required>
                                @error('password2')
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