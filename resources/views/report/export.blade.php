<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $title }} &mdash; {{ $comp->name }}</title>
    <link rel="icon" type="image/x-icon" href="{{ url('images/company/') }}/{{ $comp->fav == '' ? 'favicondefault.ico' : $comp->fav }}" />

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
</head>

<body>
    <div class="invoice">
        <div class="invoice-print">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-title">
                        <div class="col-12">
                            <table class="table">
                                <tr>
                                    <td class="text-left" style="width: 100px;">
                                        <img id="logo" width="100" height="100" class="media" src="{{ asset('images/company/logo.svg') }}" alt="Logo">
                                    </td>
                                    <td class="text-left">
                                        <h4>{{ $comp->name }}</h4>
                                        {{ $comp->address }}
                                        <br>{{ $comp->telp }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-left">
                                <strong>Sales Report Summary from {{ $param['from'] }} to {{ $param['to'] }}</strong><br>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-right">
                                <strong>Date : {{ date('Y-m-d H:i:s') }}</strong><br>
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
                                <th class="text-center">Amount</th>
                            </tr>

                            @foreach($data as $key => $d)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $d['date'] }}</td>
                                <td>{{ $d['total'] }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="text-right" colspan="2"><b>Total</b></td>
                                <td><b>{{ array_sum(array_column($data, 'total')) }}</b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- General JS Scripts -->

    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    

    <script>
        window.print()
    </script>

</body>

</html>