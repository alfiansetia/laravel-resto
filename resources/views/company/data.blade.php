@extends('layouts.template')

@push('csslib')
<link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@push('css')
@endpush

@section('content')
<div class="section-header">
    <h1>{{ $title }} </h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item active">{{ $title }}</div>
    </div>
</div>
<div class="section-body">
    <div class="row mt-sm-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>General Settings</h4>
                </div>
                <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="general">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="form-control-label col-sm-3 text-md-right">Name</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $comp->name }}" placeholder="Please Input Name" maxlength="30" required>
                                @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telp" class="form-control-label col-sm-3 text-md-right">Telp</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="tel" name="telp" class="form-control @error('telp') is-invalid @enderror" id="telp" value="{{ $comp->telp }}" placeholder="Please Input Telp" maxlength="15" required>
                                @error('telp')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
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
                        <button class="btn btn-warning" type="reset">Reset</button>
                        <button class="btn btn-primary" id="save">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Social Settings</h4>
                </div>
                <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="social">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="wa" class="form-control-label col-sm-3 text-md-right">WA</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="tel" name="wa" class="form-control @error('wa') is-invalid @enderror" id="wa" value="{{ $comp->wa }}" placeholder="Please Input WA" maxlength="15" required>
                                @error('wa')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ig" class="form-control-label col-sm-3 text-md-right">IG</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="text" name="ig" class="form-control @error('ig') is-invalid @enderror" id="ig" value="{{ $comp->ig }}" placeholder="Please Input IG" maxlength="25" required>
                                @error('ig')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fb" class="form-control-label col-sm-3 text-md-right">FB</label>
                            <div class="col-sm-6 col-md-9">
                                <input type="text" name="fb" class="form-control @error('fb') is-invalid @enderror" id="fb" value="{{ $comp->fb }}" placeholder="Please Input FB" maxlength="25" required>
                                @error('fb')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-whitesmoke text-md-right">
                        <button class="btn btn-warning" type="reset">Reset</button>
                        <button class="btn btn-primary" id="save">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Image Settings</h4>
                </div>
                <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="image">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="logo" class="form-control-label col-sm-3 text-md-right">Logo</label>
                            <div class="col-sm-6 col-md-9">
                                <div class="custom-file">
                                    <input type="file" name="logo" class="custom-file-input @error('logo') is-invalid @enderror" id="logo">
                                    <label for="logo" class="custom-file-label">Choose File</label>
                                    @error('logo')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-text text-muted">The image must have a maximum size of 2MB</div>
                                <img src="{{ url('images/company/') }}/{{ $comp->logo == '' ? 'logodefault.png' : $comp->logo }}" alt="Logo" width="100px" height="100px">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fav" class="form-control-label col-sm-3 text-md-right">Favicon</label>
                            <div class="col-sm-6 col-md-9">
                                <div class="custom-file">
                                    <input type="file" name="fav" class="custom-file-input @error('fav') is-invalid @enderror" id="fav">
                                    <label for="fav" class="custom-file-label">Choose File</label>
                                    @error('fav')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-text text-muted">The image must have a maximum size of 1MB</div>
                                <img src="{{ url('images/company/') }}/{{ $comp->fav == '' ? 'favicondefault.ico' : $comp->fav }}" alt="Favicon" width="30px" height="30px">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-whitesmoke text-md-right">
                        <button class="btn btn-warning" type="reset">Reset</button>
                        <button class="btn btn-primary" id="save">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Other Settings</h4>
                </div>
                <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="other">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="footer_struk" class="form-control-label col-sm-3 text-md-right">Footer Struk</label>
                            <div class="col-sm-6 col-md-9">
                                <textarea class="form-control @error('footer_struk') is-invalid @enderror" name="footer_struk" id="footer_struk" placeholder="Please Input Footer Struk" maxlength="100" required>{{ $comp->footer_struk }}</textarea>
                                @error('footer_struk')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="select_tax" class="form-control-label col-sm-3 text-md-right">Type</label>
                            <div class="col-sm-6 col-md-9">
                                <select name="tax" id="select_tax" class="form-control" style="width: 100%;" required>
                                    <option value="yes" {{ $comp->tax == 'yes' ? 'selected' : '' }}>yes</option>
                                    <option value="no" {{ $comp->tax == 'no' ? 'selected' : '' }}>no</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-whitesmoke text-md-right">
                        <button class="btn btn-warning" type="reset">Reset</button>
                        <button class="btn btn-primary" id="save">Save Changes</button>
                    </div>
                </form>
            </div>
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
        bsCustomFileInput.init();

        $('#select_tax').select2()

        $('form').submit(function() {
            $('button').prop('disabled', true);
            block();
        })
    })
</script>
@endpush