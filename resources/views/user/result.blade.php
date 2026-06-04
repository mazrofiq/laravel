<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Result</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f5f5f5;
            margin:0;
            padding:40px;
        }

        .container{
            max-width:600px;
            margin:auto;
        }

        .card{
            background:#fff;
            border-radius:10px;
            padding:25px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
        }

        .success{
            color:#28a745;
        }

        .failed{
            color:#dc3545;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        td{
            padding:12px;
            border-bottom:1px solid #ddd;
        }

        td:first-child{
            font-weight:bold;
            width:180px;
        }

        .btn{
            display:inline-block;
            margin-top:20px;
            background:#007bff;
            color:#fff;
            padding:10px 20px;
            text-decoration:none;
            border-radius:5px;
        }

        .btn:hover{
            background:#0056b3;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="card">

        <h2>
            Payment Result
        </h2>

        <h3 class="{{ $status == 'SUCCESS' ? 'success' : 'failed' }}">
            {{ $status }}
        </h3>

        <table>
            <tr>
                <td>Invoice</td>
                <td>{{ $invoice_number }}</td>
            </tr>

            <tr>
                <td>Amount</td>
                <td>{{ $amount }}</td>
            </tr>

            <tr>
                <td>Card Masked</td>
                <td>{{ $card }}</td>
            </tr>

            <tr>
                <td>Status</td>
                <td>{{ $status }}</td>
            </tr>

            <tr>
                <td>Response Code</td>
                <td>{{ $response_code }}</td>
            </tr>

            <tr>
                <td>Response Message</td>
                <td>{{ $response_message }}</td>
            </tr>
            

        </table>

        <a href="{{ url('/user') }}" class="btn">
            Back to Payment
        </a>

    </div>

</div>

</body>
</html>