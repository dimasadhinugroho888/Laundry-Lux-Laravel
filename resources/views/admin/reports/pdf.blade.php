<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; background: #fff; }

        .header { background: linear-gradient(135deg, #4f46e5, #6366f1); color: white; padding: 20px 28px; margin-bottom: 20px; border-radius: 0 0 12px 12px; }
        .header h1 { font-size: 22px; font-weight: 800; letter-spacing: -0.5px; }
        .header p  { font-size: 11px; opacity: 0.8; margin-top: 4px; }
        .header .meta { font-size: 10px; opacity: 0.7; margin-top: 8px; }

        .summary { display: flex; gap: 12px; margin: 0 28px 20px; }
        .summary-box { flex: 1; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 16px; background: #f8fafc; }
        .summary-box .label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #94a3b8; }
        .summary-box .value { font-size: 18px; font-weight: 800; color: #1e293b; margin-top: 4px; }

        table { width: calc(100% - 56px); margin: 0 28px; border-collapse: collapse; }
        thead tr { background: #4f46e5; color: white; }
        thead th { padding: 10px 12px; text-align: left; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr:nth-child(odd)  { background: #ffffff; }
        tbody td { padding: 9px 12px; border-bottom: 1px solid #f1f5f9; font-size: 10px; }
        .status-proses  { color: #d97706; font-weight: 700; }
        .status-selesai { color: #059669; font-weight: 700; }
        .status-diambil { color: #64748b; font-weight: 700; }
        tfoot tr { background: #eef2ff; }
        tfoot td { padding: 10px 12px; font-weight: 800; color: #4338ca; font-size: 11px; }

        .footer { margin: 20px 28px 0; padding-top: 12px; border-top: 1px solid #e2e8f0; font-size: 9px; color: #94a3b8; display: flex; justify-content: space-between; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LaundryLux — Laporan Penjualan</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        <p class="meta">Digenerate: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

    <div class="summary">
        <div class="summary-box">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $transactions->count() }}</div>
        </div>
        <div class="summary-box">
            <div class="label">Total Pendapatan</div>
            <div class="value" style="font-size:14px;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="summary-box">
            <div class="label">Status Selesai</div>
            <div class="value">{{ $transactions->where('status', 'selesai')->count() }}</div>
        </div>
        <div class="summary-box">
            <div class="label">Status Proses</div>
            <div class="value">{{ $transactions->where('status', 'proses')->count() }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>No. HP</th>
                <th>Paket</th>
                <th>Item</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $i => $t)
                @php
                    $totalHarga = $t->packages->sum(fn($p) => $p->pivot->total);
                    $totalItem  = $t->packages->sum(fn($p) => $p->pivot->qty);
                    $rincian    = $t->packages->map(fn($p) => $p->name.' x'.$p->pivot->qty)->implode(', ');
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $t->created_at->format('d/m/Y') }}</td>
                    <td><strong>{{ $t->customer->name }}</strong></td>
                    <td>{{ $t->customer->phone }}</td>
                    <td>{{ $rincian }}</td>
                    <td style="text-align:center;">{{ $totalItem }}</td>
                    <td><strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
                    <td class="status-{{ $t->status }}">{{ ucfirst($t->status) }}</td>
                </tr>
            @endforeach
        </tbody>
        @if ($transactions->count() > 0)
        <tfoot>
            <tr>
                <td colspan="6" style="text-align:right;">TOTAL PENDAPATAN:</td>
                <td>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        <span>LaundryLux Smart Laundry System &copy; {{ date('Y') }}</span>
        <span>Made by Dimas Adhi Nugroho</span>
    </div>
</body>
</html>
