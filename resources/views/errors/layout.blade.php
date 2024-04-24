<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Styles -->
        <style>
            @import url('https://fonts.googleapis.com/css?family=Montserrat:300');
            html,
            body {
                height: auto;
                margin: 0;
                padding: 0;
            }

            body {
                background: #3498DB;
                color: #fff;
                font-family: 'Montserrat', sans-serif;
                font-size: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .container {
                text-align: left;
            }

            .container h1 {
                margin-bottom: 0;
            }

            h1 {
                font-size: 30vh;
            }

            h2 span {
                font-size: 4rem;
                font-weight: 600;
            }

            a:link,
            a:visited {
                text-decoration: none;
                color: #fff;
            }

            h3 a:hover {
                text-decoration: none;
                background: #fff;
                color: #3498DB;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <h1>:(</h1><br>
        <h2>A <span>@yield('code')</span> error occurred, @yield('message').</h2><br><br>
        <h3><a href="/">Return to home</a>&nbsp;|&nbsp;<a href="javascript:history.back()">Go Back</a></h3>
    </div>
    </body>
</html>
