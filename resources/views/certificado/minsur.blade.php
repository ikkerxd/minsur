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
            color: #353334;
        }
        .title {
            font-family: Calibri,sans-serif;
            text-transform: uppercase;
            text-align: center;
            font-size: 40px;
        }

        .user {
            top: 225px;
            left: 5%;
            width: 90%;
            font-size: 21px;
            font-weight: 600;
        }

        .curso {
            top: 415px;
            left: 10%;
            width: 80%;
            font-weight: bold;
            font-size: 35px;
            color: rgb(0,72,145);
        }

        .curso-xl {
            top: 395px;
            left: 10%;
            width: 80%;
            font-weight: bold;
            font-size: 30px;
            color: rgb(0,72,145);
        }

        .dni {
            font-family: Calibri,sans-serif;
            top: 293px;
            left: 60%;
            width: 25%;
            font-size: 31.5px;
            font-weight: 600;
        }

        .fecha {
            font-family: sans-serif;
            top: 752px;
            left: 95px;
            color: #363435;
            font-size: 15px;
        }

        .codigo {
            font-family: sans-serif;
            top: 70px;
            left: 85%;
            font-weight: bold;
            color: rgb(0,72,145);
        }
    </style>

</head>
<body>
    <div style="position: fixed; left: 0; top: -265px; right: 0; bottom: 0px; text-align: center;z-index: -1000;">
        <img src="https://www.ighgroup.com/minsur/img/certificado/minsur.png" style="width: 100%; margin-top: 25%;">
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
