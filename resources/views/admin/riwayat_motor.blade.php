@extends('layouts.app')
@section('title','Riwayat Unit: '.$motor->plat_nomor)
@section('page_title','Riwayat Unit Motor')
@section('styles')
<style>
    .rm-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:14px;margin-bottom:18px}
    .rm-card{background:var(--surface);border:1px solid var(--border);border-top:3px solid var(--sc);border-radius:14px;padding:15px 17px}
    .rm-label{font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;font-weight:700}
    .rm-val{font-size:22px;font-weight:800;color:white;margin-top:6px;line-height:1}
    .rm-sub{font-size:10.5px;color:var(--muted);margin-top:5px}
    .plat-besar{font-family:monospace;font-size:15px;font-weight:700;color:white;letter-spacing:0.06em;background:var(--surface2);border:1px solid var(--border);padding:6px 12px;border-radius:8px;display:inline-block}
    .rw-item{background:var(--surface2);border:1px solid var(--border);border-left:3px solid var(--jc);border-radius:10px;padding:12px 14px}
    .rw-jenis{font-size:11px;font-weight:800;color:var(--jc);text-transform:uppercase;letter-spacing:0.06em}
    .rw-meta{font-size:11.5px;color:var(--muted);margin-top:4px;line-height:1.6}
    .rw-catatan{font-size:12.5px;color:var(--text);margin-top:6px;line-height:1.55}
    .tag-selesai{font-size:9px;background:rgba(27,187,135,0.15);color:#1bbb87;padding:2px 7px;border-radius:5px;font-weight:700;letter-spacing:0.04em}
    .tag-aktif{font-size:9px;background:rgba(248,113,113,0.15);color:#f87171;padding:2px 7px;border-radius:5px;font-weight:700;letter-spacing:0.04em}
</style>
@endsection
@section('content')

<a href="{{ route('admin.motor') }}" class="btn btn-ghost" style="margin-bottom:18px">
    <i class="ti ti-arrow-left"></i> Kembali ke Data Motor
</a>

{{-- Identitas unit --}}
<div class="card" style="margin-bottom:18px">
    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
        <div style="width:52px;height:52px;background:var(--green-glow);border:1px solid rgba(27,187,135,0.3);border-radius:14px;display:flex;align-items:center;justify-content:center;color:var(--green);font-size:24px;flex-shrink:0">
            <i class="ti ti-motorbike"></i>
        </div>
        <div>
            <span class="plat-besar">{{ $motor->plat_nomor }}</span>
            <div style="font-size:14px;font-weight:800;color:white;margin-top:7px">{{ $motor->model }}{{ $motor->warna ? ' — '.$motor->warna : '' }}</div>
            <div style="font-size:11.5px;color:var(--muted);margin-top:3px">
                Tarif weekday Rp {{ number_format($motor->tarif_weekday,0,',','.') }} · Tarif weekend Rp {{ number_format($motor->tarif_weekend,0,',','.') }}
            </div>
        </div>
        @php $st = $motor->statusEfektif(); @endphp
        <span class="badge {{ match($st) { 'OFTR' => 'bg-available', 'OTRB' => 'bg-warning', 'ONTR' => 'bg-rented', default => 'bg-maintenance' } }}" style="margin-left:auto;font-size:12px;padding:7px 14px">{{ $st }}</span>
    </div>
</div>

{{-- Ringkasan --}}
<div class="rm-grid">
    <div class="rm-card" style="--sc:#1bbb87">
        <div class="rm-label">Total Disewa</div>
        <div class="rm-val">{{ $ringkas['total_sewa'] }}<span style="font-size:12px;color:var(--muted);font-weight:400"> kali</span></div>
        <div class="rm-sub">Penyewaan yang sudah selesai</div>
    </div>
    <div class="rm-card" style="--sc:#60a5fa">
        <div class="rm-label">Pemasukan</div>
        <div class="rm-val" style="font-size:19px">Rp {{ number_format($ringkas['pemasukan'],0,',','.') }}</div>
        <div class="rm-sub">Dari unit ini</div>
    </div>
    <div class="rm-card" style="--sc:#fbbf24">
        <div class="rm-label">Biaya Perawatan</div>
        <div class="rm-val" style="font-size:19px">Rp {{ number_format($ringkas['biaya_perawatan'],0,',','.') }}</div>
        <div class="rm-sub">Total yang dikeluarkan</div>
    </div>
    <div class="rm-card" style="--sc:{{ $ringkas['masalah_aktif'] > 0 ? '#f87171' : '#94a3b8' }}">
        <div class="rm-label">Masalah Belum Ditangani</div>
        <div class="rm-val" style="color:{{ $ringkas['masalah_aktif'] > 0 ? '#f87171' : 'white' }}">{{ $ringkas['masalah_aktif'] }}</div>
        <div class="rm-sub">Tandai selesai untuk menghilangkan label</div>
    </div>
</div>

{{-- ── BAGIAN ATAS: RIWAYAT PENYEWAAN ── --}}
<div class="card" style="margin-bottom:18px">
    <div class="card-header">
        <div class="card-title"><i class="ti ti-calendar-check"></i> Riwayat Penyewaan</div>
        <span class="badge bg-process">{{ $penyewaans->count() }} transaksi</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Nomor Sewa</th><th>Konsumen</th><th>Mulai Sewa</th><th>Dikembalikan</th><th>Denda</th><th>Kerusakan</th><th>Total</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse($penyewaans as $p)
                <tr>
                    <td><b>{{ $p->nomor_sewa ?? '-' }}</b></td>
                    <td>{{ $p->konsumen->nama_lengkap ?? '-' }}</td>
                    <td style="font-size:12px;color:var(--green)">{{ $p->tanggal_mulai?->format('d/m/Y H:i') }}</td>
                    <td style="font-size:12px;color:#f87171">
                        {{ $p->tanggal_kembali_aktual ? $p->tanggal_kembali_aktual->format('d/m/Y H:i') : $p->tanggal_selesai?->format('d/m/Y H:i').' (target)' }}
                    </td>
                    <td class="{{ $p->denda_waktu > 0 ? 'denda-text' : '' }}">Rp {{ number_format($p->denda_waktu,0,',','.') }}</td>
                    <td class="{{ $p->biaya_kerusakan > 0 ? 'denda-text' : '' }}">Rp {{ number_format($p->biaya_kerusakan,0,',','.') }}</td>
                    <td style="font-weight:800;color:var(--green)">Rp {{ number_format($p->grand_total ?: $p->total_harga,0,',','.') }}</td>
                    <td><span class="badge {{ $p->status === 'Aktif' ? 'bg-rented' : 'bg-secondary' }}">{{ $p->status }}</span></td>
                </tr>
                @empty
                <tr><td colspan="8" class="empty-row">Unit ini belum pernah disewa</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── BAGIAN BAWAH: RIWAYAT PERAWATAN & KENDALA ── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="ti ti-tool"></i> Riwayat Perawatan &amp; Kendala</div>
        <div style="display:flex;gap:8px;align-items:center">
            <span class="badge bg-process">{{ $perawatans->count() }} catatan</span>
            <a href="{{ route('admin.motor') }}" class="btn btn-primary btn-sm"><i class="ti ti-tool"></i> Isi Formulir Perawatan</a>
        </div>
    </div>

    <div style="padding:0 20px 18px">
        {{-- Catatan asal data --}}
        <div style="background:var(--surface2);border:1px solid var(--border);border-radius:10px;padding:12px 14px;margin-bottom:16px;font-size:11.5px;color:var(--muted);line-height:1.6">
            <i class="ti ti-info-circle" style="color:var(--green)"></i>
            Daftar di bawah menghimpun dua sumber, yaitu catatan yang diisi admin lewat <b style="color:var(--text)">formulir perawatan</b> pada menu Data Motor,
            dan kerusakan yang ditemukan saat <b style="color:var(--text)">pengembalian kendaraan</b>.
            Untuk menambah catatan baru, gunakan tombol perawatan (ikon kunci pas) pada menu Data Motor.
        </div>

        {{-- Daftar catatan --}}
        <div style="display:flex;flex-direction:column;gap:9px">
            @forelse($perawatans as $rw)
            @php
                $warnaJenis = match($rw->jenis) {
                    'Ganti Oli' => '#1bbb87',
                    'Servis'    => '#60a5fa',
                    'Perbaikan' => '#fbbf24',
                    default     => '#f87171',
                };
            @endphp
            <div class="rw-item" style="--jc:{{ $warnaJenis }}">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap">
                    <div style="flex:1;min-width:240px">
                        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
                            <span class="rw-jenis">{{ $rw->jenis }}</span>
                            @if($rw->jenis === 'Masalah')
                                <span class="{{ $rw->selesai ? 'tag-selesai' : 'tag-aktif' }}">{{ $rw->selesai ? 'Sudah ditangani' : 'Belum ditangani' }}</span>
                            @endif
                        </div>
                        <div class="rw-meta">
                            {{ $rw->tanggal?->format('d/m/Y H:i') }} WIB
                            @if($rw->kilometer)
                                · {{ number_format($rw->kilometer,0,',','.') }} km
                                @if($rw->selisih_km ?? null)
                                    <span style="color:var(--green)">(+{{ number_format($rw->selisih_km,0,',','.') }} km dari oli sebelumnya)</span>
                                @endif
                            @endif
                            @if($rw->biaya) · <span style="color:#f87171">Rp {{ number_format($rw->biaya,0,',','.') }}</span>@endif
                        </div>
                        @if($rw->catatan)<div class="rw-catatan">{{ $rw->catatan }}</div>@endif
                        @if($rw->dicatat_oleh)<div style="font-size:10.5px;color:var(--muted);margin-top:6px">dicatat oleh {{ $rw->dicatat_oleh }}</div>@endif
                    </div>
                    <div style="display:flex;gap:6px;flex-shrink:0">
                        @if($rw->jenis === 'Masalah')
                        <form method="POST" action="{{ route('admin.motor.perawatan.selesai', $rw->id) }}">
                            @csrf @method('PATCH')
                            <button class="btn {{ $rw->selesai ? 'btn-ghost' : 'btn-primary' }} btn-sm" title="{{ $rw->selesai ? 'Buka kembali sebagai belum ditangani' : 'Tandai sudah ditangani' }}">
                                <i class="ti {{ $rw->selesai ? 'ti-rotate' : 'ti-check' }}"></i> {{ $rw->selesai ? 'Buka Lagi' : 'Tandai Selesai' }}
                            </button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('admin.motor.perawatan.destroy', $rw->id) }}" onsubmit="return confirm('Hapus catatan ini dari riwayat?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" title="Hapus catatan"><i class="ti ti-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <p style="font-size:13px;color:var(--muted);text-align:center;padding:24px 0">Belum ada catatan perawatan untuk unit ini.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
