{{-- Avatar inisial lokal (tanpa layanan pihak ketiga). Param: $name, $size (px, opsional), $photo (path storage, opsional) --}}
@php
    $size = $size ?? 36;
    $initials = collect(preg_split('/\s+/', trim($name ?? '?')))->filter()->take(2)
        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('') ?: '?';
    $hue = crc32($name ?? '') % 360;
    $hasPhoto = !empty($photo) && \Illuminate\Support\Facades\Storage::disk('public')->exists($photo);
@endphp
@if ($hasPhoto)
    <img src="{{ asset('storage/' . $photo) }}" alt="" class="app-avatar" width="{{ $size }}" height="{{ $size }}"
        style="width:{{ $size }}px;height:{{ $size }}px" loading="lazy">
@else
    <span class="app-avatar" aria-hidden="true"
        style="width:{{ $size }}px;height:{{ $size }}px;font-size:{{ round($size * 0.38) }}px;background:hsl({{ $hue }} 45% 92%);color:hsl({{ $hue }} 45% 30%)">{{ $initials }}</span>
@endif
