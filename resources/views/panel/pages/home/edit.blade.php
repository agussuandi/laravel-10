@extends('panel.layouts.app')
@section('content')
    <div class="card">
        <div class="card-header bg-info d-flex flex-grow justify-content-between align-items-center pb-0">
            <h5 class="text-white">Edit Obat</h5>
        </div>
        <div class="card-body mt-3">
            <form method="post" action="{{ route('home.update', $obat->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="namaObat" class="form-label">Nama Obat</label>
                    <input type="text" class="form-control" id="namaObat" name="namaObat" placeholder="Masukan nama obat" required autocomplete="off" maxlength="200" value="{{ $obat->name }}" />
                </div>
                <div class="mb-3">
                    <label for="mg" class="form-label">Mg (berat)</label>
                    <input type="text" class="form-control" id="mg" name="mg" placeholder="Masukan berat obat" required autocomplete="off" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')" value="{{ $obat->mg }}" />
                </div>
                <div class="mb-3">
                    <label for="company" class="form-label">Pabrik</label>
                    <input type="text" class="form-control" id="company" name="company" placeholder="Masukan pabrik pembuat obat" required autocomplete="off" maxlength="220" value="{{ $obat->company }}" />
                </div>
                <div class="mb-3">
                    <label for="dosisId" class="form-label">Pemakaian Perhari</label>
                    <select id="dosisId" name="dosisId" class="form-select" required>
                        <option>-- Pilih Pemakaian Perhari --</option>
                        @foreach ($dosis as $key => $dosis)
                            <option value="{{ $dosis->id }}" @selected($dosis->id === $obat->dosis_id)>{{ $dosis->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('home.index') }}" class="btn btn-warning">Batal</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@stop
@section('javascript')
    
@endsection