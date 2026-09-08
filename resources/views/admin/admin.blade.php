@extends('layouts.app')
@section('title','Data Admin')
@section('page_title','Data Admin')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="ti ti-shield-lock"></i> Akun Admin</div>
        <button class="btn btn-primary" onclick="openModal('modal-tambah-admin')"><i class="ti ti-plus"></i> Tambah Admin</button>
    </div>

    <div class="table-wrap">
        <table>
            <thead><tr><th>Nama Lengkap</th><th>Username</th><th>No HP</th><th>Terdaftar Sejak</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($admins as $a)
                <tr>
                    <td>
                        <b>{{ $a->nama_lengkap }}</b>
                        @if($a->id === (session('user')['id'] ?? null))
                            <span class="badge bg-available" style="margin-left:6px;font-size:10px">Kamu</span>
                        @endif
                    </td>
                    <td><code style="background:var(--surface2);padding:2px 6px;border-radius:5px;font-size:12px">{{ $a->username }}</code></td>
                    <td>{{ $a->no_hp }}</td>
                    <td style="font-size:12px;color:var(--muted)">{{ $a->created_at?->format('d/m/Y') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.akun.destroy', $a->id) }}" onsubmit="return confirm('Hapus akun admin {{ $a->nama_lengkap }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="ti ti-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="empty-row">Belum ada akun admin</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Admin -->
<div class="modal-bg" id="modal-tambah-admin">
    <div class="modal-box">
        <div class="modal-title">Tambah Akun Admin</div>
        <form method="POST" action="{{ route('admin.akun.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input class="form-input" name="nama_lengkap" placeholder="Contoh: Budi Santoso" required>
            </div>
            <div class="form-group">
                <label class="form-label">Username</label>
                <input class="form-input" name="username" placeholder="Contoh: adminadit" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label class="form-label">Nomor HP</label>
                <input class="form-input" name="no_hp" placeholder="Contoh: 081234567890" pattern="[0-9]*" inputmode="numeric" required>
                <small style="color:var(--muted);font-size:11px">Cuma angka. Login bisa pakai username atau nomor HP.</small>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input class="form-input" type="password" name="password" placeholder="Min. 4 karakter" required>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <button class="btn btn-primary" type="submit"><i class="ti ti-plus"></i> Tambah</button>
                <button class="btn btn-ghost" type="button" onclick="closeModal('modal-tambah-admin')">Batal</button>
            </div>
        </form>
    </div>
</div>
@endsection
