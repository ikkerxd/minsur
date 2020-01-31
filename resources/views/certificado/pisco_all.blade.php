<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Certificado Perurail</title>

    <style>

        html {
            margin: 0;
            padding: 0;
        }

        body {
            padding: 0;
            margin: 0;
            font-family: sans-serif;
        }
        div.papa {
            position: relative;
            /*left: 0; top: -265px; right: 0; bottom: 0;*/
            height: 97%;
            text-align: center;
            z-index: -500;
        }

        div.codigo {
            position: absolute;
            top: 70px;
            left: 85%;
            font-weight: bold;
            color: rgb(0,72,145);
        }

        div.nombre{
            position: absolute;
            margin-left: auto;
            margin-right: auto;
            left: 8%;
            right: 0;
            height: auto;
            width: 84%;
            color:#373435;
            top: 190px;
            font-size: 40px;
            font-weight: 700;
        }

        div.dni{
            position: absolute;
            margin-left: auto;
            margin-right: auto;
            left: 30%;
            right: 0;
            height: auto;
            width: 70%;
            color: #373435;
            top: 257px;
            font-size: 36px;
            font-weight: 600;
        }

        div.curso{
            position: absolute;
            margin-left: auto;
            margin-right: auto;
            top: 310px;
            left: 10%;
            right: 0;
            height: auto;
            width: 80%;
            font-weight: bold;
            font-size: 30px;
            color: #373435;
            /*text-transform: uppercase;*/
        }

        div.curso-xl{
            position: absolute;
            margin-left: auto;
            margin-right: auto;
            top: 405px;
            left: 12%;
            right: 0;
            height: auto;
            width: 76%;
            font-weight: bold;
            font-size: 37px;
            color: rgb(0,72,145);
        }

        div.fecha {
            position: absolute;
            top: 751px;
            left: 0;
            right: 0;
            height: auto;
            width: 30%;
            color: #373435;
            font-size: 15px;
            font-weight: 400;
        }

        .horas {
            position: absolute;
            top: 547px;
            left: 10%;
            width: 80%;
            color: #363435;
            font-size: 16px;
        }


        div.detalle {
            position: absolute;
            top: 355px;
            left: 8%;
            width: 84%;
            font-weight: bold;
            color: rgb(0,72,145);
        }

        .container {
            width: 100%;
            display: flex;
            height: 100%;
            font-size: 25px;
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
            border: 2px solid blue;


        }

        .item-1 {
            width: 15%;
            color: #353334;
        }

        .item-2 {
            margin-left: 15%;
            width: 85%;
            color: rgb(0,72,145);
        }

        .page-break { page-break-after: always; }

    </style>

</head>
<body>


{{-- SEGUNDA OPCION --}}
@foreach ($query as $item)
    <div style="position: absolute; left: 0; top: -265px; right: 0; bottom: 0px; text-align: center;z-index: -1000;">
        <img src="https://www.ighgroup.com/minsur/img/certificado/minsur-pisco.jpg" style="width: 100%; margin-top: 25%;">

    </div>
    <div class="papa">
        <div class="codigo">MI-{{ str_pad($item->id,8,"0", STR_PAD_LEFT) }}</div>
        <div class="nombre">{{ $item->participante }}</div>
        <div class="dni">{{ $item->dni }}</div>
        @if($item->curso == 'Curso Obligatorio I' or $item->curso == 'Curso Obligatorio II' or $item->curso == 'Curso Obligatorio III'or $item->curso == 'Curso Obligatorio IV' or $item->curso == 'Curso Obligatorio V' or $item->curso == 'Curso Obligatorio VI' or $item->curso == 'Curso Obligatorio VII' or $item->curso == 'Curso Obligatorio VIII' or $item->curso == 'Curso Obligatorio IX'  or $item->curso == 'Curso Obligatorio X')
            <div class="curso">{{ $item->curso }}</div>
        @else
            <div class="curso-xl">{{ $item->curso }}</div>
        @endif


        @if($item->curso == 'Curso Obligatorio I')
            <div class="detalle" style="padding-top: 2px">
                <div class="container">
                    <div class="item-1">Tópicos: </div>
                    <div class="item-2">
                        Reinducción Anual de Seguridad e Higiene Ocupacional. Reinducción Código de Ética y conducta Gestión y de la Seguridad y Salud Ocupacional basado en el Reglamento de Seguridad y Salud. Ocupacional y Política de Seguridad y Salud Ocupacional.
                    </div>
                </div>
            </div>
            <title class="horas">Con una duración de 08 horas lectivas.</title>
        @endif

        @if($item->curso == 'Curso Obligatorio II')
            <div class="detalle" style="padding-top: 20px">
                <div class="container">
                    <div class="item-1">Tópicos: </div>
                    <div class="item-2">
                        Notificación, Investigación y reporte de Incidentes, Incidentes peligrosos y accidentes de trabajo. Auditoría, Fiscalización e Inspección de Seguridad. El uso de equipo de protección personal (EPP).
                    </div>
                </div>
            </div>
            <div class="horas">Con una duración de 08 horas lectivas.</div>
        @endif


        @if($item->curso == 'Curso Obligatorio III')
            <div class="detalle">
                <div class="container-xl">
                    <div class="item-1">Tópicos: </div>
                    <div class="item-2">
                        Riesgos Críticos 1: Aislamiento y bloqueo de energía. Pruebas en equipos energizados. Herramientas críticas. Barreras y controles de protección en máquinas y equipos. Subestaciones eléctricas, salas eléctricas y centro de control de motores. Riesgos Críticos 2: Excavaciones y zanjas. Labores subterráneas. Espacios confinados y Perforación en superficie.
                    </div>
                </div>
            </div>
            <div class="horas">Con una duración de 08 horas lectivas.</div>
        @endif

        @if($item->curso == 'Curso Obligatorio IV')
            <div class="detalle" style="padding-top: 25px">
                <div class="container">
                    <div class="item-1">Tópicos: </div>
                    <div class="item-2">
                        Herramientas de gestión de riesgos (PETS – ATS – OPT - PETAR). Mapa de Riesgos (Significado y uso de código de señales y colores).  Prevención de lesiones en dedos y manos / Primeros Auxilios.
                    </div>
                </div>
            </div>
            <div class="horas">Con una duración de 08 horas lectivas.</div>
        @endif

        @if($item->curso == 'Curso Obligatorio V')
            <div class="detalle" style="padding-top: 25px;">
                <div class="container">
                    <div class="item-1">Tópicos: </div>
                    <div class="item-2">
                        Riegos Críticos 3: Trabajos en altura. Izaje de carga. Trabajo cerca o sobre fuentes de agua. Riesgos Críticos 4: Materiales peligrosos. Trabajos en caliente y Metales Fundidos.
                    </div>
                </div>
            </div>
            <div class="horas">Con una duración de 08 horas lectivas.</div>
        @endif

        @if($item->curso == 'Curso Obligatorio VI')
            <div class="detalle" style="padding-top: 25px; font-size: 28px !important;">
                <div class="container">
                    <div class="item-1">Tópicos: </div>
                    <div class="item-2">
                        Reglas por la vida, Decálogo de Salud y Derecho a decir NO. Higiene Ocupacional. Control de sustancias peligrosas. IPERC.
                    </div>
                </div>
            </div>
            <div class="horas">Con una duración de 08 horas lectivas.</div>
        @endif

        @if($item->curso == 'Curso Obligatorio VII')
            <div class="detalle">
                <div class="container">
                    <div class="item-1">Tópicos: </div>
                    <div class="item-2">
                        Estándar Bloqueo y Etiquetado. Estándar Materiales Peligrosos.</div>
                </div>
            </div>
            <div class="horas">Con una duración de 08 horas lectivas.</div>
        @endif

        @if($item->curso == 'Curso Obligatorio VIII')
            <div class="detalle">
                <div class="container">
                    <div class="item-1">Tópicos: </div>
                    <div class="item-2">
                        Estándar Trabajos en Caliente, Estándar Trabajos en Altura.</div>
                </div>
            </div>
            <div class="horas">Con una duración de 08 horas lectivas.</div>
        @endif

        @if($item->curso == 'Curso Obligatorio IX')
            <div class="detalle">
                <div class="container">
                    <div class="item-1">Tópicos: </div>
                    <div class="item-2">
                        Estándar Pruebas en Equipos Energizados, Estándar Subestaciones Eléctricas Salas Eléctricas y CCM.</div>
                </div>
            </div>
            <div class="horas">Con una duración de 08 horas lectivas.</div>
        @endif

        @if($item->curso == 'Curso Obligatorio X')
            <div class="detalle">
                <div class="container">
                    <div class="item-1">Tópicos: </div>
                    <div class="item-2">
                        Manejo Defensivo, Ritran, Estándar Izaje de Cargas.</div>
                </div>
            </div>
            <div class="horas">Con una duración de 08 horas lectivas.</div>
        @endif

        @if($item->curso == 'Curso Obligatorio XI')
            <div class="detalle">
                <div class="container">
                    <div class="item-1">Tópicos: </div>
                    <div class="item-2">
                        Estándar Metales Fundidos, Estándar Espacios Confinados.</div>
                </div>
            </div>
            <div class="horas">Con una duración de 08 horas lectivas.</div>
        @endif

        @if($item->curso == 'Curso Obligatorio XII')
            <div class="detalle">
                <div class="container">
                    <div class="item-1">Tópicos: </div>
                    <div class="item-2">
                        Respuesta a emergencias en áreas específicas - Prevención y Protección contra Incendio, Higiene Ocupacional - Factores de riesgos ergonómicos y psicosociales - Disposición de Residuos Sólidos.
                    </div>
                </div>
            </div>
            <div class="horas">Con una duración de 08 horas lectivas.</div>
        @endif

        <div class="fecha">{{ Carbon\Carbon::parse($item->fecha)->day }} de {{ Carbon\Carbon::parse($item->fecha)->localeMonth }} del  {{ Carbon\Carbon::parse($item->fecha)->year }}</div>
    </div>
    @if(!$loop->last)
        <div class="page-break"></div>
    @endif

@endforeach
{{-- FIN SEGUNDA OPCION --}}
</body>
</html>
