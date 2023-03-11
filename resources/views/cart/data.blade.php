@extends('layouts.template')

@push('csslib')
<link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@push('css')
@endpush

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $title }}</h4>
                </div>
                <div class="card-body pt-0">
                    <div class="form-group row">
                        <label for="name_cart" class="col-sm-3 col-form-label">Name :</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" id="name_cart" placeholder="Input Name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="select_category" class="col-sm-3 col-form-label">Type :</label>
                        <div class="col-sm-9">
                            <select name="category" id="select_category" class="form-control" style="width: 100%;">
                                <option value="dine in">dine in</option>
                                <option value="take away">take away</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="select_table" class="col-sm-3 col-form-label">Table :</label>
                        <div class="col-sm-9">
                            <select name="table" id="select_table" class="form-control" style="width: 100%;"></select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header pb-0 pt-1">
                    <h4>List Cart <div id="totalitem" class="badge badge-info">0 Item</div>
                    </h4>
                    <div class="card-header-action">
                        <button type="button" id="add_to_cart" class="btn btn-primary">Add Menu <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table" style="width: 100%;cursor: pointer;">
                            <thead>
                                <tr>
                                    <th class="dt-no-sorting" style="width: 30px;"><i class="fas fa-cog"></i></th>
                                    <th>Menu</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Disc</th>
                                    <th>Subotal</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h1 id="grandtotal"></h1>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label for="total" class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Total</label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" id="total" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="gtotal" class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Grand Total</label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" id="gtotal" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="bill" class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Bill</label>
                        <div class="col-sm-12 col-md-8">
                            <div class="input-group">
                                <input type="number" id="bill" class="form-control" min="0" value="0">
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="tooltip" title="Lunas">
                                        <input type="checkbox" id="lunas">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="return" class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Return</label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" id="return" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button type="button" id="save" class="btn btn-primary btn-block"><i class="fas fa-save mr-1"></i>Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Last 5 Order</h4>
                    <div class="card-header-action">
                        <a href="{{ route('order.index') }}" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        <table class="table table-hover" id="tabletrx">
                            <tr>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<td>
    <a href="javascript:void(0)" data-minus="5" class="badge badge-primary p-2 minus"> - </a>
    <a href="javascript:void(0)" data-plus="5" class="badge badge-primary p-2 plus"> + </a>
</td>

@endsection

@push('modal')
<div class="modal animated fade fadeInDown" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <div class="input-group">
                        <input type="search" name="name" class="form-control form-control-lg" id="search_menu" placeholder="Search Menu">
                        <div class="input-group-append">
                            <button id="btn_search" class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" data-toggle="tooltip" title="Close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-lg table-hover" id="tblmenu" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>a</th>
                                <th>a</th>
                                <th>a</th>
                                <th>a</th>
                                <th>a</th>
                            </tr>
                        </thead>
                        <tbody> </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
            </div>
        </div>
    </div>
</div>

@endpush


@push('jslib')
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>

<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>

@endpush

@push('js')
<script>
    function total(data) {
        var total = 0;
        $.each(data, function(i, v) {
            total += (v.menu.price * v.qty) - (v.menu.price * v.qty * v.menu.disc / 100);
        });
        gtotal = parseInt((total))
        if ($('#lunas').prop('checked') == true) {
            $('#bill').prop('disabled', true)
            $('#bill').val(total)
        } else {
            $('#bill').prop('disabled', false)
        }
        $('#total').val(hrg(total));
        $('#gtotal').val(hrg(gtotal));
        $('#grandtotal').text('Rp. ' + hrg(gtotal));
        $('#return').val(hrg(parseInt($('#bill').val() - gtotal)));
    }

    $(document).ready(function() {
        $("#select_table").select2({
            placeholder: "Select a Table",
            ajax: {
                delay: 1000,
                url: "{{ route('table.index') }}",
                data: function(params) {
                    return {
                        number: params.term,
                        page: params.page
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data.data, function(item) {
                            return {
                                text: item.number + ' => [' + item.status + '] ' + (item.desc == '' ? '' : '(' + item.desc + ')'),
                                id: item.id,
                                disabled: item.status == 'free' ? false : true,
                            }
                        })
                    };
                },
            },
        });
        $('#name_cart').focus()

        $('#select_category').select2();

    });

    $('#bill').change(function() {
        table.ajax.reload()
    })
    $('#lunas').change(function() {
        table.ajax.reload()
    })

    $('#select_category').change(function() {
        if ($(this).val() == 'dine in') {
            $("#select_table").prop('disabled', false);
        } else {
            $("#select_table").val('').change();
            $("#select_table").prop('disabled', true);
        }
    })

    function add_value(data) {

    }

    $('#table').on('change', '#qty', function() {
        let row = $(this).parents('tr')[0];
        data = table.row(row).data()
        if (this.value > 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            let url = "{{ route('cart.update', ':id') }}";
            url = url.replace(':id', data.id);
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    qty: this.value,
                    _method: 'put',
                },
                beforeSend: function() {
                    block();
                },
                success: function(res) {
                    table.ajax.reload();
                    unblock();
                    if (res.status == false) {
                        swal(
                            'Failed!',
                            res.message,
                            'error'
                        )
                    }
                },
                error: function(xhr, status, error) {
                    table.ajax.reload()
                    unblock();
                    er = xhr.responseJSON.errors
                    if (xhr.status == 500) {
                        swal(
                            'Failed!',
                            'Server Error',
                            'error'
                        )
                    } else if (xhr.status == 422) {
                        swal(
                            'Failed!',
                            xhr.responseJSON.message,
                            'error'
                        )
                    }
                }
            });
        } else {
            swal(
                'Failed!',
                'Qty must greater than 0',
                'error'
            )
            $(this).val(1)
        }
    });

    $('#table').on('click', '#qty_plus', function() {
        let row = $(this).parents('tr')[0];
        data = table.row(row).data()
        qty = $(this).closest("td").find("#qty")
        if (qty.val() > 0) {
            qty.val(parseInt(qty.val()) + 1).change();
        }
    });
    $('#table').on('click', '#qty_minus', function() {
        let row = $(this).parents('tr')[0];
        data = table.row(row).data()
        qty = $(this).closest("td").find("#qty")
        if (qty.val() > 0) {
            qty.val(parseInt(qty.val()) - 1).change();
        }
    });

    $('#save').click(function() {
        let data = table.rows().data();
        var total = 0;
        $.each(data, function(i, v) {
            total += (v.menu.price * v.qty) - (v.menu.price * v.qty * v.menu.disc / 100);
        });
        if ($('#name_cart').val() == '') {
            $('#name_cart').addClass('is-invalid');
            $('#name_cart').focus()
        } else if ($('#select_category').val() == 'dine in' && $('#select_table').val() == null) {
            $('#name_cart').removeClass('is-invalid');
            swal(
                'Failed!',
                'Select Table!',
                'error'
            )
            $('#select_table').focus()
        } else if ($('#bill').val() < total) {
            $('#bill').addClass('is-invalid');
            $('#bill').focus()
        } else {
            $('#bill').removeClass('is-invalid');
            $('#name_cart').removeClass('is-invalid');
            $('#select_table').removeClass('is-invalid');
            if (data.length > 0) {
                swal({
                    title: 'Save Order?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then(function(result) {
                    if (result) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('order.store') }}",
                            data: {
                                name: $('#name_cart').val(),
                                table: $('#select_table').val(),
                                category: $('#select_category').val(),
                                bill: $('#bill').val(),
                            },
                            beforeSend: function() {
                                block();
                                $('#save').prop('disabled', true);
                            },
                            success: function(res) {
                                unblock();
                                table.ajax.reload();
                                $('#save').prop('disabled', false);
                                if (res.status == true) {
                                    $('#bill').val(0)
                                    $('#name_cart').val('')
                                    $('#select_table').val('').change()
                                    $('#select_category').val('dine in').change()
                                    tbltrx.ajax.reload();
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
                                $('#save').prop('disabled', false);
                                er = xhr.responseJSON.errors
                                if (xhr.status == 500) {
                                    swal(
                                        'Failed!',
                                        'Server Error',
                                        'error'
                                    )
                                } else if (xhr.status == 422) {
                                    erlen = Object.keys(er).length
                                    for (i = 0; i < erlen; i++) {
                                        obname = Object.keys(er)[i];
                                        alert(obname + ' ' + er[obname][0])
                                    }

                                }
                            }
                        });
                    }
                })
            } else {
                swal(
                    'Failed!',
                    'Select Menu!',
                    'error'
                )
            }
        }
    })

    var tbltrx = $("#tabletrx").DataTable({
        processing: true,
        serverSide: true,
        rowId: 'id',
        ajax: {
            url: "{{ route('order.lastfive') }}",
            error: function(xhr, error, code) {
                swal(
                    'Failed!',
                    'Server Error',
                    'error'
                )
            }
        },
        dom: 'lrt',
        scrollY: '200px',
        scrollCollapse: true,
        lengthChange: false,
        paging: false,
        searching: true,
        columnDefs: [],
        info: false,
        order: [
            [0, 'desc']
        ],
        columns: [{
            title: "ID",
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
        }]
    });

    var tblmenu = $("#tblmenu").DataTable({
        processing: true,
        serverSide: true,
        rowId: 'id',
        ajax: {
            url: "{{ route('menu.index') }}",
            error: function(xhr, error, code) {
                swal(
                    'Failed!',
                    'Server Error',
                    'error'
                )
            }
        },
        dom: 'lrt',
        lengthChange: false,
        paging: false,
        searching: true,
        columnDefs: [],
        info: false,
        columns: [{
            title: "Name",
            data: 'name',
            render: function(data, type, row, meta) {
                let text;
                if (data != null) {
                    if (row.status == 'active') {
                        text = `<i class="fas fa-circle text-success" data-toggle="tooltip" title="Active"></i> ${data}`;
                    } else {
                        text = `<i class="fas fa-circle text-danger" data-toggle="tooltip" title="Nonactive"></i> ${data}`;
                    }
                }
                if (type == 'display') {
                    return text
                } else {
                    return data
                }
            }
        }, {
            title: "Category",
            data: 'catmenu_id',
            render: function(data, type, row, meta) {
                if (type == 'display') {
                    if (data != null) {
                        return row.catmenu.name
                    } else {
                        return data
                    }
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
            title: "Stok",
            data: 'stock',
            render: function(data, type, row, meta) {
                if (type == 'display') {
                    return hrg(data)
                } else {
                    return data
                }
            }
        }, {
            title: "Desc",
            data: 'desc',
        }]
    });

    $('#search_menu').keyup(function() {
        tblmenu.search($(this).val()).draw();
    })

    $('#btn_search').click(function() {
        tblmenu.search($('#search_menu').val()).draw();
    })

    $("#add_to_cart").click(function() {
        tblmenu.ajax.reload();
        $('#modalAdd').modal('show');
    })

    var table = $("#table").DataTable({
        processing: true,
        serverSide: true,
        rowId: 'id',
        ajax: {
            url: "{{ route('cart.index') }}",
            error: function(xhr, error, code) {
                swal(
                    'Failed!',
                    'Server Error',
                    'error'
                )
            }
        },
        scrollY: '250px',
        scrollCollapse: true,
        lengthChange: false,
        paging: false,
        searching: false,
        columnDefs: [],
        info: false,
        columns: [{
            title: '<i class="fas fa-cog"></i>',
            data: 'id',
            orderable: false,
            width: "30px",
            render: function(data, type, row, meta) {
                return `<button class="btn btn-sm btn-danger" id="btn_delete" value="${data}" type="button"><i class="fas fa-trash"></i></button>`
            }
        }, {
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
            data: 'menu_id',
            render: function(data, type, row, meta) {
                let text = ''
                if (data != null) {
                    text = hrg(row.menu.price)
                }
                if (type == 'display') {
                    return text
                } else {
                    return data
                }
            }
        }, {
            title: "Qty",
            data: 'qty',
            render: function(data, type, row, meta) {
                if (type == 'display') {
                    return `<div class="input-group">
                        <div class="input-group-prepend">
                          <button type="button" id="qty_minus" class="btn btn-primary btn-sm"><i class="fas fa-minus"></i></button>
                        </div>
                        <input type="number" id="qty" class="form-control form-control-sm" value="${data}" min="1" placeholder="Qty" style="width:40px;">
                        <div class="input-group-append">
                          <button type="button" id="qty_plus" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>
                        </div>
                      </div>`
                } else {
                    return data
                }
            }
        }, {
            title: "Disc",
            data: 'menu_id',
            render: function(data, type, row, meta) {
                let text = ''
                if (data != null) {
                    text = row.menu.disc + '%'
                }
                if (type == 'display') {
                    return text
                } else {
                    return data
                }
            }
        }, {
            title: "Subtotal",
            data: 'menu_id',
            render: function(data, type, row, meta) {
                let text
                if (data != null) {
                    text = (row.menu.price * row.qty) - (row.menu.price * row.qty * row.menu.disc / 100)
                }
                if (type == 'display') {
                    return hrg(text)
                } else {
                    return data
                }
            }
        }, ],
        drawCallback: function(settings) {
            let data = this.api().ajax.json().data
            total(data)
            let qty = 0;
            $.each(data, function(i, v) {
                qty += v.qty;
            });
            $('#totalitem').text(data.length + ' Item, ' + qty + ' Qty')
        },
    });
    multiCheck(table);
    var id;

    $('#tblmenu tbody').on('click', 'tr', function() {
        let data = tblmenu.row(this).data()
        if (data.stock > 0 && data.status == 'active') {
            swal({
                title: 'Add Menu?',
                text: data.name,
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then(function(result) {
                if (result) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('cart.store') }}",
                        data: {
                            menu: data.id,
                            qty: 1,
                        },
                        beforeSend: function() {
                            block();
                        },
                        success: function(res) {
                            unblock();
                            table.ajax.reload();
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
                            swal(
                                'Failed!',
                                'Server Error',
                                'error'
                            )
                        }
                    });
                }
            })
        } else {
            swal(
                'Failed!',
                'Stock 0 / Nonactive',
                'error'
            )
        }

    });

    $('#table').on('click', '#btn_delete', function() {
        let row = $(this).parents('tr')[0];
        data = table.row(row).data()
        swal({
            title: 'Delete Selected Data?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then(function(result) {
            if (result) {
                let url = "{{ route('cart.destroy', ':id') }}";
                url = url.replace(':id', data.id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: {
                        // _method: 'DELETE',
                    },
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
    });

    $('#tabletrx').on('click', '#btn_print', function() {
        let row = $(this).parents('tr')[0];
        data = tbltrx.row(row).data()
        win = window.open(`{{ url('order/${data.number}/print?type=small') }}`, 'blank');
    });

    $('#tabletrx').on('click', '#btn_pdf', function() {
        let row = $(this).parents('tr')[0];
        data = tbltrx.row(row).data()
        win = window.open(`{{ url('order/${data.number}/print?type=pdf') }}`, 'blank');
    });
</script>
@endpush