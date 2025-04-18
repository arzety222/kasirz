@extends('layouts.main')

@section('content')
    <div class="form-container">
            
        <h1>EDIT PENJUALAN</h1>
        <br>
        <a href="{{ url('list_penjualan') }}">Kembali</a>
        <br><br>
        
        @if (session('error'))
            <div style="color: red;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ url('/update') }}" method="POST">
            @csrf

            <input name="ipenjualan_id" value="{{ $detail->penjualan_id }}" type="hidden">

            <div class="form-group">
                <label>Nama Produk:</label><br>
                <select readonly name="iproduk_id">
                    @foreach($produk as $r)
                        @if($r->produk_id == $detail->produk_id)
                            <option selected value="{{ $r->produk_id }}">{{ $r->nama_produk }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <br><br>
        
            <div class="form-group">
                <label>Quantity Terjual:</label><br>
                <input value="{{ $detail->quantity_terjual }}" type="number" name="iquantity" maxlength="7"><br><br>
            </div>

            <div class="form-group">
                <label>Keterangan:</label><br>
                <input value="{{ $detail->keterangan }}" type="text" name="iketerangan" maxlength="100"><br><br>
            </div>

            <button type="submit">Simpan</button>
        </form>
        
    </div>
        
@endsection