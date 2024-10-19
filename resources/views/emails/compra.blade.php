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
                    <h1 style="font-size: 24px; color: rgb(14, 162, 176);">Factura: {{$factura['factura']}}</h1>
                </td>
            </tr>
        </table>
        @if($data['status'] == 'APPROVED')
            <h2 style="font-size: 20px; color: rgb(14, 162, 176);">{{$data['nombre']}} {{$data['apellido']}}, Se ha recibido su pago. Gracias!</h2>
            <p style="font-size: 16px; color: rgb(7, 87, 94);">Hemos recibido correctamente el pago de la factura H-8979845 para los siguientes productos.</p>
        @else
            <h2 style="font-size: 20px; color: rgb(176, 36, 14);">{{$data['nombre']}} {{$data['apellido']}}, No se ha recibido su pago. Lo lamentamos!</h2>
            <p style="font-size: 16px; color: rgb(94, 7, 58);">No Hemos recibido correctamente el pago de la factura H-8979845 para los siguientes productos.</p>
        @endif
        <table width="100%">
            <tr>
                <td style="vertical-align: top;">
                    <table width="100%" style="border-collapse: collapse;">
                        @foreach($produc->chunk(2) as $chunk)
                            <tr>
                                @foreach($chunk as $producto)
                                    <td class="product-card">
                                        <img src="{{ asset($producto->imagen1) }}" alt="imagen">
                                        <p style="font-size: 12px;">Nombre producto: {{ $producto->nombre }}</p>
                                        <p style="font-size: 12px;">Valor Normal: COP {{ number_format($producto->precio, 0, ',', '.') }}</p>
                                        <p style="font-size: 12px;">Descuento: {{ $producto->porcentaje }}%</p>
                                        <p style="font-size: 12px;">Valor Unitario: COP {{ number_format($producto->precio, 0, ',', '.') }}</p>
                                        <p style="font-size: 12px;">Cantidad: {{ $producto->cantidad }}</p>
                                        <p style="font-size: 12px;">Valor Total: COP {{ number_format(($producto->precio - ($producto->precio * $producto->porcentaje /100 )), 0, ',', '.') }}</p>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>
        <div>
            <h2 style="font-size: 20px; color: rgb(14, 162, 176);">Nombre comprador: {{$data['nombre']}} {{$data['apellido']}}</h2>
            <h2 style="font-size: 20px; color: rgb(14, 162, 176);">Email: {{$data['email']}} </h2>
            <h2 style="font-size: 20px; color: rgb(14, 162, 176);">Telefono: {{$data['telefono']}} </h2>
            <h2 style="font-size: 20px; color: rgb(14, 162, 176);">Direccion: {{$data['direccion']}} </h2>
            <h2 style="font-size: 20px; color: rgb(14, 162, 176);">Valor total Factura: COP {{ number_format($data['valort'], 0, ',', '.') }}</h2>
        </div>
    </div>
</body>
</html>
