<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Beruang Motor — Rental Motor Premium</title>
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
    html{scroll-behavior:smooth}
    body{background:var(--bg);color:var(--text);font-family:var(--font-b);overflow-x:hidden}
    /* NAV */
    nav{position:fixed;top:0;left:0;right:0;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:16px 60px;background:rgba(24,31,46,0.88);backdrop-filter:blur(20px);border-bottom:1px solid var(--border)}
    .nav-logo{display:flex;align-items:center;gap:10px;font-family:var(--font-d);font-size:18px;font-weight:800;color:white;text-decoration:none}
    .bear-icon{width:36px;height:36px;background:var(--green);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px}
    .nav-btns{display:flex;gap:10px;align-items:center}
    .btn-nav{padding:8px 20px;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;text-decoration:none;transition:0.2s;display:inline-flex;align-items:center;gap:6px;font-family:var(--font-b);border:none}
    .btn-ghost-nav{background:rgba(255,255,255,0.06);color:var(--muted);border:1px solid var(--border)}
    .btn-ghost-nav:hover{border-color:var(--green);color:var(--green)}
    .btn-green-nav{background:var(--green);color:white}
    .btn-green-nav:hover{background:var(--green-dark)}
    /* HERO */
    .hero{min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:120px 20px 80px;position:relative;overflow:hidden}
    .hero::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.04) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 80% 70% at 50% 50%,black,transparent)}
    .hero::after{content:'';position:absolute;top:20%;left:50%;transform:translateX(-50%);width:600px;height:400px;background:radial-gradient(ellipse,rgba(27,187,135,0.15) 0%,transparent 70%);pointer-events:none}
    .hero-eyebrow{display:inline-flex;align-items:center;gap:8px;background:rgba(27,187,135,0.1);border:1px solid rgba(27,187,135,0.3);color:var(--green);padding:6px 16px;border-radius:100px;font-size:12px;font-weight:700;letter-spacing:0.05em;margin-bottom:26px;position:relative;z-index:1}
    .hero-dot{width:6px;height:6px;background:var(--green);border-radius:50%;animation:pulse 2s infinite}
    @keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:0.5;transform:scale(1.4)}}
    .hero h1{font-family:var(--font-d);font-size:clamp(38px,6vw,76px);font-weight:800;line-height:1.05;letter-spacing:-0.02em;margin-bottom:20px;position:relative;z-index:1}
    .hero h1 em{font-style:normal;color:var(--green)}
    .hero p{font-size:16px;color:var(--muted);max-width:500px;line-height:1.7;margin-bottom:36px;position:relative;z-index:1;font-weight:500}
    .hero-btns{display:flex;gap:12px;flex-wrap:wrap;justify-content:center;position:relative;z-index:1}
    .btn-hero-primary{padding:13px 30px;background:var(--green);color:white;border-radius:12px;font-size:14px;font-weight:700;text-decoration:none;border:none;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:0.25s;font-family:var(--font-b);box-shadow:0 0 30px rgba(27,187,135,0.3)}
    .btn-hero-primary:hover{background:var(--green-dark);transform:translateY(-2px);box-shadow:0 0 40px rgba(27,187,135,0.5)}
    .btn-hero-outline{padding:13px 30px;background:rgba(255,255,255,0.07);color:var(--text);border-radius:12px;font-size:14px;font-weight:700;text-decoration:none;border:1px solid var(--border);display:inline-flex;align-items:center;gap:8px;transition:0.25s;font-family:var(--font-b);cursor:pointer}
    .btn-hero-outline:hover{border-color:var(--green);color:var(--green);background:rgba(27,187,135,0.08)}
    /* STATS */
    .stats-strip{display:flex;margin-top:55px;background:var(--surface);border:1px solid var(--border);border-radius:16px;overflow:hidden;position:relative;z-index:1;box-shadow:0 8px 32px rgba(0,0,0,0.2)}
    .stat-item{padding:18px 36px;text-align:center;border-right:1px solid var(--border);flex:1}
    .stat-item:last-child{border-right:none}
    .stat-item b{display:block;font-family:var(--font-d);font-size:24px;font-weight:800;color:var(--green)}
    .stat-item span{font-size:11px;color:var(--muted);font-weight:600}
    /* SECTIONS */
    section{padding:80px 60px}
    .section-eyebrow{font-size:11px;font-weight:700;letter-spacing:0.12em;color:var(--green);text-transform:uppercase;margin-bottom:10px}
    .section-title{font-family:var(--font-d);font-size:clamp(26px,3.5vw,42px);font-weight:800;line-height:1.15;margin-bottom:12px;letter-spacing:-0.01em}
    .section-sub{color:var(--muted);font-size:15px;max-width:480px;line-height:1.6;font-weight:500}
    /* MOTOR CARDS */
    .motor-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(270px,1fr));gap:20px;margin-top:36px}
    .motor-card{background:var(--surface);border:1px solid var(--border);border-radius:18px;overflow:hidden;transition:0.3s;cursor:default}
    .motor-card:hover{border-color:var(--border-g);transform:translateY(-3px);box-shadow:0 16px 40px rgba(0,0,0,0.25)}
    .motor-card-img{width:100%;height:175px;object-fit:cover;background:var(--surface2);display:flex;align-items:center;justify-content:center;color:var(--green);font-size:55px}
    .motor-card-body{padding:18px}
    .motor-card-body h3{font-size:15px;font-weight:800;color:white;margin-bottom:3px}
    .motor-card-plate{font-size:11px;color:var(--muted);font-family:monospace;letter-spacing:0.08em;margin-bottom:10px}
    .motor-specs{background:var(--bg2);border-radius:9px;padding:9px 11px;font-size:11px;color:var(--muted);margin-bottom:12px;border:1px solid var(--border);line-height:1.6}
    .motor-footer{display:flex;align-items:center;justify-content:space-between}
    .motor-price{font-size:17px;font-weight:800;color:var(--green)}
    .motor-price span{font-size:11px;color:var(--muted);font-weight:400}
    .motor-price-group{display:flex;flex-direction:column;gap:3px}
    .motor-price-row{font-size:13px;font-weight:800;color:var(--green);display:flex;align-items:baseline;gap:5px;white-space:nowrap}
    .motor-price-row .tag{font-size:9px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:0.06em;min-width:60px}
    .motor-price-row span.unit{font-size:11px;color:var(--muted);font-weight:400}
    .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:100px;font-size:10px;font-weight:700;white-space:nowrap}
    .badge-avail{background:rgba(27,187,135,0.12);color:#1bbb87;border:1px solid rgba(27,187,135,0.2)}
    .badge-rented{background:rgba(245,158,11,0.12);color:#f59e0b;border:1px solid rgba(245,158,11,0.2)}
    .badge-maint{background:rgba(148,163,184,0.12);color:#94a3b8;border:1px solid rgba(148,163,184,0.2)}
    /* HOW SECTION */
    .how-section{background:var(--bg2)}
    .steps-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:14px;margin-top:40px}
    .step{background:var(--surface);padding:28px 22px;border-radius:16px;border:1px solid var(--border);box-shadow:0 4px 16px rgba(0,0,0,0.12);transition:0.2s;cursor:pointer;position:relative}
    .step:hover{border-color:var(--green);transform:translateY(-3px);box-shadow:0 12px 28px rgba(0,0,0,0.2)}
    .step-num{font-family:var(--font-d);font-size:42px;font-weight:800;color:rgba(27,187,135,0.1);line-height:1;margin-bottom:12px;letter-spacing:-0.04em}
    .step-icon{width:42px;height:42px;background:var(--green-glow);border:1px solid rgba(27,187,135,0.25);border-radius:12px;display:flex;align-items:center;justify-content:center;color:var(--green);font-size:19px;margin-bottom:12px}
    .step h4{font-size:14px;font-weight:800;margin-bottom:7px;color:white}
    .step p{font-size:12px;color:var(--muted);line-height:1.65;font-weight:500}
    .step-click-hint{position:absolute;bottom:14px;right:14px;font-size:10px;color:var(--green);font-weight:700;display:flex;align-items:center;gap:4px;opacity:0.7}
    /* TUTORIAL MODAL */
    .tutorial-overlay{position:fixed;inset:0;z-index:300;background:rgba(8,14,28,0.9);backdrop-filter:blur(14px);display:none;align-items:flex-start;justify-content:center;padding:20px;overflow-y:auto}
    .tutorial-overlay.open{display:flex}
    .tutorial-box{background:var(--surface);border:1px solid var(--border-g);border-radius:24px;width:100%;max-width:680px;margin:auto;box-shadow:0 40px 80px rgba(0,0,0,0.5);animation:slideUp 0.3s ease;overflow:hidden}
    @keyframes slideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:none}}
    .tutorial-header{padding:28px 28px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:16px}
    .tutorial-header-icon{width:52px;height:52px;background:var(--green-glow);border:1px solid rgba(27,187,135,0.3);border-radius:14px;display:flex;align-items:center;justify-content:center;color:var(--green);font-size:24px;flex-shrink:0}
    .tutorial-header h2{font-family:var(--font-d);font-size:20px;font-weight:800;color:white;margin-bottom:3px}
    .tutorial-header p{font-size:13px;color:var(--muted)}
    .tutorial-close{margin-left:auto;width:34px;height:34px;background:var(--surface2);border:1px solid var(--border);border-radius:9px;color:var(--muted);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px;transition:0.2s;flex-shrink:0}
    .tutorial-close:hover{color:#f87171;border-color:rgba(239,68,68,0.3)}
    .tutorial-body{padding:24px 28px}
    .tutorial-step{display:flex;gap:16px;margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid var(--border)}
    .tutorial-step:last-child{border-bottom:none;margin-bottom:0;padding-bottom:0}
    .tutorial-step-num{width:28px;height:28px;background:var(--green);border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;font-size:12px;font-weight:800;flex-shrink:0;margin-top:2px}
    .tutorial-step-content h4{font-size:14px;font-weight:800;color:white;margin-bottom:6px}
    .tutorial-step-content p{font-size:13px;color:var(--muted);line-height:1.65;margin-bottom:10px}
    .mockup-form{background:var(--bg2);border:1px solid var(--border);border-radius:12px;padding:14px;margin-top:10px}
    .mockup-form-title{font-size:10px;font-weight:800;color:var(--green);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:12px}
    .mockup-field{margin-bottom:10px}
    .mockup-label{font-size:10px;font-weight:700;color:var(--muted);display:block;margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em}
    .mockup-input{background:var(--surface2);border:1px solid var(--border);border-radius:8px;padding:8px 12px;color:var(--text);font-size:12px;display:block;width:100%}
    .mockup-input.filled{border-color:var(--green);color:var(--green)}
    .mockup-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
    .mockup-note{background:rgba(27,187,135,0.08);border:1px solid rgba(27,187,135,0.2);border-radius:8px;padding:10px 12px;font-size:12px;color:var(--green);margin-top:8px;display:flex;gap:8px;align-items:flex-start}
    .mockup-warn{background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);border-radius:8px;padding:10px 12px;font-size:12px;color:#fbbf24;margin-top:8px;display:flex;gap:8px;align-items:flex-start}
    .badge-status{display:inline-flex;align-items:center;padding:3px 10px;border-radius:100px;font-size:10px;font-weight:700}
    .tutorial-nav{padding:16px 28px;border-top:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;gap:10px}
    .btn-tutorial{padding:10px 20px;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:0.2s;border:none;font-family:var(--font-b)}
    .btn-tutorial-primary{background:var(--green);color:white}
    .btn-tutorial-primary:hover{background:var(--green-dark)}
    .btn-tutorial-ghost{background:var(--surface2);color:var(--muted);border:1px solid var(--border)}
    .btn-tutorial-ghost:hover{color:var(--text)}
    .tutorial-progress{display:flex;gap:6px}
    .tutorial-dot{width:8px;height:8px;border-radius:50%;background:var(--border);transition:0.2s}
    .tutorial-dot.active{background:var(--green);width:20px;border-radius:4px}
    /* WHY */
    .why-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:16px;margin-top:40px}
    .why-card{background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:24px 18px;transition:0.2s;box-shadow:0 4px 16px rgba(0,0,0,0.1)}
    .why-card:hover{border-color:var(--border-g);transform:translateY(-3px);box-shadow:0 10px 28px rgba(0,0,0,0.18)}
    .why-icon{width:44px;height:44px;background:var(--green-glow);border:1px solid rgba(27,187,135,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;color:var(--green);font-size:20px;margin-bottom:13px}
    .why-card h4{font-size:13px;font-weight:800;margin-bottom:6px;color:white}
    .why-card p{font-size:12px;color:var(--muted);line-height:1.65;font-weight:500}
    /* ATURAN SEWA */
    .rules-wrap{max-width:820px;margin:0 auto;display:flex;flex-direction:column;gap:10px}
    .rule-item{background:var(--surface);border:1px solid var(--border);border-radius:14px;overflow:hidden;transition:border-color 0.2s}
    .rule-item.open{border-color:var(--border-g)}
    .rule-head{width:100%;display:flex;align-items:center;justify-content:space-between;gap:12px;padding:16px 20px;background:none;border:none;cursor:pointer;text-align:left;font-family:var(--font-b)}
    .rule-head-left{display:flex;align-items:center;gap:12px;font-size:14.5px;font-weight:700;color:var(--text)}
    .rule-head-left i{color:var(--green);font-size:18px;flex-shrink:0;width:20px;text-align:center}
    .rule-chevron{color:var(--muted);font-size:16px;transition:transform 0.25s;flex-shrink:0}
    .rule-item.open .rule-chevron{transform:rotate(180deg);color:var(--green)}
    .rule-body{max-height:0;overflow:hidden;transition:max-height 0.3s ease}
    .rule-body-inner{padding:0 20px 18px 52px}
    .rule-body-inner ul{margin:0;padding:0;list-style:none;display:flex;flex-direction:column;gap:8px}
    .rule-body-inner li{font-size:13.5px;color:var(--muted);line-height:1.6;position:relative;padding-left:16px}
    .rule-body-inner li::before{content:'';position:absolute;left:0;top:8px;width:5px;height:5px;border-radius:50%;background:var(--green)}
    .rule-table{width:100%;border-collapse:collapse;font-size:12.5px;margin-top:2px}
    .rule-table th{text-align:left;color:var(--green);font-size:10px;text-transform:uppercase;letter-spacing:0.06em;padding:8px 10px;border-bottom:1px solid var(--border);font-weight:700}
    .rule-table td{padding:9px 10px;color:var(--muted);border-bottom:1px solid var(--border);line-height:1.5}
    .rule-table tr:last-child td{border-bottom:none}
    .rule-table td:first-child{color:var(--text);font-weight:600;white-space:nowrap}
    /* CTA */
    .cta-section{text-align:center;background:linear-gradient(135deg,var(--surface) 0%,var(--bg2) 100%);border-top:1px solid var(--border);border-bottom:1px solid var(--border)}
    /* FOOTER */
    footer{background:var(--bg2);border-top:1px solid var(--border);padding:32px 60px;text-align:center;color:var(--muted);font-size:13px;font-weight:500}
    footer .footer-logo{font-family:var(--font-d);font-size:17px;color:white;margin-bottom:7px;display:block;font-weight:800}
    /* AUTH MODAL */
    .auth-overlay{position:fixed;inset:0;z-index:200;background:rgba(8,14,28,0.8);backdrop-filter:blur(12px);display:none;align-items:center;justify-content:center;padding:20px}
    .auth-overlay.open{display:flex}
    .auth-box{background:var(--surface);border:1px solid rgba(255,255,255,0.1);border-radius:22px;width:100%;max-width:430px;padding:34px;position:relative;box-shadow:0 32px 80px rgba(0,0,0,0.4);animation:slideUp 0.3s ease;max-height:90vh;overflow-y:auto}
    @keyframes slideUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
    .auth-close{position:absolute;top:14px;right:14px;width:30px;height:30px;border-radius:8px;background:var(--surface2);border:1px solid var(--border);color:var(--muted);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;transition:0.2s}
    .auth-close:hover{color:#f87171;border-color:rgba(239,68,68,0.3)}
    .auth-icon{width:48px;height:48px;background:var(--green-glow);border:1px solid rgba(27,187,135,0.25);border-radius:13px;display:flex;align-items:center;justify-content:center;color:var(--green);font-size:21px;margin-bottom:14px}
    .auth-box h2{font-family:var(--font-d);font-size:20px;margin-bottom:4px;color:white;font-weight:800}
    .auth-box .auth-sub{font-size:12px;color:var(--muted);margin-bottom:20px;font-weight:500}

    .field-group{margin-bottom:12px}
    .field-label{font-size:10px;font-weight:700;color:var(--muted);letter-spacing:0.07em;margin-bottom:5px;display:block;text-transform:uppercase}
    .field-input{width:100%;padding:10px 12px;background:var(--bg2);border:1px solid var(--border);border-radius:9px;color:white;font-size:13px;outline:none;transition:0.2s;font-family:var(--font-b);font-weight:500}
    .field-input:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(27,187,135,0.1)}
    .field-input::placeholder{color:rgba(255,255,255,0.18)}
    .btn-auth{width:100%;padding:12px;background:var(--green);color:white;border:none;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;margin-top:6px;transition:0.2s;font-family:var(--font-b);display:flex;align-items:center;justify-content:center;gap:8px}
    .btn-auth:hover{background:var(--green-dark)}
    .auth-switch{text-align:center;margin-top:14px;font-size:12px;color:var(--muted);font-weight:500}
    .auth-switch a{color:var(--green);cursor:pointer;font-weight:700;text-decoration:none}
    .auth-switch a:hover{text-decoration:underline}
    .alert-form{padding:9px 13px;border-radius:8px;font-size:12px;margin-bottom:13px;font-weight:600;display:flex;align-items:center;gap:7px}
    .alert-success-form{background:rgba(27,187,135,0.1);border:1px solid rgba(27,187,135,0.25);color:#1bbb87}
    .alert-error-form{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);color:#f87171}
    .success-screen{text-align:center;display:none}
    .success-icon{width:60px;height:60px;background:var(--green-glow);border:1px solid rgba(27,187,135,0.3);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--green);font-size:26px;margin:0 auto 14px;animation:pop 0.4s cubic-bezier(0.175,0.885,0.32,1.275)}
    @keyframes pop{from{transform:scale(0)}to{transform:scale(1)}}
    @media(max-width:768px){nav{padding:12px 18px}section{padding:55px 18px}.stats-strip{flex-wrap:wrap}.stat-item{flex:1;min-width:120px}footer{padding:28px 18px}}
    /* Eye toggle password */
    .pass-wrap{position:relative}
    .pass-wrap .field-input{padding-right:40px}
    .eye-btn{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--muted);font-size:16px;display:flex;align-items:center;padding:0;transition:0.2s}
    .eye-btn:hover{color:var(--green)}
    </style>
</head>
<body>

{{-- NAV --}}
<nav>
    <a class="nav-logo" href="#"><div class="bear-icon"><i class="ti ti-motorbike"></i></div> Beruang Motor</a>
    <div class="nav-btns">
        <a class="btn-nav btn-ghost-nav" href="#katalog"><i class="ti ti-search"></i> Lihat Motor</a>
        @if($adminWa ?? null)
        <a class="btn-nav btn-ghost-nav" href="https://wa.me/{{ $adminWa }}" target="_blank" title="Hubungi admin lewat WhatsApp"><i class="ti ti-brand-whatsapp"></i> Hubungi Admin</a>
        @endif
        <button class="btn-nav btn-ghost-nav" onclick="openAuth('login')"><i class="ti ti-login"></i> Masuk</button>
        <button class="btn-nav btn-green-nav" onclick="openAuth('register')"><i class="ti ti-user-plus"></i> Daftar</button>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-eyebrow"><span class="hero-dot"></span> Rental Motor Premium · Bandung</div>
    <h1>Motor Keren,<br>Perjalanan <em>Tak Terlupakan</em></h1>
    <p>Sewa motor pilihan dengan harga terjangkau. Proses booking mudah, unit terawat, siap antar jemput.</p>
    <div class="hero-btns">
        <a class="btn-hero-primary" href="#katalog"><i class="ti ti-motorbike"></i> Lihat Semua Motor</a>
        <button class="btn-hero-outline" onclick="openAuth('register')"><i class="ti ti-user-plus"></i> Daftar Gratis</button>
    </div>
    <div class="stats-strip">
        <div class="stat-item"><b>{{ $motors->sum('jumlah_tersedia') }}</b><span>Unit Tersedia</span></div>
        <div class="stat-item"><b>Buka setiap hari dari jam 07.00 WIB - 21.00 WIB</b><span>Waktu Oprasional</span></div>
        <div class="stat-item"><b>100%</b><span>Motor Siap Dipakai</span></div>
    </div>
</section>

{{-- KATALOG --}}
<section id="katalog">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:16px;margin-bottom:0">
        <div>
            <div class="section-eyebrow">Armada Kami</div>
            <div class="section-title">Pilih Motor<br>Favoritmu</div>
            <p class="section-sub">Semua unit dicek rutin, siap pakai kapan saja.</p>
        </div>
        <button class="btn-hero-outline" onclick="openAuth('login')" style="align-self:flex-end">
            <i class="ti ti-login"></i> Login untuk Booking
        </button>
    </div>
    <div class="motor-grid">
        @forelse($motors as $m)
        <div class="motor-card">
            @if($m->foto)
                <img src="{{ $m->foto }}" class="motor-card-img" alt="{{ $m->model }}" style="display:block">
            @else
                <div class="motor-card-img"><i class="ti ti-motorbike"></i></div>
            @endif
            <div class="motor-card-body">
                <h3>{{ $m->model }}</h3>
                <div class="motor-card-plate">{{ $m->jumlah_tersedia }} dari {{ $m->jumlah_unit }} unit tersedia</div>
                <div class="motor-specs">{{ $m->spesifikasi ?: 'Info spesifikasi belum tersedia' }}</div>
                <div class="motor-footer">
                    <div class="motor-price-group">
                        <div class="motor-price-row"><span class="tag">Weekdays</span> Rp {{ number_format($m->tarif_weekday,0,',','.') }}<span class="unit">/hari</span></div>
                        <div class="motor-price-row"><span class="tag">Weekend</span> Rp {{ number_format($m->tarif_weekend,0,',','.') }}<span class="unit">/hari</span></div>
                    </div>
                    <span class="badge {{ $m->jumlah_tersedia > 0 ? 'badge-avail' : 'badge-rented' }}">{{ $m->jumlah_tersedia > 0 ? $m->jumlah_tersedia.' Tersedia' : 'Penuh' }}</span>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--muted)">
            <i class="ti ti-motorbike-off" style="font-size:48px;display:block;margin-bottom:12px"></i>
            Belum ada unit motor tersedia
        </div>
        @endforelse
    </div>
</section>

{{-- CARA SEWA --}}
<section class="how-section">
    <div style="max-width:500px">
        <div class="section-eyebrow">Cara Sewa</div>
        <div class="section-title">Proses Mudah <br>4 Langkah Saja</div>
        <p class="section-sub">Dari daftar hingga motor di tangan, semua dari HP.</p>
    </div>
    <div class="steps-grid">
        <div class="step" onclick="openTutorial(1)">
            <div class="step-num">01</div>
            <div class="step-icon"><i class="ti ti-user-plus"></i></div>
            <h4>Daftar & Verifikasi</h4>
            <p>Buat akun dengan KTP, tunggu verifikasi admin dalam 1×24 jam.</p>
            <div class="step-click-hint"><i class="ti ti-info-circle"></i> Klik untuk panduan</div>
        </div>
        <div class="step" onclick="openTutorial(2)">
            <div class="step-num">02</div>
            <div class="step-icon"><i class="ti ti-calendar-check"></i></div>
            <h4>Pilih & Booking</h4>
            <p>Pilih motor, tentukan tanggal, bayar DP via transfer.</p>
            <div class="step-click-hint"><i class="ti ti-info-circle"></i> Klik untuk panduan</div>
        </div>
        <div class="step" onclick="openTutorial(3)">
            <div class="step-num">03</div>
            <div class="step-icon"><i class="ti ti-motorbike"></i></div>
            <h4>Ambil atau Diantar</h4>
            <p>Ambil di tempat sewa atau minta diantar ke alamat Anda.</p>
            <div class="step-click-hint"><i class="ti ti-info-circle"></i> Klik untuk panduan</div>
        </div>
        <div class="step" onclick="openTutorial(4)">
            <div class="step-num">04</div>
            <div class="step-icon"><i class="ti ti-package-import"></i></div>
            <h4>Kembalikan</h4>
            <p>Kembalikan tepat waktu atau ajukan perpanjangan via aplikasi.</p>
            <div class="step-click-hint"><i class="ti ti-info-circle"></i> Klik untuk panduan</div>
        </div>
    </div>
</section>

{{-- ── TUTORIAL MODALS ─────────────────────────────────── --}}
<div class="tutorial-overlay" id="tutorial-overlay" onclick="closeTutorialOverlay(event)">
    <div class="tutorial-box" id="tutorial-box">

        {{-- HEADER --}}
        <div class="tutorial-header">
            <div class="tutorial-header-icon" id="tut-icon"><i class="ti ti-user-plus"></i></div>
            <div>
                <h2 id="tut-title">Daftar & Verifikasi</h2>
                <p id="tut-sub">Langkah 1 dari 4</p>
            </div>
            <button class="tutorial-close" onclick="closeTutorial()"><i class="ti ti-x"></i></button>
        </div>

        {{-- BODY --}}
        <div class="tutorial-body" id="tut-body">
            {{-- Diisi oleh JS --}}
        </div>

        {{-- NAVIGATION --}}
        <div class="tutorial-nav">
            <button class="btn-tutorial btn-tutorial-ghost" id="btn-prev" onclick="prevTutorial()">
                <i class="ti ti-arrow-left"></i> Sebelumnya
            </button>
            <div class="tutorial-progress">
                <div class="tutorial-dot active" id="dot-1"></div>
                <div class="tutorial-dot" id="dot-2"></div>
                <div class="tutorial-dot" id="dot-3"></div>
                <div class="tutorial-dot" id="dot-4"></div>
            </div>
            <button class="btn-tutorial btn-tutorial-primary" id="btn-next" onclick="nextTutorial()">
                Selanjutnya <i class="ti ti-arrow-right"></i>
            </button>
        </div>
    </div>
</div>

{{-- WHY US --}}
<section>
    <div style="text-align:center;max-width:480px;margin:0 auto">
        <div class="section-eyebrow">Kenapa Kami</div>
        <div class="section-title">Rental yang Bisa Dipercaya</div>
    </div>
    <div class="why-grid">
        <div class="why-card"><div class="why-icon"><i class="ti ti-shield-check"></i></div><h4>Unit Bergaransi</h4><p>Setiap motor dicek mekanik sebelum diserahkan ke konsumen.</p></div>
        <div class="why-card"><div class="why-icon"><i class="ti ti-map-pin"></i></div><h4>Antar Jemput</h4><p>Layanan pengantaran dan penjemputan ke seluruh area Bandung.</p></div>
        <div class="why-card"><div class="why-icon"><i class="ti ti-clock"></i></div><h4>Denda Per Jam</h4><p>Denda keterlambatan dihitung per jam, adil dan transparan.</p></div>
        <div class="why-card"><div class="why-icon"><i class="ti ti-headset"></i></div><h4>Support Aktif</h4><p>Tim kami siap membantu melalui WhatsApp kapan pun.</p></div>
        <div class="why-card"><div class="why-icon"><i class="ti ti-receipt"></i></div><h4>Laporan Lengkap</h4><p>Riwayat sewa dan tagihan tersedia transparan di akun Anda.</p></div>
        <div class="why-card"><div class="why-icon"><i class="ti ti-trending-up"></i></div><h4>Perpanjangan Mudah</h4><p>Butuh lebih lama? Ajukan perpanjangan langsung dari aplikasi.</p></div>
    </div>
</section>

{{-- ATURAN SEWA --}}
<section id="aturan">
    <div style="text-align:center;max-width:560px;margin:0 auto 40px">
        <div class="section-eyebrow">Wajib Dibaca</div>
        <div class="section-title">Peraturan Penyewaan Motor</div>
        <p class="section-sub">Pahami dulu ketentuan berikut sebelum melakukan penyewaan, biar sama-sama nyaman.</p>
    </div>

    <div class="rules-wrap">

        <div class="rule-item">
            <button type="button" class="rule-head" onclick="toggleRule(this)">
                <span class="rule-head-left"><i class="ti ti-id-badge-2"></i> Persyaratan Penyewa</span>
                <i class="ti ti-chevron-down rule-chevron"></i>
            </button>
            <div class="rule-body"><div class="rule-body-inner"><ul>
                <li>Berusia minimal 17 tahun.</li>
                <li>Memiliki KTP yang masih berlaku.</li>
                <li>Memiliki SIM C yang masih berlaku.</li>
                <li>Bersedia memberikan identitas tambahan apabila diperlukan (misalnya KTM, NPWP, kartu pegawai, atau akun media sosial).</li>
            </ul></div></div>
        </div>

        <div class="rule-item">
            <button type="button" class="rule-head" onclick="toggleRule(this)">
                <span class="rule-head-left"><i class="ti ti-clipboard-list"></i> Proses Penyewaan</span>
                <i class="ti ti-chevron-down rule-chevron"></i>
            </button>
            <div class="rule-body"><div class="rule-body-inner"><ul>
                <li>Penyewa wajib mendaftar dan harus mengisi formulir pendaftaran akun terlebih dahulu.</li>
                <li>Melakukan pembayaran biaya sewa sesuai tarif yang berlaku.</li>
                <li>Membayar uang jaminan (deposit) apabila ditentukan oleh pihak rental.</li>
                <li>Menandatangani perjanjian sewa sebelum kendaraan diserahkan.</li>
            </ul></div></div>
        </div>

         <div class="rule-item">
            <button type="button" class="rule-head" onclick="toggleRule(this)">
                <span class="rule-head-left"><i class="ti ti-calendar-check"></i> Sistem Booking</span>
                <i class="ti ti-chevron-down rule-chevron"></i>
            </button>
            <div class="rule-body"><div class="rule-body-inner"><ul>
                <li>Booking dianggap belum aktif sampai penyewa melakukan pembayaran DP.</li>
                <li>Menunggu admin melakukan pengecekan dan konfirmasi booking.</li>
                <li>Setelah pembayaran berhasil diverifikasi, sistem akan mengubah status menjadi Diterima. Banyak penyedia rental juga menerapkan pembayaran uang muka (DP) untuk mengamankan unit sebelum hari penyewaan.</li>
                <li>Pembatalan sebelum batas waktu tertentu (misalnya 24 jam sebelum pengambilan) dapat memperoleh pengembalian dana sesuai kebijakan.</li>
                <li>Pembatalan mendadak dapat menyebabkan DP hangus.</li>
                <li>Jika penyedia membatalkan karena unit tidak tersedia, seluruh pembayaran dikembalikan kepada penyewa. Beberapa penyedia menetapkan refund penuh jika pembatalan dilakukan jauh sebelum waktu sewa, misalnya minimal 48 jam sebelumnya.</li>
            </ul></div></div>
        </div>

        <div class="rule-item">
            <button type="button" class="rule-head" onclick="toggleRule(this)">
                <span class="rule-head-left"><i class="ti ti-motorbike"></i> Ketentuan Penggunaan Kendaraan</span>
                <i class="ti ti-chevron-down rule-chevron"></i>
            </button>
            <div class="rule-body"><div class="rule-body-inner"><ul>
                <li>Kendaraan hanya boleh digunakan oleh penyewa yang terdaftar.</li>
                <li>Dilarang meminjamkan atau menyewakan kembali motor kepada pihak lain.</li>
                <li>Kendaraan hanya digunakan untuk keperluan yang sah dan tidak melanggar hukum.</li>
                <li>Dilarang mengikuti balapan liar, membawa muatan berlebih, atau melakukan modifikasi pada kendaraan.</li>
                <li>Penyewa wajib mematuhi seluruh peraturan lalu lintas yang berlaku, termasuk memiliki SIM yang sesuai dan menggunakan helm.</li>
            </ul></div></div>
        </div>

        <div class="rule-item">
            <button type="button" class="rule-head" onclick="toggleRule(this)">
                <span class="rule-head-left"><i class="ti ti-calendar-time"></i> Jangka Waktu Sewa</span>
                <i class="ti ti-chevron-down rule-chevron"></i>
            </button>
            <div class="rule-body"><div class="rule-body-inner"><ul>
                <li>Masa sewa dihitung sejak kendaraan diterima hingga waktu pengembalian yang telah disepakati.</li>
                <li>Keterlambatan pengembalian dikenakan denda sesuai ketentuan rental.</li>
                <li>Perpanjangan masa sewa harus dikonfirmasi sebelum masa sewa berakhir.</li>
            </ul></div></div>
        </div>

        <div class="rule-item">
            <button type="button" class="rule-head" onclick="toggleRule(this)">
                <span class="rule-head-left"><i class="ti ti-gas-station"></i> Bahan Bakar</span>
                <i class="ti ti-chevron-down rule-chevron"></i>
            </button>
            <div class="rule-body"><div class="rule-body-inner"><ul>
                <li>Kendaraan dikembalikan dengan jumlah bahan bakar yang sama seperti saat diterima atau sesuai kesepakatan.</li>
                <li>Apabila tidak sesuai, penyewa dikenakan biaya pengisian bahan bakar.</li>
            </ul></div></div>
        </div>

        <div class="rule-item">
            <button type="button" class="rule-head" onclick="toggleRule(this)">
                <span class="rule-head-left"><i class="ti ti-alert-triangle"></i> Kerusakan dan Kecelakaan</span>
                <i class="ti ti-chevron-down rule-chevron"></i>
            </button>
            <div class="rule-body"><div class="rule-body-inner"><ul>
                <li>Penyewa bertanggung jawab atas kerusakan yang terjadi akibat kelalaian selama masa sewa.</li>
                <li>Apabila terjadi kecelakaan, penyewa wajib segera menghubungi pihak rental.</li>
                <li>Penyewa tidak diperbolehkan memperbaiki kendaraan tanpa persetujuan pihak rental.</li>
            </ul></div></div>
        </div>

        <div class="rule-item">
            <button type="button" class="rule-head" onclick="toggleRule(this)">
                <span class="rule-head-left"><i class="ti ti-shield-x"></i> Kehilangan Kendaraan</span>
                <i class="ti ti-chevron-down rule-chevron"></i>
            </button>
            <div class="rule-body"><div class="rule-body-inner"><ul>
                <li>Kehilangan kendaraan akibat kelalaian penyewa menjadi tanggung jawab penyewa sesuai isi perjanjian.</li>
                <li>Kehilangan STNK, kunci, atau aksesori kendaraan dikenakan biaya penggantian sesuai nilai yang berlaku.</li>
            </ul></div></div>
        </div>

        <div class="rule-item">
            <button type="button" class="rule-head" onclick="toggleRule(this)">
                <span class="rule-head-left"><i class="ti ti-ban"></i> Larangan</span>
                <i class="ti ti-chevron-down rule-chevron"></i>
            </button>
            <div class="rule-body"><div class="rule-body-inner"><ul>
                <li>Dilarang menggunakan kendaraan untuk tindak kriminal.</li>
                <li>Dilarang membawa kendaraan ke luar wilayah yang telah ditentukan tanpa izin.</li>
                <li>Dilarang menggadaikan, menjual, atau memindahtangankan kendaraan kepada pihak lain.</li>
            </ul></div></div>
        </div>

        <div class="rule-item">
            <button type="button" class="rule-head" onclick="toggleRule(this)">
                <span class="rule-head-left"><i class="ti ti-clipboard-check"></i> Pengembalian Kendaraan</span>
                <i class="ti ti-chevron-down rule-chevron"></i>
            </button>
            <div class="rule-body"><div class="rule-body-inner"><ul>
                <li>Kendaraan dikembalikan dalam kondisi bersih dan lengkap beserta STNK, helm, jas hujan, dan perlengkapan lainnya.</li>
                <li>Pihak rental akan melakukan pemeriksaan kondisi kendaraan sebelum transaksi dinyatakan selesai.</li>
            </ul></div></div>
        </div>

        <div class="rule-item">
            <button type="button" class="rule-head" onclick="toggleRule(this)">
                <span class="rule-head-left"><i class="ti ti-gavel"></i> Sanksi</span>
                <i class="ti ti-chevron-down rule-chevron"></i>
            </button>
            <div class="rule-body"><div class="rule-body-inner"><ul>
                <li>Keterlambatan dikenakan denda per jam atau per hari.</li>
                <li>Pelanggaran terhadap perjanjian sewa dapat mengakibatkan penyewaan dihentikan tanpa pengembalian biaya sewa.</li>
                <li>Penyewa bertanggung jawab atas seluruh tilang, pajak parkir, atau biaya lain yang timbul selama masa penyewaan.</li>
            </ul></div></div>
        </div>

        <div class="rule-item">
            <button type="button" class="rule-head" onclick="toggleRule(this)">
                <span class="rule-head-left"><i class="ti ti-receipt-2"></i> Contoh Besaran Denda <span style="color:var(--muted);font-weight:400;font-size:12px">(Opsional)</span></span>
                <i class="ti ti-chevron-down rule-chevron"></i>
            </button>
            <div class="rule-body"><div class="rule-body-inner" style="padding-left:20px">
                <table class="rule-table">
                    <thead><tr><th>Pelanggaran</th><th>Denda Umum</th></tr></thead>
                    <tbody>
                        <tr><td>Terlambat pengembalian</td><td>Rp15.000/jam</td></tr>
                        <tr><td>Kehilangan helm</td><td>Rp150.000–Rp300.000</td></tr>
                        <tr><td>Kehilangan STNK</td><td>Biaya pengurusan STNK baru</td></tr>
                        <tr><td>Kehilangan kunci</td><td>Sesuai biaya penggantian</td></tr>
                        <tr><td>Tangki BBM kurang</td><td>Sesuai biaya pengisian + biaya layanan</td></tr>
                    </tbody>
                </table>
            </div></div>
        </div>

    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="section-title">Siap Berangkat?</div>
    <p class="section-sub" style="margin:0 auto 30px">Daftar sekarang dan nikmati pengalaman sewa motor yang mudah dan terpercaya.</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
        <button class="btn-hero-primary" onclick="openAuth('register')"><i class="ti ti-user-plus"></i> Daftar Sekarang</button>
        <button class="btn-hero-outline" onclick="openAuth('login')"><i class="ti ti-login"></i> Sudah Punya Akun</button>
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <span class="footer-logo"><i class="ti ti-motorbike"></i> Beruang Motor</span>
    <p>Rental Motor Premium · Bandung · Indonesia</p>
    <p style="margin-top:6px">© {{ date('Y') }} Beruang Motor. All rights reserved.</p>
</footer>

{{-- AUTH MODAL --}}
<div class="auth-overlay" id="auth-overlay">
    <div class="auth-box">
        <button class="auth-close" onclick="closeAuth()"><i class="ti ti-x"></i></button>

        {{-- LOGIN --}}
        <div id="panel-login">
            <div class="auth-icon"><i class="ti ti-login"></i></div>
            <h2>Selamat Datang</h2>
            <p class="auth-sub">Masuk sebagai Admin atau Konsumen — sistem akan mendeteksi otomatis.</p>
            @if(session('error'))
                <div class="alert-form alert-error-form"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
                @if((session('error') ?? '') && str_contains(session('error'), 'divalidasi'))
                    <div style="text-align:center;margin-bottom:14px">@if($adminWa ?? null)<a href="https://wa.me/{{ $adminWa }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;margin-top:12px;background:#25D366;color:white;padding:9px 16px;border-radius:9px;text-decoration:none;font-weight:700;font-size:12.5px"><i class="ti ti-brand-whatsapp"></i> Chat Admin — {{ $adminKontak }}</a>@endif</div>
                @endif
            @endif
            <form method="POST" action="{{ route('auth.login') }}">
                @csrf
                <div class="field-group">
                    <label class="field-label">Username / WhatsApp</label>
                    <input class="field-input" name="user" placeholder="Contoh: admin atau 0812xxxx" required>
                </div>
                <div class="field-group">
                    <label class="field-label">Password</label>
                    <div class="pass-wrap">
                        <input class="field-input" type="password" id="login-pass-input" name="pass" placeholder="••••••••" required>
                        <button type="button" class="eye-btn" onclick="togglePass('login-pass-input', this)">
                            <i class="ti ti-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn-auth"><i class="ti ti-login"></i> Masuk</button>
            </form>
            <div class="auth-switch">Belum punya akun? <a onclick="openAuth('register')">Daftar sekarang</a></div>
        </div>

        {{-- REGISTER --}}
        <div id="panel-register" style="display:none">
            <div class="success-screen" id="reg-success">
                <div class="success-icon"><i class="ti ti-check"></i></div>
                <h2 style="font-family:var(--font-d);margin-bottom:6px">Pendaftaran Berhasil!</h2>
                <p class="auth-sub" style="margin-bottom:8px">Akun menunggu validasi admin. Biasanya selesai dalam 1×24 jam.</p>
                <div style="margin-bottom:16px">@if($adminWa ?? null)<a href="https://wa.me/{{ $adminWa }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;margin-top:12px;background:#25D366;color:white;padding:9px 16px;border-radius:9px;text-decoration:none;font-weight:700;font-size:12.5px"><i class="ti ti-brand-whatsapp"></i> Chat Admin — {{ $adminKontak }}</a>@endif</div>
                <button class="btn-auth" onclick="openAuth('login')"><i class="ti ti-login"></i> Masuk ke Akun</button>
            </div>
            <div id="reg-form-wrap">
                <div class="auth-icon"><i class="ti ti-user-plus"></i></div>
                <h2>Buat Akun</h2>
                <p class="auth-sub">Lengkapi data sesuai KTP untuk verifikasi identitas.</p>
                @if(session('reg_error'))
                    <div class="alert-form alert-error-form"><i class="ti ti-alert-circle"></i> {{ session('reg_error') }}</div>
                @endif
                <form method="POST" action="{{ route('auth.register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="field-group"><label class="field-label">Username</label><input class="field-input" name="username" placeholder="Username unik" required></div>
                    <div class="field-group"><label class="field-label">Nama Lengkap (sesuai KTP)</label><input class="field-input" name="nama_lengkap" placeholder="Nama lengkap" required></div>
                    <div class="field-group"><label class="field-label">NIK KTP (16 Digit)</label><input class="field-input" name="nik" placeholder="3201xxxxxxxxxxxxxx" maxlength="16" inputmode="numeric" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required></div>
                    <div class="field-group"><label class="field-label">Foto KTP</label><input class="field-input" type="file" name="foto_ktp" accept="image/*" required style="padding:7px;cursor:pointer"></div>
                    <div class="field-group"><label class="field-label">Nomor WhatsApp</label><input class="field-input" name="no_whatsapp" id="reg-wa" placeholder="0812xxxx" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required></div>
                    <div class="field-group">
                        <label class="field-label">Password</label>
                        <div class="pass-wrap">
                            <input class="field-input" type="password" id="reg-pass-input" name="password" placeholder="Min. 4 karakter" required>
                            <button type="button" class="eye-btn" onclick="togglePass('reg-pass-input', this)">
                                <i class="ti ti-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn-auth"><i class="ti ti-user-plus"></i> Daftar Sekarang</button>
                </form>
                <div class="auth-switch">Sudah punya akun? <a onclick="openAuth('login')">Masuk di sini</a></div>
            </div>
        </div>
    </div>
</div>

<script>
// ── ACCORDION ATURAN SEWA ────────────────────────────
function toggleRule(btn) {
    const item   = btn.closest('.rule-item');
    const body   = item.querySelector('.rule-body');
    const isOpen = item.classList.contains('open');

    // tutup item lain yang lagi kebuka (accordion satu-per-satu)
    document.querySelectorAll('.rule-item.open').forEach(el => {
        if (el !== item) {
            el.classList.remove('open');
            el.querySelector('.rule-body').style.maxHeight = null;
        }
    });

    if (isOpen) {
        item.classList.remove('open');
        body.style.maxHeight = null;
    } else {
        item.classList.add('open');
        body.style.maxHeight = body.scrollHeight + 'px';
    }
}

function openAuth(mode) {
    document.getElementById('auth-overlay').classList.add('open');
    document.getElementById('panel-login').style.display    = mode === 'login'    ? 'block' : 'none';
    document.getElementById('panel-register').style.display = mode === 'register' ? 'block' : 'none';
}
function closeAuth() { document.getElementById('auth-overlay').classList.remove('open'); }
document.getElementById('auth-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeAuth();
});
// tab switcher dihapus - login sudah 1 form
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

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeAuth();
        closeTutorial();
    }
});

// ── TUTORIAL SYSTEM ───────────────────────────────────────
let currentTutorial = 1;

const tutorials = {
    1: {
        icon: 'ti ti-user-plus',
        title: 'Daftar & Verifikasi Akun',
        sub: 'Langkah 1 dari 4 — Membuat akun baru',
        content: `
            <div class="tutorial-step">
                <div class="tutorial-step-num">1</div>
                <div class="tutorial-step-content">
                    <h4>Klik tombol "Daftar" di pojok kanan atas</h4>
                    <p>Pada halaman utama, klik tombol hijau <b>Daftar</b> di navigasi atas, atau tombol <b>Daftar Gratis</b> di bagian hero. Modal form pendaftaran akan muncul di tengah layar.</p>
                    <div class="mockup-form">
                        <div class="mockup-form-title">Tampilan Tombol</div>
                        <div style="display:flex;gap:8px">
                            <div class="mockup-input" style="flex:1;opacity:0.5">Masuk</div>
                            <div class="mockup-input filled" style="flex:1;text-align:center;background:var(--green);color:white;border-color:var(--green)">✦ Daftar</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tutorial-step">
                <div class="tutorial-step-num">2</div>
                <div class="tutorial-step-content">
                    <h4>Isi form pendaftaran dengan lengkap</h4>
                    <p>Lengkapi semua field berikut dengan data yang valid sesuai KTP Anda.</p>
                    <div class="mockup-form">
                        <div class="mockup-form-title">Form Pendaftaran</div>
                        <div class="mockup-field"><label class="mockup-label">Username *</label><div class="mockup-input">Contoh: budi123 (bebas, tidak bisa diubah)</div></div>
                        <div class="mockup-field"><label class="mockup-label">Nama Lengkap * (sesuai KTP)</label><div class="mockup-input">Contoh: Budi Santoso</div></div>
                        <div class="mockup-field"><label class="mockup-label">NIK KTP * (16 digit angka)</label><div class="mockup-input">Contoh: 3201010101010001</div></div>
                        <div class="mockup-field"><label class="mockup-label">Foto KTP * (jpg/png, maks 5MB)</label><div class="mockup-input">Pilih file foto KTP yang jelas terbaca</div></div>
                        <div class="mockup-grid">
                            <div class="mockup-field"><label class="mockup-label">Nomor WhatsApp *</label><div class="mockup-input">Contoh: 08123456789</div></div>
                            <div class="mockup-field"><label class="mockup-label">Password * (min 4 karakter)</label><div class="mockup-input">••••••••</div></div>
                        </div>
                        <div class="mockup-warn"><i class="ti ti-alert-triangle" style="flex-shrink:0;margin-top:1px"></i> Pastikan foto KTP jelas, tidak blur, dan semua tulisan terbaca!</div>
                    </div>
                </div>
            </div>
            <div class="tutorial-step">
                <div class="tutorial-step-num">3</div>
                <div class="tutorial-step-content">
                    <h4>Klik "Daftar Sekarang" dan tunggu verifikasi</h4>
                    <p>Setelah form terisi lengkap, klik tombol <b>Daftar Sekarang</b>. Akun Anda akan langsung dibuat namun belum bisa digunakan sampai diverifikasi oleh Admin.</p>
                    <div class="mockup-note"><i class="ti ti-clock" style="flex-shrink:0;margin-top:1px"></i> Verifikasi admin biasanya selesai dalam <b>1×24 jam</b>. Setelah diverifikasi, Anda akan bisa login dan mulai booking motor.@if($adminKontak ?? null) Bila lebih dari itu belum juga diverifikasi, hubungi admin di <b>{{ $adminKontak }}</b>.@endif</div>
                </div>
            </div>`
    },
    2: {
        icon: 'ti ti-calendar-check',
        title: 'Pilih Motor & Booking',
        sub: 'Langkah 2 dari 4 — Melakukan pemesanan motor',
        content: `
            <div class="tutorial-step">
                <div class="tutorial-step-num">1</div>
                <div class="tutorial-step-content">
                    <h4>Login ke akun Anda</h4>
                    <p>Klik tombol <b>Masuk</b> di navigasi atas. Masukkan username/WhatsApp dan password, lalu klik <b>Masuk</b>. Sistem otomatis mengarahkan ke halaman Katalog Motor.</p>
                    <div class="mockup-form">
                        <div class="mockup-form-title">Form Login</div>
                        <div class="mockup-field"><label class="mockup-label">Username / WhatsApp</label><div class="mockup-input filled">budi123</div></div>
                        <div class="mockup-field"><label class="mockup-label">Password</label><div class="mockup-input">••••••••</div></div>
                    </div>
                </div>
            </div>
            <div class="tutorial-step">
                <div class="tutorial-step-num">2</div>
                <div class="tutorial-step-content">
                    <h4>Pilih motor di halaman Katalog</h4>
                    <p>Setelah login, Anda masuk ke halaman <b>Katalog Motor</b>. Pilih motor yang diinginkan — pastikan statusnya <span class="badge-status" style="background:rgba(27,187,135,0.15);color:#1bbb87">Tersedia</span>. Klik tombol <b>Booking Sekarang</b>.</p>
                    <div class="mockup-form">
                        <div class="mockup-form-title">Kartu Motor</div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                            <div><div style="font-weight:800;font-size:13px;color:white">Honda Vario 160</div><div style="font-size:11px;color:var(--muted)">B 1234 ABC</div></div>
                            <span class="badge-status" style="background:rgba(27,187,135,0.15);color:#1bbb87">Tersedia</span>
                        </div>
                        <div style="font-size:13px;font-weight:800;color:var(--green);margin-bottom:10px">Rp 100.000 <span style="color:var(--muted);font-weight:400;font-size:11px">/hari</span></div>
                        <div class="mockup-input filled" style="text-align:center;background:var(--green);color:white;border-color:var(--green)">📅 Booking Sekarang</div>
                    </div>
                </div>
            </div>
            <div class="tutorial-step">
                <div class="tutorial-step-num">3</div>
                <div class="tutorial-step-content">
                    <h4>Isi form booking secara lengkap</h4>
                    <p>Form booking muncul. Isi semua bagian berikut:</p>
                    <div class="mockup-form">
                        <div class="mockup-form-title">Form Booking Motor</div>
                        <div class="mockup-grid">
                            <div class="mockup-field"><label class="mockup-label">📅 Tanggal Mulai *</label><div class="mockup-input">21/07/2026 09:00</div></div>
                            <div class="mockup-field"><label class="mockup-label">📅 Tanggal Selesai *</label><div class="mockup-input">22/07/2026 09:00</div></div>
                        </div>
                        <div class="mockup-field"><label class="mockup-label">Opsi Pengantaran *</label><div class="mockup-input">Ambil di Tempat Sewa / Antar ke Alamat</div></div>
                        <div class="mockup-field"><label class="mockup-label">Opsi Pengembalian *</label><div class="mockup-input">Kembalikan ke Tempat Sewa / Jemput di Alamat</div></div>
                        <div class="mockup-grid">
                            <div class="mockup-field"><label class="mockup-label">Nominal DP * (min Rp 50.000)</label><div class="mockup-input filled">50000</div></div>
                            <div class="mockup-field"><label class="mockup-label">Bukti Transfer * (foto)</label><div class="mockup-input">Upload foto bukti transfer</div></div>
                        </div>
                        <div class="mockup-note"><i class="ti ti-coin" style="flex-shrink:0;margin-top:1px"></i> Total biaya terhitung <b>otomatis</b> per hari berdasarkan tanggal yang dipilih, memakai tarif weekday atau weekend sesuai harinya.</div>
                        <div class="mockup-warn"><i class="ti ti-alert-triangle" style="flex-shrink:0;margin-top:1px"></i> DP wajib ditransfer dulu sebelum booking. Upload foto bukti transfernya!</div>
                    </div>
                </div>
            </div>
            <div class="tutorial-step">
                <div class="tutorial-step-num">4</div>
                <div class="tutorial-step-content">
                    <h4>Tunggu konfirmasi Admin</h4>
                    <p>Setelah booking dikirim, Admin akan memeriksa bukti transfer dan mengkonfirmasi pesanan. Status booking bisa dicek di menu <b>Transaksi Saya</b>.</p>
                    <div style="display:flex;gap:8px;margin-top:8px">
                        <span class="badge-status" style="background:rgba(245,158,11,0.12);color:#fbbf24">⏳ Pending</span>
                        <span style="color:var(--muted);font-size:12px;margin-top:2px">→ menunggu konfirmasi admin</span>
                    </div>
                    <div style="display:flex;gap:8px;margin-top:6px">
                        <span class="badge-status" style="background:rgba(27,187,135,0.12);color:#1bbb87">✓ Diterima</span>
                        <span style="color:var(--muted);font-size:12px;margin-top:2px">→ booking dikonfirmasi, motor siap</span>
                    </div>
                </div>
            </div>`
    },
    3: {
        icon: 'ti ti-motorbike',
        title: 'Ambil atau Minta Diantar',
        sub: 'Langkah 3 dari 4 — Pengambilan motor',
        content: `
            <div class="tutorial-step">
                <div class="tutorial-step-num">1</div>
                <div class="tutorial-step-content">
                    <h4>Cek status booking di Transaksi Saya</h4>
                    <p>Setelah login, buka menu <b>Transaksi Saya</b> di sidebar kiri. Pastikan status booking sudah berubah menjadi <span class="badge-status" style="background:rgba(59,130,246,0.12);color:#93c5fd">Diterima</span> sebelum datang ke tempat sewa. Status akan berubah menjadi <span class="badge-status" style="background:rgba(27,187,135,0.12);color:#1bbb87">Aktif</span> setelah motor diserahkan kepada Anda.</p>
                    <div class="mockup-form">
                        <div class="mockup-form-title">Transaksi Saya</div>
                        <div style="display:flex;justify-content:space-between;align-items:center">
                            <div><div style="font-weight:800;font-size:13px;color:white">BR-1234</div><div style="font-size:11px;color:var(--muted)">Honda Vario 160</div></div>
                            <span class="badge-status" style="background:rgba(27,187,135,0.12);color:#1bbb87">Aktif</span>
                        </div>
                        <div style="margin-top:8px;font-size:11px;color:var(--muted)">Mulai: 21/07/2026 09:00 &nbsp;·&nbsp; Deadline: 22/07/2026 09:00</div>
                    </div>
                </div>
            </div>
            <div class="tutorial-step">
                <div class="tutorial-step-num">2</div>
                <div class="tutorial-step-content">
                    <h4>Opsi A — Ambil sendiri di tempat sewa</h4>
                    <p>Jika memilih <b>"Ambil di Tempat Sewa"</b> saat booking, datanglah ke tempat sewa Beruang Motor sesuai tanggal dan jam mulai sewa. Tunjukkan ID booking (contoh: BR-1234) kepada petugas. Setelah pengecekan, motor langsung diserahkan.</p>
                    <div class="mockup-note"><i class="ti ti-map-pin" style="flex-shrink:0;margin-top:1px"></i> Bawa <b>KTP asli</b> saat mengambil motor sebagai verifikasi identitas.</div>
                </div>
            </div>
            <div class="tutorial-step">
                <div class="tutorial-step-num">3</div>
                <div class="tutorial-step-content">
                    <h4>Opsi B — Minta diantar ke alamat</h4>
                    <p>Jika memilih <b>"Antar ke Alamat"</b> saat booking, petugas kami akan mengantar motor ke alamat yang sudah Anda isi di form booking. Pastikan Anda ada di lokasi pada jam yang disepakati.</p>
                    <div class="mockup-form">
                        <div class="mockup-form-title">Alamat Pengantaran Anda</div>
                        <div class="mockup-field"><div class="mockup-input filled">Jl. Merdeka No. 10, Bandung</div></div>
                        <div class="mockup-warn"><i class="ti ti-alert-triangle" style="flex-shrink:0;margin-top:1px"></i> Alamat harus lengkap dan akurat. Siapkan sisa pembayaran (total dikurangi DP) saat motor tiba.</div>
                    </div>
                </div>
            </div>
            <div class="tutorial-step">
                <div class="tutorial-step-num">4</div>
                <div class="tutorial-step-content">
                    <h4>Cek kondisi motor sebelum digunakan</h4>
                    <p>Sebelum motor dibawa, periksa kondisi fisiknya bersama petugas — pastikan tidak ada kerusakan yang sudah ada sebelumnya. Hal ini penting agar tidak terjadi sengketa saat pengembalian.</p>
                    <div class="mockup-note"><i class="ti ti-shield-check" style="flex-shrink:0;margin-top:1px"></i> Semua unit sudah dicek mekanik sebelum diserahkan. Jika ada masalah teknis saat digunakan, segera hubungi Admin via WhatsApp @if($adminKontak ?? null)di <b>{{ $adminKontak }}</b>@endif.</div>
                </div>
            </div>`
    },
    4: {
        icon: 'ti ti-package-import',
        title: 'Pengembalian Motor',
        sub: 'Langkah 4 dari 4 — Proses pengembalian',
        content: `
            <div class="tutorial-step">
                <div class="tutorial-step-num">1</div>
                <div class="tutorial-step-content">
                    <h4>Perhatikan batas waktu (deadline) pengembalian</h4>
                    <p>Pantau terus deadline pengembalian di menu <b>Transaksi Saya</b>. Jika terlambat, sistem akan menghitung denda otomatis sebesar <b>Rp 15.000 per jam</b> keterlambatan.</p>
                    <div class="mockup-form">
                        <div class="mockup-form-title">Transaksi Saya — Denda Berjalan</div>
                        <div style="display:flex;justify-content:space-between;align-items:center">
                            <div style="font-size:12px;color:var(--muted)">Deadline: 22/07/2026 09:00</div>
                            <div style="color:#f87171;font-weight:800;font-size:13px">Denda: Rp 45.000</div>
                        </div>
                        <div style="font-size:11px;color:var(--muted);margin-top:4px">Terlambat 3 jam × Rp 15.000/jam</div>
                    </div>
                </div>
            </div>
            <div class="tutorial-step">
                <div class="tutorial-step-num">2</div>
                <div class="tutorial-step-content">
                    <h4>Butuh lebih lama? Ajukan perpanjangan</h4>
                    <p>Jika perlu waktu tambahan, klik tombol <b>Perpanjang</b> di halaman Transaksi Saya sebelum deadline habis. Masukkan jumlah hari tambahan yang diinginkan dan kirim permintaan.</p>
                    <div class="mockup-form">
                        <div class="mockup-form-title">Form Perpanjangan</div>
                        <div class="mockup-field"><label class="mockup-label">Tambah Hari Sewa *</label><div class="mockup-input filled">2</div></div>
                        <div class="mockup-note"><i class="ti ti-coin" style="flex-shrink:0;margin-top:1px"></i> Biaya perpanjangan mengikuti tarif harian motor (weekday/weekend). Perpanjangan perlu disetujui oleh Admin terlebih dahulu.</div>
                    </div>
                </div>
            </div>
            <div class="tutorial-step">
                <div class="tutorial-step-num">3</div>
                <div class="tutorial-step-content">
                    <h4>Kembalikan motor sesuai opsi yang dipilih</h4>
                    <p>Kembalikan motor sesuai opsi yang dipilih saat booking:</p>
                    <div style="margin-top:8px;display:flex;flex-direction:column;gap:8px">
                        <div class="mockup-note"><i class="ti ti-building" style="flex-shrink:0;margin-top:1px"></i> <b>Kembalikan ke Tempat Sewa</b> — Antar sendiri motor ke tempat sewa Beruang Motor sebelum atau tepat waktu deadline.</div>
                        <div class="mockup-note"><i class="ti ti-map-pin" style="flex-shrink:0;margin-top:1px"></i> <b>Jemput di Alamat</b> — Petugas datang menjemput motor ke alamat Anda. Pastikan ada di lokasi saat petugas tiba.</div>
                    </div>
                </div>
            </div>
            <div class="tutorial-step">
                <div class="tutorial-step-num">4</div>
                <div class="tutorial-step-content">
                    <h4>Pengecekan kondisi & pembayaran akhir</h4>
                    <p>Petugas akan mengecek kondisi motor saat dikembalikan. Grand total dihitung otomatis oleh sistem:</p>
                    <div class="mockup-form">
                        <div class="mockup-form-title">Rincian Tagihan Akhir</div>
                        <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:6px"><span style="color:var(--muted)">Sewa Pokok (1 hari)</span><span>Rp 100.000</span></div>
                        <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:6px"><span style="color:var(--muted)">Denda Keterlambatan</span><span style="color:#f87171">Rp 0</span></div>
                        <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:6px"><span style="color:var(--muted)">Biaya Kerusakan</span><span style="color:#f87171">Rp 0</span></div>
                        <div style="display:flex;justify-content:space-between;font-size:13px;font-weight:800;border-top:1px solid var(--border);padding-top:8px;margin-top:4px"><span style="color:white">Grand Total</span><span style="color:var(--green)">Rp 100.000</span></div>
                        <div style="display:flex;justify-content:space-between;font-size:12px;margin-top:4px"><span style="color:var(--muted)">Sudah dibayar (DP)</span><span style="color:var(--green)">- Rp 50.000</span></div>
                        <div style="display:flex;justify-content:space-between;font-size:13px;font-weight:800;margin-top:4px"><span style="color:white">Sisa Bayar</span><span style="color:#fbbf24">Rp 50.000</span></div>
                    </div>
                    <div class="mockup-note" style="margin-top:10px"><i class="ti ti-circle-check" style="flex-shrink:0;margin-top:1px"></i> Setelah pembayaran lunas, status penyewaan berubah menjadi <b>Selesai</b> dan riwayat tersimpan di akun Anda.</div>
                </div>
            </div>`
    }
};

function openTutorial(step) {
    currentTutorial = step;
    renderTutorial();
    document.getElementById('tutorial-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeTutorial() {
    document.getElementById('tutorial-overlay').classList.remove('open');
    document.body.style.overflow = '';
}

function closeTutorialOverlay(e) {
    if (e.target === document.getElementById('tutorial-overlay')) closeTutorial();
}

function renderTutorial() {
    const t = tutorials[currentTutorial];
    document.getElementById('tut-icon').innerHTML  = '<i class="' + t.icon + '"></i>';
    document.getElementById('tut-title').innerText = t.title;
    document.getElementById('tut-sub').innerText   = t.sub;
    document.getElementById('tut-body').innerHTML  = t.content;

    // Update dots
    for (let i = 1; i <= 4; i++) {
        document.getElementById('dot-' + i).classList.toggle('active', i === currentTutorial);
    }

    // Update buttons
    document.getElementById('btn-prev').style.visibility = currentTutorial === 1 ? 'hidden' : 'visible';
    const btnNext = document.getElementById('btn-next');
    if (currentTutorial === 4) {
        btnNext.innerHTML = '<i class="ti ti-check"></i> Selesai';
        btnNext.onclick = closeTutorial;
    } else {
        btnNext.innerHTML = 'Selanjutnya <i class="ti ti-arrow-right"></i>';
        btnNext.onclick = nextTutorial;
    }

    // Scroll to top
    document.getElementById('tutorial-box').scrollTop = 0;
}

function nextTutorial() {
    if (currentTutorial < 4) { currentTutorial++; renderTutorial(); }
}
function prevTutorial() {
    if (currentTutorial > 1) { currentTutorial--; renderTutorial(); }
}

// Auto-buka modal berdasarkan session
@if(session('open_modal') === 'login' || session('error'))
    document.addEventListener('DOMContentLoaded', () => openAuth('login'));
@endif
@if(session('open_modal') === 'register')
    document.addEventListener('DOMContentLoaded', () => {
        openAuth('register');
        @if(session('reg_success'))
            document.getElementById('reg-form-wrap').style.display = 'none';
            document.getElementById('reg-success').style.display   = 'block';
        @endif
    });
@endif
</script>
</body>
</html>
