@extends('layouts.main')

@section('content')
    <div class="form-container">
            
        <h1>TAMBAH ADMIN</h1>
        <br>
        <a href="{{ url('/') }}">Kembali</a>
        <br><br>
        
        @if (session('error'))
            <div style="color: red;">
                {{ session('error') }}
            </div>
        @endif
        <br>
        <form action="{{ url('/insert_register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Tipe user</label><br>
                <select name="irole_id">
                    @foreach($role as $r)
                        <option value="{{ $r->role_id }}">{{ $r->role_name }}</option>
                    @endforeach
                </select>
            </div>
            <br><br>
        
            <div class="form-group">
                <label>Username</label><br>
                <input type="text" name="iusername" maxlength="50"><br><br>
            </div>

            <div class="form-group">
                <label>Password</label><br>
                <input type="password" name="ipassword" maxlength="100"><br><br>
            </div>

            <button type="submit">Simpan</button>
        </form>
        
    </div>
@endsection