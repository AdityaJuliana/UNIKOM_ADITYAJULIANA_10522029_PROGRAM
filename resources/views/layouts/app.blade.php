<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Beruang Motor — @yield('title', 'Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{
        --green:#1bbb87;--green-dark:#159668;--green-glow:rgba(27,187,135,0.14);
        --bg:#181f2e;--bg2:#1e2738;--surface:#242f42;--surface2:#2c3a52;
        --border:rgba(255,255,255,0.08);--border-g:rgba(27,187,135,0.2);
        --muted:#8899b4;--text:#eef2f7;
        --font-d:'Plus Jakarta Sans',sans-serif;--font-b:'Nunito',sans-serif;
    }
    body{background:var(--bg);color:var(--text);font-family:var(--font-b);min-height:100vh;display:flex}
    /* SIDEBAR */
    .sidebar{width:260px;min-height:100vh;background:var(--bg2);border-right:1px solid var(--border);display:flex;flex-direction:column;position:fixed;top:0;left:0;z-index:50}
    .sidebar-logo{padding:22px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px}
    .logo-icon{width:36px;height:36px;background:var(--green);border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;font-size:17px;flex-shrink:0}
    .logo-text{font-family:var(--font-d);font-size:15px;font-weight:800;color:white;line-height:1.2}
    .logo-text small{font-family:var(--font-b);font-size:10px;color:var(--muted);font-weight:500;display:block}
    .user-card{margin:14px 12px;padding:12px;background:var(--surface);border:1px solid var(--border);border-radius:14px;display:flex;align-items:center;gap:10px;cursor:pointer;transition:0.2s}
    .user-card:hover{border-color:rgba(27,187,135,0.4)}
    .user-avatar{width:36px;height:36px;background:var(--green-glow);border:1px solid rgba(27,187,135,0.3);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--green);font-size:16px;flex-shrink:0}
    .user-name{font-size:13px;font-weight:700;color:white}
    .user-role{font-size:10px;color:var(--green);font-weight:700;text-transform:uppercase;letter-spacing:0.06em}
    .nav-section{padding:14px 12px 6px}
    .nav-label{font-size:10px;font-weight:700;color:var(--muted);letter-spacing:0.1em;text-transform:uppercase;padding:0 6px;margin-bottom:5px}
    .nav-item{display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;color:var(--muted);font-size:13px;font-weight:600;transition:0.2s;margin-bottom:2px;border:1px solid transparent;text-decoration:none}
    .nav-item i{font-size:17px;width:20px;text-align:center}
    .nav-item:hover{background:var(--surface);color:var(--text)}
    .nav-item.active{background:var(--green-glow);color:var(--green);border-color:rgba(27,187,135,0.2)}
    .sidebar-footer{margin-top:auto;padding:14px;border-top:1px solid var(--border)}
    .btn-logout{width:100%;padding:10px;background:transparent;border:1px solid var(--border);border-radius:10px;color:var(--muted);font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:0.2s;font-family:var(--font-b);text-decoration:none}
    .btn-logout:hover{background:rgba(239,68,68,0.08);border-color:rgba(239,68,68,0.3);color:#fca5a5}
    /* MAIN */
    .main-panel{margin-left:260px;flex:1;display:flex;flex-direction:column;min-height:100vh}
    .topbar{position:sticky;top:0;z-index:40;background:rgba(24,31,46,0.9);backdrop-filter:blur(16px);border-bottom:1px solid var(--border);padding:0 32px;height:60px;display:flex;align-items:center;justify-content:space-between}
    .topbar-title{font-family:var(--font-d);font-size:17px;font-weight:800;color:white}
    .topbar-time{font-size:12px;font-weight:700;color:var(--green)}
    .content{padding:28px 32px;flex:1}
    /* CARDS */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:20px;margin-bottom:18px}
    .card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px}
    .card-title{font-size:14px;font-weight:700;color:white;display:flex;align-items:center;gap:8px}
    .card-title i{color:var(--green)}
    .stat-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:14px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:18px;position:relative;overflow:hidden}
    .stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:var(--accent,var(--green))}
    .stat-label{font-size:10px;font-weight:700;color:var(--muted);letter-spacing:0.08em;text-transform:uppercase;margin-bottom:8px}
    .stat-value{font-family:var(--font-d);font-size:28px;font-weight:800;color:white;line-height:1;margin-bottom:3px}
    .stat-sub{font-size:11px;color:var(--muted)}
    .stat-icon{position:absolute;right:16px;top:16px;width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:17px;background:var(--green-glow);color:var(--green)}
    /* TABLE */
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse}
    thead tr{border-bottom:1px solid rgba(255,255,255,0.1)}
    th{padding:11px 12px;font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:0.07em;text-align:left;white-space:nowrap}
    td{padding:12px;font-size:13px;color:var(--text);border-bottom:1px solid var(--border);vertical-align:middle}
    tbody tr:last-child td{border-bottom:none}
    tbody tr:hover td{background:rgba(255,255,255,0.02)}
    .empty-row{text-align:center;padding:30px;color:var(--muted)}
    /* BADGE */
    .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:100px;font-size:10px;font-weight:700;white-space:nowrap}
    .bg-available{background:rgba(27,187,135,0.12);color:#1bbb87}
    .bg-rented{background:rgba(245,158,11,0.12);color:#f59e0b}
    .bg-maintenance,.bg-secondary{background:rgba(148,163,184,0.12);color:#94a3b8}
    .bg-danger{background:rgba(239,68,68,0.12);color:#f87171}
    .bg-process{background:rgba(59,130,246,0.12);color:#93c5fd}
    .bg-warning{background:rgba(245,158,11,0.12);color:#fbbf24}
    /* BUTTONS */
    .btn{padding:8px 14px;border-radius:8px;border:none;cursor:pointer;font-weight:700;font-size:12px;display:inline-flex;align-items:center;gap:6px;transition:0.2s;font-family:var(--font-b);text-decoration:none;white-space:nowrap}
    .btn-primary{background:var(--green);color:white}.btn-primary:hover{background:var(--green-dark)}
    .btn-danger{background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.2)}.btn-danger:hover{background:rgba(239,68,68,0.25)}
    .btn-ghost{background:var(--surface2);color:var(--muted);border:1px solid var(--border)}.btn-ghost:hover{color:var(--text)}
    .btn-warning{background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.2)}
    .btn-sm{padding:5px 10px;font-size:11px}
    /* FORMS */
    .form-group{margin-bottom:12px}
    .form-label{font-size:10px;font-weight:700;color:var(--muted);letter-spacing:0.06em;text-transform:uppercase;margin-bottom:5px;display:block}
    .form-input{width:100%;padding:10px 12px;background:var(--bg2);border:1px solid var(--border);border-radius:9px;color:var(--text);font-size:13px;outline:none;transition:0.2s;font-family:var(--font-b)}
    .form-input:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(27,187,135,0.1)}
    .form-input::placeholder{color:rgba(255,255,255,0.2)}
    /* MODAL */
    .modal-bg{position:fixed;inset:0;z-index:200;background:rgba(8,14,28,0.85);backdrop-filter:blur(10px);display:none;align-items:center;justify-content:center;padding:20px}
    .modal-bg.open{display:flex}
    .modal-box{background:var(--surface);border:1px solid rgba(255,255,255,0.1);border-radius:20px;width:100%;max-width:480px;max-height:90vh;overflow-y:auto;padding:28px;box-shadow:0 40px 80px rgba(0,0,0,0.5);animation:slideUp 0.3s ease}
    @keyframes slideUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
    .modal-title{font-family:var(--font-d);font-size:17px;margin-bottom:18px;color:white;font-weight:800}
    /* ALERT */
    .alert{padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:14px;font-weight:600;display:flex;align-items:center;gap:8px}
    .alert-success{background:rgba(27,187,135,0.1);border:1px solid rgba(27,187,135,0.25);color:#1bbb87}
    .alert-error{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);color:#f87171}
    /* MISC */
    .denda-text{color:#f87171;font-weight:700}
    /* Eye toggle password */
    .pass-wrap{position:relative}
    .pass-wrap .profil-input{padding-right:40px}
    .eye-btn{position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--muted);font-size:15px;display:flex;align-items:center;padding:0;transition:0.2s}
    .eye-btn:hover{color:var(--green)}
    input[type="datetime-local"],input[type="date"]{color-scheme:dark}
    input[type="datetime-local"]::-webkit-calendar-picker-indicator,
    input[type="date"]::-webkit-calendar-picker-indicator{filter:brightness(10) saturate(0);cursor:pointer;opacity:0.7}
    /* PROFIL OVERLAY */
    .profil-overlay{position:fixed;inset:0;z-index:300;background:rgba(8,14,28,0.88);backdrop-filter:blur(12px);display:none;align-items:center;justify-content:center;padding:20px}
    .profil-overlay.open{display:flex}
    .profil-box{background:var(--surface);border:1px solid var(--border-g);border-radius:20px;width:100%;max-width:440px;max-height:90vh;overflow-y:auto;padding:28px;box-shadow:0 40px 80px rgba(0,0,0,0.5);animation:slideUp 0.3s ease}
    .profil-input{width:100%;padding:10px 12px;background:var(--bg2);border:1px solid var(--border);border-radius:9px;color:var(--text);font-size:13px;outline:none;transition:0.2s;font-family:var(--font-b);margin-bottom:4px}
    .profil-input:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(27,187,135,0.1)}
    .profil-label{font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:0.06em;display:block;margin-bottom:5px}
    .profil-hint{font-size:11px;color:var(--muted);margin-bottom:12px}
    /* ── Papan pemberitahuan admin ── */
    .notif-board{background:linear-gradient(135deg,rgba(27,187,135,0.10),rgba(96,165,250,0.06));border:1px solid rgba(27,187,135,0.28);border-left:4px solid var(--green);border-radius:16px;padding:18px 22px;margin-bottom:22px}
    .notif-head{display:flex;align-items:center;gap:10px;margin-bottom:14px}
    .notif-head i{font-size:22px;color:var(--green)}
    .notif-title{font-family:var(--font-d);font-size:16px;font-weight:800;color:white}
    .notif-sub{font-size:11.5px;color:var(--muted);margin-top:2px}
    .notif-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:12px}
    .notif-card{display:flex;align-items:center;gap:13px;background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:13px 15px;text-decoration:none;transition:0.15s}
    .notif-card:hover{border-color:var(--green);transform:translateY(-2px)}
    .notif-ico{width:42px;height:42px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0}
    .notif-num{font-size:22px;font-weight:800;color:white;line-height:1}
    .notif-lbl{font-size:11.5px;color:var(--muted);margin-top:3px}
    .notif-badge{margin-left:auto;background:#ef4444;color:white;font-size:11px;font-weight:800;padding:3px 10px;border-radius:20px}

    /* ── Kotak kirim WhatsApp ── */
    .wa-box{position:fixed;inset:0;background:rgba(0,0,0,0.75);z-index:200;display:flex;align-items:center;justify-content:center;padding:20px}
    .wa-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;max-width:520px;width:100%;padding:26px;max-height:90vh;overflow-y:auto}
    .wa-ico{width:56px;height:56px;border-radius:50%;background:rgba(37,211,102,0.15);border:1px solid rgba(37,211,102,0.35);display:flex;align-items:center;justify-content:center;font-size:28px;color:#25D366;margin:0 auto 14px}
    .wa-prev{background:#0b1420;border:1px solid var(--border);border-radius:12px;padding:14px;font-size:12px;color:#cbd5e1;white-space:pre-wrap;line-height:1.65;max-height:230px;overflow-y:auto;margin:14px 0}
    .wa-send{display:flex;align-items:center;justify-content:center;gap:9px;background:#25D366;color:white;border:none;border-radius:11px;padding:13px;width:100%;font-size:14px;font-weight:800;text-decoration:none;cursor:pointer}
    .wa-send:hover{background:#1eb855}

    @yield('styles')
    </style>
</head>
<body>
<div class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="ti ti-motorbike"></i></div>
        <div class="logo-text">Beruang Motor<small>Premium Rental</small></div>
    </div>

    {{-- User card bisa diklik untuk edit profil --}}
    <div class="user-card" onclick="openProfilModal()" title="Klik untuk edit profil">
        <div class="user-avatar"><i class="ti ti-user"></i></div>
        <div style="flex:1;min-width:0">
            <div class="user-name" id="user-name-display">{{ session('user.name') }}</div>
            <div class="user-role">{{ session('user.role') === 'admin' ? 'Administrator' : 'Konsumen' }}</div>
        </div>
        <i class="ti ti-edit" style="font-size:13px;color:var(--green);opacity:0.7;flex-shrink:0"></i>
    </div>

    @if(session('user.role') === 'admin')
    <div class="nav-section">
        <div class="nav-label">Administrasi</div>
        <a href="{{ route('admin.dashboard') }}"    class="nav-item {{ request()->routeIs('admin.dashboard')    ? 'active' : '' }}"><i class="ti ti-layout-dashboard"></i> Dashboard</a>
        <a href="{{ route('admin.motor') }}"        class="nav-item {{ request()->routeIs('admin.motor*')       ? 'active' : '' }}"><i class="ti ti-motorbike"></i> Data Motor</a>
        <a href="{{ route('admin.konsumen') }}"     class="nav-item {{ request()->routeIs('admin.konsumen*')    ? 'active' : '' }}"><i class="ti ti-users"></i> Data Konsumen</a>
        <a href="{{ route('admin.transaksi') }}"    class="nav-item {{ request()->routeIs('admin.transaksi*')   ? 'active' : '' }}"><i class="ti ti-calendar-check"></i> Penyewaan</a>
        <a href="{{ route('admin.pengembalian') }}" class="nav-item {{ request()->routeIs('admin.pengembalian*')? 'active' : '' }}"><i class="ti ti-package-import"></i> Pengembalian</a>
        <a href="{{ route('admin.laporan') }}"      class="nav-item {{ request()->routeIs('admin.laporan*')     ? 'active' : '' }}"><i class="ti ti-file-analytics"></i> Laporan Rekap</a>
        <a href="{{ route('admin.akun.index') }}"   class="nav-item {{ request()->routeIs('admin.akun*')        ? 'active' : '' }}"><i class="ti ti-shield-lock"></i> Data Admin</a>
    </div>
    @else
    <div class="nav-section">
        <div class="nav-label">Menu Saya</div>
        <a href="{{ route('konsumen.katalog') }}" class="nav-item {{ request()->routeIs('konsumen.katalog') ? 'active' : '' }}"><i class="ti ti-motorbike"></i> Katalog Motor</a>
        <a href="{{ route('konsumen.riwayat') }}" class="nav-item {{ request()->routeIs('konsumen.riwayat') ? 'active' : '' }}"><i class="ti ti-history"></i> Transaksi Saya</a>
    </div>
    @endif

    <div class="sidebar-footer">
        <a href="{{ route('auth.logout') }}" class="btn-logout"><i class="ti ti-logout"></i> Logout</a>
    </div>
</div>

<div class="main-panel">
    <div class="topbar">
        <div class="topbar-title">@yield('page_title','Dashboard')</div>
        <div class="topbar-time" id="clock"></div>
    </div>
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
        @endif

        {{-- ── Papan pemberitahuan admin ── --}}
        @if(session('user.role') === 'admin' && ($notifTotal ?? 0) > 0)
            <div class="notif-board">
                <div class="notif-head">
                    <i class="ti ti-bell-ringing"></i>
                    <div>
                        <div class="notif-title">Menunggu Tindakan Anda</div>
                        <div class="notif-sub">Terdapat {{ $notifTotal }} hal yang perlu segera diproses</div>
                    </div>
                    <span class="notif-badge">{{ $notifTotal }}</span>
                </div>
                <div class="notif-grid">
                    @if(($notifDaftar ?? 0) > 0)
                    <a href="{{ route('admin.konsumen') }}" class="notif-card">
                        <div class="notif-ico" style="background:rgba(96,165,250,0.15);color:#60a5fa"><i class="ti ti-user-plus"></i></div>
                        <div>
                            <div class="notif-num">{{ $notifDaftar }}</div>
                            <div class="notif-lbl">Akun baru menunggu verifikasi</div>
                        </div>
                    </a>
                    @endif
                    @if(($notifPesanan ?? 0) > 0)
                    <a href="{{ route('admin.transaksi') }}" class="notif-card">
                        <div class="notif-ico" style="background:rgba(251,191,36,0.15);color:#fbbf24"><i class="ti ti-shopping-cart"></i></div>
                        <div>
                            <div class="notif-num">{{ $notifPesanan }}</div>
                            <div class="notif-lbl">Pemesanan motor baru</div>
                        </div>
                    </a>
                    @endif
                    @if(($notifPerpanjangan ?? 0) > 0)
                    <a href="{{ route('admin.transaksi') }}" class="notif-card">
                        <div class="notif-ico" style="background:rgba(167,139,250,0.15);color:#a78bfa"><i class="ti ti-calendar-plus"></i></div>
                        <div>
                            <div class="notif-num">{{ $notifPerpanjangan }}</div>
                            <div class="notif-lbl">Permintaan perpanjangan sewa</div>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
        @endif

        {{-- ── Kotak kirim notifikasi WhatsApp ke konsumen ── --}}
        @if(session('wa'))
            @php $wa = session('wa'); @endphp
            <div class="wa-box" id="wa-box">
                <div class="wa-card">
                    <div class="wa-ico"><i class="ti ti-brand-whatsapp"></i></div>
                    <div style="text-align:center">
                        <div style="font-family:var(--font-d);font-size:17px;font-weight:800;color:white">Notifikasi WhatsApp Siap Dikirim</div>
                        <div style="font-size:12.5px;color:var(--muted);margin-top:6px">
                            {{ $wa['judul'] }} &middot; kepada <b style="color:var(--text)">{{ $wa['nama'] }}</b> ({{ $wa['nomor'] }})
                        </div>
                    </div>
                    <div class="wa-prev">{{ $wa['pesan'] }}</div>
                    <a href="{{ $wa['tautan'] }}" target="_blank" class="wa-send" onclick="tutupWa()">
                        <i class="ti ti-send"></i> Buka WhatsApp &amp; Kirim
                    </a>
                    <button type="button" class="btn btn-ghost" style="width:100%;justify-content:center;margin-top:10px" onclick="tutupWa()">Lewati</button>
                </div>
            </div>
            <script>
                function tutupWa(){ var b=document.getElementById('wa-box'); if(b) b.style.display='none'; }
                // Coba buka WhatsApp otomatis. Bila diblokir peramban,
                // konsumen tetap bisa dikirimi lewat tombol di atas.
                window.addEventListener('load', function(){
                    var w = window.open(@json($wa['tautan']), '_blank');
                    if (w) { tutupWa(); }
                });
            </script>
        @endif
        @if($errors->any())
            <div class="alert alert-error"><i class="ti ti-alert-circle"></i> {{ $errors->first() }}</div>
        @endif
        @yield('content')
    </div>
</div>

{{-- ── MODAL EDIT PROFIL ─────────────────────────────────── --}}
<div class="profil-overlay" id="profil-overlay" onclick="closeProfilOverlay(event)">
    <div class="profil-box">
        {{-- Header --}}
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px">
            <div style="width:44px;height:44px;background:var(--green-glow);border:1px solid rgba(27,187,135,0.3);border-radius:12px;display:flex;align-items:center;justify-content:center;color:var(--green);font-size:20px;flex-shrink:0">
                <i class="ti ti-user-edit"></i>
            </div>
            <div>
                <div style="font-family:var(--font-d);font-size:17px;font-weight:800;color:white">Edit Profil</div>
                <div style="font-size:12px;color:var(--muted)">Perbarui data akun Anda</div>
            </div>
            <button onclick="closeProfilModal()" style="margin-left:auto;background:var(--surface2);border:1px solid var(--border);border-radius:8px;width:30px;height:30px;color:var(--muted);cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0">✕</button>
        </div>

        {{-- Alert --}}
        <div id="profil-alert" style="display:none;padding:10px 14px;border-radius:8px;font-size:13px;font-weight:600;margin-bottom:14px"></div>

        {{-- ── FORM KONSUMEN ── --}}
        @if(session('user.role') === 'konsumen')
        <div style="background:var(--bg2);border-radius:10px;padding:11px 13px;margin-bottom:16px;font-size:12px;color:var(--muted);display:flex;align-items:center;gap:8px">
            <i class="ti ti-lock" style="color:var(--green);flex-shrink:0"></i>
            <span><b style="color:var(--text)">NIK, Nama Lengkap, dan Foto KTP</b> tidak dapat diubah demi keamanan.</span>
        </div>

        <div class="form-group">
            <label class="profil-label">Username Baru</label>
            <input id="p-username" class="profil-input" type="text" placeholder="{{ session('user.username') }}">
            <div class="profil-hint">Kosongkan jika tidak ingin mengubah</div>
        </div>

        <div class="form-group">
            <label class="profil-label">Nomor WhatsApp Baru</label>
            <input id="p-wa" class="profil-input" type="tel" inputmode="numeric"
                   oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                   placeholder="{{ session('user.no_whatsapp') ?? 'Nomor WhatsApp' }}">
            <div class="profil-hint">Kosongkan jika tidak ingin mengubah</div>
        </div>

        <div style="background:var(--bg2);border:1px solid var(--border);border-radius:12px;padding:14px;margin-bottom:16px">
            <div style="font-size:10px;font-weight:800;color:var(--green);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:12px;display:flex;align-items:center;gap:6px">
                <i class="ti ti-lock-password"></i> Ganti Password
            </div>
            <div class="form-group">
                <label class="profil-label">Password Lama *</label>
                <div class="pass-wrap">
                    <input id="p-old-pass" class="profil-input" type="password" placeholder="Wajib diisi jika ganti password">
                    <button type="button" class="eye-btn" onclick="togglePass('p-old-pass',this)"><i class="ti ti-eye"></i></button>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <div class="form-group">
                    <label class="profil-label">Password Baru</label>
                    <div class="pass-wrap">
                        <input id="p-new-pass" class="profil-input" type="password" placeholder="Min. 4 karakter">
                        <button type="button" class="eye-btn" onclick="togglePass('p-new-pass',this)"><i class="ti ti-eye"></i></button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="profil-label">Konfirmasi</label>
                    <div class="pass-wrap">
                        <input id="p-confirm-pass" class="profil-input" type="password" placeholder="Ulangi password">
                        <button type="button" class="eye-btn" onclick="togglePass('p-confirm-pass',this)"><i class="ti ti-eye"></i></button>
                    </div>
                </div>
            </div>
            <div class="profil-hint">Kosongkan semua field password jika tidak ingin mengubah</div>
            <div style="font-size:11.5px;color:#fbbf24;margin-top:8px;display:flex;align-items:flex-start;gap:6px;line-height:1.55">
                <i class="ti ti-info-circle" style="flex-shrink:0;margin-top:1px"></i>
                <span>Lupa password lama? Segera hubungi admin untuk minta direset.@if($adminWa ?? null) <a href="https://wa.me/{{ $adminWa }}" target="_blank" style="color:#fbbf24;font-weight:700;text-decoration:underline">Chat Admin ({{ $adminKontak }})</a>@endif</span>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
            <button onclick="simpanProfil()" style="padding:11px;background:var(--green);color:white;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit;display:flex;align-items:center;justify-content:center;gap:6px">
                <i class="ti ti-check"></i> Simpan Perubahan
            </button>
            <button onclick="closeProfilModal()" style="padding:11px;background:var(--surface2);color:var(--muted);border:1px solid var(--border);border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit">
                Batal
            </button>
        </div>
        @endif

        {{-- ── FORM ADMIN ── --}}
        @if(session('user.role') === 'admin')
        @php
            // Dibaca langsung dari database, bukan dari session, supaya field-nya
            // tetap terisi benar walau sesi login-nya dibuat sebelum kolom
            // username ditambahkan.
            $adminAktif = \App\Models\Admin::find(session('user.id'));
        @endphp
        <div class="form-group">
            <label class="profil-label">Nama Tampilan</label>
            <input id="p-admin-nama" class="profil-input" type="text" value="{{ $adminAktif->nama_lengkap ?? session('user.name') }}">
            <div class="profil-hint">Nama yang tampil di sidebar</div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
            <div class="form-group">
                <label class="profil-label">Username</label>
                <input id="p-admin-username" class="profil-input" type="text" value="{{ $adminAktif->username ?? '' }}" autocomplete="off">
            </div>
            <div class="form-group">
                <label class="profil-label">Nomor HP</label>
                <input id="p-admin-hp" class="profil-input" type="text" value="{{ $adminAktif->no_hp ?? '' }}" inputmode="numeric" pattern="[0-9]*" autocomplete="off">
            </div>
        </div>
        <div class="profil-hint" style="margin-top:-8px;margin-bottom:16px">Login bisa pakai username atau nomor HP. Nomor HP hanya angka.</div>

        <div style="background:var(--bg2);border:1px solid var(--border);border-radius:12px;padding:14px;margin-bottom:16px">
            <div style="font-size:10px;font-weight:800;color:var(--green);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:12px;display:flex;align-items:center;gap:6px">
                <i class="ti ti-lock-password"></i> Ganti Password
            </div>
            <div class="form-group">
                <label class="profil-label">Password Lama *</label>
                <div class="pass-wrap">
                    <input id="p-admin-old" class="profil-input" type="password" placeholder="Wajib diisi jika ganti password">
                    <button type="button" class="eye-btn" onclick="togglePass('p-admin-old',this)"><i class="ti ti-eye"></i></button>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <div class="form-group">
                    <label class="profil-label">Password Baru</label>
                    <div class="pass-wrap">
                        <input id="p-admin-new" class="profil-input" type="password" placeholder="Min. 4 karakter">
                        <button type="button" class="eye-btn" onclick="togglePass('p-admin-new',this)"><i class="ti ti-eye"></i></button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="profil-label">Konfirmasi</label>
                    <div class="pass-wrap">
                        <input id="p-admin-confirm" class="profil-input" type="password" placeholder="Ulangi password">
                        <button type="button" class="eye-btn" onclick="togglePass('p-admin-confirm',this)"><i class="ti ti-eye"></i></button>
                    </div>
                </div>
            </div>
            <div class="profil-hint">Kosongkan semua field password jika tidak ingin mengubah</div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
            <button onclick="simpanProfilAdmin()" style="padding:11px;background:var(--green);color:white;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit;display:flex;align-items:center;justify-content:center;gap:6px">
                <i class="ti ti-check"></i> Simpan Perubahan
            </button>
            <button onclick="closeProfilModal()" style="padding:11px;background:var(--surface2);color:var(--muted);border:1px solid var(--border);border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit">
                Batal
            </button>
        </div>
        @endif
    </div>
</div>

<script>
// ── CLOCK ─────────────────────────────────────────────────
function updateClock(){document.getElementById('clock').innerText=new Date().toLocaleString('id-ID');}
updateClock();setInterval(updateClock,1000);

// ── GENERIC MODAL ─────────────────────────────────────────
function openModal(id){document.getElementById(id).classList.add('open');}
function closeModal(id){document.getElementById(id).classList.remove('open');}
document.addEventListener('keydown',e=>{
    if(e.key==='Escape'){
        document.querySelectorAll('.modal-bg.open').forEach(m=>m.classList.remove('open'));
        closeProfilModal();
    }
});

// ── TOGGLE SHOW/HIDE PASSWORD ────────────────────────────
function togglePass(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'ti ti-eye-off';
    } else {
        input.type = 'password';
        icon.className = 'ti ti-eye';
    }
}

// ── PROFIL MODAL ──────────────────────────────────────────
function openProfilModal(){
    document.getElementById('profil-overlay').classList.add('open');
    document.body.style.overflow='hidden';
    hideProfilAlert();
}
function closeProfilModal(){
    document.getElementById('profil-overlay').classList.remove('open');
    document.body.style.overflow='';
}
function closeProfilOverlay(e){
    if(e.target===document.getElementById('profil-overlay')) closeProfilModal();
}
function showProfilAlert(msg,type){
    const el=document.getElementById('profil-alert');
    el.innerText=msg;
    el.style.display='block';
    el.style.background =type==='ok'?'rgba(27,187,135,0.1)':'rgba(239,68,68,0.1)';
    el.style.border     =type==='ok'?'1px solid rgba(27,187,135,0.25)':'1px solid rgba(239,68,68,0.25)';
    el.style.color      =type==='ok'?'#1bbb87':'#f87171';
}
function hideProfilAlert(){
    const el=document.getElementById('profil-alert');
    if(el) el.style.display='none';
}

// ── SIMPAN PROFIL KONSUMEN ────────────────────────────────
async function simpanProfil(){
    hideProfilAlert();
    const payload={
        username    :document.getElementById('p-username')?.value.trim()||null,
        no_whatsapp :document.getElementById('p-wa')?.value.trim()||null,
        old_password:document.getElementById('p-old-pass')?.value||null,
        new_password:document.getElementById('p-new-pass')?.value||null,
        new_password_confirmation:document.getElementById('p-confirm-pass')?.value||null,
    };
    try{
        const res=await fetch('{{ route("profil.update") }}',{
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
            body:JSON.stringify(payload),
        });
        const json=await res.json();
        showProfilAlert(json.message,json.status);
        if(json.status==='ok'){
            if(json.name) document.getElementById('user-name-display').innerText=json.name;
            ['p-old-pass','p-new-pass','p-confirm-pass'].forEach(id=>{
                const el=document.getElementById(id);
                if(el) el.value='';
            });
        }
    }catch(e){
        showProfilAlert('Gagal terhubung ke server.','error');
    }
}

// ── SIMPAN PROFIL ADMIN ───────────────────────────────────
async function simpanProfilAdmin(){
    hideProfilAlert();
    const payload={
        nama        :document.getElementById('p-admin-nama')?.value.trim()||null,
        username    :document.getElementById('p-admin-username')?.value.trim()||null,
        no_hp       :document.getElementById('p-admin-hp')?.value.trim()||null,
        old_password:document.getElementById('p-admin-old')?.value||null,
        new_password:document.getElementById('p-admin-new')?.value||null,
        new_password_confirmation:document.getElementById('p-admin-confirm')?.value||null,
    };
    try{
        const res=await fetch('{{ route("profil.update.admin") }}',{
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
            body:JSON.stringify(payload),
        });
        const json=await res.json();
        showProfilAlert(json.message,json.status);
        if(json.status==='ok'){
            if(json.name) document.getElementById('user-name-display').innerText=json.name;
            ['p-admin-old','p-admin-new','p-admin-confirm'].forEach(id=>{
                const el=document.getElementById(id);
                if(el) el.value='';
            });
        }
    }catch(e){
        showProfilAlert('Gagal terhubung ke server.','error');
    }
}
</script>
@yield('scripts')
</body>
</html>
