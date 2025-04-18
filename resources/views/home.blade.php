@extends('layouts.main')

@section('content')
    <p>Selamat Datang, <?php echo strtoupper(session('username')); ?> !</p>
@endsection