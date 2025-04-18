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
            background-color: #DCF8F1;
            padding: 20px;
            margin: 20px;
            width: 150px;
        }

        .kanan {
            border:none;
            background-color: #B2F7E6;
            padding: 20px;
            margin: 20px;
            width: 850px;
        }
    </style>

    <body style="background: #fff;">
        
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
                            <li>
                                <a href="{{ url('register') }}">Register Admin</a>
                            </li>
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