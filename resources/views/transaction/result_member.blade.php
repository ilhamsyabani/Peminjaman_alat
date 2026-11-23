@foreach ($members as $member)
    <li class="app-result">
        @include('partials.avatar', ['name' => $member->name, 'photo' => $member->photo, 'size' => 44])
        <div class="flex-grow-1 min-w-0">
            <div class="fw-bold text-gray-900">{{ $member->name }}</div>
            <div class="small text-gray-500 text-truncate">{{ $member->identity_number }} · {{ $member->hp }}</div>
            <div class="mt-1">@include('partials.status', ['status' => $member->status, 'type' => 'member'])</div>
        </div>
        <form action="{{ url('/processmember') }}" method="POST">
            @csrf
            <input type="hidden" value="{{ $member->id }}" name="id">
            <input type="hidden" value="process" name="status">
            <button type="submit" class="btn btn-sm btn-gray-800" aria-label="Pilih {{ $member->name }}">Pilih</button>
        </form>
    </li>
@endforeach
