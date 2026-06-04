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

    {{-- ERROR RESPONSE --}}
    @if(isset($is_error) && $is_error)

        <div class="card error">

            <h2>⚠️ Request Validation Failed</h2>

            <table>

                <tr>
                    <td>Error Code</td>
                    <td>{{ $error_code }}</td>
                </tr>

                <tr>
                    <td>Error Type</td>
                    <td>{{ $error_type }}</td>
                </tr>

                <tr>
                    <td>Error Message</td>
                    <td>{{ $error_message }}</td>
                </tr>

            </table>

            @if($error_message == 'Luhn Validation')

                <p>
                    The card number entered is invalid.
                    Please verify the card number and try again.
                </p>

            @endif

        </div>

    {{-- SUCCESS RESPONSE --}}
    @elseif($status == 'SUCCESS')

        <div class="card success">

            <h2>✅ Payment Successful</h2>

            <table>

                <tr>
                    <td>Status</td>
                    <td>{{ $status }}</td>
                </tr>
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
                    <td>Response Code</td>
                    <td>{{ $response_code }}</td>
                </tr>

                <tr>
                    <td>Response Message</td>
                    <td>{{ $response_message }}</td>
                </tr>

            </table>

            <p>
                Thank you. Your payment has been successfully processed.
            </p>

        </div>

    {{-- FAILED RESPONSE --}}
    @else

        <div class="card failed">

            <h2>❌ Payment Failed</h2>

            <table>

                <tr>
                    <td>Status</td>
                    <td>{{ $status }}</td>
                </tr>
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
                    <td>Response Code</td>
                    <td>{{ $response_code }}</td>
                </tr>

                <tr>
                    <td>Response Message</td>
                    <td>{{ $response_message }}</td>
                </tr>

            </table>

            <p>
                The transaction could not be completed.
                Please try another card or contact your issuing bank.
            </p>

        </div>

    @endif

    <a href="{{ url('/user') }}" class="btn">
        Back to Payment
    </a>

</div>

</body>
</html>