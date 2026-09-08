@extends('layouts.app')
@section('title','Katalog Motor')
@section('page_title','Katalog Motor')
@section('content')

<div style="margin-bottom:18px">
    <div style="font-size:13px;color:var(--muted)">Pilih unit dan booking sekarang. DP minimal <b style="color:var(--green)">Rp 50.000</b>.</div>
</div>

<div style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);border-radius:12px;padding:14px 18px;margin-bottom:22px">
    <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:10px">
        <i class="ti ti-info-circle" style="color:#fbbf24;font-size:18px;flex-shrink:0;margin-top:1px"></i>
        <p style="font-size:13px;color:#fbbf24;font-weight:700">Setiap booking wajib melampirkan bukti transfer DP. Admin akan mengkonfirmasi dalam 1×24 jam.</p>
    </div>
    <ul style="margin:0;padding-left:28px;display:flex;flex-direction:column;gap:5px">
        <li style="font-size:12px;color:#fbbf24;opacity:0.85">Booking baru dianggap aktif setelah pembayaran DP diverifikasi admin (status berubah jadi "Diterima").</li>
        <li style="font-size:12px;color:#fbbf24;opacity:0.85">Pembatalan minimal 24 jam sebelum jadwal pengambilan bisa memperoleh pengembalian dana sesuai kebijakan.</li>
        <li style="font-size:12px;color:#fbbf24;opacity:0.85">Pembatalan mendadak (kurang dari 24 jam) menyebabkan DP hangus.</li>
        <li style="font-size:12px;color:#fbbf24;opacity:0.85">Kalau pihak kami yang membatalkan karena unit ternyata tidak tersedia, seluruh pembayaran dikembalikan penuh.</li>
    </ul>
</div>

<div style="margin-bottom:18px;max-width:320px">
    <label class="form-label">Filter Jenis Motor</label>
    <select class="form-input" id="filter-jenis" onchange="filterJenisKatalog(this.value)">
        <option value="">Semua Jenis</option>
        @foreach($motors as $m)
            <option value="{{ $m->model }}">{{ $m->model }}</option>
        @endforeach
    </select>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(270px,1fr));gap:18px">
    @forelse($motors as $m)
    <div class="katalog-card" data-jenis="{{ $m->model }}" style="background:var(--surface);border:1px solid var(--border);border-radius:16px;overflow:hidden;transition:0.3s" onmouseover="this.style.borderColor='rgba(27,187,135,0.4)';this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='var(--border)';this.style.transform='none'">
        @if($m->foto)
            <img src="{{ $m->foto }}" style="width:100%;height:170px;object-fit:cover" alt="{{ $m->model }}">
        @else
            <div style="width:100%;height:170px;background:var(--surface2);display:flex;align-items:center;justify-content:center;color:var(--green);font-size:55px">
                <i class="ti ti-motorbike"></i>
            </div>
        @endif
        <div style="padding:18px">
            <div style="font-weight:800;font-size:15px;color:white;margin-bottom:3px">{{ $m->model }}</div>
            <div style="font-size:11px;color:var(--muted);margin-bottom:10px">{{ $m->jumlah_tersedia }} dari {{ $m->jumlah_unit }} unit tersedia</div>
            <div style="background:var(--bg2);border-radius:10px;padding:10px 12px;font-size:11px;color:var(--muted);margin-bottom:12px;border:1px solid var(--border);line-height:1.6">
                {{ $m->spesifikasi ?: 'Info spesifikasi belum tersedia' }}
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                <div>
                    <div style="font-size:15px;font-weight:800;color:var(--green)">Rp {{ number_format($m->tarif_weekday,0,',','.') }}<span style="font-size:11px;color:var(--muted);font-weight:400"> /hari (weekday)</span></div>
                    <div style="font-size:15px;font-weight:800;color:var(--green)">Rp {{ number_format($m->tarif_weekend,0,',','.') }}<span style="font-size:11px;color:var(--muted);font-weight:400"> /hari (weekend)</span></div>
                </div>
                <span class="badge {{ $m->jumlah_tersedia > 0 ? 'bg-available' : 'bg-rented' }}">{{ $m->jumlah_tersedia > 0 ? $m->jumlah_tersedia.' Tersedia' : 'Penuh' }}</span>
            </div>
            @if($m->jumlah_tersedia > 0)
                <button class="btn btn-primary" style="width:100%;justify-content:center" onclick="openModal('booking-{{ $m->id }}')">
                    <i class="ti ti-calendar-plus"></i> Booking Sekarang
                </button>
            @else
                <button class="btn btn-ghost" style="width:100%;justify-content:center;opacity:0.5;cursor:not-allowed" disabled>
                    <i class="ti ti-ban"></i> Semua Unit Disewa
                </button>
            @endif
        </div>
    </div>

    {{-- Modal Booking --}}
    @if($m->jumlah_tersedia > 0)
    <div class="modal-bg" id="booking-{{ $m->id }}">
        <div class="modal-box" style="max-width:520px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px">
                <div>
                    <div style="font-size:11px;color:var(--green);font-weight:700;text-transform:uppercase;margin-bottom:3px">Booking Motor</div>
                    <div style="font-size:18px;font-weight:800;color:white">{{ $m->model }}</div>
                    <div style="font-size:12px;color:var(--muted)">Rp {{ number_format($m->tarif_weekday,0,',','.') }}/hari (weekday) · Rp {{ number_format($m->tarif_weekend,0,',','.') }}/hari (weekend)</div>
                </div>
                <button onclick="closeModal('booking-{{ $m->id }}')" style="background:var(--surface2);border:1px solid var(--border);border-radius:8px;width:32px;height:32px;color:var(--muted);cursor:pointer;font-size:16px">✕</button>
            </div>

            <form method="POST" action="{{ route('konsumen.booking') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="motor_id" value="{{ $m->id }}">

                <div style="background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:14px;margin-bottom:12px">
                    <div style="font-size:10px;font-weight:800;color:var(--green);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px"><i class="ti ti-calendar"></i> PERIODE SEWA</div>
                    <div style="display:grid;grid-template-columns:2fr 1fr;gap:10px">
                        <div class="form-group"><label class="form-label">Tanggal &amp; Jam Mulai</label><input type="datetime-local" class="form-input" name="tanggal_mulai" required onchange="hitungTotal(this.form, {{ $m->tarif_weekday }}, {{ $m->tarif_weekend }})" oninput="hitungTotal(this.form, {{ $m->tarif_weekday }}, {{ $m->tarif_weekend }})"></div>
                        <div class="form-group"><label class="form-label">Jumlah Hari</label><input type="number" class="form-input" name="jumlah_hari" min="1" value="1" required onchange="hitungTotal(this.form, {{ $m->tarif_weekday }}, {{ $m->tarif_weekend }})" oninput="hitungTotal(this.form, {{ $m->tarif_weekday }}, {{ $m->tarif_weekend }})"></div>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label"><i class="ti ti-clock"></i> Motor Dikembalikan</label>
                        <div class="form-input info-selesai" style="min-height:19px;color:var(--text);font-weight:700"></div>
                    </div>
                </div>

                <div style="background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:14px;margin-bottom:12px">
                    <div style="font-size:10px;font-weight:800;color:var(--green);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px"><i class="ti ti-truck-delivery"></i> PENGANTARAN</div>
                    <div class="form-group">
                        <label class="form-label">Opsi Pengantaran</label>
                        <select class="form-input" name="metode_pengantaran" onchange="toggleAlamat(this,'antar-{{ $m->id }}'); hitungTotal(this.form, {{ $m->tarif_weekday }}, {{ $m->tarif_weekend }})">
                            <option value="Ambil di Tempat Sewa">Ambil di Tempat Sewa</option>
                            <option value="Antar ke Alamat">Antar ke Alamat</option>
                        </select>
                    </div>
                    <div id="antar-{{ $m->id }}" style="display:none" class="form-group">
                        <label class="form-label">Alamat Pengantaran</label>
                        <textarea class="form-input" name="alamat_pengantaran" rows="2" placeholder="Masukkan alamat lengkap" style="margin-bottom:10px"></textarea>

                        <label class="form-label">Estimasi Jarak dari Tempat Sewa</label>
                        <select class="form-input" name="jarak_pengantaran" onchange="hitungTotal(this.form, {{ $m->tarif_weekday }}, {{ $m->tarif_weekend }})">
                            <option value="kurang_2km">Di bawah 2 KM — Gratis</option>
                            <option value="2_5km">2 KM - 5 KM — Rp 15.000</option>
                            <option value="lebih_5km">Di atas 5 KM (khusus kota Bandung) — Rp 25.000</option>
                        </select>
                        <div style="font-size:11px;color:#fbbf24;margin-top:8px;background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);border-radius:8px;padding:8px 10px">
                            <i class="ti ti-alert-triangle"></i> Harap cek dulu jarak asli dari tempat sewa ke alamat kamu. Kalau pilihan jarak tidak sesuai kenyataan, booking berisiko dibatalkan.
                        </div>
                    </div>
                </div>

                <div style="background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:14px;margin-bottom:12px">
                    <div style="font-size:10px;font-weight:800;color:var(--green);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px"><i class="ti ti-map-pin"></i> PENGEMBALIAN</div>
                    <div class="form-group">
                        <label class="form-label">Opsi Pengembalian</label>
                        <select class="form-input" name="metode_pengembalian" onchange="toggleAlamat(this,'jemput-{{ $m->id }}'); hitungTotal(this.form, {{ $m->tarif_weekday }}, {{ $m->tarif_weekend }})">
                            <option value="Kembalikan ke Tempat Sewa">Kembalikan ke Tempat Sewa</option>
                            <option value="Jemput di Alamat">Jemput di Alamat</option>
                        </select>
                    </div>
                    <div id="jemput-{{ $m->id }}" style="display:none" class="form-group">
                        <label class="form-label">Alamat Penjemputan</label>
                        <textarea class="form-input" name="alamat_pengembalian" rows="2" placeholder="Masukkan alamat lengkap" style="margin-bottom:10px"></textarea>

                        <label class="form-label">Estimasi Jarak dari Tempat Sewa</label>
                        <select class="form-input" name="jarak_pengembalian" onchange="hitungTotal(this.form, {{ $m->tarif_weekday }}, {{ $m->tarif_weekend }})">
                            <option value="kurang_2km">Di bawah 2 KM — Gratis</option>
                            <option value="2_5km">2 KM - 5 KM — Rp 15.000</option>
                            <option value="lebih_5km">Di atas 5 KM (khusus kota Bandung) — Rp 25.000</option>
                        </select>
                        <div style="font-size:11px;color:#fbbf24;margin-top:8px;background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);border-radius:8px;padding:8px 10px">
                            <i class="ti ti-alert-triangle"></i> Harap cek dulu jarak asli dari tempat sewa ke alamat kamu. Kalau pilihan jarak tidak sesuai kenyataan, booking berisiko dibatalkan.
                        </div>
                    </div>
                </div>

                <div style="background:rgba(27,187,135,0.08);border:1px solid rgba(27,187,135,0.2);border-radius:12px;padding:14px;margin-bottom:12px">
                    <div style="font-size:10px;font-weight:800;color:var(--green);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px"><i class="ti ti-coin"></i> PEMBAYARAN DP</div>

                    <div style="background:var(--surface2);border:1px solid var(--border);border-radius:10px;padding:12px;margin-bottom:12px">
                        <div style="font-size:11px;color:var(--muted);margin-bottom:8px">Transfer DP ke salah satu rekening berikut:</div>
                        <div style="display:flex;flex-direction:column;gap:8px">
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
                                <div>
                                    <div style="font-size:13px;color:white;font-weight:700">BCA <span style="color:var(--green)">8470165252</span></div>
                                    <div style="font-size:11px;color:var(--muted)">a.n. Irwan Nugroho</div>
                                </div>
                                <button type="button" onclick="salinRekening('8470165252', this)" style="background:none;border:1px solid var(--border);border-radius:6px;color:var(--muted);cursor:pointer;font-size:11px;padding:5px 9px;display:flex;align-items:center;gap:4px;flex-shrink:0;white-space:nowrap"><i class="ti ti-copy"></i> Salin</button>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
                                <div>
                                    <div style="font-size:13px;color:white;font-weight:700">Mandiri <span style="color:var(--green)">1310004688307</span></div>
                                    <div style="font-size:11px;color:var(--muted)">a.n. Irwan Nugroho</div>
                                </div>
                                <button type="button" onclick="salinRekening('1310004688307', this)" style="background:none;border:1px solid var(--border);border-radius:6px;color:var(--muted);cursor:pointer;font-size:11px;padding:5px 9px;display:flex;align-items:center;gap:4px;flex-shrink:0;white-space:nowrap"><i class="ti ti-copy"></i> Salin</button>
                            </div>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                        <div class="form-group"><label class="form-label">Nominal DP (Rp)</label><input type="number" class="form-input" name="dp_dibayar" value="50000" min="50000" required></div>
                        <div class="form-group"><label class="form-label">Bukti Transfer</label><input type="file" class="form-input" name="bukti_transfer" accept="image/*" required style="padding:7px;cursor:pointer"></div>
                    </div>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;background:var(--surface2);border-radius:10px;margin-bottom:14px">
                    <span style="font-size:13px;color:var(--muted);font-weight:600">Total Biaya Sewa</span>
                    <span class="total-label" style="font-size:18px;font-weight:800;color:var(--green)">Rp 0</span>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                    <button type="submit" class="btn btn-primary" style="justify-content:center;padding:12px"><i class="ti ti-calendar-check"></i> Konfirmasi</button>
                    <button type="button" class="btn btn-ghost" style="justify-content:center;padding:12px" onclick="closeModal('booking-{{ $m->id }}')">Batal</button>
                </div>
            </form>
        </div>
    </div>
    @endif
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--muted)">
        <i class="ti ti-motorbike-off" style="font-size:48px;display:block;margin-bottom:12px"></i>
        Belum ada motor tersedia
    </div>
    @endforelse
</div>

{{-- Modal konfirmasi setelah booking berhasil dikirim --}}
<div class="modal-bg" id="modal-booking-sukses">
    <div class="modal-box" style="max-width:470px;text-align:center">
        <div style="width:62px;height:62px;margin:0 auto 16px;border-radius:50%;background:rgba(27,187,135,0.12);border:1px solid rgba(27,187,135,0.35);display:flex;align-items:center;justify-content:center;color:var(--green);font-size:32px">
            <i class="ti ti-circle-check"></i>
        </div>
        <div style="font-size:19px;font-weight:800;color:white;margin-bottom:6px">Booking Berhasil Dikirim</div>
        <p style="font-size:13px;color:var(--muted);line-height:1.65;margin-bottom:18px">
            Pesanan Anda telah kami terima dan saat ini menunggu verifikasi dari Admin.
        </p>

        <div style="background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:16px;text-align:left;margin-bottom:18px">
            <div style="display:flex;gap:11px;margin-bottom:13px">
                <i class="ti ti-clock-hour-4" style="color:var(--green);font-size:17px;flex-shrink:0;margin-top:1px"></i>
                <div style="font-size:12.5px;color:var(--text);line-height:1.6">
                    Proses konfirmasi memerlukan waktu paling lama <b>1&times;24 jam</b> terhitung sejak booking dikirim.
                </div>
            </div>
            <div style="display:flex;gap:11px;margin-bottom:13px">
                <i class="ti ti-refresh" style="color:var(--green);font-size:17px;flex-shrink:0;margin-top:1px"></i>
                <div style="font-size:12.5px;color:var(--text);line-height:1.6">
                    Mohon memeriksa halaman <b>Transaksi Saya</b> secara berkala untuk mengetahui apakah booking Anda diterima atau ditolak.
                </div>
            </div>
            <div style="display:flex;gap:11px">
                <i class="ti ti-headset" style="color:#fbbf24;font-size:17px;flex-shrink:0;margin-top:1px"></i>
                <div style="font-size:12.5px;color:#fbbf24;line-height:1.6">
                    Apabila dalam <b>24 jam</b> status pesanan belum juga berubah, mohon segera menghubungi Admin.
                    @if($adminWa ?? null)
                        <br><a href="https://wa.me/{{ $adminWa }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;margin-top:8px;background:#25D366;color:white;padding:7px 14px;border-radius:8px;text-decoration:none;font-weight:700;font-size:12px">
                            <i class="ti ti-brand-whatsapp"></i> Chat Admin — {{ $adminKontak }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-ghost" style="width:100%;justify-content:center;padding:12px" onclick="closeModal('modal-booking-sukses')">
            Tutup
        </button>
    </div>
</div>
@endsection
@section('scripts')
<script>
@if(session('booking_sukses'))
openModal('modal-booking-sukses');
@endif

function ongkirDariJarak(pilihan) {
    if (pilihan === '2_5km')     return 15000;
    if (pilihan === 'lebih_5km') return 25000;
    return 0; // kurang_2km
}

function filterJenisKatalog(jenis) {
    document.querySelectorAll('.katalog-card').forEach(function (card) {
        card.style.display = (jenis === '' || card.dataset.jenis === jenis) ? '' : 'none';
    });
}

function salinRekening(nomor, btn) {
    navigator.clipboard.writeText(nomor).then(() => {
        const asli = btn.innerHTML;
        btn.innerHTML = '<i class="ti ti-check"></i> Disalin';
        setTimeout(() => { btn.innerHTML = asli; }, 1500);
    }).catch(() => {
        alert('Nomor rekening: ' + nomor);
    });
}

function toggleAlamat(sel, id) {
    document.getElementById(id).style.display = (sel.value === 'Antar ke Alamat' || sel.value === 'Jemput di Alamat') ? 'block' : 'none';
}

function formatTanggalJam(d) {
    const pad = n => String(n).padStart(2, '0');
    return pad(d.getDate()) + '/' + pad(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + pad(d.getHours()) + ':' + pad(d.getMinutes());
}

function hitungTotal(form, tarifWeekday, tarifWeekend) {
    const start = new Date(form.tanggal_mulai.value);
    const hari  = parseInt(form.jumlah_hari.value, 10);
    const box   = form.closest('.modal-box');

    if (form.tanggal_mulai.value && hari > 0) {
        // Tanggal & jam selesai = tanggal mulai + jumlah hari, jam sama persis
        // seperti jam mulai (tidak dipilih manual lagi).
        const end = new Date(start);
        end.setDate(end.getDate() + hari);

        // Hitung per hari: Sabtu(6)/Minggu(0) pakai tarif weekend, selain itu weekday
        let total = 0;
        for (let i = 0; i < hari; i++) {
            const hariIni = new Date(start);
            hariIni.setDate(hariIni.getDate() + i);
            const isWeekend = hariIni.getDay() === 0 || hariIni.getDay() === 6;
            total += isWeekend ? tarifWeekend : tarifWeekday;
        }

        // Ongkir dari pilihan jarak (bukan flat lagi)
        if (form.metode_pengantaran.value === 'Antar ke Alamat')   total += ongkirDariJarak(form.jarak_pengantaran.value);
        if (form.metode_pengembalian.value === 'Jemput di Alamat') total += ongkirDariJarak(form.jarak_pengembalian.value);

        box.querySelector('.total-label').innerText  = 'Rp ' + total.toLocaleString('id-ID');
        box.querySelector('.info-selesai').innerText = formatTanggalJam(end) + ' (' + hari + ' hari)';
    } else {
        box.querySelector('.info-selesai').innerText = '';
    }
}
</script>
@endsection
