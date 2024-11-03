<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de compra</title>
    <style>
 
        body {
            margin: 0;
            padding: 0;
            background: rgb(245, 243, 243);
        }
        .container {
            width: 100%;
            max-width: 600px; /* Máxima anchura para el correo */
            margin: auto; /* Centrar el contenedor */
            background: white; /* Fondo blanco para el contenido */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
            padding: 20px; /* Espaciado interno */
        }
        .product-card {
            border: 1px solid rgb(33, 178, 183);
            border-radius: 2%; /* Bordes redondeados */
            padding: 10px; /* Espaciado interno de las tarjetas */
            margin-bottom: 10px; /* Espaciado entre tarjetas */
        }
        img {
            width: 100%; /* Asegura que las imágenes ocupen el 100% del ancho del contenedor */
            height: auto; /* Mantiene la proporción */
        }
        h1, h2, p {
            margin: 0; /* Elimina márgenes predeterminados */
        }
    </style>
</head>

<body>
    <div class="container">
        <table width="100%">
            <tr>
                <td style="text-align: center;">
                    <img src="{{ asset('logo.jpg') }}" alt="icono de logo" style="width: 100px; height: 100px;">
                </td>
                <td style="text-align: center;">
                    <h1 style="font-size: 24px; color: rgb(14, 162, 176);">Asignacion de citas</h1>
                </td>
            </tr>
        </table>
        <h2 style="font-size: 20px; color: rgb(14, 162, 176);">{{$data['nombre']}} , Se ha registrado de forma correcta la cita. Gracias!</h2>
        <p style="font-size: 16px; color: rgb(7, 87, 94);">Programacion de la cita para el dia {{$data['fecha_cita']}} a la hora {{$horario['hora_inicio']}} hasta {{$horario['hora_fin']}}</p>
    </div>
</body>
</html>
