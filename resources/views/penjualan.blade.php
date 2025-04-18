@extends('layouts.main')

@section('content')
<div align="center">
            
            <h1>PENJUALAN</h1>
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
            <p><a href="{{ url('add') }}">Tambah</a></p>
            <br>
            <table style="background-color:#fff">
                <tr style="background-color:#BEB3F4">
                    <td>No</td>
                    <td>Nama Produk</td>
                    <td>Qty Terjual</td>
                    <td>Harga</td>
                    <td>Ket</td>
                    <td>Actions</td>
                </tr>

                <?php $no=1; ?>

                @foreach($data as $r)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $r->nama_produk }}</td>
                        <td>{{ $r->quantity_terjual }}</td>
                        <td>Rp {{ number_format($r->harga_terjual, 0, ",", ".") }}</td>
                        <td>{{ $r->keterangan }}</td>
                        <td><a href="{{ url('edit') }}/{{ $r->penjualan_id }}">Edit</a> - <a onclick="return confirmDelete()" href="{{ url('delete') }}/{{ $r->penjualan_id }}">Delete</a></td>
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
