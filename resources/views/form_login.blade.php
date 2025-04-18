<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kasirz</title>

        <link rel="stylesheet" href="{{ asset('style.css') }}">
    </head>

    <body>
        <div class="form-container">
                
            <h1>LOGIN KASIRZ</h1>

            @if (session('error'))
                <div style="color: red;">
                    {{ session('error') }}
                </div>
            @endif
            <br>
            <form action="{{ url('/proses_login') }}" method="POST">
                @csrf

            
                <br><br>
            
                <div class="form-group">
                    <label>Username</label><br>
                    <input type="text" name="iusername" maxlength="50"><br><br>
                </div>

                <div class="form-group">
                    <label>Password</label><br>
                    <input type="password" name="ipassword" maxlength="100"><br><br>
                </div>

                <button type="submit">Login</button>
            </form>
            
        </div>
    </body>
</html>