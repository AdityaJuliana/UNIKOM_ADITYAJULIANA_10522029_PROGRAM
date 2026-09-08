@extends('layouts.app')
@section('title','Data Konsumen')
@section('page_title','Data Konsumen')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="ti ti-users"></i> Data Konsumen Terdaftar</div>
        <span class="badge bg-process">{{ $konsumens->count() }} Akun</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Nama Lengkap</th>
                    <th>NIK</th>
                    <th>WhatsApp</th>
                    <th>Foto KTP</th>
                    <th>Valid</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($konsumens as $k)
                <tr>
                    <td><b>{{ $k->username }}</b></td>
                    <td>
                        <code style="background:var(--surface2);color:var(--green);padding:3px 8px;border-radius:6px;border:1px solid var(--border);font-size:12px">
                            {{ $k->password }}
                        </code>
                    </td>
                    <td>{{ $k->nama_lengkap }}</td>
                    <td style="font-family:monospace;font-size:12px">{{ $k->nik }}</td>
                    <td>{{ $k->no_whatsapp }}</td>
                    <td>
                        <a href="{{ route('admin.konsumen.ktp', $k->username) }}" class="btn btn-ghost btn-sm">
                            <i class="ti ti-id"></i> Lihat KTP
                        </a>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.konsumen.validasi', $k->username) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                style="background:none;border:none;cursor:pointer;font-size:20px"
                                title="{{ $k->is_validated ? 'Batalkan Validasi' : 'Validasi Akun' }}">
                                {{ $k->is_validated ? '✅' : '⬜' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap">
                            {{-- Riwayat --}}
                            <a href="{{ route('admin.konsumen.riwayat', $k->username) }}" class="btn btn-primary btn-sm">
                                <i class="ti ti-history"></i> Riwayat
                            </a>

                            {{-- Reset Password --}}
                            <form method="POST" action="{{ route('admin.konsumen.reset-password', $k->username) }}"
                                  onsubmit="return confirm('Reset password {{ $k->nama_lengkap }} ke \'12345\'?\n\nKonsumen harus segera mengganti password setelah login.')">
                                @csrf @method('PATCH')
                                <button class="btn btn-warning btn-sm" title="Reset Password ke 12345">
                                    <i class="ti ti-key"></i> Reset PW
                                </button>
                            </form>

                            {{-- Hapus --}}
                            <form method="POST" action="{{ route('admin.konsumen.destroy', $k->username) }}"
                                  onsubmit="return confirm('Hapus akun {{ $k->username }} secara permanen?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="empty-row">Belum ada konsumen terdaftar</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
