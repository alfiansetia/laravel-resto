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
    </header>
    <center>
        <img id="logo" width="100px" height="100px" class="media" src="data:image/png;base64,{{ $image }}" alt="Logo">
    </center>
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
            </tr>
            <tr>
                <td colspan="2">Cust : {{ $order->name }}</td>
            </tr>
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
                <td colspan="2">@if($ord->menu->catmenu_id != null)[{{ $ord->menu->catmenu->name ?? '' }}]@endif <b>{{ $ord->menu->name }}</b></td>
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
        <br>
        <p style="align-items: center;">
            <center>
                <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($order->number, 'QRCODE', 5,5) }}" alt="barcode" />
                <br>{{ $order->number }}
            </center>
        </p>
        <br>
        <p style="text-align:center">
            {{ $comp->footer_struk }}
        </p>
        <p style="text-align: center;">www.kacangan.net</p>
        <br>_

    </section>
    <footer style="text-align:center">
        <div style="break-after:page"></div>
    </footer>
</body>

<script>
    window.print();
</script>

</html>