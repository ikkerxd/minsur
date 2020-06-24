<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Constancia de salud covid 19</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            padding: 50px 100px 0px 100px;
        }
        input[type=checkbox]:before { font-family: DejaVu Sans; }
        input[type=checkbox] { display: inline; }
    </style>
</head>

<body>
<div align="right"><span style="color:red;">IGH - <strong>{{ $codigo }}</strong></span></div>
<h4 style="text-align:center">CONSTANCIA DE RECEPCION</h4>

<p class="text-justify">Mediante la presente conste que yo <strong>{{ $nombres }}</strong> Identificado con DNI <strong>{{ $dni }}</strong>
    Trabajador del área <strong>{{ $area }}</strong> de la empresa / contratista <strong>{{ $company }}</strong> De ocupación / cargo <strong>{{ $cargo }}</strong> </p>

<p>He recibido la inducción:</p>
<br>
<h4 style="text-align:center">MEDIDAS PREVENTIVAS PARA EVITAR CONTAGIO COVID-19</h4>

<p>El cual contiene los siguiente temas:</p>

<table cellspacing="0" rowspacing="0" style="font-size:12px;width:100%;font-family:helvetica;border: 1px solid silver;">
    <tr>
        <td style="padding:5px;border: 1px solid silver;">1. </td>
        <td style="padding:5px;border: 1px solid silver;">Coronavirus (covid-19) y su transmisión</td>
        <td style="padding:5px;border: 1px solid silver;">5. </td>
        <td style="padding:5px;border: 1px solid silver;">Movilización a la unidad minera</td>
    </tr>
    <tr>
        <td style="padding:5px;border: 1px solid silver;">2. </td>
        <td style="padding:5px;border: 1px solid silver;">Signos, síntomas y pruebas de determinación</td>
        <td style="padding:5px;border: 1px solid silver;">6. </td>
        <td style="padding:5px;border: 1px solid silver;">Recepción y hospedaje en la unidad minera</td>
    </tr>
    <tr>
        <td style="padding:5px;border: 1px solid silver;">3. </td>
        <td style="padding:5px;border: 1px solid silver;">Disposiciones legales y corporativas</td>
        <td style="padding:5px;border: 1px solid silver;">7. </td>
        <td style="padding:5px;border: 1px solid silver;">Vigilancia epidemiológica</td>
    </tr>
    <tr>
        <td style="padding:5px;border: 1px solid silver;">4. </td>
        <td style="padding:5px;border: 1px solid silver;">Medidas preventivas generales y epp</td>
        <td style="padding:5px;border: 1px solid silver;">8. </td>
        <td style="padding:5px;border: 1px solid silver;">Guias de seguridad y salud para la movilización</td>
    </tr>
</table>
<br>

<p class="text-justify">En señal de conformidad firmo la presente constancia y me comprometo a cumplir con las medidas
    preventivas establecidas por mi seguridad y salud así como las de mis compañeros de trabajo.</p>
<br>

<div><span>Fecha Capacitación: {{ $fecha }}</span></div>
<br>

<div align="center" style="width:100%">
    <p>.............................................................</p>
    <p>Firma y huella del trabajador</p>
</div>
<br>

<div align="center">
    <center><img src="data:image/svg+xml;base64,{{ base64_encode($codeQR) }}" style="margin: 0; padding: 0"></center>
    <p style="text-align:center;font-size:10px">Codigo QR - IGH GROUP</p>
</div>

</body>
</html>