@extends('layouts.template')

@push('csslib')
<link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
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
                        <li class="nav-item"><a href="{{ route('company.general') }}" class="nav-link active">General</a></li>
                        <li class="nav-item"><a href="{{ route('company.social') }}" class="nav-link">Social</a></li>
                        <li class="nav-item"><a href="{{ route('company.image') }}" class="nav-link">Image</a></li>
                        <li class="nav-item"><a href="{{ route('company.other') }}" class="nav-link">Other</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form id="setting-form" method="POST" action="{{ route('company.general.update') }}">
                @csrf
                <div class="card" id="settings-card">
                    <div class="card-header">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row align-items-center">
                            <label for="name" class="form-control-label col-sm-3 text-md-right">Name</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $comp->name }}" placeholder="Please Input Name" maxlength="30" autofocus required>
                                @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="telp" class="form-control-label col-sm-3 text-md-right">Telp</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="tel" name="telp" class="form-control @error('telp') is-invalid @enderror" id="telp" value="{{ $comp->telp }}" placeholder="Please Input Telp" maxlength="15" required>
                                @error('telp')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="address" class="form-control-label col-sm-3 text-md-right">Address</label>
                            <div class="col-sm-6 col-md-9">
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Please Input Address" maxlength="200" required>{{ $comp->address }}</textarea>
                                @error('address')
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