<!-- resources/views/emails/new_product_created.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Task Scheduling for daily/hourly emails</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e6e6e6;
        }

        .header {
            background: #f6f6f6;
            color: gold;
            text-align: center;
            padding: 10px 0;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            margin: 0;
        }

        .content {
            padding: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Wellcome To Our Good user !</h2>
        </div>
        <div class="content">
            <p>Hello {{ $product->user->name }},</p>
            <p>A new product "{{ $product->name }}" has been created.</p>
            </td>
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>User Name</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> {{ $product->id }} </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->user->name }}</td>
                    </tr>
                </tbody>
            </table>
            <p>If you have any questions, feel free to contact us.</p>
            <p>Thank you!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ date('d-M-Y H:i:s') }}
                YourCompany. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
