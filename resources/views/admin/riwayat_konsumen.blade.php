@extends('layouts.app')
@section('title','Riwayat: '.$konsumen->nama_lengkap)
@section('page_title','Riwayat Transaksi Konsumen')
@section('content')

<a href="{{ route('admin.konsumen') }}" class="btn btn-ghost" style="margin-bottom:18px">
    <i class="ti ti-arrow-left"></i> Kembali ke Data Konsumen
</a>

{{-- Info Konsumen --}}
<div class="card" style="margin-bottom:18px">
    <div style="display:flex;align-items:center;gap:14px">
        <div style="width:48px;height:48px;background:var(--green-glow);border:1px solid rgba(27,187,135,0.3);border-radius:14px;display:flex;align-items:center;justify-content:center;color:var(--green);font-size:22px;flex-shrink:0">
            <i class="ti ti-user"></i>
        </div>
        <div>
            <div style="font-size:17px;font-weight:800;color:white">{{ $konsumen->nama_lengkap }}</div>
            <div style="font-size:12px;color:var(--muted)">{{ $konsumen->no_whatsapp }} &nbsp;·&nbsp; NIK: {{ $konsumen->nik }}</div>
        </div>
        <span class="badge {{ $konsumen->is_validated ? 'bg-available' : 'bg-danger' }}" style="margin-left:auto">
            {{ $konsumen->is_validated ? '✓ Tervalidasi' : '✗ Belum Valid' }}
        </span>
    </div>
</div>

{{-- Riwayat Penyewaan (gabungan booking + penyewaan + perpanjangan) --}}
<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="ti ti-motorbike"></i> Riwayat Penyewaan</div>
        <span class="badge bg-process">{{ $rentals->count() }} Transaksi</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nomor Sewa</th><th>Motor</th><th>Mulai</th><th>Selesai</th>
                    <th>Total</th><th>DP</th><th>Denda</th><th>Grand Total</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rentals as $r)
                <tr>
                    <td><b>{{ $r->nomor_sewa ?? '(belum dikonfirmasi)' }}</b></td>
                    <td>{{ $r->motor->model ?? '-' }}</td>
                    <td style="font-size:12px">{{ $r->tanggal_mulai?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td style="font-size:12px">{{ $r->tanggal_selesai?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>Rp {{ number_format($r->total_harga,0,',','.') }}</td>
                    <td style="color:var(--green);font-weight:700">Rp {{ number_format($r->dp_dibayar,0,',','.') }}</td>
                    <td class="{{ $r->denda_waktu > 0 ? 'denda-text' : '' }}">Rp {{ number_format($r->denda_waktu,0,',','.') }}</td>
                    <td style="font-weight:800;color:var(--green)">Rp {{ number_format($r->grand_total,0,',','.') }}</td>
                    <td>
                        <span class="badge {{ match($r->status) { 'Aktif' => 'bg-available', 'Pending' => 'bg-warning', 'Ditolak' => 'bg-danger', default => 'bg-secondary' } }}">
                            {{ $r->status }}
                        </span>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.penyewaan.destroy', $r->id) }}"
                              onsubmit="return confirm('Hapus riwayat penyewaan ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="ti ti-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" class="empty-row">Belum ada riwayat penyewaan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
