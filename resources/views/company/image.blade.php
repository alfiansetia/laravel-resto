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
                        <li class="nav-item"><a href="{{ route('company.social') }}" class="nav-link">Social</a></li>
                        <li class="nav-item"><a href="{{ route('company.image') }}" class="nav-link active">Image</a></li>
                        <li class="nav-item"><a href="{{ route('company.other') }}" class="nav-link">Other</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form id="setting-form" method="POST" action="{{ route('company.image.update') }}">
                @csrf
                <div class="card" id="settings-card">
                    <div class="card-header">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row ">
                            <label for="logo" class="form-control-label col-sm-3 text-md-right">Logo</label>
                            <div class="col-sm-6 col-md-9">
                                <div class="custom-file">
                                    <input type="file" name="logo" class="custom-file-input @error('logo') is-invalid @enderror" id="logo" required>
                                    <label for="logo" class="custom-file-label">Choose File</label>
                                    @error('logo')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-text text-muted">The image must have a maximum size of 2MB</div>
                                <img src="{{ $comp->logo }}" alt="Logo" width="100px" height="100px">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="fav" class="form-control-label col-sm-3 text-md-right">Favicon</label>
                            <div class="col-sm-6 col-md-9">
                                <div class="custom-file">
                                    <input type="file" name="fav" class="custom-file-input @error('fav') is-invalid @enderror" id="fav" required>
                                    <label for="fav" class="custom-file-label">Choose File</label>
                                    @error('fav')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-text text-muted">The image must have a maximum size of 1MB</div>
                                <img src="{{ $comp->fav }}" alt="Favicon" width="30px" height="30px">
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

@push('jslib')
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();

        $('form').submit(function() {
            $('button').prop('disabled', true);
            block();
        })
    })
</script>
@endpush