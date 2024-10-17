<!DOCTYPE html>
<html>
<head>
    <title>Correo de Laravel</title>
</head>

<body>
    <div style="width: 100%;height: 100%;display: flex;flex-direction: column;justify-content: center;align-items: center;background: rgb(245, 243, 243)">
        <div style="display:flex;flex-direction: row;justify-content: space-between;width: 50%" >
            <img src="{{ asset('logo.jpg') }}" alt="icono de logo" style="width: 100px;height: 100px;">
            <p style="font-size: 40px;font-weight: bold;color: rgb(14, 162, 176)">Factura:0001</p>
        </div>
        <div style="display:flex;flex-direction: column;width: 50%">
            <p style="font-size: 30px;font-weight: bold;color: rgb(14, 162, 176)">Se ha recibido su pago. Gracias!</p>
            <p style="font-size: 20px;font-weight: bold;color: rgb(7, 87, 94)">Hemos recibido correctamente el pago de la factura H-8979845 para los siguientes productos.</p>
            <div style="display:flex;flex-wrap: wrap;gap: 5px">
                {{-- tarjeta --}}
                <div style="width: 200px;height: 350px; display: flex; flex-direction: column;border: 1px solid rgb(33, 178, 183);padding: 4px;border-radius: 2%;background: white">
                    <img src="{{ asset('logo.jpg') }}" alt="icono de logo" style="width: 100%">
                    <p style="font-size: 12px;margin: 5px">Nombre producto:Ibuprofeno</p>
                    <p style="font-size: 12px;margin: 5px">Valor Nomal:COP 25.000</p>
                    <p style="font-size: 12px;margin: 5px">Descuento: 10%</p>
                    <p style="font-size: 12px;margin: 5px">Valor Unitario: COP 22.500</p>
                    <p style="font-size: 12px;margin: 5px">Cantidad: 2</p>
                    <p style="font-size: 12px;margin: 5px">VaLor Total: COP 45.000</p>
                </div>
                <div style="width: 200px;height: 350px; display: flex; flex-direction: column;border: 1px solid rgb(33, 178, 183);padding: 4px;border-radius: 2%;background: white">
                    <img src="{{ asset('logo.jpg') }}" alt="icono de logo" style="width: 100%">
                    <p style="font-size: 12px;margin: 5px">Nombre producto:Ibuprofeno</p>
                    <p style="font-size: 12px;margin: 5px">Valor Nomal:COP 25.000</p>
                    <p style="font-size: 12px;margin: 5px">Descuento: 10%</p>
                    <p style="font-size: 12px;margin: 5px">Valor Unitario: COP 22.500</p>
                    <p style="font-size: 12px;margin: 5px">Cantidad: 2</p>
                    <p style="font-size: 12px;margin: 5px">VaLor Total: COP 45.000</p>
                </div>
                <div style="width: 200px;height: 350px; display: flex; flex-direction: column;border: 1px solid rgb(33, 178, 183);padding: 4px;border-radius: 2%;background: white">
                    <img src="{{ asset('logo.jpg') }}" alt="icono de logo" style="width: 100%">
                    <p style="font-size: 12px;margin: 5px">Nombre producto:Ibuprofeno</p>
                    <p style="font-size: 12px;margin: 5px">Valor Nomal:COP 25.000</p>
                    <p style="font-size: 12px;margin: 5px">Descuento: 10%</p>
                    <p style="font-size: 12px;margin: 5px">Valor Unitario: COP 22.500</p>
                    <p style="font-size: 12px;margin: 5px">Cantidad: 2</p>
                    <p style="font-size: 12px;margin: 5px">VaLor Total: COP 45.000</p>
                </div>
                <div style="width: 200px;height: 350px; display: flex; flex-direction: column;border: 1px solid rgb(33, 178, 183);padding: 4px;border-radius: 2%;background: white">
                    <img src="{{ asset('logo.jpg') }}" alt="icono de logo" style="width: 100%">
                    <p style="font-size: 12px;margin: 5px">Nombre producto:Ibuprofeno</p>
                    <p style="font-size: 12px;margin: 5px">Valor Nomal:COP 25.000</p>
                    <p style="font-size: 12px;margin: 5px">Descuento: 10%</p>
                    <p style="font-size: 12px;margin: 5px">Valor Unitario: COP 22.500</p>
                    <p style="font-size: 12px;margin: 5px">Cantidad: 2</p>
                    <p style="font-size: 12px;margin: 5px">VaLor Total: COP 45.000</p>
                </div> 
            </div>
            <div style="display:flex;flex-direction: column" >         
                <p style="font-size: 30px;font-weight: bold;color: rgb(14, 162, 176);margin: 5px">Cantidad productos:6</p>
                <p style="font-size: 30px;font-weight: bold;color: rgb(14, 162, 176);margin: 5px">Valor total Factura: COP 500.000</p>
            </div>
        </div>
    </div>
</body>
</html>