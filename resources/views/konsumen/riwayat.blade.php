@extends('layouts.app')
@section('title','Transaksi Saya')
@section('page_title','Transaksi Saya')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="ti ti-history"></i> Transaksi Saya</div>
    </div>

    <div style="margin:0 20px 18px;background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);border-radius:12px;padding:14px 18px">
        <div style="display:flex;align-items:flex-start;gap:10px">
            <i class="ti ti-info-circle" style="color:#fbbf24;font-size:18px;flex-shrink:0;margin-top:1px"></i>
            <p style="font-size:13px;color:#fbbf24;font-weight:700">Perpanjangan sewa cuma bisa dalam satuan hari.</p>
        </div>
        <ul style="margin:8px 0 0;padding-left:28px;display:flex;flex-direction:column;gap:5px">
            <li style="font-size:12px;color:#fbbf24;opacity:0.85">Butuh tambahan cuma beberapa jam? Tidak perlu ajukan perpanjangan -- biarkan saja, nanti otomatis kehitung denda keterlambatan Rp 15.000/jam. Hasilnya sama saja.</li>
            <li style="font-size:12px;color:#fbbf24;opacity:0.85">Biaya perpanjangan harian mengikuti tarif motor di hari itu (weekday/weekend), sama seperti perhitungan sewa awal.</li>
            <li style="font-size:12px;color:#fbbf24;opacity:0.85">Sistem otomatis cek apakah unit kamu sudah dijadwalkan buat penyewa lain di periode perpanjangan. Kalau bentrok, admin akan pindahkan ke unit sejenis yang kosong sebelum menyetujui.</li>
            <li style="font-size:12px;color:#fbbf24;opacity:0.85"><b>Perpanjangan hanya bisa diajukan satu kali</b> untuk setiap penyewaan. Setelah diajukan, tombol Perpanjang akan hilang -- baik permintaannya nanti disetujui maupun ditolak admin.</li>
        </ul>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nomor Sewa</th><th>Motor</th><th>Mulai Sewa</th>
                    <th>Deadline</th><th>Denda</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penyewaans as $p)
                <tr>
                    <td><b>{{ $p->nomor_sewa ?? '(belum dikonfirmasi)' }}</b></td>
                    <td>{{ $p->motor->model ?? '-' }}</td>
                    <td style="font-size:12px">{{ $p->tanggal_mulai?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td style="font-size:12px">{{ $p->tanggal_selesai?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td class="{{ $p->denda_berjalan > 0 ? 'denda-text' : '' }}">
                        Rp {{ number_format($p->denda_berjalan,0,',','.') }}
                    </td>
                    <td>
                        @if($p->status === 'Aktif' && $p->perpanjangan_status === 'Pending')
                            <span class="badge bg-warning">Perpanjangan Pending</span>
                        @elseif($p->status === 'Pending')
                            <span class="badge bg-warning">Menunggu Konfirmasi</span>
                        @elseif($p->status === 'Aktif' && !$p->sudah_diambil)
                            <span class="badge bg-process">Diterima</span>
                            <div style="font-size:10.5px;color:var(--muted);margin-top:4px">Menunggu pengambilan motor</div>
                        @elseif($p->status === 'Aktif')
                            <span class="badge bg-available">Aktif</span>
                            @if($p->perpanjangan_status === 'Rejected')
                                <div style="font-size:10.5px;color:#f87171;margin-top:4px">Perpanjangan ditolak admin</div>
                            @elseif($p->perpanjangan_status === 'Approved')
                                <div style="font-size:10.5px;color:var(--muted);margin-top:4px">Sudah diperpanjang</div>
                            @endif
                        @elseif($p->status === 'Ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-secondary">Selesai</span>
                        @endif
                    </td>
                    <td>
                        @if($p->status === 'Aktif' && $p->sudah_diambil && $p->perpanjangan_status === null)
                            <button class="btn btn-warning btn-sm" onclick="openModal('perpanjang-{{ $p->id }}')">
                                <i class="ti ti-clock-plus"></i> Perpanjang
                            </button>
                            {{-- Modal Perpanjang --}}
                            <div class="modal-bg" id="perpanjang-{{ $p->id }}">
                                <div class="modal-box">
                                    <div class="modal-title">Perpanjang Sewa</div>
                                    <div style="background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:14px;margin-bottom:16px">
                                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                            <div>
                                                <div style="font-size:10px;font-weight:700;color:var(--muted);margin-bottom:3px">NOMOR SEWA</div>
                                                <div style="font-weight:700">{{ $p->nomor_sewa }}</div>
                                            </div>
                                            <div>
                                                <div style="font-size:10px;font-weight:700;color:var(--muted);margin-bottom:3px">MOTOR</div>
                                                <div style="font-weight:700">{{ $p->motor->model ?? '-' }}</div>
                                            </div>
                                            <div style="grid-column:1/-1">
                                                <div style="font-size:10px;font-weight:700;color:var(--muted);margin-bottom:3px">DEADLINE SAAT INI</div>
                                                <div style="font-weight:700;color:#fbbf24">{{ $p->tanggal_selesai?->format('d/m/Y H:i') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('konsumen.perpanjang', $p->id) }}" id="form-perpanjang-{{ $p->id }}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="form-label">Tambah Hari Sewa</label>
                                            <input type="number" class="form-input" name="tambah_hari" placeholder="Contoh: 2" min="1" required
                                                oninput="hitungPerpanjangan(this.form, '{{ $p->tanggal_selesai?->toIso8601String() }}', {{ $p->motor->tarif_weekday ?? 0 }}, {{ $p->motor->tarif_weekend ?? 0 }})">
                                            <small style="color:var(--muted);font-size:11px">Tarif mengikuti hari perpanjangan: Rp {{ number_format($p->motor->tarif_weekday ?? 0,0,',','.') }}/hari (weekday) atau Rp {{ number_format($p->motor->tarif_weekend ?? 0,0,',','.') }}/hari (weekend)</small>
                                        </div>
                                        <div style="font-size:12px;color:var(--muted);margin-bottom:14px;padding-top:10px;border-top:1px solid var(--border)">
                                            <div>Deadline baru: <b class="info-deadline-baru" style="color:var(--text)">isi jumlah hari dulu</b></div>
                                            <div style="margin-top:4px">Estimasi biaya: <b class="info-biaya-tambahan" style="color:var(--green)">Rp 0</b></div>
                                        </div>
                                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                            <button type="submit" class="btn btn-primary" style="justify-content:center;padding:12px">
                                                <i class="ti ti-send"></i> Kirim Permintaan
                                            </button>
                                            <button type="button" class="btn btn-ghost" style="justify-content:center;padding:12px" onclick="closeModal('perpanjang-{{ $p->id }}')">
                                                Batal
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            <span style="color:var(--muted);font-size:12px">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="empty-row">Belum ada riwayat transaksi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal konfirmasi setelah permintaan perpanjangan dikirim --}}
<div class="modal-bg" id="modal-perpanjang-sukses">
    <div class="modal-box" style="max-width:470px;text-align:center">
        <div style="width:62px;height:62px;margin:0 auto 16px;border-radius:50%;background:rgba(27,187,135,0.12);border:1px solid rgba(27,187,135,0.35);display:flex;align-items:center;justify-content:center;color:var(--green);font-size:32px">
            <i class="ti ti-send"></i>
        </div>
        <div style="font-size:19px;font-weight:800;color:white;margin-bottom:6px">Permintaan Perpanjangan Terkirim</div>
        <p style="font-size:13px;color:var(--muted);line-height:1.65;margin-bottom:18px">
            Permintaan Anda telah kami terima dan saat ini menunggu persetujuan dari Admin.
        </p>

        <div style="background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:16px;text-align:left;margin-bottom:18px">
            <div style="display:flex;gap:11px;margin-bottom:13px">
                <i class="ti ti-clock-hour-4" style="color:var(--green);font-size:17px;flex-shrink:0;margin-top:1px"></i>
                <div style="font-size:12.5px;color:var(--text);line-height:1.6">
                    Admin akan terlebih dahulu memeriksa ketersediaan unit pada periode perpanjangan yang Anda ajukan.
                </div>
            </div>
            <div style="display:flex;gap:11px;margin-bottom:13px">
                <i class="ti ti-refresh" style="color:var(--green);font-size:17px;flex-shrink:0;margin-top:1px"></i>
                <div style="font-size:12.5px;color:var(--text);line-height:1.6">
                    Mohon memeriksa halaman ini secara berkala untuk mengetahui apakah perpanjangan Anda disetujui atau ditolak.
                </div>
            </div>
            <div style="display:flex;gap:11px;margin-bottom:13px">
                <i class="ti ti-alert-triangle" style="color:#fbbf24;font-size:17px;flex-shrink:0;margin-top:1px"></i>
                <div style="font-size:12.5px;color:#fbbf24;line-height:1.6">
                    Selama menunggu persetujuan, <b>deadline pengembalian masih mengikuti jadwal semula</b>. Mohon tetap perhatikan batas waktunya agar terhindar dari denda keterlambatan.
                </div>
            </div>
            <div style="display:flex;gap:11px">
                <i class="ti ti-headset" style="color:#fbbf24;font-size:17px;flex-shrink:0;margin-top:1px"></i>
                <div style="font-size:12.5px;color:#fbbf24;line-height:1.6">
                    Apabila status permintaan belum juga berubah dalam waktu lama, mohon segera menghubungi Admin.
                    @if($adminWa ?? null)
                        <br><a href="https://wa.me/{{ $adminWa }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;margin-top:8px;background:#25D366;color:white;padding:7px 14px;border-radius:8px;text-decoration:none;font-weight:700;font-size:12px">
                            <i class="ti ti-brand-whatsapp"></i> Chat Admin — {{ $adminKontak }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-primary" style="width:100%;justify-content:center;padding:12px" onclick="closeModal('modal-perpanjang-sukses')">
            <i class="ti ti-check"></i> Mengerti
        </button>
    </div>
</div>
@endsection
@section('scripts')
<script>
@if(session('perpanjangan_sukses'))
openModal('modal-perpanjang-sukses');
@endif
function formatTanggalJam(d) {
    const pad = n => String(n).padStart(2, '0');
    return pad(d.getDate()) + '/' + pad(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + pad(d.getHours()) + ':' + pad(d.getMinutes());
}
function hitungPerpanjangan(form, deadlineIso, tarifWeekday, tarifWeekend) {
    const hari = parseInt(form.tambah_hari.value, 10);
    const box  = form.closest('.modal-box');
    if (!deadlineIso || !(hari > 0)) return;

    const mulai = new Date(deadlineIso);
    const baru  = new Date(mulai);
    baru.setDate(baru.getDate() + hari);

    let total = 0;
    for (let i = 0; i < hari; i++) {
        const hariIni   = new Date(mulai);
        hariIni.setDate(hariIni.getDate() + i);
        const isWeekend = hariIni.getDay() === 0 || hariIni.getDay() === 6;
        total += isWeekend ? tarifWeekend : tarifWeekday;
    }

    box.querySelector('.info-deadline-baru').innerText   = formatTanggalJam(baru);
    box.querySelector('.info-biaya-tambahan').innerText  = 'Rp ' + total.toLocaleString('id-ID');
}
</script>
@endsection
