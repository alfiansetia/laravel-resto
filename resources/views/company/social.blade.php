@extends('layouts.template')

@push('csslib')
<link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@push('css')
@endpush

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Jump To</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item"><a href="{{ route('company.general') }}" class="nav-link">General</a></li>
                        <li class="nav-item"><a href="{{ route('company.social') }}" class="nav-link active">Social</a></li>
                        <li class="nav-item"><a href="{{ route('company.image') }}" class="nav-link">Image</a></li>
                        <li class="nav-item"><a href="{{ route('company.other') }}" class="nav-link">Other</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form id="setting-form" method="POST" action="{{ route('company.social.update') }}">
                @csrf
                <div class="card" id="settings-card">
                    <div class="card-header">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row align-items-center">
                            <label for="wa" class="form-control-label col-sm-3 text-md-right">WA</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="tel" name="wa" class="form-control @error('wa') is-invalid @enderror" id="wa" value="{{ $comp->wa }}" placeholder="Please Input WA" maxlength="15" autofocus required>
                                @error('wa')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="ig" class="form-control-label col-sm-3 text-md-right">IG</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="text" name="ig" class="form-control @error('ig') is-invalid @enderror" id="ig" value="{{ $comp->ig }}" placeholder="Please Input IG" maxlength="15" required>
                                @error('ig')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="fb" class="form-control-label col-sm-3 text-md-right">FB</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="text" name="fb" class="form-control @error('fb') is-invalid @enderror" id="fb" value="{{ $comp->fb }}" placeholder="Please Input FB" maxlength="15" required>
                                @error('fb')
                                <span class="error invalid-feedback">{{ $message }}</span>
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