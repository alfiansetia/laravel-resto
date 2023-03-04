@extends('layouts.template')

@push('csslib')
<link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@push('css')
@endpush

@section('content')
<div class="section-header">
    <h1>{{ $title }} </h1>
    <div class="section-header-button">
        <button type="button" id="add_to_cart" class="btn btn-primary">Add to cart</a>
    </div>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
        <div class="breadcrumb-item active">{{ $title }}</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row mb-2">
                        <label for="name_cart" class="col-sm-3 col-form-label"><span class="h4">Name :</span></label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control form-control-lg" id="name_cart" placeholder="Input Name" required>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label for="name_cart" class="col-sm-3 col-form-label"><span class="h4">Table :</span></label>
                        <div class="col-sm-9">
                            <select name="table" id="select_table" class="form-control form-control-lg" style="width: 100%;"></select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <form action="" id="formSelected">
                            <table class="table table-hover" id="table" style="width: 100%;cursor: pointer;">
                                <thead>
                                    <tr>
                                        <th class="dt-no-sorting" style="width: 30px;"><i class="fas fa-cog"></i></th>
                                        <th>Menu</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Disc</th>
                                        <th>Subotal</th>
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
            <div class="card">
                <div class="card-body">
                    <h1 id="grandtotal"></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Total</label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" id="total" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Disc</label>
                        <div class="col-sm-12 col-md-8">
                            <input type="number" id="disc" class="form-control" value="0" min="0" max="100" onchange="zero(this)">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Grand Total</label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" id="gtotal" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Bill</label>
                        <div class="col-sm-12 col-md-8">
                            <input type="number" id="bill" class="form-control" min="0" value="0">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Return</label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" id="return" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                </div>
            </div>
        </div> -->
    </div>
</div>
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
                <table class="table table-lg table-hover" id="tblmenu" style="width: 100%;">
                    <thead></thead>
                    <tbody> </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
                <button type="reset" id="reset" class="btn btn-warning"><i class="fas fa-undo mr-1" data-toggle="tooltip" title="Reset"></i>Reset</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1" data-toggle="tooltip" title="Save"></i>Save</button>
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
    function zero(dom) {
        if ($(dom).val() == '' || $(dom).val() < 0) {
            $(dom).val(0)
        } else if ($(dom).val() > 100)[
            $(dom).val(100)
        ]
        table.ajax.reload()
    }

    function total(data) {
        var total = 0;
        $.each(data, function(i, v) {
            total += (v.menu.price * v.qty) - (v.menu.price * v.qty * v.menu.disc / 100);
        });
        gtotal = parseInt((total) - (total * parseInt($('#disc').val()) / 100))
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
                                text: item.number + ' [' + item.name + ']' + ' =>' + item.status + ' ',
                                id: item.id,
                                disabled: item.status == 'free' ? false : true,
                            }
                        })
                    };
                },
            },
        });
        $('#name_cart').focus()

        $('#bill').change(function() {
            table.ajax.reload()
        })
    });

    $('#btn_delete').click(function() {
        deleteData()
    })

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
            title: "Disc",
            data: 'disc',
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
                    text = row.menu.name
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
                    return `<input type="number" id="qty" class="form-control form-control-sm" value="${data}" min="1">`
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
                    text = row.menu.disc
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
        }, {
            title: "Desc",
            data: 'desc',
        }, ],
        drawCallback: function(settings) {
            let data = this.api().ajax.json().data
            total(data)
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('menu.store') }}",
                data: $(form).serialize(),
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
        let url = "{{ route('menu.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(result) {
                unblock();
                $('#edit_reset').val(result.data.id);
                $('#edit_id').val(result.data.id);
                $('#edit_name').val(result.data.name);
                if (result.data.catmenu_id != null) {
                    let option = new Option(result.data.catmenu.name, result.data.catmenu_id, true, true);
                    $('#edit_catmenu').append(option).change();
                } else {
                    $('#edit_catmenu').val('').change();
                }
                $('#edit_price').val(result.data.price);
                $('#edit_stok').val(result.data.stock);
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

    $('#tblmenu tbody').on('click', 'tr', function() {
        let data = tblmenu.row(this).data()
        if (data.stock > 0 && data.status == 'active') {
            if (confirm('Add ' + data.name + ' to cart?')) {
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
        } else {
            alert('Stock 0 / Nonactive')
        }

    });

    // $('#table tbody').on('click', 'tr td:not(:first-child)', function() {
    //     $('#formEdit .error.invalid-feedback').each(function(i) {
    //         $(this).hide();
    //     });
    //     $('#formEdit input.is-invalid').each(function(i) {
    //         $(this).removeClass('is-invalid');
    //     });
    //     row = $(this).parents('tr')[0];
    //     id = table.row(row).data().id
    //     let url = "{{ route('menu.edit', ':id') }}";
    //     url = url.replace(':id', id);
    //     $.ajax({
    //         url: url,
    //         method: 'GET',
    //         success: function(result) {
    //             unblock();
    //             $('#edit_reset').val(result.data.id);
    //             $('#edit_id').val(result.data.id);
    //             $('#edit_name').val(result.data.name);
    //             if (result.data.catmenu_id != null) {
    //                 let option = new Option(result.data.catmenu.name, result.data.catmenu_id, true, true);
    //                 $('#edit_catmenu').append(option).change();
    //             } else {
    //                 $('#edit_catmenu').val('').change();
    //             }
    //             $('#edit_price').val(result.data.price);
    //             $('#edit_stok').val(result.data.stock);
    //             $('#edit_status').val(result.data.status).change();
    //             $('#edit_desc').val(result.data.desc);

    //             $('#modalEdit').modal('show');
    //             $('#modalEdit').on('shown.bs.modal', function() {
    //                 $('#edit_name').focus();
    //             })
    //         },
    //         beforeSend: function() {
    //             block();
    //         },
    //         error: function(xhr, status, error) {
    //             unblock();
    //             er = xhr.responseJSON.errors
    //             swal(
    //                 'Failed!',
    //                 'Server Error',
    //                 'error'
    //             )
    //         }
    //     });
    // });

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
            let url = "{{ route('menu.update', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'POST',
                url: url,
                data: $(form).serialize(),
                beforeSend: function() {
                    block();
                    $('button[type="submit"]').prop('disabled', true);
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
            url: "{{ route('menu.change') }}",
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

    $('#table').on('click', '#btn_delete', function() {
        let row = $(this).parents('tr')[0];
        data = table.row(row).data()
        console.log(data.id)

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
</script>
@endpush