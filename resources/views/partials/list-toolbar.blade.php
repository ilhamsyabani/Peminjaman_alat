{{-- Toolbar daftar: $placeholder, $filter (opsional): ['name' => ..., 'label' => ..., 'options' => [value => label]] --}}
<form method="GET" class="app-toolbar" role="search">
    <div class="d-flex flex-wrap gap-2 flex-grow-1">
        <div class="input-group" style="max-width: 360px">
            <span class="input-group-text"><i class="fas fa-search" aria-hidden="true"></i></span>
            <input type="search" class="form-control" name="search" value="{{ request('search') }}"
                placeholder="{{ $placeholder ?? 'Cari…' }}" aria-label="{{ $placeholder ?? 'Cari' }}">
        </div>
        @isset($filter)
            <select name="{{ $filter['name'] }}" class="form-select w-auto" aria-label="{{ $filter['label'] }}"
                onchange="this.form.submit()">
                @foreach ($filter['options'] as $value => $label)
                    <option value="{{ $value }}" @selected(request($filter['name'], array_key_first($filter['options'])) == $value)>{{ $label }}</option>
                @endforeach
            </select>
        @endisset
        <button type="submit" class="btn btn-gray-800">Cari</button>
        @if (request('search') || (isset($filter) && request($filter['name'], 'all') !== 'all'))
            <a href="{{ url()->current() }}" class="btn btn-link text-gray-600">Reset</a>
        @endif
    </div>
    <div class="d-flex align-items-center gap-2">
        <label for="pagination" class="small text-gray-600 text-nowrap mb-0">Tampilkan</label>
        <select id="pagination" name="pagination" class="form-select form-select-sm" style="width: 76px" onchange="this.form.submit()">
            @foreach ([5, 10, 25, 50] as $n)
                <option value="{{ $n }}" @selected((int) request('pagination', 5) === $n)>{{ $n }}</option>
            @endforeach
        </select>
    </div>
</form>
