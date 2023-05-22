@extends('layouts.template')

@push('csslib')
<link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/table/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@push('css')
@endpush

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ $title }}</h4>
                </div>
                <div class="card-body pt-0">
                    <form action="" id="formSelected">
                        <table class="table table-hover" id="table" style="width: 100%;cursor: pointer;">
                            <thead>
                                <tr>
                                    <th class="dt-no-sorting" style="width: 30px;">Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>WA</th>
                                    <th>Role</th>
                                    <th>Address</th>
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
@endsection

@push('modal')
<div class="modal animated fade fadeInDown" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
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
                        <label class="control-label" for="name"><i class="far fa-user mr-1" data-toggle="tooltip" title="Full Name User"></i>Name :</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                        <span id="err_name" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email"><i class="far fa-envelope mr-1" data-toggle="tooltip" title="Email User"></i>Email :</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Please Enter Email" required>
                        <span id="err_email" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="wa"><i class="fab fa-whatsapp mr-1" data-toggle="tooltip" title="WA User"></i>WA :</label>
                        <input type="tel" name="wa" class="form-control" id="wa" placeholder="Please Enter WA" maxlength="15" required>
                        <span id="err_wa" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password"><i class="fas fa-lock mr-1" data-toggle="tooltip" title="Password User"></i>Password :</label>
                        <input type="text" name="password" class="form-control" id="password" placeholder="Please Enter Password" minlength="5" required>
                        <span id="err_password" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="role"><i class="fas fa-user-tag mr-1" data-toggle="tooltip" title="Role User"></i>Role :</label>
                        <select name="role" id="role" class="form-control select2" style="width: 100%;" required>
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                        </select>
                        <span id="err_role" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="address"><i class="fas fa-map-marker mr-1" data-toggle="tooltip" title="Address User"></i>Address :</label>
                        <textarea name="address" class="form-control" id="address" placeholder="Please Enter Address" maxlength="150"></textarea>
                        <span id="err_address" class="error invalid-feedback" style="display: hide;"></span>
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

<div class="modal animated fade fadeInDown" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleEdit"><i class="fas fa-edit mr-1" data-toggle="tooltip" title="Edit Data"></i>Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip" title="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEdit" class="form-vertical" action="" method="POST" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label class="control-label" for="edit_name"><i class="far fa-user mr-1" data-toggle="tooltip" title="Full Name User"></i>Name :</label>
                        <input type="hidden" name="id" id="edit_id">
                        <input type="text" name="name" class="form-control" id="edit_name" placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                        <span id="err_edit_name" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_email"><i class="far fa-envelope mr-1" data-toggle="tooltip" title="Email User"></i>Email :</label>
                        <input type="email" name="email" class="form-control" id="edit_email" placeholder="Please Enter Email" required>
                        <span id="err_edit_email" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_wa"><i class="fab fa-whatsapp mr-1" data-toggle="tooltip" title="WA User"></i>WA :</label>
                        <input type="text" name="wa" class="form-control" id="edit_wa" placeholder="Please Enter WA" maxlength="15" required>
                        <span id="err_edit_wa" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_password"><i class="fas fa-lock mr-1" data-toggle="tooltip" title="Password User"></i>Password :</label>
                        <input type="text" name="password" class="form-control" id="edit_password" placeholder="Please Enter Password" autocomplete="off" minlength="5">
                        <span id="err_edit_password" class="error invalid-feedback" style="display: hide;"></span>
                        <small id="passwordHelpBlock" class="form-text text-muted">leave blank if not change password</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_role"><i class="fas fa-user-tag mr-1" data-toggle="tooltip" title="Role User"></i>Role :</label>
                        <select name="role" id="edit_role" class="form-control select2" style="width: 100%;" required>
                            <option value="">Please Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                        </select>
                        <span id="err_edit_role" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_address"><i class="fas fa-map-marker mr-1" data-toggle="tooltip" title="Address User"></i>Address :</label>
                        <textarea name="address" class="form-control" id="edit_address" placeholder="Please Enter Address" maxlength="150"></textarea>
                        <span id="err_edit_address" class="error invalid-feedback" style="display: hide;"></span>
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

<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>

@endpush

@push('js')
<script>
    var table = $("#table").DataTable({
        processing: true,
        serverSide: true,
        rowId: 'id',
        ajax: {
            url: "{{ route('user.index') }}",
            error: function(xhr, error, code) {
                swal(
                    'Failed!',
                    'Server Error',
                    'error'
                )
            }
        },
        dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        oLanguage: {
            oPaginate: {
                sPrevious: '<i class="fas fa-chevron-left"></i>',
                sNext: '<i class="fas fa-chevron-right"></i>'
            },
            // "sInfo": "Showing page _PAGE_ of _PAGES_",
            sSearch: '',
            sSearchPlaceholder: "Search...",
            sLengthMenu: "Results :  _MENU_",
        },
        lengthMenu: [
            [10, 50, 100, 500, 1000],
            ['10 rows', '50 rows', '100 rows', '500 rows', '1000 rows']
        ],
        pageLength: 10,
        lengthChange: false,
        columnDefs: [],
        columns: [{
            title: 'Id',
            data: 'id',
            orderable: false,
            width: "30px",
            render: function(data, type, row, meta) {
                return `<div class="custom-checkbox custom-control"><input type="checkbox" id="check${data}" data-checkboxes="mygroup" name="id[]" value="${data}" class="custom-control-input child-chk select-customers-info"><label for="check${data}" class="custom-control-label">&nbsp;</label></div>`
            }
        }, {
            title: "Name",
            data: 'name',
            render: function(data, type, row, meta) {
                if (row.email_verified_at != null) {
                    text = `<i class="fas fa-circle text-success" data-toggle="tooltip" title="Active"></i> ${data}`;
                } else {
                    text = `<i class="fas fa-circle text-danger" data-toggle="tooltip" title="Nonactive"></i> ${data}`;
                }
                if (type == 'display') {
                    return text
                } else {
                    return data
                }
            }
        }, {
            title: "Email",
            data: 'email',
        }, {
            title: "WA",
            data: 'wa',
        }, {
            title: 'Role',
            data: 'roles[0].name',
            orderable: false,
            searchable: false,
            render: function(data, type, row, meta) {
                let text = '';
                if (data != '') {
                    if (data == 'admin') {
                        text = `<span class="badge badge-success">${data}</span>`
                    } else {
                        text = `<span class="badge badge-danger">${data}</span>`
                    }
                }
                if (type == 'display') {
                    return text
                } else {
                    return data
                }
            }
        }, {
            title: "Address",
            data: 'address',
        }, ],
        buttons: [, {
                text: '<i class="fa fa-plus"></i>Add',
                className: 'btn btn-sm btn-primary bs-tooltip',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Add Data'
                },
                action: function(e, dt, node, config) {
                    $('#modalAdd').modal('show');
                    $('#modalAdd').on('shown.bs.modal', function() {
                        $('#name').focus();
                    })
                }
            },
            {
                text: '<i class="fa fa-tools"></i>Action',
                className: 'btn btn-sm btn-info bs-tooltip',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Action'
                },
                extend: 'collection',
                autoClose: true,
                buttons: [{
                    text: 'Remove',
                    className: 'btn btn-danger',
                    action: function(e, dt, node, config) {
                        deleteData();
                    }
                }]
            }, {
                extend: "colvis",
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Column Visible'
                },
                className: 'btn btn-sm btn-primary'
            }, {
                extend: "pageLength",
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Page Length'
                },
                className: 'btn btn-sm btn-info'
            }
        ],
        headerCallback: function(e, a, t, n, s) {
            e.getElementsByTagName("th")[0].innerHTML = '<div class="custom-checkbox custom-control"><input type="checkbox" class="custom-control-input chk-parent select-customers-info" id="checkbox-all"><label for="checkbox-all" class="custom-control-label">&nbsp;</label></div>'
        },
        initComplete: function() {
            $('#table').DataTable().buttons().container().appendTo('#tableData_wrapper .col-md-6:eq(0)');
        },
    });
    multiCheck(table);
    var id;

    $('#form').submit(function(event) {
        event.preventDefault();
    }).validate({
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            $(element).addClass('is-valid');
        },
        submitHandler: function(form) {
            let formData = form;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('user.store') }}",
                data: $(formData).serialize(),
                beforeSend: function() {
                    block();
                    $('button[type="submit"]').prop('disabled', true);
                    $('#form .error.invalid-feedback').each(function(i) {
                        $(this).hide();
                    });
                    $('#form input.is-invalid').each(function(i) {
                        $(this).removeClass('is-invalid');
                    });
                },
                success: function(res) {
                    unblock();
                    table.ajax.reload();
                    $('button[type="submit"]').prop('disabled', false);
                    $('#reset').click();
                    if (res.status == true) {
                        swal(
                            'Success!',
                            res.message,
                            'success'
                        )
                    } else {
                        swal(
                            'Failed!',
                            res.message,
                            'error'
                        )
                    }
                },
                error: function(xhr, status, error) {
                    unblock();
                    $('button[type="submit"]').prop('disabled', false);
                    er = xhr.responseJSON.errors
                    if (xhr.status == 500) {
                        swal(
                            'Failed!',
                            'Server Error',
                            'error'
                        )
                    } else {
                        erlen = Object.keys(er).length
                        for (i = 0; i < erlen; i++) {
                            obname = Object.keys(er)[i];
                            $('#' + obname).addClass('is-invalid');
                            $('#err_' + obname).text(er[obname][0]);
                            $('#err_' + obname).show();
                        }
                    }
                }
            });
        }
    });

    $('#reset').click(function() {
        $('#form .error.invalid-feedback').each(function(i) {
            $(this).hide();
        });
        $('#form input.is-invalid').each(function(i) {
            $(this).removeClass('is-invalid');
        });
    })

    $('#edit_reset').click(function() {
        id = $(this).val();
        let url = "{{ route('user.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(result) {
                unblock();
                $('#edit_reset').val(result.data.id);
                $('#edit_id').val(result.data.id);
                $('#edit_name').val(result.data.name);
                $('#edit_email').val(result.data.email);
                $('#edit_wa').val(result.data.wa);
                $('#edit_address').val(result.data.address);
                $('#edit_password').val('');
                if (result.data.roles.length > 0) {
                    $('#edit_role').val(result.data.roles[0].name).change();
                } else {
                    $('#edit_role').val('').change();
                }
                $('#edit_reset').prop('disabled', false);
            },
            beforeSend: function() {
                block();
                $('#edit_reset').prop('disabled', true);
            },
            error: function(xhr, status, error) {
                unblock();
                $('#edit_reset').prop('disabled', false);
                er = xhr.responseJSON.errors
                swal(
                    'Failed!',
                    'Server Error',
                    'error'
                )
            }
        });
    })

    $('#table tbody').on('click', 'tr td:not(:first-child)', function() {
        $('#formEdit .error.invalid-feedback').each(function(i) {
            $(this).hide();
        });
        $('#formEdit input.is-invalid').each(function(i) {
            $(this).removeClass('is-invalid');
        });
        row = $(this).parents('tr')[0];
        id = table.row(row).data().id
        let url = "{{ route('user.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(result) {
                unblock();
                $('#edit_reset').val(result.data.id);
                $('#edit_id').val(result.data.id);
                $('#edit_name').val(result.data.name);
                $('#edit_email').val(result.data.email);
                $('#edit_wa').val(result.data.wa);
                $('#edit_address').val(result.data.address);
                $('#edit_password').val('');
                if (result.data.roles.length > 0) {
                    $('#edit_role').val(result.data.roles[0].name).change();
                } else {
                    $('#edit_role').val('').change();
                }
                $('#modalEdit').modal('show');
                $('#modalEdit').on('shown.bs.modal', function() {
                    $('#edit_name').focus();
                })
            },
            beforeSend: function() {
                block();
            },
            error: function(xhr, status, error) {
                unblock();
                er = xhr.responseJSON.errors
                swal(
                    'Failed!',
                    'Server Error',
                    'error'
                )
            }
        });

    });

    $('#formEdit').submit(function(event) {
        event.preventDefault();
    }).validate({
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            $(element).addClass('is-valid');
        },
        submitHandler: function(form) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            let url = "{{ route('user.update', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'POST',
                url: url,
                data: $(form).serialize(),
                beforeSend: function() {
                    block();
                    $('button[type="submit"]').prop('disabled', true);
                    console.log('loading bro');
                    $('#formEdit .error.invalid-feedback').each(function(i) {
                        $(this).hide();
                    });
                    $('#formEdit input.is-invalid').each(function(i) {
                        $(this).removeClass('is-invalid');
                    });
                },
                success: function(res) {
                    unblock();
                    $('button[type="submit"]').prop('disabled', false);
                    $('#reset').click();
                    if (res.status == true) {
                        if (id != "{{ auth()->user()->id }}") {
                            // 
                        } else {
                            window.location.reload()
                        }
                        table.ajax.reload();
                        swal(
                            'Success!',
                            res.message,
                            'success'
                        )
                    } else {
                        swal(
                            'Failed!',
                            res.message,
                            'error'
                        )
                    }
                },
                error: function(xhr, status, error) {
                    unblock();
                    $('button[type="submit"]').prop('disabled', false);
                    er = xhr.responseJSON.errors
                    if (xhr.status == 500) {
                        swal(
                            'Failed!',
                            'Server Error',
                            'error'
                        )
                    } else {
                        erlen = Object.keys(er).length
                        for (i = 0; i < erlen; i++) {
                            obname = Object.keys(er)[i];
                            $('#' + obname).addClass('is-invalid');
                            $('#err_edit_' + obname).text(er[obname][0]);
                            $('#err_edit_' + obname).show();
                        }
                    }

                }
            });
        }
    });

    function deleteData() {
        if (selected()) {
            swal({
                title: 'Delete Selected Data?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then(function(result) {
                if (result) {
                    let form = $("#formSelected");
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ route('user.destroy') }}",
                        data: $(form).serialize(),
                        beforeSend: function() {
                            block();
                        },
                        success: function(res) {
                            unblock();
                            table.ajax.reload();
                            if (res.status == true) {
                                swal(
                                    'Deleted!',
                                    res.message,
                                    'success'
                                )
                            } else {
                                swal(
                                    'Failed!',
                                    res.message,
                                    'error'
                                )
                            }
                        },
                        error: function(xhr, status, error) {
                            unblock();
                            er = xhr.responseJSON.errors
                            swal(
                                'Failed!',
                                'Server Error',
                                'error'
                            )
                        }
                    });
                }
            })
        }
    }

    function selected() {
        let id = $('input[name="id[]"]:checked').length;
        if (id <= 0) {
            swal({
                title: 'Failed!',
                text: "No Selected Data!",
                icon: 'error',
            })
            return false
        } else {
            return true
        }
    }
</script>
@endpush