<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo de Laravel</title>
    <style>
        /* Estilos generales que se aplican en todos los clientes de correo */
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
                    <h1 style="font-size: 24px; color: rgb(14, 162, 176);">Factura: 0001</h1>
                </td>
            </tr>
        </table>

        <h2 style="font-size: 20px; color: rgb(14, 162, 176);">Se ha recibido su pago. Gracias!</h2>
        <p style="font-size: 16px; color: rgb(7, 87, 94);">Hemos recibido correctamente el pago de la factura H-8979845 para los siguientes productos.</p>

        <table width="100%">
            <tr>
                <td style="vertical-align: top;">
                    <table width="100%" style="border-collapse: collapse;">
                        <tr>
                            <td class="product-card">
                                <img src="{{ asset('logo.jpg') }}" alt="icono de logo">
                                <p style="font-size: 12px;">Nombre producto: Ibuprofeno</p>
                                <p style="font-size: 12px;">Valor Normal: COP 25.000</p>
                                <p style="font-size: 12px;">Descuento: 10%</p>
                                <p style="font-size: 12px;">Valor Unitario: COP 22.500</p>
                                <p style="font-size: 12px;">Cantidad: 2</p>
                                <p style="font-size: 12px;">Valor Total: COP 45.000</p>
                            </td>
                            <td class="product-card">
                                <img src="{{ asset('logo.jpg') }}" alt="icono de logo">
                                <p style="font-size: 12px;">Nombre producto: Ibuprofeno</p>
                                <p style="font-size: 12px;">Valor Normal: COP 25.000</p>
                                <p style="font-size: 12px;">Descuento: 10%</p>
                                <p style="font-size: 12px;">Valor Unitario: COP 22.500</p>
                                <p style="font-size: 12px;">Cantidad: 2</p>
                                <p style="font-size: 12px;">Valor Total: COP 45.000</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="product-card">
                                <img src="{{ asset('logo.jpg') }}" alt="icono de logo">
                                <p style="font-size: 12px;">Nombre producto: Ibuprofeno</p>
                                <p style="font-size: 12px;">Valor Normal: COP 25.000</p>
                                <p style="font-size: 12px;">Descuento: 10%</p>
                                <p style="font-size: 12px;">Valor Unitario: COP 22.500</p>
                                <p style="font-size: 12px;">Cantidad: 2</p>
                                <p style="font-size: 12px;">Valor Total: COP 45.000</p>
                            </td>
                            <td class="product-card">
                                <img src="{{ asset('logo.jpg') }}" alt="icono de logo">
                                <p style="font-size: 12px;">Nombre producto: Ibuprofeno</p>
                                <p style="font-size: 12px;">Valor Normal: COP 25.000</p>
                                <p style="font-size: 12px;">Descuento: 10%</p>
                                <p style="font-size: 12px;">Valor Unitario: COP 22.500</p>
                                <p style="font-size: 12px;">Cantidad: 2</p>
                                <p style="font-size: 12px;">Valor Total: COP 45.000</p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top;">
                    <h2 style="font-size: 20px; color: rgb(14, 162, 176);">Cantidad productos: 6</h2>
                    <h2 style="font-size: 20px; color: rgb(14, 162, 176);">Valor total Factura: COP 500.000</h2>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
