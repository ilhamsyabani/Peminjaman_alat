{{-- Kartu peminjam. Param: $member (nullable) --}}
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <h2 class="h6 text-gray-500 text-uppercase small fw-bold mb-3">Peminjam</h2>
        @if ($member)
            <div class="d-flex align-items-center gap-3 mb-3">
                @include('partials.avatar', ['name' => $member->name, 'photo' => $member->photo, 'size' => 56])
                <div class="min-w-0">
                    <a href="{{ route('members.show', $member) }}" class="h5 d-block mb-1 text-gray-900">{{ $member->name }}</a>
                    @include('partials.status', ['status' => $member->status, 'type' => 'member'])
                </div>
            </div>
            <dl class="app-dl app-dl--compact">
                <dt>No. identitas</dt><dd>{{ $member->identity_number }}</dd>
                <dt>No. HP</dt><dd>{{ $member->hp }}</dd>
                <dt>Email</dt><dd>{{ $member->email }}</dd>
                <dt>Alamat</dt><dd>{{ $member->address }}</dd>
            </dl>
        @else
            <p class="text-gray-500 mb-0">Data member sudah dihapus.</p>
        @endif
    </div>
</div>
