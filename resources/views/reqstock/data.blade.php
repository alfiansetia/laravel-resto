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
                                    <th>Number</th>
                                    <th>Kasir</th>
                                    <th>Date</th>
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
@endsection

@push('modal')
<div class="modal animated fade fadeInDown" id="modalAdd" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-plus mr-1" data-toggle="tooltip" title="Add Data"></i>Add Data Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" data-toggle="tooltip" title="Close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form" class="form-vertical" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label" for="desc"><i class="fas fa-comment mr-1" data-toggle="tooltip" title="Desc"></i>Desc :</label>
                        <textarea name="desc" class="form-control" id="desc" placeholder="Please Enter Desc" maxlength="150"></textarea>
                        <span id="err_desc" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="menu"><i class="fas fa-tags mr-1" data-toggle="tooltip" title="Menu"></i>Menu :</label>
                        <select id="menu" class="form-control" style="width: 100%;">
                        </select>
                        <span id="err_menu" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="type"><i class="fas fa-comment mr-1" data-toggle="tooltip" title="Type"></i>Type :</label>
                        <select name="type" id="type" class="form-control" style="width: 100%;">
                            <option value="add">add</option>
                            <option value="adjust">adjust</option>
                        </select>
                        <span id="err_type" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <button type="button" class="btn btn-info btn-sm mb-2" id="btn_table_add">Add Menu to table</button>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm" id="tableadd" style="width: 100%;cursor: pointer;">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>Type</th>
                                    <th>Qty</th>
                                    <th class="dt-no-sorting" style="width: 30px;">Act</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
                <h5 class="modal-title" id="titleEdit"><i class="fas fa-info mr-1" data-toggle="tooltip" title="Edit Data"></i>Detail Request <span class="badge badge-success" id="req_number">12345</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip" title="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4">
                        <table class="table table-sm table-hover table-responsive">
                            <tr>
                                <td style="text-align: left;">User</td>
                                <td style="width: 10px;text-align: center;">:</td>
                                <td style="text-align: left;" id="req_user">Aku</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">Date</td>
                                <td style="width: 10px;text-align: center;">:</td>
                                <td style="text-align: left;" id="req_date">sads</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">Status</td>
                                <td style="width: 10px;text-align: center;">:</td>
                                <td style="text-align: left;" id="req_status">paid</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">Date State</td>
                                <td style="width: 10px;text-align: center;">:</td>
                                <td style="text-align: left;" id="req_date_state">sads</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">State By</td>
                                <td style="width: 10px;text-align: center;">:</td>
                                <td style="text-align: left;" id="req_stateby">sads</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">Desc</td>
                                <td style="width: 10px;text-align: center;">:</td>
                                <td style="text-align: left;" id="req_desc">sads</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-8">
                        <div class="table-responsive">
                            <table id="tabletrx" class="table table-sm table-hover table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Type</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
                <button type="button" class="btn btn-warning" id="btn_cancel"><i class="fas fa-ban mr-1" data-toggle="tooltip" title="State Status Cancel"></i>Set Cancel</button>
                <button type="button" class="btn btn-success" id="btn_done"><i class="fas fa-check-circle mr-1" data-toggle="tooltip" title="State Status Done"></i>Set Done</button>
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
    $(document).ready(function() {
        $("#menu").select2({
            placeholder: "Select a Menu",
            ajax: {
                delay: 1000,
                url: "{{ route('menu.index') }}",
                data: function(params) {
                    return {
                        name: params.term,
                        page: params.page
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data.data, function(item) {
                            return {
                                stock: item.stock,
                                text: item.name + ' => ' + item.stock,
                                id: item.id,
                            }
                        })
                    };
                },
            }
        });
        $("#type").select2();

    });
    var table_add = $('#tableadd').DataTable({
        rowId: id,
        data: [],
        dom: 'lrt',
        lengthChange: false,
        paging: false,
        searching: false,
        columnDefs: [],
        info: false,
        columns: [{
            title: "Menu",
            data: "name"
        }, {
            title: "Type",
            data: "type"
        }, {
            title: 'Qty',
            data: 'qty',
            render: function(data, type, row, meta) {

                let text = `<input class="form-control form-control-sm" type="number" min="1" value="${data}" style="width:50%">`;
                if (type == 'display') {
                    return `<div class="input-group" style="white-space: nowrap;">
                        <div class="input-group-prepend">
                          <button type="button" id="qty_minus" class="btn btn-primary btn-sm"><i class="fas fa-minus"></i></button>
                        </div>
                        <input type="number" id="qty" class="form-control form-control-sm" value="${data}" min="0" placeholder="Qty" style="width:30px;">
                        <div class="input-group-append">
                          <button type="button" id="qty_plus" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>
                        </div>
                      </div>`
                } else {
                    return data
                }
            }
        }, {
            title: 'Act',
            render: function(data, type, row, meta) {
                return `<button class="btn btn-sm btn-danger" id="btn_delete" value="${data}" type="button"><i class="fas fa-trash"></i></button>`
            }
        }],
    });

    $('#tableadd').on('click', '#btn_delete', function() {
        var row = table_add.row($(this).parents('tr'));
        row.remove().draw(false);
    });

    $('#tableadd').on('change', '#qty', function() {
        let row = $(this).parents('tr')[0];
        let row_data = table_add.row(row)
        qty = $(this).closest("td").find("#qty")
        if (qty.val() > 0) {
            row_data.data()['qty'] = qty.val()
            row_data.invalidate().draw(false);
        } else {
            row_data.data()['qty'] = row_data.data().qty
            row_data.invalidate().draw(false);
        }
    });

    $('#tableadd').on('click', '#qty_plus', function() {
        let row = $(this).parents('tr')[0];
        let row_data = table_add.row(row)
        let qty = row_data.data().qty
        let type = row_data.data().type
        if (qty > 0 && type == 'add') {
            row_data.data()['qty'] = parseInt(qty) + 1
            row_data.invalidate().draw(false);
        } else if (qty >= 0 && type == 'adjust') {
            row_data.data()['qty'] = parseInt(qty) + 1
            row_data.invalidate().draw(false);
        }
    });

    $('#tableadd').on('click', '#qty_minus', function() {
        let row = $(this).parents('tr')[0];
        let row_data = table_add.row(row)
        let qty = row_data.data().qty
        let type = row_data.data().type
        if (qty > 1 && type == 'add') {
            row_data.data()['qty'] = parseInt(qty) - 1
            row_data.invalidate().draw(false);
        } else if (qty > 0 && type == 'adjust') {
            row_data.data()['qty'] = parseInt(qty) - 1
            row_data.invalidate().draw(false);
        }
    });

    $('#btn_table_add').click(function() {
        let type = $('#type').val()
        let cari = 0
        let menu = $("#menu").select2('data')
        let dttbl = table_add.rows().data().toArray()
        if (menu.length > 0) {
            for (let i = 0; i < dttbl.length; i++) {
                if (dttbl[i].id == menu[0].id) {
                    cari++
                }
            }

            if (cari > 0) {
                swal(
                    'Failed!',
                    'Menu sudah ada',
                    'error'
                )
            } else {
                if (menu[0].stock == 0 && type == 'adjust') {
                    swal(
                        'Failed!',
                        'Stok 0 hanya bisa type add!',
                        'error'
                    )
                } else {
                    table_add.row.add({
                        id: menu[0].id,
                        name: menu[0].text,
                        type: type,
                        qty: 1,
                    }).draw();
                }
            }
        } else {
            $('#menu').focus();
        }

    })

    $('#form').submit(function(event) {
        event.preventDefault();
        let dttbl = table_add.rows().data().toArray()
        let cari = 0
        for (let i = 0; i < dttbl.length; i++) {
            if (dttbl[i].qty < 1 && type == 'add') {
                cari++
            }
        }
        if (cari > 0) {
            swal(
                'Failed!',
                'Qty tidak boleh kurang dari 1 jika type add!',
                'error'
            )
        } else {
            let data = {
                desc: $('#desc').val(),
                menu: dttbl,
            }
            if (dttbl.length > 0) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('reqstock.store') }}",
                    data: data,
                    beforeSend: function() {
                        block();
                        $('button[type="submit"]').prop('disabled', true);
                        $('#form .error.invalid-feedback').each(function(i) {
                            $(this).hide();
                        });
                        $('#desc').removeClass('is-invalid');
                        $('#form input.is-invalid').each(function(i) {
                            $(this).removeClass('is-invalid');
                        });
                    },
                    success: function(res) {
                        unblock();
                        $('button[type="submit"]').prop('disabled', false);
                        if (res.status == true) {
                            table.ajax.reload()
                            $('#reset').click();
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
                        } else if (xhr.status == 403) {
                            swal(
                                'Failed!',
                                xhr.responseJSON.message,
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
            } else {
                $('#menu').focus()
            }
        }

    })

    $('#reset').click(function() {
        table_add.rows().remove().draw()
        $("#menu").empty('').change()
        $('#form .error.invalid-feedback').each(function(i) {
            $(this).hide();
        });
        $('#desc').removeClass('is-invalid');
        $('#form input.is-invalid').each(function(i) {
            $(this).removeClass('is-invalid');
        });
    })

    var table = $("#table").DataTable({
        processing: true,
        serverSide: true,
        rowId: 'id',
        ajax: {
            url: "{{ route('reqstock.index') }}",
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
            title: "Number",
            data: 'number',
        }, {
            title: "Kasir",
            data: 'user_id',
            visible: false,
            render: function(data, type, row, meta) {
                let text = ''
                if (data != null) {
                    text = row.user.email
                }
                if (type == 'display') {
                    return text
                } else {
                    return data
                }
            }
        }, {
            title: "Date",
            data: 'date',
        }, {
            title: "Status",
            data: 'status',
            render: function(data, type, row, meta) {
                if (data == 'done') {
                    text = `<span class="badge badge-success">${data}</span>`;
                } else if (data == 'pending') {
                    text = `<span class="badge badge-warning">${data}</span>`;
                } else {
                    text = `<span class="badge badge-secondary">${data}</span>`;
                }
                if (type == 'display') {
                    return text
                } else {
                    return data
                }
            }
        }, {
            title: "desc",
            data: 'desc',
        }],
        buttons: [, {
            text: '<i class="fa fa-plus"></i>Add',
            className: 'btn btn-sm btn-info bs-tooltip',
            attr: {
                'data-toggle': 'tooltip',
                'title': 'Add Data'
            },
            action: function(e, dt, node, config) {
                $('#modalAdd').modal('show');
                $('#modalAdd').on('shown.bs.modal', function() {
                    $('#desc').focus();
                })
            }
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

    var tbltrx = $("#tabletrx").DataTable({
        rowId: 'id',
        data: [],
        dom: 'lrt',
        lengthChange: false,
        paging: false,
        searching: true,
        columnDefs: [],
        info: false,
        order: [
            [0, 'asc']
        ],
        columns: [{
            title: "Menu",
            data: 'menu_id',
            render: function(data, type, row, meta) {
                let text = ''
                if (data != null) {
                    text = row.menu.name
                }
                if (type == 'display') {
                    return text
                } else {
                    return data
                }
            }
        }, {
            title: "Type",
            data: 'type',
        }, {
            title: "Qty",
            data: 'qty',
        }]
    });

    $('#table tbody').on('click', 'tr td:not(:first-child,:last-child)', function() {
        row = $(this).parents('tr')[0];
        id = table.row(row).data().id
        detail(id, true);
    });

    $('#btn_done').click(function() {
        let btn = $(this);
        setStatus(id, 'done', btn)
    })

    $('#btn_cancel').click(function() {
        let btn = $(this);
        setStatus(id, 'cancel', btn)
    })

    function setStatus(id, status, btn) {
        let url = "{{ route('reqstock.change', ':id') }}";
        url = url.replace(':id', id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                status: status
            },
            beforeSend: function() {
                btn.prop('disabled', true);
                block();
            },
            success: function(res) {
                btn.prop('disabled', false);
                unblock();
                table.ajax.reload();
                detail(id, false)
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
                } else if (xhr.status == 403) {
                    swal(
                        'Failed!',
                        xhr.responseJSON.message,
                        'error'
                    )
                } else {
                    swal(
                        'Failed!',
                        'Error',
                        'error'
                    )
                }
            }
        });
    }

    function detail(id, openModal) {
        let url = "{{ route('reqstock.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(result) {
                unblock();
                $('#req_number').text(result.data.number)
                if (result.data.status == 'pending') {
                    $('#req_number').addClass('badge-warning')
                    $('#req_number').removeClass('badge-secondary')
                    $('#req_number').removeClass('badge-success')
                } else if (result.data.status == 'done') {
                    $('#req_number').addClass('badge-success')
                    $('#req_number').removeClass('badge-secondary')
                    $('#req_number').removeClass('badge-warning')
                } else if (result.data.status == 'cancel') {
                    $('#req_number').addClass('badge-secondary')
                    $('#req_number').removeClass('badge-success')
                    $('#req_number').removeClass('badge-warning')
                }
                $('#req_date').text(result.data.date)
                $('#req_type').text(result.data.type)
                $('#req_date_state').text(result.data.date_state ?? '-')
                if (result.data.user_id != null) {
                    $('#req_user').text(result.data.user.name)
                } else {
                    $('#req_user').text('-')
                }
                if (result.data.stateby_id != null) {
                    $('#req_stateby').text(result.data.stateby.name)
                } else {
                    $('#req_stateby').text('-')
                }
                $('#req_status').text(result.data.status)
                if (result.data.status == 'pending') {
                    $('#btn_done').prop('disabled', false)
                    $('#btn_cancel').prop('disabled', false)
                } else {
                    $('#btn_done').prop('disabled', true)
                    $('#btn_cancel').prop('disabled', true)
                }
                $('#req_desc').text(result.data.desc)
                tbltrx.clear().rows.add(result.data.dtreqstock).draw();
                if (openModal == true) {
                    $('#modalEdit').modal('show');
                }
            },
            beforeSend: function() {
                block();
            },
            error: function(xhr, status, error) {
                unblock();
                er = xhr.responseJSON.errors
                if (xhr.status == 403) {
                    swal(
                        'Failed!',
                        xhr.responseJSON.message,
                        'error'
                    )
                } else {
                    swal(
                        'Failed!',
                        'Server Error',
                        'error'
                    )
                }
            }
        });
    }

    $('#table').on('click', '#btn_print', function() {
        let row = $(this).parents('tr')[0];
        data = table.row(row).data()
        win = window.open(`{{ url('order/${data.number}/print?type=small') }}`, 'blank');
    });

    $('#table').on('click', '#btn_pdf', function() {
        let row = $(this).parents('tr')[0];
        data = table.row(row).data()
        win = window.open(`{{ url('order/${data.number}/print?type=pdf') }}`, 'blank');
    });
</script>
@endpush