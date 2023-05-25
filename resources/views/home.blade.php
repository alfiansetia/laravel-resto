@extends('layouts.template')

@push('csslib')
<link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('content')
<div class="section-body">
    <!-- <h2 class="section-title">This is Example Page</h2>
    <p class="section-lead">This page is just an example for you to create your own page.</p>
    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ $title }}</h4>
        </div>
        <div class="card-body pt-0">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
        <div class="card-footer bg-whitesmoke">
            This is card footer
        </div>
    </div> -->


    <div class="row">
        @role('admin')
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>User</h4>
                    </div>
                    <div class="card-body" id="total_user">
                        Loading...
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-cubes"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Table Free</h4>
                    </div>
                    <div class="card-body" id="total_table">
                        Loading...
                    </div>
                </div>
            </div>
        </div>
        @endrole
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Menu</h4>
                    </div>
                    <div class="card-body" id="total_menu">
                        Loading...
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-cart-plus"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Order Today</h4>
                    </div>
                    <div class="card-body" id="total_order_today">
                        Loading...
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Sales Today</h4>
                    </div>
                    <div class="card-body" id="total_sales_today">
                        Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Statistics This Month</h4>
                    <div class="card-header-action">
                        <div class="btn-group">
                            <button id="line" type="button" class="btn btn-primary">Line</button>
                            <button id="bar" type="button" class="btn btn-primary">Bar</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart" height="182"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Top Menu</h4>
                </div>
                <div class="card-body" id="top-6-scroll">
                    <ul class="list-unstyled list-unstyled-border" id="top">
                        <li>Loading...</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h4>Menu Stock Limit</h4>
                    <div class="card-header-action">
                        <a href="{{ route('menu.index') }}" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="card-body" id="top-4-scroll">
                    <ul class="list-unstyled list-unstyled-border" id="lost">
                        Loading...
                    </ul>
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
                                <th>ID</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Category</th>
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

@push('jslib')
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>

<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
@endpush

@push('js')

<script>
    $(document).ready(function() {
        // if ($("#top-4-scroll").length) {
        $("#top-4-scroll").css({
            height: 315
        }).niceScroll();
        // }
        // if ($("#top-6-scroll").length) {
        $("#top-6-scroll").css({
            height: 450
        }).niceScroll();
        // }
        // scroll()

    })


    var tbltrx = $("#tabletrx").DataTable({
        processing: true,
        serverSide: true,
        rowId: 'id',
        ajax: {
            url: "{{ route('order.lastfive') }}",
            error: function(xhr, error, code) {
                if (xhr.status == 401) {
                    window.location.reload()
                } else {
                    swal(
                        'Failed!',
                        'Server Error',
                        'error'
                    )
                }
            }
        },
        dom: 'lrt',
        scrollY: '255px',
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

    var statistics_chart = document.getElementById("myChart").getContext('2d');

    var myChart = new Chart(statistics_chart, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Total',
                data: [],
                borderWidth: 5,
                borderColor: '#6777ef',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6777ef',
                pointRadius: 4
            }]
        },
        options: {
            legend: {
                display: false
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return "Rp. " + hrg(tooltipItem.value)
                    }
                }
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    // ticks: {
                    //     stepSize: 150
                    // }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    }
                }]
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart',
                onProgress: function(animation) {
                    // 
                },
                onComplete: function(animation) {
                    // 
                }
            }
        }
    });

    $('#line').prop('disabled', true);
    $('#bar').prop('disabled', false);

    $('#line').click(function() {
        $('#line').prop('disabled', true);
        $('#bar').prop('disabled', false);
        myChart.config.type = "line";
        myChart.update();
    })

    $('#bar').click(function() {
        $('#bar').prop('disabled', true);
        $('#line').prop('disabled', false);
        myChart.config.type = "bar";
        myChart.update();
    })

    getData()
    getReport()

    function getReport() {
        myChart.data.datasets[0].data = []
        myChart.data.labels = []
        myChart.update();

        $.get("{{ route('home.report') }}").done(function(response) {
            for (let i = 0; i < response.data.length; i++) {
                myChart.data.datasets[0].data.push(response.data[i].total ?? 0)
                myChart.data.labels.push(response.data[i].date)
                myChart.update();
            }
        }).fail(function(xhr) {
            if (xhr.status == 403) {
                swal(
                    'Failed!',
                    xhr.responseJSON.message,
                    'error'
                )
            } else if (xhr.status == 401) {
                window.location.reload()
            } else {
                swal(
                    'Failed!',
                    'Server Error',
                    'error'
                )
            }
        })
    }

    setInterval(function() {
        getData()
        getReport()
        tbltrx.ajax.reload()
    }, 10000)

    function getData() {
        $.get("{{ route('home.getdata') }}").done(function(response) {
            $('#total_user').text(response.data.total_user)
            $('#total_table').text(response.data.total_table)
            $('#total_menu').text(response.data.total_menu)
            $('#total_order_today').text(response.data.total_order_today)
            $('#total_sales_today').text('Rp.' + hrg(response.data.total_sales_today))
            $('#top').empty()
            $('#lost').empty()
            let top = response.data.top_menu
            let lost = response.data.lost_menu

            for (let i = 0; i < top.length; i++) {
                let text = `<li class="media">
                            <img class="mr-3 rounded" width="55" src="${top[i].img}" alt="product">
                            <div class="media-body">
                                <div class="float-right">
                                    <div class="font-weight-600 text-muted text-small">${top[i].total_sales} Sales</div>
                                </div>
                                <div class="media-title">${top[i].name}</div>
                            </div>
                        </li>`
                $('#top').append(text)
                $("#top-6-scroll").getNiceScroll().resize();
            }
            for (let i = 0; i < lost.length; i++) {
                let text = `<li class="media">
                            <img class="mr-3 rounded" width="55" src="${lost[i].img}" alt="product">
                            <div class="media-body">
                                <div class="float-right">
                                    <div class="font-weight-600 text-muted text-small"><span class="badge badge-danger">${lost[i].stock}</span></div>
                                </div>
                                <div class="media-title">${lost[i].name}</div>
                            </div>
                        </li>`
                $('#lost').append(text)
                $("#top-4-scroll").getNiceScroll().resize();
            }
        }).fail(function(xhr) {
            if (xhr.status == 403) {
                swal(
                    'Failed!',
                    xhr.responseJSON.message,
                    'error'
                )
            } else if (xhr.status == 401) {
                window.location.reload()
            } else {
                swal(
                    'Failed!',
                    'Server Error',
                    'error'
                )
            }
        })
    }
</script>


@endpush