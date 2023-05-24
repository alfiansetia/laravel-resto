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
                        <li class="nav-item"><a href="{{ route('company.general') }}" class="nav-link">General</a></li>
                        <li class="nav-item"><a href="{{ route('company.social') }}" class="nav-link">Social</a></li>
                        <li class="nav-item"><a href="{{ route('company.image') }}" class="nav-link">Image</a></li>
                        <li class="nav-item"><a href="{{ route('company.other') }}" class="nav-link active">Other</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form id="setting-form" method="POST" action="{{ route('company.other.update') }}">
                @csrf
                <div class="card" id="settings-card">
                    <div class="card-header">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row align-items-center">
                            <label for="footer_struk" class="form-control-label col-sm-3 text-md-right">Footer Struk</label>
                            <div class="col-sm-6 col-md-9">
                                <textarea class="form-control @error('footer_struk') is-invalid @enderror" name="footer_struk" id="footer_struk" placeholder="Please Input Footer Struk" maxlength="100" autofocus required>{{ $comp->footer_struk }}</textarea>
                                @error('footer_struk')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="select_tax" class="form-control-label col-sm-3 text-md-right">TAX</label>
                            <div class="col-sm-6 col-md-9">
                                <select name="tax" id="select_tax" class="form-control" style="width: 100%;" required>
                                    <option value="yes" {{ $comp->tax == 'yes' ? 'selected' : '' }}>yes</option>
                                    <option value="no" {{ $comp->tax == 'no' ? 'selected' : '' }}>no</option>
                                </select>
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
<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        $('#select_tax').select2()

        $('form').submit(function() {
            $('button').prop('disabled', true);
            block();
        })
    })
</script>
@endpush