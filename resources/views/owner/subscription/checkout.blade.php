@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-credit-card me-2"></i>Checkout: {{ $package->name }}
            </div>
            <div class="card-body">
                <div class="bg-light rounded p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">{{ $package->name }}</h5>
                        <span class="badge bg-primary">{{ $package->duration_days }} hari</span>
                    </div>
                    <h3 class="text-primary mb-0">{{ formatRupiah($package->price) }}</h3>
                </div>

                <form action="{{ route('owner.subscription.pay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">

                    <h6 class="mb-3">Pilih Metode Pembayaran</h6>

                    <div class="mb-3">
                        <div class="form-check p-3 border rounded mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" value="manual"
                                id="methodManual" checked>
                            <label class="form-check-label w-100" for="methodManual">
                                <div class="d-flex justify-content-between">
                                    <span><i class="bi bi-bank me-2"></i>Transfer Manual</span>
                                    <span class="text-muted small">Konfirmasi 1x24 jam</span>
                                </div>
                            </label>
                        </div>

                        @foreach($gateways as $gateway)
                        <div class="form-check p-3 border rounded mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" value="payment_gateway"
                                id="gateway{{ $gateway->id }}">
                            <input type="hidden" name="payment_gateway_id" value="{{ $gateway->id }}" disabled>
                            <label class="form-check-label w-100" for="gateway{{ $gateway->id }}">
                                <div class="d-flex justify-content-between">
                                    <span><i class="bi bi-credit-card me-2"></i>{{ $gateway->display_name }}</span>
                                    <span class="text-muted small">Otomatis</span>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-lock me-1"></i>Lanjutkan Pembayaran
                        </button>
                        <a href="{{ route('owner.subscription.packages') }}" class="btn btn-outline-secondary">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('input[name="payment_method"]').on('change', function() {
    $('input[name="payment_gateway_id"]').prop('disabled', true);
    if (this.value === 'payment_gateway') {
        $(this).closest('.form-check').find('input[name="payment_gateway_id"]').prop('disabled', false);
    }
});
</script>
@endpush