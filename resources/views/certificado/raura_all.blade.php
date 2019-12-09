<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado raura minsur</title>
    <style>
        html {
            margin: 0;
        }
        .user, .dni, .curso, .fecha, .codigo, .curso-xl {
            color: #373435;
            display: block;
            text-align: center;
            font-family: sans-serif;
        }

        .user {
            font-size: 40px;
            font-weight: 600;
            padding-top: 120px;
        }

        .dni {
            font-family: Calibri,sans-serif;
            font-size: 32px;
            font-weight: 600;
            padding-top: 44px;
            padding-left: 280px;
        }

        .curso {
            font-weight: bold;
            font-size: 44px;
            color: #B02E3B;
            height: 145px;
            padding-top: 70px;
            padding-left: 105px;
            padding-right: 105px;

        }
        .curso-xl {
            font-weight: bold;
            font-size: 37px;
            color: #B02E3B;
            height: 165px;
            padding-top: 50px;
            padding-left: 105px;
            padding-right: 105px;

        }

        .fecha {
            font-family: sans-serif;
            color: #373435;
            font-size: 19px;
            text-align: left;
            padding-top: 163px;
            padding-left: 50px;
        }

        .codigo {
            font-family: sans-serif;
            font-weight: bold;
            color: #B02E3B;

            padding-top: 75px;
            padding-right: 55px;
            text-align: right;
        }
        .page-break { page-break-after: always; }
    </style>

</head>
<body>

<div style="position: fixed; left: 0; top: -265px; right: 0; bottom: 0px; text-align: center;z-index: -1000;">
    <img src="https://www.ighgroup.com/minsur/img/certificado/raura1.png" style="width: 100%; margin-top: 25%;">
</div>
@foreach ($query as $item)
    <spam class="codigo">RA-{{ str_pad($item->id,8,"0", STR_PAD_LEFT) }}</spam>
    <spam class="user">{{ $item->participante }}</spam>
    <spam class="dni">{{ $item->dni }}</spam>
    @if(strlen($item->curso)>= 75)
        <spam class="curso-xl">{{ $item->curso }}</spam>
    @else
        <spam class="curso">{{ $item->curso }}</spam>
    @endif
    <spam class="fecha">{{ Carbon\Carbon::parse($item->fecha)->day }} de {{ Carbon\Carbon::parse($item->fecha)->localeMonth }} del  {{ Carbon\Carbon::parse($item->fecha)->year }}</spam>

    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach

</body>
</html>
