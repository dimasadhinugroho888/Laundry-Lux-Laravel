<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bill Transaksi</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h3, h4 {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .no-border {
            border: none;
        }
    </style>
</head>
<body>

<h3>BILL LAUNDRY</h3>
<hr>

<table class="no-border">
    <tr class="no-border">
        <td class="no-border"><strong>Customer</strong></td>
        <td class="no-border">: {{ $transaction->customer->name }}</td>
    </tr>
    <tr class="no-border">
        <td class="no-border"><strong>Status</strong></td>
        <td class="no-border">: {{ ucfirst($transaction->status) }}</td>
    </tr>
    <tr class="no-border">
        <td class="no-border"><strong>Tanggal</strong></td>
        <td class="no-border">: {{ $transaction->created_at->format('d-m-Y') }}</td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Paket</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @php $grandTotal = 0; @endphp
        @foreach ($transaction->packages as $p)
            @php
                $subtotal = $p->pivot->total;
                $grandTotal += $subtotal;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->name }}</td>
                <td>Rp {{ number_format($p->price) }}</td>
                <td>{{ $p->pivot->qty }}</td>
                <td>Rp {{ number_format($subtotal) }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="4" class="text-right">TOTAL</th>
            <th>Rp {{ number_format($grandTotal) }}</th>
        </tr>
    </tbody>
</table>

<br>
<p><strong>Terima kasih 🙏</strong></p>

</body>
</html>
