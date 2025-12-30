@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center py-5">
                @if($payment->isPaid())
                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                <h3 class="mt-4">Pembayaran Berhasil!</h3>
                <p class="text-muted">Langganan Anda telah diaktifkan.</p>
                @elseif($payment->isPending())
                <i class="bi bi-hourglass-split text-warning" style="font-size: 5rem;"></i>
                <h3 class="mt-4">Menunggu Pembayaran</h3>

                @if($payment->payment_method == 'manual')
                <p class="text-muted">Silakan transfer ke rekening berikut:</p>

                <div class="bg-light rounded p-4 text-start my-4">
                    <p class="mb-2"><strong>Bank:</strong> {{ setting('bank_name', 'BCA') }}</p>
                    <p class="mb-2"><strong>No. Rekening:</strong> {{ setting('bank_account_number', '1234567890') }}
                    </p>
                    <p class="mb-2"><strong>Atas Nama:</strong> {{ setting('bank_account_name', 'Maripos Outlet') }}</p>
                    <hr>
                    <p class="mb-0"><strong>Jumlah:</strong> <span class="text-primary fs-4">{{
                            formatRupiah($payment->amount) }}</span></p>
                </div>

                <p class="text-muted small">Invoice: <code>{{ $payment->invoice_number }}</code></p>
                <p class="text-muted small">Pembayaran akan diverifikasi dalam 1x24 jam setelah transfer.</p>
                @else
                <p class="text-muted">Menunggu konfirmasi dari payment gateway.</p>
                @endif
                @else
                <i class="bi bi-x-circle-fill text-danger" style="font-size: 5rem;"></i>
                <h3 class="mt-4">Pembayaran Gagal</h3>
                <p class="text-muted">{{ $payment->notes ?? 'Silakan coba lagi atau hubungi admin.' }}</p>
                @endif

                <div class="mt-4">
                    <a href="{{ route('owner.subscription.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Status Langganan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection