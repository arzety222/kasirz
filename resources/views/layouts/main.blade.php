<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kasirz</title>

        <link rel="stylesheet" href="{{ asset('style.css') }}">
    </head>
    <style>    
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
        }
        .kiri {
            border:none;
            background-color:rgb(246, 248, 220);
            padding: 20px;
            margin: 20px;
            width: 150px;
        }

        .kanan {
            border:none;
            background-color:rgb(226, 203, 140);
            padding: 20px;
            margin: 20px;
            width: 850px;
        }
    </style>

    <!-- <body style="background: #fff;"> -->
    <body style="background-image: url('{{asset('furniture_rumah_minimalis.webp')}}')">
        
        <div class="main-form-container">
            
            <div align="center" style="background: #F4D4B3;">
                <h1>Aplikasi Penjualan Kasirz</h1>
            </div>
        
            <table style="border:none; padding: 10px; width:100%">
                <tr style="border:none" valign="top">
                    <td class="kiri">
                        <!-- MENU KIRI -->
                        <p>Menu</p>
                        <ul>
                            @if(session('role_id') == 1)
                                <li>
                                    <a href="{{ url('register') }}">Register Admin</a>
                                </li>
                            @endif
                            
                            <li>
                                <a href="{{ url('list_produk') }}">Produk</a>
                            </li>
                            <li>
                                <a href="{{ url('list_penjualan') }}">Penjualan</a>
                            </li>
                            <li>
                                <a href="{{ url('logout') }}">Logout</a>
                            </li>
                        </ul>
                    </td>
                    <td class="kanan">
                        <!-- KONTEN -->
                        @yield('content')
                        
                    </td>
                </tr>
            </table>
        </div>
        
    </body>
</html>