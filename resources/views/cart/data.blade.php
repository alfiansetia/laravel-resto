@extends('layouts.template')

@push('csslib')
<link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">

<link rel="stylesheet" href="{{ asset('plugins/pagination/pagination.css') }}">
@endpush

@push('css')
@endpush

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h4>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="all" name="stock" class="custom-control-input" value="all" checked>
                            <label class="custom-control-label" for="all">all</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="available" name="stock" class="custom-control-input" value="available">
                            <label class="custom-control-label" for="available">available</label>
                        </div>
                    </h4>
                    <div class="card-header-action">
                        <div class="btn-group">
                            <button type="button" id="add_to_cart" class="btn btn-primary">Menu</button>
                            <button type="button" id="list_table" class="btn btn-primary">Table</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="m-2">
                        <select name="" id="select_category" class="form-control">
                            <option value="">All</option>
                        </select>
                    </div>
                    <div class="table-responsive-1 w-100">
                        <div id="data" class="row data-container">
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6 mb-3">
                                <button class="btn btn-outline-secondary btn-sm pt-2 pb-2 btn-menu btn-block pilih">
                                    <img src="" class="img-fluid w-100 mb-2" style="height:140px;object-fit: cover;">
                                    <br>
                                    ( )
                                    <br>
                                    <b style="font-size:10pt;" class="text-primary">Coklat</b>
                                    <br>
                                    <b style="font-size:10pt;" class="text-success">Rp10,000,-</b>
                                </button>
                            </div>
                        </div>
                        <br>
                        <div class="wrapper">
                            <div id="pagination" class="pagination d-inline"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ $title }}</h4>
                    <div id="totalitem" class="badge badge-info">0 Item</div>
                </div>
                <div class="card-body pt-0">
                    <div class="form-group row mb-1">
                        <label for="name_cart" class="col-sm-3 col-form-label">Name :</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" id="name_cart" placeholder="Input Name" required>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="type" class="col-sm-3 col-form-label">Type :</label>
                        <div class="col-sm-9">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="dine_in" name="category" class="custom-control-input" value="dine in" checked>
                                <label class="custom-control-label" for="dine_in">dine in</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="take_away" name="category" class="custom-control-input" value="take away">
                                <label class="custom-control-label" for="take_away">take away</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="select_table" class="col-sm-3 col-form-label">Table :</label>
                        <div class="col-sm-9">
                            <select name="table" id="select_table" class="form-control" style="width: 100%;"></select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="table" style="width: 100%;cursor: pointer;">
                            <thead>
                                <tr>
                                    <th class="dt-no-sorting" style="width: 30px;"><i class="fas fa-cog"></i></th>
                                    <th style="max-width: 100px;">Menu</th>
                                    <th>Price</th>
                                    <th style="white-space: nowrap;">Qty</th>
                                    <th style="width: 30px;">Disc</th>
                                    <th>Subotal</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke text-md-right">
                    <div class="form-group row mb-1">
                        <label for="total" class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Total</label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" id="total" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="gtotal" class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Grand Total</label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" id="gtotal" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="bill" class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Bayar</label>
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
                    <div class="form-group row mb-2">
                        <label for="return" class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Kembali</label>
                        <div class="col-sm-12 col-md-8">
                            <input type="text" id="return" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-4"></label>
                        <div class="col-sm-12 col-md-8">
                            <button type="button" id="save" class="btn btn-primary btn-block"><i class="fas fa-save mr-1"></i>Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <div class="card card-warning">
                <div class="card-body">
                    <h1 id="grandtotal"></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card card-danger">
                <div class="card-header">
                    <h4>Last 5 Order</h4>
                    <div class="card-header-action">
                        <a href="{{ route('order.index') }}" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tabletrx" style="width: 100%;">
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

<div class="modal animated fade fadeInDown" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="table_all" name="status" class="custom-control-input" value="all" checked>
                        <label class="custom-control-label" for="table_all">all</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="table_available" name="status" class="custom-control-input" value="available">
                        <label class="custom-control-label" for="table_available">available</label>
                    </div>
                </h5>
                <!-- <h5 class="modal-title" id="titleEdit"><i class="fas fa-list mr-1" data-toggle="tooltip" title="List Table"></i>List Table</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip" title="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="data_table" class="row data-container">
                    <div class="col-1 mb-3">
                        <button class="btn btn-outline-secondary btn-sm pt-2 pb-2 btn-menu btn-block pilih">
                            <b style="font-size:12pt;" class="text-primary">#1</b>
                            <br>
                            (cccc)
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="wrapper mr-auto">
                    <div id="pagination_table" class="pagination d-inline"></div>
                </div>
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
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script src="{{ asset('plugins/pagination/pagination.min.js') }}"></script>


@endpush

@push('js')
<script>
    $(document).ready(function() {
        $('#select_category').selectric({
            disableOnMobile: false,
            nativeOnMobile: false,
            onChange: function() {
                pg.pagination('destroy');
                pg = pgn_menu()
                pg.pagination(1)
            },
        })
        getCatmenu()
    });

    function getCatmenu() {
        $.get("{{ route('catmenu.index') }}").done(function(response) {
            for (let i = 0; i < response.data.length; i++) {
                $('#select_category').append(`<option value="${response.data[i].id}">${response.data[i].name}</option>`)
            }
            $('#select_category').selectric('refresh');
        }).fail(function(xhr) {
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
        })
    }

    $('#name_cart').val('Umum')

    datatbl = $('#data_table')
    var pg1 = pgn_table()

    $('#list_table').click(function() {
        pg1.pagination(1)
        $('#modalEdit').modal('show');
    })

    dataContainer = $('#data')
    var pg = pgn_menu()

    $('input[type=radio][name=stock]').change(function() {
        pg.pagination('destroy');
        pg = pgn_menu()
        pg.pagination(1);
    });

    $('input[type=radio][name=status]').change(function() {
        pg1.pagination('destroy');
        pg1 = pgn_table()
        pg1.pagination(1);
    });

    function pgn_table() {
        let status = $('input[type=radio][name=status]:checked').val()
        let object = $('#pagination_table').pagination({
            dataSource: "{{ route('table.paginate') }}" + (status == 'available' ? '?status=available' : ''),
            locator: 'data',
            alias: {
                pageNumber: 'page',
            },
            totalNumberLocator: function(response) {
                return response.total
            },
            showPageNumbers: true,
            showSizeChanger: true,
            ajax: {
                beforeSend: function() {
                    datatbl.html(`<div class="col-12 text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>`);
                }
            },
            pageSize: 30,
            formatAjaxError: function(jqXHR, textStatus, errorThrown) {
                swal(
                    'Failed!',
                    'Server Error',
                    'error'
                )
            },
            callback: function(data, pagination) {
                let page = pagination.pageNumber
                let total = data.length;
                if (total > 0) {
                    show_data_table(data)
                } else {
                    datatbl.html(`<div class="col-12 text-center">Table tidak tersedia</div>`);
                }
            }
        })
        return object
    }

    function show_data_table(data) {
        let text = '';
        for (let i = 0; i < data.length; i++) {
            text += `<div class="col-xl-2 col-lg-2 col-md-3 col-4 mb-2 ">
                            <button onclick="selected_table(${data[i].id},'${data[i].number}', '${data[i].status}')" data-toggle="tooltip" title="${data[i].status}" ${data[i].status == 'free' ? '' : 'disabled'} class="btn btn-lg btn-outline-${data[i].status == 'free' ? 'success' : data[i].status == 'booked'? 'warning' : 'danger'} m-0 btn-menu btn-block">
                                <b style="font-size:10pt;white-space: nowrap;text-align:center;" class="text-primary">${data[i].number}</b>
                            </button>
                        </div>`
        }
        $('#data_table').html(text);
    }

    function pgn_menu() {
        let stock = $('input[type=radio][name=stock]:checked').val()
        let object = $('#pagination').pagination({
            dataSource: "{{ route('menu.paginate') }}?category=" + $('#select_category').val() + "&" + (stock == 'available' ? 'stock=available' : ''),
            locator: 'data',
            alias: {
                pageNumber: 'page',
            },
            totalNumberLocator: function(response) {
                return response.total
            },
            showPageNumbers: true,
            showSizeChanger: true,
            ajax: {
                beforeSend: function() {
                    dataContainer.html(`<div class="col-12 text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>`);
                }
            },
            pageSize: 8,
            formatAjaxError: function(jqXHR, textStatus, errorThrown) {
                swal(
                    'Failed!',
                    'Server Error',
                    'error'
                )
            },
            callback: function(data, pagination) {
                let page = pagination.pageNumber
                let total = data.length;
                if (total > 0) {
                    show_data(data)
                } else {
                    dataContainer.html(`<div class="col-12 text-center">Menu tidak tersedia</div>`);
                }

            }
        })
        return object
    }

    function show_data(data) {
        let text = '';
        for (let i = 0; i < data.length; i++) {
            text += `<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6 mb-3">
                            <button onclick="add_menu('${data[i].name}', ${data[i].id}, 1)" ${data[i].stock > 0 ? '' : 'disabled'} class="btn btn-outline-${data[i].stock > 0 ? 'secondary' : 'danger'} btn-sm pt-2 pb-2 btn-menu btn-block pilih" data-id="5" fdprocessedid="ma35zh">
                                <img src="{{ url('images/menu/') }}/${data[i].img != null ? data[i].img : 'default.png' }" class="img-fluid w-100 mb-2" style="height:100px;object-fit: cover;">
                                <br>
                                <b class="text-primary">${data[i].catmenu_id != '' ? ('['+data[i].catmenu.name+ '] ') : ''}${data[i].name}</b>
                                <br>
                                <b style="font-size:10pt;" class="text-success">Rp ${hrg(data[i].price)} ${data[i].disc > 0 ? (data[i].disc + '%') : ''}</b>
                            </button>
                        </div>`
        }
        $('#data').html(text);
    }

    function selected_table(id, number, status) {
        if (status == 'free') {
            var option = new Option((number + ' [' + status + ']'), id, true, true);
            $("#select_table").append(option).trigger('change');
            $('#modalEdit').modal('hide');
            $('#name_cart').focus()
        }
    }
</script>

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
                url: "{{ route('table.index') }}?status=available",
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
                                text: item.number + ' => [' + item.status + '] ',
                                id: item.id,
                                disabled: item.status == 'free' ? false : true,
                            }
                        })
                    };
                },
            },
        });

        $('#name_cart').focus()

        $('input[type=radio][name=category]').change(function() {
            if ($(this).val() == 'dine in') {
                $("#select_table").prop('disabled', false);
                $('#list_table').prop('disabled', false);
            } else {
                $("#select_table").val('').change();
                $("#select_table").prop('disabled', true);
                $('#list_table').prop('disabled', true);
            }
        });

    });

    $('#bill').change(function() {
        table.ajax.reload()
    })
    $('#lunas').change(function() {
        table.ajax.reload()
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
        let category = $('input[type=radio][name=category]:checked').val()
        let data = table.rows().data();
        var total = 0;
        $.each(data, function(i, v) {
            total += (v.menu.price * v.qty) - (v.menu.price * v.qty * v.menu.disc / 100);
        });
        if ($('#name_cart').val() == '') {
            $('#name_cart').addClass('is-invalid');
            $('#name_cart').focus()
        } else if (category == 'dine in' && $('#select_table').val() == null) {
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
                                category: category,
                                bill: $('#bill').val(),
                            },
                            beforeSend: function() {
                                block();
                                $('#save').prop('disabled', true);
                            },
                            success: function(res) {
                                unblock();
                                table.ajax.reload();
                                pg.pagination(1);
                                $('#save').prop('disabled', false);
                                if (res.status == true) {
                                    $('#bill').val(0)
                                    $('#name_cart').val('Umum')
                                    $('#select_table').val('').change()
                                    $("#dine_in").prop('checked', true).change();
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
        scrollX: true,
        scroller: true,
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
            title: "Disc",
            data: 'disc',
            render: function(data, type, row, meta) {
                if (type == 'display') {
                    return `${data}%`
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
        scrollX: true,
        scroller: true,
        lengthChange: false,
        paging: false,
        searching: false,
        columnDefs: [],
        info: false,
        order: [
            [1, 'desc']
        ],
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
        if (data.stock > 0) {
            add_menu(data.name, data.id, 1);
        } else {
            swal(
                'Failed!',
                'Stock 0',
                'error'
            )
        }

    });

    function add_menu(name, menu, qty) {
        swal({
            title: 'Add Menu?',
            text: name,
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
                        menu: menu,
                        qty: qty,
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
    }

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