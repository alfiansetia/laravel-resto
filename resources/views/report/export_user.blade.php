<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $title }} &mdash; {{ $comp->name }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ public_path('library/bootstrap/dist/css/bootstrap.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ public_path('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ public_path('assets/css/components.css') }}">
</head>

<body style="background-color: white;">
    <div class="invoice p-1">
        <div class="invoice-print">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-title">
                        <div class="col-12">
                            <table class="table">
                                <tr>
                                    <td class="text-left" style="width: 100px;">
                                        <img id="logo" width="100" height="100" class="media" src="{{ $image }}" alt="Logo">
                                    </td>
                                    <td class="text-left">
                                        <h4>{{ $comp->name }}</h4>
                                        {{ $comp->address }}
                                        <br>{{ $comp->telp }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12">
                            <p class="text-left">
                                <strong>Your Sales Report Summary from {{ $param['from'] }} to {{ $param['to'] }}</strong>
                                <br>
                                <strong>Date : {{ date('Y-m-d H:i:s') }}</strong>
                                <br>
                                <strong>Name : {{ auth()->user()->name }}</strong>
                                <br>
                                <strong>Email : {{ auth()->user()->email }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-md">
                            <tr>
                                <th data-width="40">#</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                            @foreach($data as $key => $d)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $d['date'] }}</td>
                                <td>{{ number_format($d['total'],0,',','.'); }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="text-right" colspan="2"><b>Total</b></td>
                                <td><b>{{ number_format(array_sum(array_column($data, 'total')),0,',','.'); }}</b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- General JS Scripts -->

    <script src="{{ public_path('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ public_path('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ public_path('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="{{ public_path('assets/js/scripts.js') }}"></script>
    <script src="{{ public_path('assets/js/custom.js') }}"></script>

</body>

</html>