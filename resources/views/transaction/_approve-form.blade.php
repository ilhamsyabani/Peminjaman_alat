{{-- Form persetujuan. Param: $transaction --}}
<form action="{{ route('transactions.approve') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $transaction->id }}">
    <label class="form-label fw-bold" for="collateral">Jaminan yang diserahkan</label>
    <select class="form-select mb-1 @error('collateral') is-invalid @enderror" id="collateral" name="collateral">
        <option value="KTM" @selected(old('collateral') === 'KTM')>KTM (Kartu Tanda Mahasiswa)</option>
        <option value="KTP" @selected(old('collateral') === 'KTP')>KTP</option>
    </select>
    @error('collateral')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    <p class="small text-gray-500 mb-3">Simpan kartu jaminan sampai semua barang dikembalikan.</p>
    <button class="btn btn-gray-800 w-100" type="submit">
        <i class="fas fa-check me-1" aria-hidden="true"></i> Setujui pinjaman
    </button>
</form>
