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
            padding:40px;
        }

        .container{
            max-width:700px;
            margin:auto;
        }

        .card{
            background:white;
            border-radius:10px;
            padding:25px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
        }

        .success{
            background:#d4edda;
            border-left:5px solid #28a745;
        }

        .failed{
            background:#f8d7da;
            border-left:5px solid #dc3545;
        }

        .error{
            background:#fff3cd;
            border-left:5px solid #ffc107;
        }

        h2{
            margin-top:0;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        td{
            padding:12px;
            border-bottom:1px solid #ddd;
        }

        td:first-child{
            width:200px;
            font-weight:bold;
        }

        .btn{
            display:inline-block;
            margin-top:20px;
            background:#007bff;
            color:white;
            text-decoration:none;
            padding:10px 20px;
            border-radius:5px;
        }

        .btn:hover{
            background:#0056b3;
        }

    </style>

</head>
<body>

<div class="container">

    <div class="card error">

        <h2>⚠️ 3DS Authentication Failed</h2>

        <table>
            <tr>
                <td>Status</td>
                <td>AUTHENTICATION FAILED</td>
            </tr>

            <tr>
                <td>Invoice Number</td>
                <td>{{ $invoice_number }}</td>
            </tr>

            <tr>
                <td>Amount</td>
                <td>{{ $amount }}</td>
            </tr>

            <tr>
                <td>Authentication Status</td>
                <td>FAILED</td>
            </tr>

            <tr>
                <td>Reason</td>
                <td>OTP Verification Failed</td>
            </tr>

        </table>
        <p>
            The 3D Secure authentication could not be completed. This may occur because the OTP was incorrect, expired, the authentication session timed out, or the cardholder cancelled the authentication process.
        </p>
        <p>
            Please try again or contact your issuing bank for further assistance.
        </p>
    </div>

    <a href="{{ url('/user') }}" class="btn">
        Back to Payment
    </a>

</div>

</body>
</html>