<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado minsur</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            padding: 0px 20px 0px 20px;
        }
        input[type=checkbox]:before { font-family: DejaVu Sans; }
        input[type=checkbox] { display: inline; }
    </style>
</head>

<body>
    <div align="right"><span style="color:red;">{{ $codigo }}</span></div>
    <h4 style="text-align:center">ANEXOS N°4</h4>
    <h4 style="text-align:center">INDUCCION Y ORIENTACIÓN BASICA</h4>
    <h5 style="text-align:center">PARA USO DE LA GERENCIA DE SEGURIDAD Y SALUD OCUPACIONAL</h5>

    <table cellspacing="0" rowspacing="0" style="font-size:12px;width:100%;font-family:helvetica;border: 1px solid silver;">
        <tr>
            <td style="padding:5px;width:25%;border: 1px solid silver;">Titular</td>
            <td style="padding:5px;width:25%;border: 1px solid silver;">MINSUR S.A</td>
            <td style="padding:5px;;width:25%;border: 1px solid silver;">Trabajador</td>
            <td style="padding:5px;width:25%";border: 1px solid silver;>{{ $nombres }}</td>
        </tr>
        <tr>
            <td style="padding:5px;border: 1px solid silver;">E.C.M./CONEXAS</td>
            <td style="padding:5px;border: 1px solid silver;">{{ $company }}</td>
            <td style="padding:5px;border: 1px solid silver;">Fecha de Ingreso</td>
            <td style="padding:5px;border: 1px solid silver;"></td>
        </tr>
        <tr>
            <td style="padding:5px;border: 1px solid silver;">Unidad de Producción</td>
            <td style="padding:5px;border: 1px solid silver;">U.M San Rafael</td>
            <td style="padding:5px;border: 1px solid silver;">Registro o N° de Fotocheck</td>
            <td style="padding:5px;border: 1px solid silver;">{{ $dni }}</td>
        </tr>
        <tr>
            <td style="padding:5px;border: 1px solid silver;">Distrito</td>
            <td style="padding:5px;border: 1px solid silver;">Antauta</td>
            <td style="padding:5px;border: 1px solid silver;">Ocupación</td>
            <td style="padding:5px;border: 1px solid silver;">{{ $cargo }}</td>
        </tr>
        <tr>
            <td style="padding:5px;border: 1px solid silver;">Provincia</td>
            <td style="padding:5px;border: 1px solid silver;">Melgar</td>
            <td style="padding:5px;border: 1px solid silver;">Área de Trabajo</td>
            <td style="padding:5px;border: 1px solid silver;">{{ $area }}</td>
        </tr>
    </table>
    <br>

    <div style="text-align: justify;line-height: 2em;font-size:12px">
        <input type="checkbox" checked>
        <label>Revisión del Programa de Recorrido de inducción por ingreso del Departamento de Administración de Personal.</label><br>

        <input type="checkbox" checked>
        <label>Bienvenida y explicación del propósito de la orientación.</label><br>

        <input type="checkbox" checked>
        <label>Pasado y presente del desempeño de la unidad de producción en Seguridad y Salud Ocupacional.</label><br>

        <input type="checkbox" checked>
        <label>Importancia del trabajador en el Programa de Seguridad y Salud Ocupacional. </label><br>

        <input type="checkbox" checked>
        <label>Politica de Seguridad y Salud Ocupacional.</label><br>

        <input type="checkbox" checked>
        <label>Presentación y explicación del Sistema de Gestión de Seguridad y Salud Ocupacional implementado en la empresa minera.</label><br>

        <input type="checkbox" checked>
        <label>Reglamento Interno de Seguridad y Salud Ocupacional, Reglas de Transito y otras normas. </label><br>

        <input type="checkbox" checked>
        <label>Comite Paritario de Seguridad y Salud Ocupacional. </label><br>

        <input type="checkbox" checked>
        <label>Obligaciones, Derechos y Responsabilidades de los trabajadores y supervisores.</label><br>

        <input type="checkbox" checked>
        <label>Explicación de Peligros, Riesgos, incidentes, estandares, PETS, ATS, PETAR, IPERC y jerarquia de controles.</label><br>

        <input type="checkbox" checked>
        <label>Trabajos de alto riesgo en la Unidad Minera.</label><br>

        <input type="checkbox" checked>
        <label>Higiene ocupacional: Agentes físicos, químico, biológicos, ergonomía.</label><br>

        <input type="checkbox" checked>
        <label> Código de colores y serialización.</label><br>

        <input type="checkbox" checked>
        <label> Control de sustancias peligrosas.</label><br>

        <input type="checkbox" checked>
        <label> Primeros Auxilios y Resucitación Cardio Pulmonar (RCP).</label><br>

        <input type="checkbox" checked>
        <label> Plan de emergencias en la Unidad minera.</label><br>
    </div>
    <br>
    <div align="right"><span>Fecha Capacitación: {{ $fecha }}</span></div>
    <br>
    <table cellspacing="0" rowspacing="0" style="border: hidden" style="width:100%">
        <tr>
            <td>
                <p>.................................................</p>
                <p>Firma del Trabajador</p>
            </td>
        </tr>
    </table>
    <center><img src="data:image/svg+xml;base64,{{ base64_encode($codeQR) }}" style="margin: 0; padding: 0"></center>
    <p style="text-align:center;font-size:10px; margin: 0; padding: 0">Codigo QR - IGH GROUP</p>
</body>
</html>