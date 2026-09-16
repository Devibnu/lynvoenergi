<!DOCTYPE html>
<html>
<head>
    <title>Katalog Produk Lynvo Energi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>KATALOG PRODUK LYNVO ENERGI</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Merek</th>
                <th>Nama Produk</th>
                <th>Spesifikasi (Voltage/Ah/CCA)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->category?->name }}</td>
                <td>{{ $product->brand }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->voltage ?? '-' }} / {{ $product->capacity_ah ?? '-' }} Ah / {{ $product->cca ?? '-' }} CCA</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
