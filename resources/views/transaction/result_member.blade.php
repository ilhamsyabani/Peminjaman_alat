@foreach ($members as $member)
    <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
        <div class="d-flex flex-column px-4 col-3">
            <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->image }}">
        </div>
        <div class="d-flex flex-column">
            <h6 style="font-size: 14px;">{{ $member->name }}</h6>
            <span style="font-size: 12px;" class="mb-0 text-xs">No handphone: <span
                    class="text-dark font-weight-bold ms-sm-2">{{ $member->hp }}</span></span>
            <span style="font-size: 12px;" class="mb-0 text-xs">Email: <span
                    class="text-dark ms-sm-2 font-weight-bold">{{ $member->email }}</span></span>
            <span style="font-size: 12px;" class="text-xs">Alamat: <span
                    class="text-dark ms-sm-2 font-weight-bold">{{ $member->address }}</span></span>
            <form action="{{ url('/processmember') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $member->id }}" name="id">
                <input type="hidden" value="process" name="status">
                <button type="submit" class="btn btn-sm btn-gray-800 align-items-center mt-2">tambah</button>
            </form>

        </div>
    </li>
@endforeach
