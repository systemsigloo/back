<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nuevo Pedido Recibido</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; color: #333333; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <tr>
            <td style="padding: 20px; text-align: center; background-color: #d4a017; color: #ffffff; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <h1 style="margin: 0; font-size: 24px;">Rest Good Friends</h1>
                <h2 style="margin: 5px 0 0; font-size: 18px;">Nuevo Pedido Recibido</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <h3 style="margin: 0 0 10px; font-size: 18px;">Datos del Comprador</h3>
                <p style="margin: 5px 0;">
                    <strong>Nombre:</strong> {{ $pedidoData['nombre'] }}
                </p>
                <p style="margin: 5px 0;">
                    <strong>Teléfono:</strong> {{ $pedidoData['telefono'] }}
                </p>
                <p style="margin: 5px 0;">
                    <strong>Dirección de Entrega:</strong> {{ $pedidoData['comentarios'] ?: 'No especificada' }}
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding: 0 20px 20px;">
                <h3 style="margin: 0 0 10px; font-size: 18px;">Detalles de la Compra</h3>
                <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse; border: 1px solid #ddd;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th style="text-align: left; border-bottom: 1px solid #ddd;">Producto</th>
                            <th style="text-align: right; border-bottom: 1px solid #ddd;">Cantidad</th>
                            <th style="text-align: right; border-bottom: 1px solid #ddd;">Precio Unitario (USD)</th>
                            <th style="text-align: right; border-bottom: 1px solid #ddd;">Subtotal (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidoData['productos'] as $producto)
                            <tr>
                                <td style="border-bottom: 1px solid #ddd;">{{ $producto['nombre'] }}</td>
                                <td style="text-align: right; border-bottom: 1px solid #ddd;">{{ $producto['cantidad'] }}</td>
                                <td style="text-align: right; border-bottom: 1px solid #ddd;">${{ number_format($producto['precio_unitario'], 2, '.', ',') }}</td>
                                <td style="text-align: right; border-bottom: 1px solid #ddd;">${{ number_format($producto['subtotal'], 2, '.', ',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 0 20px 20px;">
                <h3 style="margin: 0 0 10px; font-size: 18px;">Detalles del Pago</h3>
                <p style="margin: 5px 0;">
                    <strong>Método de Pago:</strong> {{ $pedidoData['metodo_pago'] == 'pagoMovil' ? 'Pago Móvil' : 'Dólares' }}
                </p>
                <p style="margin: 5px 0;">
                    <strong>Total (USD):</strong> ${{ number_format($pedidoData['total_usd'], 2, '.', ',') }}
                </p>
                <p style="margin: 5px 0;">
                    <strong>Total (Bs):</strong> {{ number_format($pedidoData['total_bs'], 2, '.', ',') }} Bs
                </p>
                <p style="margin: 5px 0;">
                    <strong>Tasa de Cambio:</strong> {{ number_format($pedidoData['tasa'], 2, '.', ',') }} Bs/USD
                </p>
                @if ($pedidoData['comprobante'])
                    <p style="margin: 10px 0;">
                        <strong>Comprobante de Pago:</strong><br>
                        <img src="{{ $message->embed($pedidoData['comprobante_path']) }}" alt="Comprobante de Pago" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 4px; margin-top: 10px;">
                    </p>
                @else
                    <p style="margin: 5px 0;">
                        <strong>Comprobante de Pago:</strong> No proporcionado
                    </p>
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; text-align: center; background-color: #f8f9fa; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                <p style="margin: 0; font-size: 14px; color: #666;">
                    Gracias por tu pedido en Rest Good Friends. ¡Te contactaremos pronto!
                </p>
            </td>
        </tr>
    </table>
</body>
</html>