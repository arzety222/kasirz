@extends('layouts.main')

@section('content')
    <div class="form-container">
            
        <h1>TAMBAH PRODUK</h1>
        <br>
        <a href="{{ url('list_produk') }}">Kembali</a>
        <br><br>
        
        @if (session('error'))
            <div style="color: red;">
                {{ session('error') }}
            </div>
        @endif
        <br>
        <form action="{{ url('/insert_produk') }}" method="POST">
            @csrf

        
            <div class="form-group">
                <label>Nama Produk</label><br>
                <input type="text" name="inamaproduk" maxlength="50"><br><br>
            </div>

            <div class="form-group">
                <label>Harga</label><br>
                <input type="number" name="iharga" maxlength="11"><br><br>
            </div>

            <div class="form-group">
                <label>Stok</label><br>
                <input type="number" name="istok" maxlength="7"><br><br>
            </div>

            <button type="submit">Simpan</button>
        </form>
        
    </div>

@endsection