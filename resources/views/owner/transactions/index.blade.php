@extends('layouts.backend')

@section('title', $title)

@section('sidebar')
@include('partials.sidebar-owner')
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-receipt me-2"></i>Riwayat Transaksi</span>
    </div>
    <div class="card-body">
        {{-- Filters --}}
        <form class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Outlet</label>
                <select class="form-select" name="outlet_id">
                    <option value="">Semua Outlet</option>
                    @foreach($outlets as $outlet)
                    <option value="{{ $outlet->id }}" {{ request('outlet_id')==$outlet->id ? 'selected' : '' }}>
                        {{ $outlet->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover" id="transactionsTable">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Outlet</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $trx)
                    <tr>
                        <td><code>{{ $trx->invoice_number }}</code></td>
                        <td>{{ $trx->outlet->name }}</td>
                        <td>{{ $trx->cashier->name }}</td>
                        <td>{{ formatRupiah($trx->total) }}</td>
                        <td>
                            <span class="badge bg-{{ $trx->payment_status == 'paid' ? 'success' : 'warning' }}">
                                {{ $trx->paymentMethod->name }}
                            </span>
                        </td>
                        <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('owner.transactions.show', $trx->id) }}"
                                class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('pos.receipt', $trx->id) }}" class="btn btn-sm btn-outline-secondary"
                                target="_blank">
                                <i class="bi bi-printer"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $transactions->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    $('#transactionsTable').DataTable({
        paging: false,
        info: false,
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' }
    });
});
</script>
@endpush