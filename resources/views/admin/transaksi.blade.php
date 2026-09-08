@extends('layouts.app')
@section('title','Penyewaan')
@section('page_title','Penyewaan')
@section('styles')
<style>
    .f-chips{display:flex;gap:9px;flex-wrap:wrap;margin-bottom:14px}
    .f-chip{display:flex;align-items:center;gap:8px;background:var(--surface2);border:1px solid var(--border);border-radius:11px;padding:9px 15px;text-decoration:none;color:var(--text);font-size:12.5px;font-weight:700;transition:0.15s}
    .f-chip:hover{border-color:var(--green)}
    .f-chip.aktif{background:var(--green-glow);border-color:var(--green);color:var(--green)}
    .f-chip .n{background:rgba(255,255,255,0.08);border-radius:20px;padding:1px 9px;font-size:11px;font-weight:800}
    .f-chip.aktif .n{background:var(--green);color:#0b1420}
    .f-bar{display:flex;gap:9px;align-items:center;flex-wrap:wrap}
    .f-bar .form-input{margin:0;height:38px}
</style>
@endsection

@section('content')



<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="ti ti-calendar-check"></i> Penyewaan</div>
        <span class="badge bg-process">
            @if($items->count() === $jumlah['semua'])
                {{ $items->count() }} butuh aksi
            @else
                {{ $items->count() }} dari {{ $jumlah['semua'] }} ditampilkan
            @endif
        </span>
    </div>

    {{-- ── Penyaringan ── --}}
    <div style="padding:0 20px 16px">
        <div class="f-chips">
            @php
                $pilihan = [
                    'semua'        => ['Semua',           'ti-list'],
                    'booking'      => ['Pemesanan Baru',  'ti-shopping-cart'],
                    'serahkan'     => ['Serah Terima',    'ti-key'],
                    'perpanjangan' => ['Perpanjangan',    'ti-calendar-plus'],
                ];
            @endphp
            @foreach($pilihan as $kode => $info)
                <a href="{{ route('admin.transaksi', array_filter(['tipe' => $kode, 'jenis' => $jenis, 'cari' => $cari])) }}"
                   class="f-chip {{ $tipe === $kode ? 'aktif' : '' }}">
                    <i class="ti {{ $info[1] }}"></i> {{ $info[0] }}
                    <span class="n">{{ $jumlah[$kode] }}</span>
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('admin.transaksi') }}" class="f-bar">
            <input type="hidden" name="tipe" value="{{ $tipe }}">
            <input type="text" name="cari" class="form-input" style="width:280px"
                   placeholder="Cari nomor sewa, konsumen, atau plat nomor"
                   value="{{ $cari }}">
            <select name="jenis" class="form-input" style="width:210px">
                <option value="">Semua Jenis Motor</option>
                @foreach($daftarJenis as $j)
                    <option value="{{ $j }}" {{ $jenis === $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary btn-sm" type="submit"><i class="ti ti-filter"></i> Filter</button>
            @if($cari !== '' || $jenis !== '' || $tipe !== 'semua')
                <a href="{{ route('admin.transaksi') }}" class="btn btn-ghost btn-sm"><i class="ti ti-x"></i> Reset</a>
            @endif
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nomor Sewa</th><th>Konsumen</th><th>Jenis Motor</th>
                    <th>Jadwal Antar</th><th>Jadwal Kembali</th><th>DP / Sisa</th>
                    <th>Bukti</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td><b>{{ $item->nomor_sewa ?? '(belum ada)' }}</b></td>
                    <td>{{ $item->konsumen->nama_lengkap ?? '-' }}</td>
                    <td>{{ $item->motor->model ?? '-' }}</td>
                    <td>
                        <div style="font-size:12px">
                            <b style="color:var(--green)">{{ $item->tanggal_mulai?->format('d/m/Y H:i') }}</b><br>
                            <span style="color:var(--muted)">{{ $item->metode_pengantaran }}</span>
                            @if($item->alamat_pengantaran)<br><small style="color:#f87171">{{ $item->alamat_pengantaran }}</small>@endif
                        </div>
                    </td>
                    <td>
                        <div style="font-size:12px">
                            @if($item->tipe === 'perpanjangan')
                                <b style="color:#fbbf24">{{ $item->deadline_baru?->format('d/m/Y H:i') }}</b><br>
                                <span style="color:#fbbf24">+{{ $item->perpanjangan_hari }} hari diminta</span><br>
                            @else
                                <b style="color:#f87171">{{ $item->tanggal_selesai?->format('d/m/Y H:i') }}</b><br>
                            @endif
                            <span style="color:var(--muted)">{{ $item->metode_pengembalian }}</span>
                            @if($item->alamat_pengembalian)<br><small style="color:#f87171">{{ $item->alamat_pengembalian }}</small>@endif
                        </div>
                    </td>
                    <td>
                        @php $sisa = max(0, $item->total_harga - $item->dp_dibayar); @endphp
                        <div style="font-size:12.5px;line-height:1.75;white-space:nowrap">
                            <div>DP: <b style="color:var(--green)">Rp {{ number_format($item->dp_dibayar,0,',','.') }}</b></div>
                            <div>Sisa: <b style="color:#fbbf24">Rp {{ number_format($sisa,0,',','.') }}</b></div>
                            <div style="margin-top:5px;padding-top:5px;border-top:1px solid var(--border)">Total: <b style="color:white">Rp {{ number_format($item->total_harga,0,',','.') }}</b></div>
                        </div>
                    </td>
                    <td>
                        @if($item->bukti_transfer)
                            <button type="button" class="btn btn-ghost btn-sm" onclick="openModal('bukti-{{ $item->id }}')"><i class="ti ti-eye"></i> Lihat</button>
                        @else
                            <span style="color:var(--muted);font-size:12px">-</span>
                        @endif
                    </td>
                    <td>
                        @php
                            // Untuk baris yang menunggu serah terima, tampilkan status motor
                            // yang sebenarnya supaya sama persis dengan Data Motor dan Dashboard.
                            $stMotor = $item->tipe === 'serahkan' && $item->motor
                                       ? $item->motor->statusEfektif() : null;
                        @endphp
                        <span class="badge {{ match(true) {
                            $item->tipe === 'booking'      => 'bg-warning',
                            $item->tipe === 'perpanjangan' => 'bg-process',
                            $stMotor === 'OTRB'            => 'bg-warning',
                            $stMotor === 'ONTR'            => 'bg-rented',
                            $stMotor === 'OFTR'            => 'bg-available',
                            default                        => 'bg-secondary',
                        } }}">
                            {{ match(true) {
                                $item->tipe === 'booking'      => 'Pending',
                                $item->tipe === 'perpanjangan' => 'Perpanjangan',
                                $stMotor !== null              => $stMotor,
                                default                        => $item->status,
                            } }}
                        </span>
                        @if($stMotor === 'OFTR')
                            <div style="font-size:10px;color:var(--muted);margin-top:4px">Belum masuk hari sewa</div>
                        @endif
                    </td>
                    <td>
                        @if($item->tipe === 'booking')
                            <div style="display:flex;flex-direction:column;gap:5px">
                                <button type="button" class="btn btn-primary btn-sm" style="width:100%;justify-content:center" onclick="openModal('konfirmasi-{{ $item->id }}')"><i class="ti ti-check"></i> Terima</button>
                                <form method="POST" action="{{ route('admin.booking.tolak', $item->id) }}" onsubmit="return confirm('Tolak booking ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" style="width:100%;justify-content:center"><i class="ti ti-x"></i> Tolak</button>
                                </form>
                            </div>
                        @elseif($item->tipe === 'serahkan')
                            <form method="POST" action="{{ route('admin.booking.serahkan', $item->id) }}" onsubmit="return confirm('Pastikan motor sudah diserahkan kepada konsumen. Lanjutkan?')">
                                @csrf @method('PATCH')
                                <button class="btn btn-primary btn-sm" style="width:100%;justify-content:center"><i class="ti ti-key"></i> Serahkan Motor</button>
                            </form>
                        @elseif($item->tipe === 'perpanjangan')
                            <div style="display:flex;flex-direction:column;gap:5px">
                                <button type="button" class="btn btn-primary btn-sm" style="width:100%;justify-content:center" onclick="openModal('izinkan-{{ $item->id }}')"><i class="ti ti-check"></i> Izinkan</button>
                                <form method="POST" action="{{ route('admin.perpanjangan.tolak', $item->id) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-danger btn-sm" style="width:100%;justify-content:center"><i class="ti ti-x"></i> Tolak</button>
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>

                {{-- Modal Bukti Transfer --}}
                @if($item->bukti_transfer)
                <div class="modal-bg" id="bukti-{{ $item->id }}">
                    <div class="modal-box" style="max-width:420px">
                        <div class="modal-title">Bukti Transfer</div>
                        <img src="{{ $item->bukti_transfer }}" style="width:100%;border-radius:10px;margin-bottom:14px">
                        <button class="btn btn-ghost" type="button" style="width:100%;justify-content:center" onclick="closeModal('bukti-{{ $item->id }}')">Tutup</button>
                    </div>
                </div>
                @endif

                {{-- Modal Konfirmasi Booking + Pilih Unit --}}
                @if($item->tipe === 'booking')
                <div class="modal-bg" id="konfirmasi-{{ $item->id }}">
                    <div class="modal-box">
                        <div class="modal-title">Konfirmasi & Pilih Unit</div>
                        <p style="font-size:13px;color:var(--muted);margin-bottom:14px">
                            Jenis: <b style="color:white">{{ $item->motor->model ?? '-' }}</b>.
                            Pilih unit fisik yang akan dipakai untuk penyewaan {{ $item->konsumen->nama_lengkap ?? '' }} ini
                            ({{ $item->tanggal_mulai?->format('d/m/Y H:i') }} &rarr; {{ $item->tanggal_selesai?->format('d/m/Y H:i') }}).
                        </p>
                        <form method="POST" action="{{ route('admin.booking.konfirmasi', $item->id) }}">
                            @csrf @method('PATCH')
                            @if($item->semua_bentrok)
                                <div style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.3);border-radius:10px;padding:12px;margin-bottom:14px;font-size:12px;color:#f87171">
                                    <i class="ti ti-alert-triangle"></i> Semua unit {{ $item->motor->model ?? '' }} lagi kepakai (bentrok jadwal) untuk rentang tanggal ini. Belum bisa dikonfirmasi -- tunggu salah satu unit kosong, atau tolak booking ini.
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="form-label">Unit yang Dipakai</label>
                                <select class="form-input" name="motor_id" required {{ $item->semua_bentrok ? 'disabled' : '' }}>
                                    @forelse($item->unit_pilihan as $u)
                                        <option value="{{ $u->id }}"
                                            {{ (!$u->bentrok && $u->id == $item->motor_id) ? 'selected' : '' }}
                                            {{ $u->bentrok ? 'disabled' : '' }}>
                                            {{ $u->kode }} — {{ $u->warna ?: '-' }} — {{ $u->plat_nomor }}
                                            {{ $u->bentrok ? '(bentrok jadwal, sedang disewa lain)' : '' }}
                                        </option>
                                    @empty
                                        <option value="{{ $item->motor_id }}">{{ $item->motor->kode ?? '-' }} — {{ $item->motor->plat_nomor ?? '-' }}</option>
                                    @endforelse
                                </select>
                                <div style="font-size:11px;color:var(--muted);margin-top:5px">Unit yang bentrok jadwal otomatis tidak bisa dipilih.</div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                <button class="btn btn-primary" type="submit" @if($item->semua_bentrok) disabled style="opacity:0.5;cursor:not-allowed" @endif><i class="ti ti-check"></i> Konfirmasi</button>
                                <button class="btn btn-ghost" type="button" onclick="closeModal('konfirmasi-{{ $item->id }}')">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                {{-- Modal Izinkan Perpanjangan + Pilih Unit --}}
                @if($item->tipe === 'perpanjangan')
                <div class="modal-bg" id="izinkan-{{ $item->id }}">
                    <div class="modal-box">
                        <div class="modal-title">Izinkan Perpanjangan</div>
                        <p style="font-size:13px;color:var(--muted);margin-bottom:14px">
                            Sewa <b style="color:white">{{ $item->nomor_sewa }}</b> ({{ $item->motor->model ?? '-' }}) mau ditambah
                            <b style="color:white">{{ $item->perpanjangan_hari }} hari</b>, deadline baru
                            <b style="color:white">{{ $item->deadline_baru?->format('d/m/Y H:i') }}</b>.
                        </p>
                        <form method="POST" action="{{ route('admin.perpanjangan.izinkan', $item->id) }}">
                            @csrf @method('PATCH')
                            @if($item->semua_bentrok)
                                <div style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.3);border-radius:10px;padding:12px;margin-bottom:14px;font-size:12px;color:#f87171">
                                    <i class="ti ti-alert-triangle"></i> Semua unit sejenis lagi kepakai (bentrok jadwal) untuk periode perpanjangan ini. Belum bisa diizinkan -- tolak dulu, atau tunggu salah satu unit kosong.
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="form-label">Unit yang Dipakai</label>
                                <select class="form-input" name="motor_id" required {{ $item->semua_bentrok ? 'disabled' : '' }}>
                                    @forelse($item->unit_pilihan as $u)
                                        <option value="{{ $u->id }}"
                                            {{ (!$u->bentrok && $u->id == $item->motor_id) ? 'selected' : '' }}
                                            {{ $u->bentrok ? 'disabled' : '' }}>
                                            {{ $u->kode }} — {{ $u->warna ?: '-' }} — {{ $u->plat_nomor }}
                                            {{ $u->bentrok ? '(bentrok jadwal, sedang disewa lain)' : '' }}
                                        </option>
                                    @empty
                                        <option value="{{ $item->motor_id }}">{{ $item->motor->kode ?? '-' }} — {{ $item->motor->plat_nomor ?? '-' }}</option>
                                    @endforelse
                                </select>
                                <div style="font-size:11px;color:var(--muted);margin-top:5px">Unit yang bentrok jadwal otomatis tidak bisa dipilih.</div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                <button class="btn btn-primary" type="submit" @if($item->semua_bentrok) disabled style="opacity:0.5;cursor:not-allowed" @endif><i class="ti ti-check"></i> Konfirmasi</button>
                                <button class="btn btn-ghost" type="button" onclick="closeModal('izinkan-{{ $item->id }}')">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                @empty
                <tr><td colspan="9" class="empty-row">
                    @if($tipe !== 'semua' || $cari !== '' || $jenis !== '')
                        Tidak ada data yang cocok dengan penyaringan
                    @else
                        Tidak ada yang butuh aksi saat ini
                    @endif
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
