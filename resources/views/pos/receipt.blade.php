<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #fff;
            padding: 20px;
            max-width: 80mm;
            margin: 0 auto;
        }

        .receipt {
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #000;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11px;
            color: #666;
        }

        .info {
            margin-bottom: 15px;
            font-size: 11px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .items {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 15px 0;
            margin-bottom: 15px;
        }

        .item {
            margin-bottom: 10px;
        }

        .item-name {
            font-weight: 600;
        }

        .item-details {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #666;
        }

        .totals {
            margin-bottom: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .total-row.grand {
            font-size: 16px;
            font-weight: 700;
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 1px dashed #000;
            padding-top: 15px;
        }

        .qr {
            text-align: center;
            margin: 15px 0;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="header">
            <h1>{{ $transaction->outlet->name }}</h1>
            <p>{{ $transaction->outlet->address }}</p>
            @if($transaction->outlet->phone)
            <p>Tel: {{ $transaction->outlet->phone }}</p>
            @endif
        </div>

        <div class="info">
            <div class="info-row">
                <span>No. Invoice</span>
                <span>{{ $transaction->invoice_number }}</span>
            </div>
            <div class="info-row">
                <span>Tanggal</span>
                <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span>Kasir</span>
                <span>{{ $transaction->cashier->name }}</span>
            </div>
            @if($transaction->customer_name)
            <div class="info-row">
                <span>Pelanggan</span>
                <span>{{ $transaction->customer_name }}</span>
            </div>
            @endif
        </div>

        <div class="items">
            @foreach($transaction->items as $item)
            <div class="item">
                <div class="item-name">{{ $item->product_name }}</div>
                <div class="item-details">
                    <span>{{ $item->quantity }} x {{ number_format($item->product_price, 0, ',', '.') }}</span>
                    <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="totals">
            <div class="total-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($transaction->discount_amount > 0)
            <div class="total-row">
                <span>Diskon</span>
                <span>- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            @if($transaction->tax_amount > 0)
            <div class="total-row">
                <span>Pajak</span>
                <span>Rp {{ number_format($transaction->tax_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="total-row grand">
                <span>TOTAL</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Bayar ({{ $transaction->paymentMethod->name }})</span>
                <span>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>{{ setting('website_name', 'Maripos Outlet') }}</p>
        </div>
    </div>

    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer me-1"></i>Cetak Struk
        </button>
        <a href="{{ route('pos.outlet', $transaction->outlet_id) }}" class="btn btn-secondary">
            Transaksi Baru
        </a>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>

</html>