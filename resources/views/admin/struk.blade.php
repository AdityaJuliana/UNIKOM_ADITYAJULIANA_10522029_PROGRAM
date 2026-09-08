<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Struk {{ $penyewaan->nomor_sewa }} — Beruang Motor</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    :root{
        --ink:#1c2333; --muted:#6b7488; --line:#c7cdd8; --green:#0f9d6e; --paper:#ffffff; --bgpage:#eef1f6;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    body{background:var(--bgpage);font-family:'Nunito',sans-serif;color:var(--ink);padding:32px 16px;display:flex;flex-direction:column;align-items:center;gap:18px}

    .toolbar{display:flex;gap:10px}
    .btn{padding:11px 20px;border-radius:10px;border:none;font-weight:800;font-size:13px;cursor:pointer;display:inline-flex;align-items:center;gap:7px;font-family:'Nunito',sans-serif}
    .btn-print{background:var(--green);color:white}
    .btn-back{background:white;color:var(--muted);border:1px solid var(--line)}

    .struk{width:380px;max-width:100%;background:var(--paper);border-radius:14px;box-shadow:0 10px 40px rgba(20,30,50,0.12);overflow:hidden}
    .struk-head{background:var(--ink);color:white;padding:26px 24px 22px;text-align:center}
    .struk-logo{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:22px;letter-spacing:0.02em}
    .struk-logo span{color:#5fd6a8}
    .struk-tagline{font-size:10.5px;color:#aab3c5;text-transform:uppercase;letter-spacing:0.14em;margin-top:4px;font-weight:700}

    .struk-body{padding:22px 24px 8px;font-family:'JetBrains Mono',monospace}
    .row{display:flex;justify-content:space-between;gap:10px;font-size:12px;margin-bottom:6px}
    .row .k{color:var(--muted)}
    .row .v{font-weight:700;text-align:right}
    .divider{border:none;border-top:1.5px dashed var(--line);margin:14px 0}
    .section-label{font-size:10px;color:var(--green);font-weight:700;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:8px}

    .total-row{display:flex;justify-content:space-between;align-items:center;margin-top:4px;padding-top:10px;border-top:1.5px solid var(--ink)}
    .total-row .k{font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:0.05em}
    .total-row .v{font-size:19px;font-weight:800;color:var(--green)}

    .lunas-badge{display:inline-block;margin-top:10px;padding:4px 12px;background:rgba(15,157,110,0.1);color:var(--green);border:1px solid rgba(15,157,110,0.3);border-radius:20px;font-size:10px;font-weight:800;letter-spacing:0.05em}

    .struk-foot{padding:20px 24px 26px;text-align:center}
    .struk-foot .thanks{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:14px;margin-bottom:4px}
    .struk-foot .sub{font-size:11px;color:var(--muted);line-height:1.6}
    .barcode{margin:16px auto 4px;height:38px;width:80%;background:repeating-linear-gradient(90deg,var(--ink) 0px,var(--ink) 2px,transparent 2px,transparent 5px)}
    .struk-id-print{font-family:'JetBrains Mono',monospace;font-size:10px;color:var(--muted);letter-spacing:0.15em;margin-top:6px}

    @media print{
        body{background:white;padding:0;display:block}
        .toolbar{display:none}
        .struk{box-shadow:none;border-radius:0;width:100%}
        @page{margin:12mm}
    }
</style>
</head>
<body>

    <div class="toolbar">
        <button class="btn btn-print" onclick="window.print()"><i>🖨</i> Cetak Struk</button>
        <a href="{{ route('admin.pengembalian') }}" class="btn btn-back">&larr; Kembali</a>
    </div>

    @php
        $hariID  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $bulanID = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $fmt = function ($tgl) use ($hariID, $bulanID) {
            if (!$tgl) return '-';
            return $hariID[$tgl->dayOfWeek].', '.$tgl->day.' '.$bulanID[$tgl->month].' '.$tgl->year.' — '.$tgl->format('H:i').' WIB';
        };
    @endphp

    <div class="struk">
        <div class="struk-head">
            <div class="struk-logo">BERUANG <span>RENTAL MOTOR</span></div>
            <div class="struk-tagline">Premium Rental &middot; Struk Pengembalian</div>
        </div>

        <div class="struk-body">
            <div class="row"><span class="k">No. Sewa</span><span class="v">{{ $penyewaan->nomor_sewa }}</span></div>
            <div class="row"><span class="k">Dicetak</span><span class="v">{{ now()->format('d/m/Y H:i') }}</span></div>
            <div class="row"><span class="k">Diproses Oleh</span><span class="v">{{ $penyewaan->diproses_oleh ?? '-' }}</span></div>

            <hr class="divider">
            <div class="section-label">Data Penyewa</div>
            <div class="row"><span class="k">Nama</span><span class="v">{{ $penyewaan->konsumen->nama_lengkap ?? '-' }}</span></div>
            <div class="row"><span class="k">No. WhatsApp</span><span class="v">{{ $penyewaan->konsumen->no_whatsapp ?? '-' }}</span></div>

            <hr class="divider">
            <div class="section-label">Data Motor</div>
            <div class="row"><span class="k">Model</span><span class="v">{{ $penyewaan->motor->model ?? '-' }}</span></div>
            <div class="row"><span class="k">Warna</span><span class="v">{{ $penyewaan->motor->warna ?? '-' }}</span></div>
            <div class="row"><span class="k">Plat Nomor</span><span class="v">{{ $penyewaan->motor->plat_nomor ?? '-' }}</span></div>

            <hr class="divider">
            <div class="section-label">Periode Sewa</div>
            <div class="row"><span class="k">Mulai</span></div>
            <div class="row" style="margin-top:-3px"><span class="v" style="text-align:left">{{ $fmt($penyewaan->tanggal_mulai) }}</span></div>
            <div class="row" style="margin-top:8px"><span class="k">Selesai</span></div>
            <div class="row" style="margin-top:-3px"><span class="v" style="text-align:left">{{ $fmt($penyewaan->tanggal_kembali_aktual ?? $penyewaan->tanggal_selesai) }}</span></div>

            <hr class="divider">
            <div class="section-label">Rincian Biaya</div>
            <div class="row"><span class="k">Biaya Sewa</span><span class="v">Rp {{ number_format($penyewaan->total_harga,0,',','.') }}</span></div>
            @if($penyewaan->denda_waktu > 0)
            <div class="row"><span class="k">Denda Keterlambatan</span><span class="v">Rp {{ number_format($penyewaan->denda_waktu,0,',','.') }}</span></div>
            @endif
            @if($penyewaan->biaya_kerusakan > 0)
            <div class="row"><span class="k">Biaya Kerusakan</span><span class="v">Rp {{ number_format($penyewaan->biaya_kerusakan,0,',','.') }}</span></div>
            @endif
            <div class="row"><span class="k">DP Dibayar</span><span class="v">- Rp {{ number_format($penyewaan->dp_dibayar,0,',','.') }}</span></div>

            <div class="total-row">
                <span class="k">Grand Total</span>
                <span class="v">Rp {{ number_format($penyewaan->grand_total,0,',','.') }}</span>
            </div>
            <div style="text-align:center">
                <span class="lunas-badge">&#10003; {{ $penyewaan->status_pembayaran }}</span>
            </div>
        </div>

        <div class="struk-foot">
            <div class="barcode"></div>
            <div class="struk-id-print">{{ $penyewaan->nomor_sewa }}</div>
            <div class="thanks" style="margin-top:14px">Terima kasih! 🏍️</div>
            <div class="sub">Sudah dicek & dalam kondisi baik saat pengembalian.<br>Sampai jumpa di penyewaan berikutnya.</div>
        </div>
    </div>

</body>
</html>
