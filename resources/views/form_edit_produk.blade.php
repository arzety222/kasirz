@extends('layouts.main')

@section('content')
    <div class="form-container">
            
        <h1>EDIT PRODUK</h1>
        <br>
        <a href="{{ url('list_produk') }}">Kembali</a>
        <br><br>
        
        @if (session('error'))
            <div style="color: red;">
                {{ session('error') }}
            </div>
        @endif
        <br>
        <form action="{{ url('/update_produk') }}" method="POST">
            @csrf

            <input name="iproduk_id" value="{{ $detail->produk_id}}" type="hidden">
        
            <div class="form-group">
                <label>Nama Produk</label><br>
                <input value = "{{ $detail->nama_produk}}" type="text" name="inamaproduk" maxlength="50"><br><br>
            </div>

            <div class="form-group">
                <label>Harga</label><br>
                <input value = "{{ $detail->harga}}" type="number" name="iharga" maxlength="11"><br><br>
            </div>

            <div class="form-group">
                <label>Stok</label><br>
                <input value = "{{ $detail->stok}}" type="number" name="istok" maxlength="7"><br><br>
            </div>

            <button type="submit">Simpan</button>
        </form>
        
    </div>
        
@endsection