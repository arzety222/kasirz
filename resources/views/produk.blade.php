@extends('layouts.main')

@section('content')
<div align="center">
            
            <h1>PRODUK</h1>
            @if (session('success'))
                <div style="color: green;">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div style="color: red;">
                    {{ session('error') }}
                </div>
            @endif
            <br>
            <p><a href="{{ url('add_produk') }}">Tambah</a></p>
            <br>
            <table style="background-color:#fff">
                <tr style="background-color:#BEB3F4">
                    <td>No</td>
                    <td>Nama Produk</td>
                    <td>Harga</td>
                    <td>Stok</td>
                    <td>Actions</td>
                </tr>
                <?php $no=1; ?>

                @foreach($data as $r)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $r->nama_produk }}</td>
                        <td>Rp {{ number_format($r->harga, 0, ",", ".") }}</td>
                        <td>{{ number_format($r->stok, 0, ",", ".") }}</td>
                        <td><a href="{{ url('edit_produk') }}/{{ $r->produk_id }}">Edit</a> - <a onclick="return confirmDelete()" href="{{ url('delete_produk') }}/{{ $r->produk_id}}">Delete</a></td>
                    </tr>
                    
                    <?php $no++ ?>
                @endforeach
                

            </table>
        </div>
    </body>
</html>

<script>
    function confirmDelete() {
        return confirm("Apakah anda yakin mau hapus ?");
    }
</script>
@endsection('content')
