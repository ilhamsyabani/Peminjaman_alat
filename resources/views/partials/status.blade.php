{{-- Badge status. Param: $status, $type: member|transaction|item|product --}}
@php
    $map = [
        'member' => [
            'tidak_ada' => ['Tidak meminjam', 'neutral'],
            'process' => ['Sedang diproses', 'info'],
            'meminjam' => ['Sedang meminjam', 'warning'],
        ],
        'transaction' => [
            'diproses' => ['Menunggu persetujuan', 'warning'],
            'disetujui' => ['Dipinjam', 'info'],
            'selesai' => ['Selesai', 'success'],
        ],
        'item' => [
            'diproses' => ['Dipinjam', 'info'],
            'selesai' => ['Dikembalikan', 'success'],
        ],
        'product' => [
            'tersedia' => ['Tersedia', 'success'],
            'process' => ['Dipilih di dashboard', 'info'],
            'menunggu persetujuan' => ['Dipinjam', 'warning'],
            'kosong' => ['Tidak tersedia', 'neutral'],
        ],
    ];
    $key = trim((string) $status);
    [$label, $tone] = $map[$type][$key] ?? [ucfirst(str_replace('_', ' ', $key)) ?: '—', 'neutral'];
@endphp
<span class="app-badge app-badge--{{ $tone }}">{{ $label }}</span>
