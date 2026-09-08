@extends('layouts.app')
@section('title','Dashboard')
@section('page_title','Dashboard')
@section('styles')
<style>
    .status-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:16px;margin-bottom:18px}
    .status-card{background:var(--surface);border:1px solid var(--border);border-top:3px solid var(--sc);border-radius:16px;padding:18px 20px;position:relative;overflow:hidden}
    .status-code{font-size:26px;font-weight:800;color:var(--sc);letter-spacing:0.02em;line-height:1}
    .status-name{font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;font-weight:700;margin-top:5px}
    .status-count{font-size:40px;font-weight:800;color:white;line-height:1;margin:12px 0 2px}
    .status-desc{font-size:11px;color:var(--muted);line-height:1.5}
    .status-icon{position:absolute;top:16px;right:18px;width:38px;height:38px;border-radius:11px;background:var(--sc-bg);color:var(--sc);display:flex;align-items:center;justify-content:center;font-size:19px}
    .status-list{margin-top:12px;padding-top:10px;border-top:1px solid var(--border);max-height:110px;overflow-y:auto;display:flex;flex-direction:column;gap:4px}
    .status-list-item{font-size:11.5px;color:var(--muted);display:flex;gap:6px;align-items:baseline}
    .status-list-item b{color:var(--text);font-family:monospace;font-size:11px;flex-shrink:0}
    .status-empty{font-size:11px;color:var(--muted);opacity:0.6;padding:4px 0}
</style>
@endsection
@section('content')

<div class="status-grid">
    <div class="status-card" style="--sc:#1bbb87;--sc-bg:rgba(27,187,135,0.12)">
        <div class="status-icon"><i class="ti ti-circle-check"></i></div>
        <div class="status-code">OFTR</div>
        <div class="status-name">Off The Road</div>
        <div class="status-count">{{ count($rekapStatus['OFTR']) }}</div>
        <div class="status-desc">Ada di tempat sewa, belum ada yang booking</div>
        <div class="status-list">
            @forelse($rekapStatus['OFTR'] as $m)
                <div class="status-list-item"><b>{{ $m->plat_nomor }}</b> {{ $m->model }}</div>
            @empty
                <div class="status-empty">Tidak ada unit</div>
            @endforelse
        </div>
    </div>

    <div class="status-card" style="--sc:#fbbf24;--sc-bg:rgba(251,191,36,0.12)">
        <div class="status-icon"><i class="ti ti-lock-clock"></i></div>
        <div class="status-code">OTRB</div>
        <div class="status-name">Off The Road Booking</div>
        <div class="status-count">{{ count($rekapStatus['OTRB']) }}</div>
        <div class="status-desc">Sudah dibooking &amp; masuk hari sewa, belum diambil</div>
        <div class="status-list">
            @forelse($rekapStatus['OTRB'] as $m)
                <div class="status-list-item"><b>{{ $m->plat_nomor }}</b> {{ $m->model }}</div>
            @empty
                <div class="status-empty">Tidak ada unit</div>
            @endforelse
        </div>
    </div>

    <div class="status-card" style="--sc:#f87171;--sc-bg:rgba(248,113,113,0.12)">
        <div class="status-icon"><i class="ti ti-key"></i></div>
        <div class="status-code">ONTR</div>
        <div class="status-name">On The Road</div>
        <div class="status-count">{{ count($rekapStatus['ONTR']) }}</div>
        <div class="status-desc">Sedang dipakai konsumen di luar</div>
        <div class="status-list">
            @forelse($rekapStatus['ONTR'] as $m)
                <div class="status-list-item"><b>{{ $m->plat_nomor }}</b> {{ $m->model }}</div>
            @empty
                <div class="status-empty">Tidak ada unit</div>
            @endforelse
        </div>
    </div>

    <div class="status-card" style="--sc:#94a3b8;--sc-bg:rgba(148,163,184,0.12)">
        <div class="status-icon"><i class="ti ti-tool"></i></div>
        <div class="status-code">PERAWATAN</div>
        <div class="status-name">Maintenance</div>
        <div class="status-count">{{ count($rekapStatus['Perawatan']) }}</div>
        <div class="status-desc">Lagi diperbaiki, tidak bisa disewakan</div>
        <div class="status-list">
            @forelse($rekapStatus['Perawatan'] as $m)
                <div class="status-list-item"><b>{{ $m->plat_nomor }}</b> {{ $m->model }}</div>
            @empty
                <div class="status-empty">Tidak ada unit</div>
            @endforelse
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="ti ti-trending-up"></i> Omset Bulan Ini</div>
        <span class="badge bg-available">{{ $txCount }} transaksi selesai</span>
    </div>
    <div style="padding:22px 20px">
        <div style="font-size:32px;font-weight:800;color:var(--green);line-height:1">Rp {{ number_format($omset,0,',','.') }}</div>
        <div style="font-size:12px;color:var(--muted);margin-top:6px">Dihitung dari penyewaan yang sudah selesai diproses bulan {{ now()->translatedFormat('F Y') }}</div>
    </div>
</div>
@endsection
