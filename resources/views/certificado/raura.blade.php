<!doctype html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificado raura minsur</title>
    <style>
        html {
            margin: 0;
        }
        .user, .dni, .curso, .fecha, .codigo, .curso-xl {
            position: absolute;
            margin-left: auto;
            margin-right: auto;
            left: 0;
            right: 0;
            height: auto;
            width: 70%;
            color: #373435;
        }
        .title {
            font-family: Calibri,sans-serif;
            text-transform: uppercase;
            text-align: center;

        }

        .user {
            top: 220px;
            left: 15%;
            font-size: 40px;
            font-weight: 600;
        }

        .curso {
            top: 425px;
            left: 12%;
            width: 76%;
            font-weight: bold;
            font-size: 44px;
            color: #B02E3B;
        }
        .curso-xl {
            top: 405px;
            left: 12%;
            width: 76%;
            font-weight: bold;
            font-size: 37px;
            color: #B02E3B;
        }

        .dni {
            font-family: Calibri,sans-serif;
            top: 308px;
            left: 55.5%;
            width: 25%;
            font-size: 31.5px;
            font-weight: 600;
        }

        .fecha {
            font-family: sans-serif;
            top: 733px;
            left: 47px;
            color: #373435;
            font-size: 18.5px;
        }

        .codigo {
            font-family: sans-serif;
            top: 70px;
            left: 85%;
            font-weight: bold;
            color: #B02E3B;
        }
    </style>

</head>
<body>
<div style="position: fixed; left: 0; top: -265px; right: 0; bottom: 0px; text-align: center;z-index: -1000;">
    <img src="https://www.ighgroup.com/minsur/img/certificado/raura.png" style="width: 100%; margin-top: 25%;">
</div>
<spam class="codigo">{{ $codigo }}</spam>
<spam class="title user">{{ $nombres }}</spam>
<spam class="dni">{{ $dni }}</spam>
@if($xl)
    <spam class="title curso-xl">{{ $curso }}</spam>
@else
    <spam class="title curso">{{ $curso }}</spam>
@endif
<spam class="fecha">{{ $fecha }}</spam>
</body>
</html>
