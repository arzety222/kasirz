@extends('layouts.main')

@section('content')
    <div class="form-container">
            
        <h1>TAMBAH PENJUALAN</h1>
        <br>
        <a href="{{ url('list_penjualan') }}">Kembali</a>
        <br><br>
        
        @if (session('error'))
            <div style="color: red;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ url('/insert') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Produk:</label><br>
                <select name="iproduk_id">
                    @foreach($produk as $r)
                        <option value="{{ $r->produk_id }}">{{ $r->nama_produk }}</option>
                    @endforeach
                </select>
            </div>
            <br><br>
        
            <div class="form-group">
                <label>Quantity Terjual:</label><br>
                <input type="number" name="iquantity" maxlength="7"><br><br>
            </div>

            <div class="form-group">
                <label>Keterangan:</label><br>
                <input type="text" name="iketerangan" maxlength="100"><br><br>
            </div>

            <button type="submit">Simpan</button>
        </form>
        
    </div>

@endsection