@extends('layouts.app')
@section('title','Pengembalian')
@section('page_title','Pengembalian Motor')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="ti ti-package-import"></i> Proses Pengembalian</div>
        <span class="badge bg-warning">Unit Aktif Disewa</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>ID Sewa</th><th>Kode Unit</th><th>Konsumen</th><th>Mulai Sewa</th><th>Deadline</th><th>Terlambat</th><th>Est. Denda</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($aktif as $r)
                <tr>
                    <td><b>{{ $r->nomor_sewa }}</b></td>
                    <td><span class="badge bg-process">{{ $r->motor->kode ?? '-' }}</span></td>
                    <td>{{ $r->konsumen->nama_lengkap ?? '-' }}</td>
                    <td style="font-size:12px;color:var(--green)">{{ $r->tanggal_mulai?->format('d/m/Y H:i') }}</td>
                    <td style="font-size:12px;color:#f87171">{{ $r->tanggal_selesai?->format('d/m/Y H:i') }}</td>
                    <td class="{{ $r->jam_terlambat > 0 ? 'denda-text' : '' }}">{{ $r->jam_terlambat }} Jam</td>
                    <td class="{{ $r->denda_estimasi > 0 ? 'denda-text' : '' }}">Rp {{ number_format($r->denda_estimasi,0,',','.') }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="openModal('modal-kembali-{{ $r->id }}')">
                            <i class="ti ti-package-import"></i> Proses Kembali
                        </button>

                        <div class="modal-bg" id="modal-kembali-{{ $r->id }}">
                            <div class="modal-box">
                                {{-- Header modal --}}
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px">
                                    <div>
                                        <div style="font-size:11px;color:var(--green);font-weight:700;text-transform:uppercase;margin-bottom:3px">Proses Pengembalian</div>
                                        <div style="font-size:18px;font-weight:800;color:white">{{ $r->nomor_sewa }}</div>
                                    </div>
                                    <button onclick="closeModal('modal-kembali-{{ $r->id }}')" style="background:var(--surface2);border:1px solid var(--border);border-radius:8px;width:32px;height:32px;color:var(--muted);cursor:pointer;font-size:16px">✕</button>
                                </div>

                                {{-- Info --}}
                                <div style="background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:14px;margin-bottom:14px;display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                    <div><div style="font-size:10px;font-weight:700;color:var(--muted);margin-bottom:3px">KONSUMEN</div><div style="font-weight:700">{{ $r->konsumen->nama_lengkap ?? '-' }}</div></div>
                                    <div><div style="font-size:10px;font-weight:700;color:var(--muted);margin-bottom:3px">MOTOR</div><div style="font-weight:700">{{ $r->motor->model ?? '-' }}</div></div>
                                    <div><div style="font-size:10px;font-weight:700;color:var(--muted);margin-bottom:3px">MULAI SEWA</div><div style="font-size:13px;color:#1bbb87">{{ $r->tanggal_mulai?->format('d/m/Y H:i') }}</div></div>
                                    <div><div style="font-size:10px;font-weight:700;color:var(--muted);margin-bottom:3px">DEADLINE</div><div style="font-size:13px;color:#f87171">{{ $r->tanggal_selesai?->format('d/m/Y H:i') }}</div></div>
                                    <div><div style="font-size:10px;font-weight:700;color:var(--muted);margin-bottom:3px">KETERLAMBATAN</div><div style="color:{{ $r->jam_terlambat > 0 ? '#f87171' : '#1bbb87' }};font-weight:700">{{ $r->jam_terlambat }} Jam {{ $r->jam_terlambat > 0 ? '(Terlambat)' : '(Tepat Waktu)' }}</div></div>
                                </div>

                                {{-- Denda --}}
                                <div style="background:{{ $r->denda_estimasi > 0 ? 'rgba(239,68,68,0.08)' : 'rgba(27,187,135,0.08)' }};border:1px solid {{ $r->denda_estimasi > 0 ? 'rgba(239,68,68,0.25)' : 'rgba(27,187,135,0.2)' }};border-radius:12px;padding:14px;margin-bottom:14px;display:flex;align-items:center;justify-content:space-between">
                                    <div>
                                        <div style="font-size:10px;font-weight:700;color:var(--muted);margin-bottom:3px">DENDA WAKTU</div>
                                        <div style="font-size:22px;font-weight:800;color:{{ $r->denda_estimasi > 0 ? '#f87171' : '#1bbb87' }}">Rp {{ number_format($r->denda_estimasi,0,',','.') }}</div>
                                    </div>
                                    <i class="ti ti-{{ $r->denda_estimasi > 0 ? 'clock-x' : 'clock-check' }}" style="font-size:32px;opacity:0.3"></i>
                                </div>

                                {{-- Form --}}
                                <form method="POST" action="{{ route('admin.pengembalian.proses', $r->id) }}">
                                    @csrf
                                    <div style="background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:14px;margin-bottom:14px">
                                        <div style="font-size:10px;font-weight:800;color:var(--green);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:12px"><i class="ti ti-tool"></i> KONDISI UNIT</div>
                                        <div style="font-size:10.5px;color:var(--muted);margin-bottom:12px;line-height:1.5"><i class="ti ti-info-circle"></i> Bila dipilih Ada Kerusakan, catatan ini otomatis tersimpan juga ke Riwayat Perawatan unit tersebut.</div>
                                        <div class="form-group">
                                            <label class="form-label">Status Kerusakan</label>
                                            <select class="form-input" name="damage_status" onchange="toggleDamage(this, '{{ $r->id }}')">
                                                <option value="tidak">✅ Tidak Ada Kerusakan</option>
                                                <option value="ya">⚠️ Ada Kerusakan</option>
                                            </select>
                                        </div>
                                        <div id="damage-{{ $r->id }}" style="display:none;display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                            <div class="form-group">
                                                <label class="form-label">Catatan Kerusakan</label>
                                                <input class="form-input" name="damage_note" placeholder="Contoh: Lampu pecah">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Biaya Kerusakan (Rp)</label>
                                                <input class="form-input" type="number" name="damage_cost" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                        <button class="btn btn-primary" type="submit" style="justify-content:center;padding:12px"><i class="ti ti-check"></i> Proses & Selesai</button>
                                        <button class="btn btn-ghost" type="button" style="justify-content:center;padding:12px" onclick="closeModal('modal-kembali-{{ $r->id }}')">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="empty-row">Tidak ada unit yang sedang disewa</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script>
function toggleDamage(sel, id) {
    document.getElementById('damage-' + id).style.display = sel.value === 'ya' ? 'grid' : 'none';
}
</script>
@endsection
