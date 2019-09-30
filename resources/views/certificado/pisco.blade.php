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
            font-family: sans-serif;
        }
        .user, .dni, .curso, .fecha, .codigo, .detalle, .curso-xl, .horas {
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
            font-family: sans-serif;
            text-align: center;
        }

        .user {
            top: 192px;
            left: 8%;
            width: 84%;
            font-weight: 600;
            font-size: 38px;
        }

        .curso {
            top: 315px;
            left: 10%;
            width: 80%;
            font-weight: bold;
            font-size: 26px;
            color: #373435;
        }

        .curso-xl {
            top: 355px;
            left: 10%;
            width: 80%;
            font-weight: bold;
            font-size: 38px;
            color: rgb(0,72,145);
            text-transform: uppercase;

        }

        .dni {
            font-family: Calibri,sans-serif;
            top: 260px;
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
            font-size: 14px;
        }

        .codigo {
            font-family: sans-serif;
            top: 70px;
            left: 85%;
            font-weight: bold;
            color: rgb(0,72,145);
        }

        .detalle {
            top: 355px;
            left: 8%;
            right: 8%;
            font-weight: bold;
            font-size: 26px;
            color: #373435;
        }

        .horas {
            top: 545px;
            left: 10%;
            width: 80%;
            color: #363435;
            font-size: 16px;
        }

        .container {
            width: 100%;
            display: flex;
            height: 100%;
            font-size: 25px;
            border: 2px solid blue;
            text-transform: uppercase;
            text-align: justify;

        }

        .container-xl {
            width: 100%;
            display: flex;
            height: 100%;
            font-size: 22px;
            text-transform: uppercase;
            text-align: justify;

        }

        .item-1 {
            /*border: 1px solid red;*/
            width: 15%;
            color: #363435;
        }

        .item-2 {
            margin-left: 15%;
            /*border: 1px solid red;*/
            width: 85%;
            color: rgb(0,72,145);


        }
    </style>

</head>
<body>
<div style="position: fixed; left: 0; top: -265px; right: 0; bottom: 0px; text-align: center;z-index: -1000;">
    <img src="https://www.ighgroup.com/minsur/img/certificado/minsur-pisco.jpg" style="width: 100%; margin-top: 25%;">
</div>
<span class="codigo">{{ $codigo }}</span>
<span class="title user">{{ $nombres }}</span>
<spam class="dni">{{ $dni }}</spam>
@if($curso == 'Curso Obligatorio I' or $curso == 'Curso Obligatorio II' or $curso == 'Curso Obligatorio III'or $curso == 'Curso Obligatorio IV'or $curso == 'Curso Obligatorio V'or $curso == 'Curso Obligatorio VI'or $curso == 'Curso Obligatorio VII')
    <span class="title curso">{{ $curso }}</span>
@else
    <span class="title curso-xl">{{ $curso }}</span>
@endif


@if($curso == 'Curso Obligatorio I')
    <div class="detalle" style="padding-top: 2px">
        <div class="container">
            <div class="item-1">Tópicos: </div>
            <div class="item-2">
                Reinducción Anual de Seguridad e Higiene Ocupacional. Reinducción Código de Ética y conducta Gestión y de la Seguridad y Salud Ocupacional basado en el Reglamento de Seguridad y Salud. Ocupacional y Política de Seguridad y Salud Ocupacional.
            </div>
        </div>
    </div>
    <span class="title horas">Con una duración de 08 horas lectivas.</span>
@endif

@if($curso == 'Curso Obligatorio II')
    <div class="detalle" style="padding-top: 20px">
        <div class="container">
            <div class="item-1">Tópicos: </div>
            <div class="item-2">
                Notificación, Investigación y reporte de Incidentes, Incidentes peligrosos y accidentes de trabajo. Auditoría, Fiscalización e Inspección de Seguridad. El uso de equipo de protección personal (EPP).
            </div>
        </div>
    </div>
    <span class="title horas">Con una duración de 08 horas lectivas.</span>
@endif

@if($curso == 'Curso Obligatorio III')
    <div class="detalle">
        <div class="container-xl">
            <div class="item-1">Tópicos: </div>
            <div class="item-2">
                Riesgos Críticos 1: Aislamiento y bloqueo de energía. Pruebas en equipos energizados. Herramientas críticas. Barreras y controles de protección en máquinas y equipos. Subestaciones eléctricas, salas eléctricas y centro de control de motores. Riesgos Críticos 2: Excavaciones y zanjas. Labores subterráneas. Espacios confinados y Perforación en superficie.
            </div>
        </div>
    </div>
    <span class="title horas">Con una duración de 08 horas lectivas.</span>
@endif

@if($curso == 'Curso Obligatorio IV')
    <div class="detalle" style="padding-top: 25px">
        <div class="container">
            <div class="item-1">Tópicos: </div>
            <div class="item-2">
                Herramientas de gestión de riesgos (PETS – ATS – OPT - PETAR). Mapa de Riesgos (Significado y uso de código de señales y colores).  Prevención de lesiones en dedos y manos / Primeros Auxilios.
            </div>
        </div>
    </div>
    <span class="title horas">Con una duración de 08 horas lectivas.</span>
@endif

@if($curso == 'Curso Obligatorio V')
    <div class="detalle" style="padding-top: 25px;">
        <div class="container">
            <div class="item-1">Tópicos: </div>
            <div class="item-2">
                Riegos Críticos 3: Trabajos en altura. Izaje de carga. Trabajo cerca o sobre fuentes de agua. Riesgos Críticos 4: Materiales peligrosos. Trabajos en caliente y Metales Fundidos.
            </div>
        </div>
    </div>
    <span class="title horas">Con una duración de 08 horas lectivas.</span>
@endif

@if($curso == 'Curso Obligatorio VI')
    <div class="detalle" style="padding-top: 25px; font-size: 28px !important;">
        <div class="container">
            <div class="item-1">Tópicos: </div>
            <div class="item-2">
                Reglas por la vida, Decálogo de Salud y Derecho a decir NO. Higiene Ocupacional. Control de sustancias peligrosas. IPERC.
            </div>
        </div>
    </div>
    <span class="title horas">Con una duración de 08 horas lectivas.</span>
@endif

@if($curso == 'Curso Obligatorio VII')
    <div class="detalle">
        <div class="container">
            <div class="item-1">Tópicos: </div>
            <div class="item-2">
                Estándar Bloqueo y Etiquetado. Estándar Materiales Peligrosos.</div>
        </div>
    </div>
    <span class="title horas">Con una duración de 08 horas lectivas.</span>
@endif

<spam class="fecha">{{ $fecha }}</spam>
</body>
</html>