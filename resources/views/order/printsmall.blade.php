<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'PT Sans', sans-serif;
        }

        @page {
            size: 2.8in 11in;
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
        }

        table {
            width: 100%;
        }

        tr {
            width: 100%;

        }

        h1 {
            text-align: center;
            vertical-align: middle;
        }

        #logo {
            width: 60%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            padding: 5px;
            margin: 2px;
            display: block;
            margin: 0 auto;
        }

        header {
            width: 100%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            vertical-align: middle;
        }

        .items thead {
            text-align: center;
        }

        .center-align {
            text-align: center;
        }

        .bill-details td {
            font-size: 12px;
        }

        .receipt {
            font-size: medium;
        }

        .items .heading {
            font-size: 12.5px;
            text-transform: uppercase;
            border-top: 1px solid black;
            margin-bottom: 4px;
            border-bottom: 1px solid black;
            vertical-align: middle;
        }

        .items thead tr th:first-child,
        .items tbody tr td:first-child {
            width: 47%;
            min-width: 47%;
            max-width: 47%;
            word-break: break-all;
            text-align: left;
        }

        .items td {
            font-size: 12px;
            text-align: right;
            vertical-align: bottom;
        }

        .price::before {
            content: "Rp ";
            font-family: Arial;
            text-align: right;
        }

        .sum-up {
            text-align: right !important;
        }

        .total {
            font-size: 13px;
            /* border-top: 1px dashed black !important; */
            /* border-bottom: 1px dashed black !important; */
        }

        .total.text,
        .total.price {
            text-align: right;
        }

        .total.price::before {
            content: "Rp ";
        }

        .line {
            border-top: 1px solid black !important;
        }

        .heading.rate {
            width: 20%;
        }

        .heading.amount {
            width: 50%;
        }

        .heading.qty {
            width: 5%
        }

        p {
            padding: 1px;
            margin: 0;
        }

        section,
        footer {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <header>
        <!-- <div id="logo" class="media" data-src="{{ url('images/company/logodefault.svg') }}" src="{{ url('images/company/logodefault.svg') }}"></div> -->
    </header>
    <img id="logo" width="100px" height="100px" class="media" src="{{ url('images/company/logodefault.svg') }}" alt="Logo">
    <p style="text-align: center;">
        <b>
            <span style="font-size: x-large;">{{ $comp->name }}</span>
        </b>
        <br>{{ $comp->address }}
        <br>{{ $comp->telp }}
    </p>
    <table class="bill-details">
        <tbody>
            <tr>
                <td colspan="2">Date : <span>{{ date('d-m-Y H:i:s', strtotime($order->date)) }}</span></td>
                <!-- <td>Time : <span>2</span></td> -->
            </tr>
            <tr>
                <!-- <td>Table : <span>{{ $order->table_id == null ? $order->category : $order->table->number }}</span></td> -->
                <td colspan="2">Cust : {{ $order->name }}<span>4</span></td>
            </tr>
            <!-- <tr>
                <th class="center-align" colspan="2"><span class="receipt">Original Receipt</span></th>
            </tr> -->
        </tbody>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th class="heading name">Table</th>
                <th class="heading amount">#{{ $order->table_id == null ? $order->category : $order->table->number }}</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total = 0;
            $subtotal = 0;
            $disc = 0;
            @endphp
            @foreach($order->dtorder as $ord)
            @php
            $total = $total + $ord->qty * $ord->price - ($ord->qty * $ord->price * $ord->disc / 100);
            $subtotal = $subtotal + $ord->qty * $ord->price;
            $disc = $disc + ($ord->qty * $ord->price * $ord->disc / 100);
            @endphp
            <tr>
                <td colspan="2"><b>{{ $ord->menu->name }}</b></td>
            </tr>
            <tr>
                <td>{{ $ord->qty }} X {{ number_format($ord->price,0,',','.') }}</td>
                <td class="price">{{ number_format($ord->qty*$ord->price,0,',','.') }}</td>
            </tr>
            @if($ord->disc > 0)
            <td></td>
            <td>
                -{{ number_format($ord->price*$ord->disc/100,0,',','.') }}
            </td>
            @endif
            @endforeach
            <tr>
                <td class="sum-up line">Subtotal</td>
                <td class="line">{{ number_format($subtotal,0,',','.') }}</td>
            </tr>
            @if($disc > 0)
            <tr>
                <td class="sum-up">Disc</td>
                <td class="">-{{ number_format($disc,0,',','.') }}</td>
            </tr>
            @endif
            <tr>
                <th class="total text">Total</th>
                <th class="total price">{{ number_format($total,0,',','.') }}</th>
            </tr>
            <tr>
                <td class="sum-up">Bill</td>
                <td class="">{{ number_format($order->bill,0,',','.') }}</td>
            </tr>
            <tr>
                <td class="sum-up" style="border-bottom: 1px solid black !important;">Return</td>
                <td class="" style="border-bottom: 1px solid black !important;">{{ number_format($order->bill-$total,0,',','.') }}</td>
            </tr>
        </tbody>
    </table>
    <section>
        <p>
            Cashier : <span>{{ $user->name }}</span>
        </p>
        <p style="align-items: center;">
            <center>
                <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($order->number, 'QRCODE', 5,5) }}" alt="barcode" />
                <!-- <div style="align-items: center;">{!! DNS2D::getBarcodeHTML($order->number, 'QRCODE') !!}</div> -->
                <br>{{ $order->number }}
            </center>
        </p>
        <br>
        <p style="text-align:center">
            Thank you for your visit!
        </p>
        <p style="text-align: center;">www.kacangan.net</p>
        <br>
        <br>_

    </section>
    <footer style="text-align:center">
        <!-- <p>Technology Partner Dotworld Technologies</p> -->
        <div style="break-after:page"></div>
    </footer>
</body>

<script>
    window.print();
</script>

</html>