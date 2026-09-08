@extends('layouts.app')
@section('title','Laporan Rekap')
@section('page_title','Laporan Rekap')
@section('content')

<div class="stat-grid">
    <div class="stat-card" style="--accent:var(--green)"><div class="stat-label">Total Sewa</div><div class="stat-value" style="font-size:20px;color:var(--green)">Rp {{ number_format($summary['total_sewa'],0,',','.') }}</div><div class="stat-icon"><i class="ti ti-receipt"></i></div></div>
    <div class="stat-card" style="--accent:#f59e0b"><div class="stat-label">Total Denda</div><div class="stat-value" style="font-size:20px;color:#fbbf24">Rp {{ number_format($summary['total_denda'],0,',','.') }}</div><div class="stat-icon" style="background:rgba(245,158,11,0.12);color:#fbbf24"><i class="ti ti-clock-x"></i></div></div>
    <div class="stat-card" style="--accent:#f87171"><div class="stat-label">Biaya Rusak</div><div class="stat-value" style="font-size:20px;color:#f87171">Rp {{ number_format($summary['total_rusak'],0,',','.') }}</div><div class="stat-icon" style="background:rgba(239,68,68,0.12);color:#f87171"><i class="ti ti-tool"></i></div></div>
    <div class="stat-card" style="--accent:var(--green);background:linear-gradient(135deg,rgba(27,187,135,0.12),rgba(27,187,135,0.04))"><div class="stat-label">Grand Total</div><div class="stat-value" style="font-size:20px;color:var(--green)">Rp {{ number_format($summary['grand_total'],0,',','.') }}</div><div class="stat-icon"><i class="ti ti-coin"></i></div></div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="ti ti-file-analytics"></i> Rekapitulasi Transaksi</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
            <form method="GET" action="{{ route('admin.laporan') }}" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                {{-- Filter perawatan di bawah dibawa ikut supaya tidak ke-reset --}}
                <input type="hidden" name="p_jenis" value="{{ request('p_jenis') }}">
                <input type="hidden" name="p_start" value="{{ request('p_start') }}">
                <input type="hidden" name="p_end"   value="{{ request('p_end') }}">
                <input type="date" name="start" class="form-input" style="margin:0;width:155px" value="{{ request('start') }}">
                <input type="date" name="end"   class="form-input" style="margin:0;width:155px" value="{{ request('end') }}">
                <button class="btn btn-primary btn-sm" type="submit"><i class="ti ti-filter"></i> Filter</button>
                <a href="{{ route('admin.laporan', request()->only(['p_jenis','p_start','p_end'])) }}" class="btn btn-ghost btn-sm"><i class="ti ti-x"></i> Reset</a>
            </form>
            <a href="{{ route('admin.laporan.download', request()->all()) }}" class="btn btn-warning btn-sm"><i class="ti ti-download"></i> CSV</a>
        </div>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>ID / Tgl</th><th>Konsumen</th><th>Motor</th><th>Sewa Pokok</th><th>Denda</th><th>Kerusakan</th><th>Grand Total</th><th>Struk</th></tr></thead>
            <tbody>
                @forelse($laporan as $r)
                <tr>
                    <td><b>{{ $r->nomor_sewa }}</b><br><small style="color:var(--muted)">{{ $r->tanggal_kembali_aktual?->format('d/m/Y') }}</small></td>
                    <td>{{ $r->konsumen->nama_lengkap ?? '-' }}</td>
                    <td>{{ $r->motor->model ?? '-' }}</td>
                    <td>Rp {{ number_format($r->total_harga,0,',','.') }}</td>
                    <td class="{{ $r->denda_waktu > 0 ? 'denda-text' : '' }}">Rp {{ number_format($r->denda_waktu,0,',','.') }}</td>
                    <td class="{{ $r->biaya_kerusakan > 0 ? 'denda-text' : '' }}">
                        Rp {{ number_format($r->biaya_kerusakan,0,',','.') }}
                        @if($r->catatan_kerusakan)<br><small style="color:var(--muted)">{{ $r->catatan_kerusakan }}</small>@endif
                    </td>
                    <td style="font-weight:800;color:var(--green)">Rp {{ number_format($r->grand_total,0,',','.') }}</td>
                    <td><a href="{{ route('admin.pengembalian.struk', $r->id) }}" target="_blank" class="btn btn-ghost btn-sm"><i class="ti ti-printer"></i> Cetak</a></td>
                </tr>
                @empty
                <tr><td colspan="8" class="empty-row">Belum ada data laporan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── REKAP PERAWATAN MOTOR ── --}}
<div class="stat-grid" style="margin-top:22px">
    <div class="stat-card" style="--accent:#60a5fa">
        <div class="stat-label">Catatan Perawatan</div>
        <div class="stat-value" style="font-size:20px;color:#93c5fd">{{ $summaryPerawatan['jumlah'] }}</div>
        <div class="stat-icon" style="background:rgba(59,130,246,0.12);color:#93c5fd"><i class="ti ti-clipboard-list"></i></div>
    </div>
    <div class="stat-card" style="--accent:#94a3b8">
        <div class="stat-label">Unit Ditangani</div>
        <div class="stat-value" style="font-size:20px;color:#cbd5e1">{{ $summaryPerawatan['unit'] }}</div>
        <div class="stat-icon" style="background:rgba(148,163,184,0.12);color:#cbd5e1"><i class="ti ti-motorbike"></i></div>
    </div>
    <div class="stat-card" style="--accent:#f87171">
        <div class="stat-label">Total Biaya Perawatan</div>
        <div class="stat-value" style="font-size:20px;color:#f87171">Rp {{ number_format($summaryPerawatan['total_biaya'],0,',','.') }}</div>
        <div class="stat-icon" style="background:rgba(239,68,68,0.12);color:#f87171"><i class="ti ti-tool"></i></div>
    </div>
</div>

<div class="card" style="margin-top:18px">
    <div class="card-header">
        <div class="card-title"><i class="ti ti-tool"></i> Riwayat Perawatan Motor</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
            <form method="GET" action="{{ route('admin.laporan') }}" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                {{-- Filter transaksi di atas dibawa ikut supaya tidak ke-reset --}}
                <input type="hidden" name="start" value="{{ request('start') }}">
                <input type="hidden" name="end"   value="{{ request('end') }}">
                <select name="p_jenis" class="form-input" style="margin:0;width:150px">
                    <option value="">Semua Jenis</option>
                    <option value="Ganti Oli" {{ request('p_jenis') === 'Ganti Oli' ? 'selected' : '' }}>Ganti Oli</option>
                    <option value="Servis"    {{ request('p_jenis') === 'Servis'    ? 'selected' : '' }}>Servis Rutin</option>
                    <option value="Perbaikan" {{ request('p_jenis') === 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                    <option value="Masalah"   {{ request('p_jenis') === 'Masalah'   ? 'selected' : '' }}>Masalah</option>
                </select>
                <input type="date" name="p_start" class="form-input" style="margin:0;width:155px" value="{{ request('p_start') }}">
                <input type="date" name="p_end"   class="form-input" style="margin:0;width:155px" value="{{ request('p_end') }}">
                <button class="btn btn-primary btn-sm" type="submit"><i class="ti ti-filter"></i> Filter</button>
                <a href="{{ route('admin.laporan', ['start' => request('start'), 'end' => request('end')]) }}" class="btn btn-ghost btn-sm"><i class="ti ti-x"></i> Reset</a>
            </form>
            <a href="{{ route('admin.laporan.download.perawatan', request()->only(['p_start','p_end','p_jenis'])) }}" class="btn btn-warning btn-sm"><i class="ti ti-download"></i> CSV</a>
        </div>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Tanggal &amp; Jam</th><th>Motor</th><th>Jenis</th><th>Kilometer</th><th>Biaya</th><th>Catatan</th><th>Dicatat Oleh</th></tr></thead>
            <tbody>
                @forelse($perawatans as $rw)
                @php
                    $warnaJenis = match($rw->jenis) {
                        'Ganti Oli' => 'bg-available',
                        'Servis'    => 'bg-process',
                        'Perbaikan' => 'bg-warning',
                        default     => 'bg-danger',
                    };
                @endphp
                <tr>
                    <td style="white-space:nowrap"><b>{{ $rw->tanggal?->format('d/m/Y') }}</b><br><small style="color:var(--muted)">{{ $rw->tanggal?->format('H:i') }} WIB</small></td>
                    <td>
                        <b style="font-family:monospace;letter-spacing:0.04em">{{ $rw->motor->plat_nomor ?? '-' }}</b><br>
                        <small style="color:var(--muted)">{{ $rw->motor->model ?? '-' }}{{ $rw->motor?->warna ? ' — '.$rw->motor->warna : '' }}</small>
                    </td>
                    <td><span class="badge {{ $warnaJenis }}">{{ $rw->jenis }}</span></td>
                    <td style="white-space:nowrap">{{ $rw->kilometer ? number_format($rw->kilometer,0,',','.').' km' : '-' }}</td>
                    <td class="{{ $rw->biaya > 0 ? 'denda-text' : '' }}" style="white-space:nowrap">{{ $rw->biaya ? 'Rp '.number_format($rw->biaya,0,',','.') : '-' }}</td>
                    <td style="font-size:12px;color:var(--muted);max-width:280px">{{ $rw->catatan ?: '-' }}</td>
                    <td style="font-size:12px;color:var(--muted);white-space:nowrap">{{ $rw->dicatat_oleh ?: '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="empty-row">Belum ada catatan perawatan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
