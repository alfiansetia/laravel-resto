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
                        <label for="range" class="col-sm-3 col-form-label">Range</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="range" placeholder="YYYY-MM-DD" autocomplete="off">
                        </div>
                    </div>
                    <div class="card-footer text-right mt-0">
                        <button class="btn btn-primary" id="apply">Apply</button>
                    </div>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-body">
                    <h3>
                        Total Sales = Rp. <span id="total"></span>
                    </h3>

                    <h4><span id="terbilang"></span></h4>

                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Report Sales</h4>
                </div>
                <div class="card-body p-0">
                    <!-- <div class="table-responsive"> -->
                    <table class="table table-hover" id="table" style="width: 100%;cursor: pointer;">
                        <thead>
                            <th>Date</th>
                            <th>Total</th>
                        </thead>
                    </table>
                    <!-- </div> -->
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
                <h5 class="modal-title" id="titleEdit"><i class="fas fa-info mr-1" data-toggle="tooltip" title="Detail Order"></i>Order Date : <span id="detail_date"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip" title="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table_detail" style="width: 100%;cursor: pointer;">
                        <thead>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Category</th>
                            <th>Total</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <p>
                <h4>
                    Total Sales = Rp. <span id="detail_total"></span>
                </h4>
                <h4><span id="detail_terbilang"></span></h4>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
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
    $('#apply').click(function() {
        getData()
    })

    if ($("#range").length) {
        $('#range').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            maxSpan: {
                days: 31
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                'Last 31 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment()],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            },
            showDropdowns: true,
            startDate: moment().startOf('month'),
            endDate: moment(),
            maxDate: moment(),
        });
    }

    var table = $('#table').DataTable({
        data: [],
        dom: 'lrt',
        scrollY: '400px',
        scrollCollapse: false,
        scrollX: true,
        scroller: true,
        lengthChange: false,
        paging: false,
        searching: false,
        columnDefs: [],
        info: false,
        columns: [{
            title: "Date",
            data: "date",
        }, {
            title: "Total",
            data: "total",
            render: function(data, type, row, meta) {
                return hrg(data)
            }
        }],
    });

    var table_detail = $("#table_detail").DataTable({
        rowId: 'id',
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
            title: "Total",
            data: 'total',
            render: function(data, type, row, meta) {
                return hrg(data)
            }
        }]
    });

    $('#table tbody').on('click', 'tr td', function() {
        let row = $(this).parents('tr')[0];
        let data = table.row(row).data()
        $('#detail_total').text(hrg(data.total))
        $('#detail_terbilang').text(terbilangRupiah(data.total) + (data.total == 0 ? '' : ' rupiah'))
        getOrder(data.date)
    })

    getData()

    function getOrder(date) {
        $.get(`{{ route('report.perdate') }}?date=${date}`).done(function(response) {
            $('#detail_date').text(date)
            $('#modalEdit').modal('show')
            table_detail.clear().rows.add(response.data).draw();
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

    function getData() {
        let from = $('#range').data('daterangepicker').startDate.format('YYYY-MM-DD');
        let to = $('#range').data('daterangepicker').endDate.format('YYYY-MM-DD');

        $.get(`{{ route('report.getdata') }}?from=${from}&to=${to}`).done(function(response) {
            table.clear().rows.add(response.data).draw();
            let total = 0;
            for (let i = 0; i < response.data.length; i++) {
                total = parseInt(total) + parseInt(response.data[i].total)
            }
            $('#total').text(hrg(total))
            $('#terbilang').text(terbilangRupiah(total) + (total == 0 ? '' : ' rupiah'))
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

    function terbilangRupiah(angka) {
        var bilangan = [
            '', 'satu', 'dua', 'tiga', 'empat', 'lima',
            'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'
        ];
        var hasil = '';

        if (angka < 12) {
            hasil = bilangan[angka];
        } else if (angka < 20) {
            hasil = terbilangRupiah(angka - 10) + ' belas';
        } else if (angka < 100) {
            hasil = terbilangRupiah(Math.floor(angka / 10)) + ' puluh ' + terbilangRupiah(angka % 10);
        } else if (angka < 200) {
            hasil = ' seratus ' + terbilangRupiah(angka - 100);
        } else if (angka < 1000) {
            hasil = terbilangRupiah(Math.floor(angka / 100)) + ' ratus ' + terbilangRupiah(angka % 100);
        } else if (angka < 2000) {
            hasil = ' seribu ' + terbilangRupiah(angka - 1000);
        } else if (angka < 1000000) {
            hasil = terbilangRupiah(Math.floor(angka / 1000)) + ' ribu ' + terbilangRupiah(angka % 1000);
        } else if (angka < 1000000000) {
            hasil = terbilangRupiah(Math.floor(angka / 1000000)) + ' juta ' + terbilangRupiah(angka % 1000000);
        } else if (angka < 1000000000000) {
            hasil = terbilangRupiah(Math.floor(angka / 1000000000)) + ' milyar ' + terbilangRupiah(angka % 1000000000);
        } else if (angka < 1000000000000000) {
            hasil = terbilangRupiah(Math.floor(angka / 1000000000000)) + ' triliun ' + terbilangRupiah(angka % 1000000000000);
        }

        return hasil;
    }
</script>
@endpush