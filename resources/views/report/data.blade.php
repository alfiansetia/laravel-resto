@extends('layouts.template')

@push('csslib')
<link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/table/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">


<link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">

@endpush

@push('css')
@endpush

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-lg-5">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="from" class="col-sm-3 col-form-label">From</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control datepicker" id="from" placeholder="From">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="to" class="col-sm-3 col-form-label">To</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control datepicker" id="to" placeholder="To">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ $title }}</h4>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <form action="" id="formSelected">
                            <table class="table table-hover" id="table" style="width: 100%;cursor: pointer;">
                                <thead>
                                    <tr>
                                        <th class="dt-no-sorting" style="width: 30px;">Id</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Disc</th>
                                        <th>Stok</th>
                                        <th>Desc</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
<div class="modal animated fade fadeInDown" id="modalAdd" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-plus mr-1" data-toggle="tooltip" title="Add Data"></i>Add Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" data-toggle="tooltip" title="Close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form" class="form-vertical" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label" for="name"><i class="fas fa-tag mr-1" data-toggle="tooltip" title="Name Menu"></i>Name :</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                        <span id="err_name" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="catmenu"><i class="fas fa-tags mr-1" data-toggle="tooltip" title="Category Menu"></i>Category :</label>
                        <select name="catmenu" id="catmenu" class="form-control" style="width: 100%;" required></select>
                        <span id="err_catmenu" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="price"><i class="fas fa-money-bill mr-1" data-toggle="tooltip" title="Price Menu"></i>Price :</label>
                        <input type="number" name="price" class="form-control" id="price" placeholder="Please Enter Price" value="0" min="0">
                        <span id="err_price" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="disc"><i class="fas fa-percent mr-1" data-toggle="tooltip" title="Disc Menu"></i>Disc :</label>
                        <input type="number" name="disc" class="form-control" id="disc" placeholder="Please Enter Disc" value="0" min="0">
                        <span id="err_disc" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="img"><i class="fas fa-image mr-1" data-toggle="tooltip" title="Image Menu"></i>Image :</label>
                        <input type="file" name="img" class="form-control" id="img" placeholder="Please Enter Image" required>
                        <span id="err_img" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="desc"><i class="fas fa-comment mr-1" data-toggle="tooltip" title="Desc Table"></i>Desc :</label>
                        <textarea name="desc" class="form-control" id="desc" placeholder="Please Enter desc" maxlength="150"></textarea>
                        <span id="err_desc" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
                <button type="reset" id="reset" class="btn btn-warning"><i class="fas fa-undo mr-1" data-toggle="tooltip" title="Reset"></i>Reset</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1" data-toggle="tooltip" title="Save"></i>Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal animated fade fadeInDown" id="modalEdit" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleEdit"><i class="fas fa-edit mr-1" data-toggle="tooltip" title="Edit Data"></i>Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip" title="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEdit" class="fofrm-vertical" action="" method="POST" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label class="control-label" for="edit_name"><i class="fas fa-tag mr-1" data-toggle="tooltip" title="Name Menu"></i>Name :</label>
                        <input type="text" name="name" class="form-control" id="edit_name" placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                        <span id="err_edit_name" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_catmenu"><i class="fas fa-tags mr-1" data-toggle="tooltip" title="Category Menu"></i>Category :</label>
                        <select name="catmenu" id="edit_catmenu" class="form-control select2" style="width: 100%;" required></select>
                        <span id="err_edit_catmenu" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_price"><i class="fas fa-money-bill mr-1" data-toggle="tooltip" title="Price Menu"></i>Price :</label>
                        <input type="number" name="price" class="form-control" id="edit_price" placeholder="Please Enter Price" value="0" min="0">
                        <span id="err_edit_price" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_disc"><i class="fas fa-percent mr-1" data-toggle="tooltip" title="Disc Menu"></i>Disc :</label>
                        <input type="number" name="disc" class="form-control" id="edit_disc" placeholder="Please Enter Disc" value="0" min="0">
                        <span id="err_edit_disc" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_img"><i class="fas fa-image mr-1" data-toggle="tooltip" title="Image Menu"></i>Image :</label>
                        <input type="file" name="img" class="form-control" id="edit_img" placeholder="Please Enter Image">
                        <span id="err_edit_img" class="error invalid-feedback" style="display: hide;"></span>
                        <img id="img_prev" src="" alt="Menu" width="100px" height="100px">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_desc"><i class="fas fa-comment mr-1" data-toggle="tooltip" title="Desc Table"></i>Desc :</label>
                        <textarea name="desc" class="form-control" id="edit_desc" placeholder="Please Enter desc" maxlength="150"></textarea>
                        <span id="err_edit_desc" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="container-fluid">
                        <ul class="list-group list-group-flush" id="log" style="max-height: 200px;margin-bottom: 10px;overflow:scroll;-webkit-overflow-scrolling: touch;">
                        </ul>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
                <button type="button" id="edit_reset" class="btn btn-warning"><i class="fas fa-undo mr-1" data-toggle="tooltip" title="Reset"></i>Reset</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1" data-toggle="tooltip" title="Save"></i>Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endpush


@push('jslib')
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/table/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/table/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

<script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
@endpush

@push('js')
<script>
    $(document).ready(function() {

    });
</script>
@endpush