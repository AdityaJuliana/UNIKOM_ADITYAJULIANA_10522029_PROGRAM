@extends('layouts.app')
@section('title','KTP: '.$konsumen->nama_lengkap)
@section('page_title','Detail KTP Konsumen')
@section('content')

<div style="max-width:540px;margin:0 auto">
    <a href="{{ route('admin.konsumen') }}" class="btn btn-ghost" style="margin-bottom:18px">
        <i class="ti ti-arrow-left"></i> Kembali ke Data Konsumen
    </a>

    <div class="card">
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px">
            <div style="width:48px;height:48px;background:var(--green-glow);border:1px solid rgba(27,187,135,0.3);border-radius:14px;display:flex;align-items:center;justify-content:center;color:var(--green);font-size:22px;flex-shrink:0">
                <i class="ti ti-id"></i>
            </div>
            <div>
                <div style="font-size:17px;font-weight:800;color:white">{{ $konsumen->nama_lengkap }}</div>
                {{-- Hanya tampilkan nomor HP saja --}}
                <div style="font-size:12px;color:var(--muted)">{{ $konsumen->no_whatsapp }}</div>
            </div>
            <span class="badge {{ $konsumen->is_validated ? 'bg-available' : 'bg-danger' }}" style="margin-left:auto">
                {{ $konsumen->is_validated ? '✓ Valid' : '✗ Belum Valid' }}
            </span>
        </div>

        <div style="background:var(--bg2);border-radius:12px;padding:14px;margin-bottom:16px;display:grid;grid-template-columns:1fr 1fr;gap:10px">
            <div>
                <div style="font-size:10px;font-weight:700;color:var(--muted);margin-bottom:4px">NIK</div>
                <div style="font-family:monospace;font-size:14px;font-weight:700">{{ $konsumen->nik }}</div>
            </div>
            <div>
                <div style="font-size:10px;font-weight:700;color:var(--muted);margin-bottom:4px">WHATSAPP</div>
                <div style="font-size:14px;font-weight:700">{{ $konsumen->no_whatsapp }}</div>
            </div>
        </div>

        @if($konsumen->foto_ktp)
            <img src="{{ $konsumen->foto_ktp }}"
                 style="width:100%;border-radius:12px;margin-bottom:14px"
                 alt="Foto KTP {{ $konsumen->nama_lengkap }}">
            <a href="{{ $konsumen->foto_ktp }}"
               download="KTP_{{ $konsumen->nama_lengkap }}.jpg"
               class="btn btn-primary"
               style="width:100%;justify-content:center">
                <i class="ti ti-download"></i> Download Foto KTP
            </a>
        @else
            <div style="height:160px;background:var(--bg2);border:2px dashed var(--border);border-radius:12px;display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--muted);gap:8px">
                <i class="ti ti-id-off" style="font-size:32px"></i>
                <span style="font-size:13px">Foto KTP belum diunggah</span>
            </div>
        @endif
    </div>
</div>
@endsection
