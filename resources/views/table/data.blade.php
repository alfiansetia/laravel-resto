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
<div class="section-header">
    <h1>{{ $title }} </h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item active">{{ $title }}</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <form action="" id="formSelected">
                            <table class="table table-hover" id="table" style="width: 100%;cursor: pointer;">
                                <thead>
                                    <tr>
                                        <th class="dt-no-sorting" style="width: 30px;">Id</th>
                                        <th>Number</th>
                                        <th>Name</th>
                                        <th>Status</th>
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
                        <label class="control-label" for="number"><i class="fas fa-table mr-1" data-toggle="tooltip" title="Number Table"></i>Number :</label>
                        <input type="number" name="number" class="form-control" id="number" placeholder="Please Enter Number" max="1000" required>
                        <span id="err_number" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name"><i class="fas fa-tag mr-1" data-toggle="tooltip" title="Name Table"></i>Name :</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                        <span id="err_name" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="status"><i class="fas fa-question-circle mr-1" data-toggle="tooltip" title="Status Table"></i>Status :</label>
                        <select name="status" id="status" class="form-control select2" style="width: 100%;" required>
                            <option value="free">free</option>
                            <option value="booked">booked</option>
                            <option value="nonactive">nonactive</option>
                        </select>
                        <span id="err_status" class="error invalid-feedback" style="display: hide;"></span>
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
                <form id="formEdit" class="fofrm-vertical" action="" method="POST" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label class="control-label" for="edit_number"><i class="fas fa-table mr-1" data-toggle="tooltip" title="Number Table"></i>Number :</label>
                        <input type="number" name="number" class="form-control" id="edit_number" placeholder="Please Enter Number" max="1000" required>
                        <span id="err_edit_number" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_name"><i class="fas fa-tag mr-1" data-toggle="tooltip" title="Name Table"></i>Name :</label>
                        <input type="text" name="name" class="form-control" id="edit_name" placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                        <span id="err_edit_name" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_status"><i class="fas fa-question-circle mr-1" data-toggle="tooltip" title="Status Table"></i>Status :</label>
                        <select name="status" id="edit_status" class="form-control select2" style="width: 100%;" required>
                            <option value="free">free</option>
                            <option value="booked">booked</option>
                            <option value="nonactive">nonactive</option>
                        </select>
                        <span id="err_edit_status" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_desc"><i class="fas fa-comment mr-1" data-toggle="tooltip" title="Desc Table"></i>Desc :</label>
                        <textarea name="desc" class="form-control" id="edit_desc" placeholder="Please Enter desc" maxlength="150"></textarea>
                        <span id="err_edit_desc" class="error invalid-feedback" style="display: hide;"></span>
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

<div class="modal animated fade fadeInDown" id="modalChange" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-edit mr-1" data-toggle="tooltip" title="Change Data"></i>Change Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" data-toggle="tooltip" title="Close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="change_status"><i class="fas fa-question-circle mr-1" data-toggle="tooltip" title="Status Table"></i>Status :</label>
                    <select name="status" id="change_status" class="form-control select2" style="width: 100%;" required>
                        <option value="free">free</option>
                        <option value="booked">booked</option>
                        <option value="nonactive">nonactive</option>
                    </select>
                    <span id="err_change_status" class="error invalid-feedback" style="display: hide;"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
                <button type="button" id="submitChange" class="btn btn-primary"><i class="fas fa-paper-plane mr-1" data-toggle="tooltip" title="Save"></i>Save</button>
            </div>
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
        ajax: "{{ route('table.index') }}",
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
            title: "Number",
            data: 'number',
        }, {
            title: "Name",
            data: 'name',
        }, {
            title: "Status",
            data: 'status',
            render: function(data, type, row, meta) {
                if (data == 'free') {
                    text = `<span class="badge badge-success">${data}</span>`;
                } else if (data == 'nonactive') {
                    text = `<span class="badge badge-danger">${data}</span>`;
                } else {
                    text = `<span class="badge badge-warning">${data}</span>`;
                }
                if (type == 'display') {
                    return text
                } else {
                    return data
                }
            }
        }, {
            title: "Desc",
            data: 'desc',
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
                    $('#number').focus();
                })
            }
        }, {
            text: '<i class="fa fa-tools"></i>Action',
            className: 'btn btn-sm btn-info bs-tooltip',
            attr: {
                'data-toggle': 'tooltip',
                'title': 'Action'
            },
            extend: 'collection',
            autoClose: true,
            buttons: [{
                text: 'Change',
                className: 'btn btn-info',
                action: function(e, dt, node, config) {
                    changeData();
                }
            }, {
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
        }],
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
                url: "{{ route('table.store') }}",
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
                    erlen = Object.keys(er).length
                    for (i = 0; i < erlen; i++) {
                        obname = Object.keys(er)[i];
                        $('#' + obname).addClass('is-invalid');
                        $('#err_' + obname).text(er[obname][0]);
                        $('#err_' + obname).show();
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
        let url = "{{ route('table.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(result) {
                unblock();
                $('#edit_reset').val(result.data.id);
                $('#edit_id').val(result.data.id);
                $('#edit_number').val(result.data.number);
                $('#edit_name').val(result.data.name);
                $('#edit_status').val(result.data.status).change();
                $('#edit_desc').val(result.data.desc);
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
        let url = "{{ route('table.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(result) {
                unblock();
                $('#edit_reset').val(result.data.id);
                $('#edit_id').val(result.data.id);
                $('#edit_number').val(result.data.number);
                $('#edit_name').val(result.data.name);
                $('#edit_status').val(result.data.status).change();
                $('#edit_desc').val(result.data.desc);

                $('#modalEdit').modal('show');
                $('#modalEdit').on('shown.bs.modal', function() {
                    $('#edit_number').focus();
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
            let url = "{{ route('table.update', ':id') }}";
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
                            $('#err_edit_' + obname).text(er[obname][0]);
                            $('#err_edit_' + obname).show();
                        }
                    }
                }
            });
        }
    });

    function changeData() {
        if (selected()) {
            $('#modalChange').modal('show');
            $('#modalChange').on('shown.bs.modal', function() {
                $('#change_status').focus();
            })
        }
    }

    $("#submitChange").click(function() {
        let btn = $(this);
        let status = $('#change_status').val();
        let form = $("#formSelected");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{ route('table.change') }}",
            data: $(form).serialize() + '&status=' + status,
            beforeSend: function() {
                btn.prop('disabled', true);
                block();
            },
            success: function(res) {
                btn.prop('disabled', false);
                unblock();
                table.ajax.reload();
                if (res.status == true) {
                    swal(
                        'Changed!',
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
                btn.prop('disabled', false);
                unblock();
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
                        $('#err_change_' + obname).text(er[obname][0]);
                        $('#err_change_' + obname).show();
                    }
                }
            }
        });
    })

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
                        url: "{{ route('table.destroy') }}",
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