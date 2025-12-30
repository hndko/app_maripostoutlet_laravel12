@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-receipt me-2"></i>{{ $transaction->invoice_number }}</span>
                <a href="{{ route('pos.receipt', $transaction->id) }}" class="btn btn-sm btn-outline-secondary"
                    target="_blank">
                    <i class="bi bi-printer me-1"></i>Cetak
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">{{ formatRupiah($item->product_price) }}</td>
                                <td class="text-end">{{ formatRupiah($item->subtotal) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                                <td class="text-end">{{ formatRupiah($transaction->subtotal) }}</td>
                            </tr>
                            @if($transaction->discount_amount > 0)
                            <tr>
                                <td colspan="3" class="text-end">Diskon</td>
                                <td class="text-end text-success">- {{ formatRupiah($transaction->discount_amount) }}
                                </td>
                            </tr>
                            @endif
                            @if($transaction->tax_amount > 0)
                            <tr>
                                <td colspan="3" class="text-end">Pajak</td>
                                <td class="text-end">{{ formatRupiah($transaction->tax_amount) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total</strong></td>
                                <td class="text-end"><strong class="fs-5">{{ formatRupiah($transaction->total)
                                        }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end">Bayar</td>
                                <td class="text-end">{{ formatRupiah($transaction->paid_amount) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end">Kembalian</td>
                                <td class="text-end">{{ formatRupiah($transaction->change_amount) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><i class="bi bi-info-circle me-2"></i>Informasi</div>
            <div class="card-body">
                <p class="mb-2"><strong>Outlet:</strong> {{ $transaction->outlet->name }}</p>
                <p class="mb-2"><strong>Kasir:</strong> {{ $transaction->cashier->name }}</p>
                <p class="mb-2"><strong>Tanggal:</strong> {{ $transaction->created_at->format('d M Y, H:i') }}</p>
                <p class="mb-2"><strong>Pembayaran:</strong> {{ $transaction->paymentMethod->name }}</p>
                @if($transaction->customer_name)
                <p class="mb-2"><strong>Pelanggan:</strong> {{ $transaction->customer_name }}</p>
                @endif
                @if($transaction->notes)
                <p class="mb-0"><strong>Catatan:</strong> {{ $transaction->notes }}</p>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('owner.transactions.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
</div>
@endsection