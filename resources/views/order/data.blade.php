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
                                        <th>Kasir</th>
                                        <th>Number</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th class="dt-no-sorting">Action</th>
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
        //
    });

    var table = $("#table").DataTable({
        processing: true,
        serverSide: true,
        rowId: 'id',
        ajax: {
            url: "{{ route('order.index') }}",
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
            title: "Number",
            data: 'number',
        }, {
            title: "Date",
            data: 'date',
        }, {
            title: "Customer",
            data: 'name',
        }, {
            title: "Category",
            data: 'category',
        }, {
            title: "Status",
            data: 'status',
            render: function(data, type, row, meta) {
                if (data == 'paid') {
                    text = `<span class="badge badge-success">${data}</span>`;
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
            title: "Action",
            data: 'id',
            orderable: false,
            render: function(data, type, row, meta) {
                let text = `<div class="btn-group mb-3" role="group" aria-label="Basic example">
                      <button type="button" id="btn_print" class="btn btn-primary" data-toggle="tooltip" title="Print"><i class="fas fa-print"></i></button>
                      <button type="button" id="btn_pdf" class="btn btn-danger" data-toggle="tooltip" title="Download PDF"><i class="fas fa-file-pdf"></i></button>
                    </div>`;
                if (type == 'display') {
                    return text
                } else {
                    return data
                }
            }
        }],
        buttons: [{
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