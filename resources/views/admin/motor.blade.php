@extends('layouts.app')
@section('title','Data Motor')
@section('page_title','Data Motor')
@section('styles')
<style>
    .status-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:14px;margin-bottom:18px}
    .status-card{background:var(--surface);border:1px solid var(--border);border-top:3px solid var(--sc);border-radius:16px;padding:16px 18px;position:relative;cursor:pointer;transition:0.2s}
    .status-card:hover{border-color:var(--sc);transform:translateY(-2px)}
    .status-card.aktif{border-color:var(--sc);box-shadow:0 0 0 1px var(--sc)}
    .status-code{font-size:22px;font-weight:800;color:var(--sc);line-height:1}
    .status-name{font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;font-weight:700;margin-top:4px}
    .status-count{font-size:34px;font-weight:800;color:white;line-height:1;margin:10px 0 2px}
    .status-desc{font-size:11px;color:var(--muted);line-height:1.5}
    .status-icon{position:absolute;top:14px;right:16px;width:34px;height:34px;border-radius:10px;background:var(--sc-bg);color:var(--sc);display:flex;align-items:center;justify-content:center;font-size:17px}
    .plat-besar{font-family:monospace;font-size:14px;font-weight:700;color:white;letter-spacing:0.06em;background:var(--surface2);border:1px solid var(--border);padding:5px 10px;border-radius:7px;display:inline-block;white-space:nowrap}
    .badge-masalah{font-size:9px;background:rgba(248,113,113,0.15);color:#f87171;padding:2px 6px;border-radius:5px;margin-left:5px;font-weight:700;letter-spacing:0.04em;white-space:nowrap}
    .rw-item{background:var(--surface2);border:1px solid var(--border);border-left:3px solid var(--jc);border-radius:10px;padding:11px 13px}
    .rw-jenis{font-size:11px;font-weight:800;color:var(--jc);text-transform:uppercase;letter-spacing:0.06em}
    .rw-meta{font-size:11.5px;color:var(--muted);margin-top:3px;line-height:1.6}
    .rw-catatan{font-size:12px;color:var(--text);margin-top:5px;line-height:1.5}
    .badge-kunci{font-size:9px;background:rgba(148,163,184,0.15);color:#94a3b8;padding:2px 6px;border-radius:5px;margin-left:5px;font-weight:700;letter-spacing:0.04em}
</style>
@endsection
@section('content')

{{-- Ringkasan status armada (klik buat filter) --}}
<div class="status-grid">
    <div class="status-card status-filter" data-status="OFTR" onclick="filterStatus('OFTR', this)" style="--sc:#1bbb87;--sc-bg:rgba(27,187,135,0.12)">
        <div class="status-icon"><i class="ti ti-circle-check"></i></div>
        <div class="status-code">OFTR</div>
        <div class="status-name">Off The Road</div>
        <div class="status-count">{{ count($rekapStatus['OFTR']) }}</div>
        <div class="status-desc">Ada di tempat sewa, belum ada yang booking</div>
    </div>

    <div class="status-card status-filter" data-status="OTRB" onclick="filterStatus('OTRB', this)" style="--sc:#fbbf24;--sc-bg:rgba(251,191,36,0.12)">
        <div class="status-icon"><i class="ti ti-lock-clock"></i></div>
        <div class="status-code">OTRB</div>
        <div class="status-name">Off The Road Booking</div>
        <div class="status-count">{{ count($rekapStatus['OTRB']) }}</div>
        <div class="status-desc">Sudah dibooking &amp; masuk hari sewa, belum diambil</div>
    </div>

    <div class="status-card status-filter" data-status="ONTR" onclick="filterStatus('ONTR', this)" style="--sc:#f87171;--sc-bg:rgba(248,113,113,0.12)">
        <div class="status-icon"><i class="ti ti-key"></i></div>
        <div class="status-code">ONTR</div>
        <div class="status-name">On The Road</div>
        <div class="status-count">{{ count($rekapStatus['ONTR']) }}</div>
        <div class="status-desc">Sedang dipakai konsumen di luar</div>
    </div>

    <div class="status-card status-filter" data-status="Perawatan" onclick="filterStatus('Perawatan', this)" style="--sc:#94a3b8;--sc-bg:rgba(148,163,184,0.12)">
        <div class="status-icon"><i class="ti ti-tool"></i></div>
        <div class="status-code">PERAWATAN</div>
        <div class="status-name">Maintenance</div>
        <div class="status-count">{{ count($rekapStatus['Perawatan']) }}</div>
        <div class="status-desc">Lagi diperbaiki, tidak bisa disewakan</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="ti ti-motorbike"></i> Armada Motor</div>
        <button class="btn btn-primary" onclick="openModal('modal-tambah')"><i class="ti ti-plus"></i> Tambah Unit</button>
    </div>

    <div style="padding:16px 20px 0;display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end">
        <div style="flex:1;min-width:220px;max-width:320px">
            <label class="form-label">Filter Jenis Motor</label>
            <select class="form-input" id="filter-jenis" onchange="terapkanFilter()">
                <option value="">Semua Jenis ({{ $motors->flatten()->count() }} unit)</option>
                @foreach($motors as $jenis => $units)
                    <option value="{{ $jenis }}">{{ $jenis }} ({{ $units->count() }} unit)</option>
                @endforeach
            </select>
        </div>
        <div style="flex:1;min-width:200px;max-width:280px">
            <label class="form-label">Filter Status</label>
            <select class="form-input" id="filter-status" onchange="terapkanFilter()">
                <option value="">Semua Status</option>
                <option value="OFTR">OFTR ({{ count($rekapStatus['OFTR']) }})</option>
                <option value="OTRB">OTRB ({{ count($rekapStatus['OTRB']) }})</option>
                <option value="ONTR">ONTR ({{ count($rekapStatus['ONTR']) }})</option>
                <option value="Perawatan">Perawatan ({{ count($rekapStatus['Perawatan']) }})</option>
            </select>
        </div>
        <button type="button" class="btn btn-ghost" onclick="resetFilter()" style="margin-bottom:1px"><i class="ti ti-filter-off"></i> Reset</button>
    </div>

    <div class="table-wrap">
        <table>
            <thead><tr><th>Plat Nomor</th><th>Warna</th><th>Tarif Weekday</th><th>Tarif Weekend</th><th>Status</th><th>Aksi</th></tr></thead>
            @forelse($motors as $jenis => $units)
            <tbody class="jenis-group" data-jenis="{{ $jenis }}">
                <tr class="jenis-header" onclick="toggleJenisGroup(this)" style="cursor:pointer;background:var(--surface2)">
                    <td colspan="6">
                        <i class="ti ti-chevron-down jenis-chevron" style="transition:transform 0.2s;margin-right:8px;color:var(--muted)"></i>
                        <i class="ti ti-motorbike" style="color:var(--green);margin-right:6px"></i>
                        <b style="color:white">{{ $jenis }}</b>
                        <span style="color:var(--muted);font-weight:400;font-size:12px;margin-left:6px">({{ $units->count() }} unit)</span>
                        <span class="badge bg-available" style="margin-left:8px;font-size:10px"><i class="ti ti-history"></i> {{ $units->sum(fn($u) => $u->penyewaans->count()) }}x disewa</span>
                    </td>
                </tr>
                @foreach($units as $m)
                @php $st = $m->statusEfektif(); @endphp
                <tr class="jenis-unit-row" data-status="{{ $st }}">
                    <td><span class="plat-besar">{{ $m->plat_nomor }}</span></td>
                    <td>{{ $m->warna ?: '-' }}</td>
                    <td style="color:var(--green);font-weight:700">Rp {{ number_format($m->tarif_weekday,0,',','.') }}</td>
                    <td style="color:var(--green);font-weight:700">Rp {{ number_format($m->tarif_weekend,0,',','.') }}</td>
                    <td>
                        <span class="badge {{ match($st) { 'OFTR' => 'bg-available', 'OTRB' => 'bg-warning', 'ONTR' => 'bg-rented', default => 'bg-maintenance' } }}">{{ $st }}</span>
                        @if($m->statusDikunci())<span class="badge-kunci" title="Status dikunci manual oleh admin"><i class="ti ti-lock"></i> manual</span>@endif
                        @php $jmlMasalah = $m->perawatans->where('jenis','Masalah')->where('selesai', false)->count(); @endphp
                        @if($jmlMasalah > 0)<a href="{{ route('admin.motor.riwayat', $m->kode) }}" class="badge-masalah" style="text-decoration:none" title="Ada masalah yang belum ditangani. Klik untuk membuka riwayat unit."><i class="ti ti-alert-triangle"></i> {{ $jmlMasalah }} masalah</a>@endif
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap">
                            <a href="{{ route('admin.motor.riwayat', $m->kode) }}" class="btn btn-ghost btn-sm" onclick="event.stopPropagation()" title="Lihat riwayat unit"><i class="ti ti-history"></i></a>
                            <button class="btn btn-ghost btn-sm" onclick="event.stopPropagation();openModal('modal-edit-{{ $m->kode }}')" title="Edit Unit"><i class="ti ti-edit"></i></button>
                            <button class="btn btn-ghost btn-sm" onclick="event.stopPropagation();openModal('modal-status-{{ $m->kode }}')" title="Ubah Status"><i class="ti ti-adjustments"></i></button>
                            <button class="btn btn-ghost btn-sm" onclick="event.stopPropagation();openModal('modal-perawatan-{{ $m->kode }}')" title="Isi formulir perawatan"><i class="ti ti-tool"></i></button>
                            <form method="POST" action="{{ route('admin.motor.destroy', $m->kode) }}" onsubmit="return confirm('Hapus unit {{ $m->plat_nomor }}?')" onclick="event.stopPropagation()">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="ti ti-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Modal Formulir Perawatan -->
                <div class="modal-bg" id="modal-perawatan-{{ $m->kode }}">
                    <div class="modal-box" style="max-width:520px">
                        <div class="modal-title">Formulir Perawatan</div>
                        <p style="font-size:12px;color:var(--muted);margin-bottom:16px">
                            <b style="color:var(--text);font-family:monospace">{{ $m->plat_nomor }}</b> ·
                            {{ $m->model }}{{ $m->warna ? ' — '.$m->warna : '' }}
                        </p>

                        <form method="POST" action="{{ route('admin.motor.perawatan.store', $m->kode) }}">
                            @csrf
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                <div class="form-group">
                                    <label class="form-label">Jenis</label>
                                    <select class="form-input" name="jenis" required>
                                        <option value="Ganti Oli">Ganti Oli</option>
                                        <option value="Servis">Servis Rutin</option>
                                        <option value="Perbaikan">Perbaikan</option>
                                        <option value="Masalah">Masalah / Kerusakan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tanggal &amp; Jam</label>
                                    <input type="datetime-local" class="form-input" name="tanggal" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                                </div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                <div class="form-group">
                                    <label class="form-label">Kilometer</label>
                                    <input type="number" class="form-input" name="kilometer" min="0" placeholder="Contoh: 12500">
                                    <div style="font-size:10.5px;color:var(--muted);margin-top:4px">Angka odometer saat dicatat</div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Biaya (Rp) <span style="color:var(--muted);font-weight:400">opsional</span></label>
                                    <input type="number" class="form-input" name="biaya" min="0" placeholder="Contoh: 45000">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Catatan</label>
                                <textarea class="form-input" name="catatan" rows="2" placeholder="Contoh: ganti oli Federal 10-40, sekalian cek rem depan"></textarea>
                            </div>
                            <div style="font-size:11px;color:var(--muted);margin-bottom:14px;line-height:1.55">
                                <i class="ti ti-info-circle"></i> Catatan yang tersimpan bisa dilihat kapan saja lewat tombol riwayat (ikon jam).
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                <button class="btn btn-primary" type="submit"><i class="ti ti-device-floppy"></i> Simpan Catatan</button>
                                <button class="btn btn-ghost" type="button" onclick="closeModal('modal-perawatan-{{ $m->kode }}')">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Ubah Status -->
                <div class="modal-bg" id="modal-status-{{ $m->kode }}">
                    <div class="modal-box">
                        <div class="modal-title">Ubah Status: {{ $m->plat_nomor }}</div>
                        <p style="font-size:12px;color:var(--muted);margin-bottom:14px">
                            {{ $m->model }}{{ $m->warna ? ' — '.$m->warna : '' }}<br>
                            Status sekarang: <b style="color:white">{{ $st }}</b>
                            @if($m->statusDikunci())
                                <span style="color:#94a3b8">(dikunci manual)</span>
                            @else
                                <span style="color:var(--green)">(otomatis)</span>
                            @endif
                        </p>
                        <form method="POST" action="{{ route('admin.motor.status', $m->kode) }}">
                            @csrf @method('PATCH')
                            <div class="form-group">
                                <label class="form-label">Status Unit</label>
                                <select class="form-input" name="status_override">
                                    <option value="auto" {{ !$m->statusDikunci() ? 'selected' : '' }}>Otomatis (ikut data penyewaan)</option>
                                    <option value="OFTR"      {{ $m->status_override === 'OFTR' ? 'selected' : '' }}>OFTR — Off The Road (siap disewa)</option>
                                    <option value="OTRB"      {{ $m->status_override === 'OTRB' ? 'selected' : '' }}>OTRB — Off The Road Booking (sudah dibooking)</option>
                                    <option value="ONTR"      {{ $m->status_override === 'ONTR' ? 'selected' : '' }}>ONTR — On The Road (sedang dipakai)</option>
                                    <option value="Perawatan" {{ $m->status_override === 'Perawatan' ? 'selected' : '' }}>Perawatan — sedang diperbaiki</option>
                                </select>
                                <div style="font-size:11px;color:var(--muted);margin-top:6px;line-height:1.5">
                                    Pilih <b>Otomatis</b> supaya status ngikutin data penyewaan sendiri (OTRB pas masuk hari sewa, ONTR pas motor diserahkan, OFTR pas sudah dikembalikan).
                                    Pilih status lain kalau mau dikunci manual — sistem tidak akan menimpanya.
                                </div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                <button class="btn btn-primary" type="submit"><i class="ti ti-check"></i> Simpan</button>
                                <button class="btn btn-ghost" type="button" onclick="closeModal('modal-status-{{ $m->kode }}')">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Edit -->
                <div class="modal-bg" id="modal-edit-{{ $m->kode }}">
                    <div class="modal-box">
                        <div class="modal-title">Edit Unit: {{ $m->plat_nomor }}</div>
                        <form method="POST" action="{{ route('admin.motor.update', $m->kode) }}">
                            @csrf @method('PUT')
                            <div class="form-group"><label class="form-label">Model / Jenis Motor</label><input class="form-input" name="model" value="{{ $m->model }}" list="daftar-jenis"></div>
                            <div class="form-group"><label class="form-label">Warna</label><input class="form-input" name="warna" value="{{ $m->warna }}" placeholder="Contoh: Hitam"></div>
                            <div class="form-group"><label class="form-label">Plat Nomor</label><input class="form-input" name="plat_nomor" value="{{ $m->plat_nomor }}"></div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                <div class="form-group"><label class="form-label">Tarif Weekday /24 Jam (Rp)</label><input class="form-input" type="number" name="tarif_weekday" value="{{ $m->tarif_weekday }}"></div>
                                <div class="form-group"><label class="form-label">Tarif Weekend /24 Jam (Rp)</label><input class="form-input" type="number" name="tarif_weekend" value="{{ $m->tarif_weekend }}"></div>
                            </div>
                            <div class="form-group"><label class="form-label">Spesifikasi</label><textarea class="form-input" name="spesifikasi" rows="2">{{ $m->spesifikasi }}</textarea></div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                <button class="btn btn-primary" type="submit"><i class="ti ti-check"></i> Simpan</button>
                                <button class="btn btn-ghost" type="button" onclick="closeModal('modal-edit-{{ $m->kode }}')">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
            @empty
            <tbody><tr><td colspan="6" class="empty-row">Belum ada unit motor</td></tr></tbody>
            @endforelse
        </table>
    </div>
</div>

<datalist id="daftar-jenis">
    @foreach($motors as $jenis => $units)
        <option value="{{ $jenis }}">
    @endforeach
</datalist>

<!-- Modal Tambah -->
<div class="modal-bg" id="modal-tambah">
    <div class="modal-box">
        <div class="modal-title">Tambah Unit Motor</div>
        <form method="POST" action="{{ route('admin.motor.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Model / Jenis Motor</label>
                <input class="form-input" name="model" id="input-model-baru" placeholder="Contoh: Honda PCX 160" list="daftar-jenis" autocomplete="off" required oninput="cekJenisMotor()">
                <div style="font-size:11px;color:var(--muted);margin-top:5px">Ketik nama jenisnya, atau pilih dari daftar yang sudah ada.</div>
            </div>
            <div class="form-group"><label class="form-label">Warna</label><input class="form-input" name="warna" placeholder="Contoh: Hitam"></div>
            <div class="form-group"><label class="form-label">Plat Nomor</label><input class="form-input" name="plat_nomor" placeholder="Contoh: B 1234 ABC" required></div>

            {{-- Muncul kalau jenisnya SUDAH ada: tarif & spesifikasi diwarisi otomatis --}}
            <div id="info-jenis-lama" style="display:none;background:rgba(27,187,135,0.08);border:1px solid rgba(27,187,135,0.25);border-radius:10px;padding:12px 14px;margin-bottom:14px">
                <div style="font-size:12px;color:var(--green);font-weight:700;margin-bottom:4px"><i class="ti ti-circle-check"></i> Jenis ini sudah terdaftar</div>
                <div style="font-size:11.5px;color:var(--muted);line-height:1.6">
                    Tarif &amp; spesifikasi otomatis ikut unit <b id="nama-jenis-lama" style="color:var(--text)"></b> yang sudah ada,
                    jadi cukup isi warna &amp; plat nomor saja. Kalau mau ubah tarifnya, edit lewat unit yang sudah terdaftar.
                </div>
            </div>

            {{-- Muncul kalau jenisnya BARU: wajib isi tarif & spesifikasi --}}
            <div id="field-jenis-baru">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                    <div class="form-group"><label class="form-label">Tarif Weekday /24 Jam (Rp)</label><input class="form-input" type="number" name="tarif_weekday" placeholder="100000" required></div>
                    <div class="form-group"><label class="form-label">Tarif Weekend /24 Jam (Rp)</label><input class="form-input" type="number" name="tarif_weekend" placeholder="115000" required></div>
                </div>
                <div class="form-group"><label class="form-label">Spesifikasi</label><textarea class="form-input" name="spesifikasi" rows="2" placeholder="155cc, ABS, dll"></textarea></div>
            </div>

            <div class="form-group"><label class="form-label">Foto Unit <span style="color:var(--muted);font-weight:400">(opsional)</span></label><input class="form-input" type="file" name="foto" accept="image/*" style="padding:8px;cursor:pointer"></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <button class="btn btn-primary" type="submit"><i class="ti ti-plus"></i> Tambah</button>
                <button class="btn btn-ghost" type="button" onclick="closeModal('modal-tambah')">Batal</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
// Daftar jenis motor yang sudah terdaftar (buat cek di form Tambah Unit)
const JENIS_TERDAFTAR = @json($motors->keys()->values());

function cekJenisMotor() {
    const input      = document.getElementById('input-model-baru');
    const blokBaru   = document.getElementById('field-jenis-baru');
    const blokLama   = document.getElementById('info-jenis-lama');
    const namaJenis  = document.getElementById('nama-jenis-lama');
    const nilai      = input.value.trim().toLowerCase();

    const cocok = JENIS_TERDAFTAR.find(j => j.toLowerCase() === nilai);

    if (cocok) {
        blokBaru.style.display = 'none';
        blokLama.style.display = 'block';
        namaJenis.innerText    = cocok;
    } else {
        blokBaru.style.display = 'block';
        blokLama.style.display = 'none';
    }

    // Field yang lagi disembunyikan tidak boleh wajib diisi, kalau tidak
    // form-nya bakal nolak submit tanpa pesan yang jelas.
    blokBaru.querySelectorAll('input[type=number]').forEach(function (el) {
        if (cocok) {
            el.removeAttribute('required');
            el.value = '';
        } else {
            el.setAttribute('required', 'required');
        }
    });
}

function terapkanFilter() {
    const jenis  = document.getElementById('filter-jenis').value;
    const status = document.getElementById('filter-status').value;

    document.querySelectorAll('.jenis-group').forEach(function (grup) {
        const cocokJenis = (jenis === '' || grup.dataset.jenis === jenis);
        let adaBarisTampil = false;

        grup.querySelectorAll('.jenis-unit-row').forEach(function (row) {
            const cocokStatus = (status === '' || row.dataset.status === status);
            const tampil = cocokJenis && cocokStatus;
            row.style.display = tampil ? '' : 'none';
            if (tampil) adaBarisTampil = true;
        });

        // Sembunyikan seluruh grup kalau tidak ada unit yang lolos filter
        grup.style.display = (cocokJenis && (status === '' || adaBarisTampil)) ? '' : 'none';
    });

    // Tandai kartu status yang lagi aktif
    document.querySelectorAll('.status-filter').forEach(function (card) {
        card.classList.toggle('aktif', card.dataset.status === status && status !== '');
    });
}

function filterStatus(status, card) {
    const select = document.getElementById('filter-status');
    // Klik kartu yang sama dua kali = lepas filternya
    select.value = (select.value === status) ? '' : status;
    terapkanFilter();
}

function resetFilter() {
    document.getElementById('filter-jenis').value  = '';
    document.getElementById('filter-status').value = '';
    terapkanFilter();
}

function toggleJenisGroup(headerRow) {
    const tbody    = headerRow.closest('tbody');
    const isClosed = tbody.classList.toggle('collapsed');
    tbody.querySelectorAll('.jenis-unit-row').forEach(function (row) {
        row.style.display = isClosed ? 'none' : '';
    });
    const chevron = headerRow.querySelector('.jenis-chevron');
    chevron.style.transform = isClosed ? 'rotate(-90deg)' : 'rotate(0deg)';
}
</script>
@endsection
