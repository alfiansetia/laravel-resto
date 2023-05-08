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
                    <div class="table-responsive">
                        <form action="" id="formSelected">
                            <table class="table table-hover" id="table" style="width: 100%;cursor: pointer;">
                                <thead>
                                    <tr>
                                        <th class="dt-no-sorting" style="width: 30px;">Id</th>
                                        <th>Number</th>
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
                        <label class="control-label" for="desc"><i class="fas fa-comment mr-1" data-toggle="tooltip" title="Desc Table"></i>Desc :</label>
                        <textarea name="desc" class="form-control" id="desc" placeholder="Please Enter desc" maxlength="150"></textarea>
                        <span id="err_desc" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="menu"><i class="fas fa-tags mr-1" data-toggle="tooltip" title="Menu"></i>Menu :</label>
                        <select name="menu" id="menu" class="form-control" style="width: 100%;" required>
                        </select>
                        <span id="err_menu" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <button type="button" class="btn btn-info btn-sm mb-2" id="btn_table_add">Add Menu to table</button>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm" id="tableadd" style="width: 100%;cursor: pointer;">
                            <thead>
                                <tr>
                                    <th>Menu</th>
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
                <h5 class="modal-title" id="titleEdit"><i class="fas fa-info mr-1" data-toggle="tooltip" title="Edit Data"></i>Detail Order <span class="badge badge-success" id="order_number">12345</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip" title="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4">
                        <table class="table table-sm table-hover table-responsive">
                            <tr>
                                <td style="text-align: left;">Kasir</td>
                                <td style="width: 10px;text-align: center;">:</td>
                                <td style="text-align: left;" id="order_user">Aku</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">Date</td>
                                <td style="width: 10px;text-align: center;">:</td>
                                <td style="text-align: left;" id="order_date">sads</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">Name</td>
                                <td style="width: 10px;text-align: center;">:</td>
                                <td style="text-align: left;" id="order_name">Aku</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">Table</td>
                                <td style="width: 10px;text-align: center;">:</td>
                                <td style="text-align: left;" id="order_table">#1</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">Total</td>
                                <td style="width: 10px;text-align: center;">:</td>
                                <td style="text-align: left;" id="order_total">Rp 10.000</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">Bayar</td>
                                <td style="width: 10px;text-align: center;">:</td>
                                <td style="text-align: left;" id="order_bill">Rp 10.000</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">Status</td>
                                <td style="width: 10px;text-align: center;">:</td>
                                <td style="text-align: left;" id="order_status">paid</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-8">
                        <div class="table-responsive">
                            <table id="tabletrx" class="table table-sm table-hover table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Disc</th>
                                        <th>Subtotal</th>
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
            </div>
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
                        <option value="active">active</option>
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
                                text: item.name,
                                id: item.id,
                                // disabled: item.status == 'nonactive' ? true : false,
                            }
                        })
                    };
                },
            }
        });

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
            title: 'Qty',
            data: 'qty',
            render: function(data, type, row, meta) {

                let text = `<input class="form-control form-control-sm" type="number" min="1" value="${data}" style="width:50%">`;
                if (type == 'display') {
                    return `<div class="input-group" style="white-space: nowrap;">
                        <div class="input-group-prepend">
                          <button type="button" id="qty_minus" class="btn btn-primary btn-sm"><i class="fas fa-minus"></i></button>
                        </div>
                        <input type="number" id="qty" class="form-control form-control-sm" value="${data}" min="1" placeholder="Qty" style="width:30px;">
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

    $('#tableadd').on('click', '#qty_plus', function() {
        let row = $(this).parents('tr')[0];
        qty = $(this).closest("td").find("#qty")
        if (qty.val() > 0) {
            qty.val(parseInt(qty.val()) + 1).change();
        }
    });

    $('#tableadd').on('click', '#qty_minus', function() {
        let row = $(this).parents('tr')[0];
        qty = $(this).closest("td").find("#qty")
        if (qty.val() > 1) {
            qty.val(parseInt(qty.val()) - 1).change();
        }
    });

    $('#btn_table_add').click(function() {
        let cari = 0;
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
                table_add.row.add({
                    id: menu[0].id,
                    name: menu[0].text,
                    qty: 1,
                }).draw();
            }

        } else {
            $('#menu').focus();
        }

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
                    text = `<span class="badge badge-danger">${data}</span>`;
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
            className: 'btn btn-sm btn-primary bs-tooltip',
            attr: {
                'data-toggle': 'tooltip',
                'title': 'Add Data'
            },
            action: function(e, dt, node, config) {
                $('#modalAdd').modal('show');
                $('#modalAdd').on('shown.bs.modal', function() {
                    $('#qty').focus();
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
            [0, 'desc']
        ],
        columns: [{
            title: "Menu",
            data: 'menu_id',
            render: function(data, type, row, meta) {
                let text = ''
                if (data != null) {
                    if (row.menu.catmenu_id != null) {
                        text = '[' + row.menu.catmenu.name + '] <b>' + row.menu.name + '</b>'
                    } else {
                        text = row.menu.name
                    }
                }
                if (type == 'display') {
                    return text
                } else {
                    return data
                }
            }
        }, {
            title: "Price",
            data: 'price',
            render: function(data, type, row, meta) {
                if (type == 'display') {
                    return hrg(data)
                } else {
                    return data
                }
            }
        }, {
            title: "Qty",
            data: 'qty',
        }, {
            title: "Disc",
            data: 'disc',
            render: function(data, type, row, meta) {
                if (type == 'display') {
                    return data + '%'
                } else {
                    return data
                }
            }
        }, {
            title: "Subtotal",
            data: 'id',
            render: function(data, type, row, meta) {
                let text
                if (data != null) {
                    text = (row.price * row.qty) - (row.price * row.qty * row.disc / 100)
                }
                if (type == 'display') {
                    return hrg(text)
                } else {
                    return data
                }
            }
        }]
    });

    $('#table tbody').on('click', 'tr td:not(:first-child,:last-child)', function() {
        row = $(this).parents('tr')[0];
        id = table.row(row).data().id
        let url = "{{ route('order.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(result) {
                unblock();
                $('#order_number').text(result.data.number)
                $('#order_date').text(result.data.date)
                $('#order_name').text(result.data.name)
                if (result.data.category == 'dine in' && result.data.table_id != '') {
                    $('#order_table').text('#' + result.data.table.number)
                } else {
                    $('#order_table').text(result.data.category)
                }
                if (result.data.user_id != '') {
                    $('#order_user').text(result.data.user.name)
                } else {
                    $('#order_user').text('-')
                }
                $('#order_total').text('Rp ' + hrg(result.data.total))
                $('#order_bill').text('Rp ' + hrg(result.data.bill))
                tbltrx.clear().rows.add(result.data.dtorder).draw();
                $('#modalEdit').modal('show');
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
            url: "{{ route('order.change') }}",
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
                        url: "{{ route('order.destroy') }}",
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