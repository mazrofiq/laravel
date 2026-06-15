<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Credit Card Payment</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f5f5f5;
}

.container {
    width: 450px;
    margin: 40px auto;
}

.card-preview {
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: white;
    border-radius: 15px;
    padding: 25px;
    height: 220px;
    margin-bottom: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,.2);
}

.card-number {
    margin-top: 50px;
    font-size: 24px;
    letter-spacing: 2px;
}

.card-holder,
.card-expiry {
    margin-top: 20px;
    font-size: 14px;
}

.form-box {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,.1);
}

.input-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type=text],
input[type=password] {
    width: 100%;
    padding: 10px;
    border: 1px solid #CCC;
    border-radius: 6px;
    box-sizing: border-box;
}

.row {
    display: flex;
    gap: 10px;
}

.row .input-group {
    flex: 1;
}

.radio-group {
    display: flex;
    gap: 25px;
    margin-top: 8px;
}

.radio-group label {
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: normal;
    margin-bottom: 0;
}

button {
    width: 100%;
    padding: 12px;
    background: #2a5298;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background: #1e3c72;
}
</style>
</head>
<body>

<div class="container">

    <div class="card-preview">
        <div class="card-number" id="previewCardNumber">
            XXXX XXXX XXXX XXXX
        </div>

        <div class="card-holder" id="previewHolder">
            CARD HOLDER
        </div>

        <div class="card-expiry" id="previewExpiry">
            MM/YY
        </div>
    </div>

    <div class="form-box">

        <form id="paymentForm"
            method="POST"
            action="{{ route('getthreeds') }}">

            @csrf

            <div class="input-group">
                <label>Transaction Type</label>

                <div class="radio-group">
                    <label>
                        <input type="radio"
                            name="transactionType"
                            value="SALE"
                            checked
                            onchange="changeAction()">
                        SL
                    </label>

                    <label>
                        <input type="radio"
                            name="transactionType"
                            value="MOTO"
                            onchange="changeAction()">
                        MT
                    </label>
                    <label>
                        <input type="radio"
                            name="transactionType"
                            value="AUTHORIZE"
                            onchange="changeAction()">
                        AUTH
                    </label>
                    <label>
                        <input type="radio"
                            name="transactionType"
                            value="NON 3DS SALE"
                            onchange="changeAction()">
                        N SL
                    </label>
                    <label>
                        <input type="radio"
                            name="transactionType"
                            value="NON 3DS AUTHORIZE"
                            onchange="changeAction()">
                        N AU
                    </label>
                </div>
            </div>

            <div class="input-group">
                <label>Name</label>
                <input type="text"
                    name="card_holder"
                    required>
            </div>

            <div class="input-group">
                <label>Amount</label>
                <input type="text"
                    name="amount"
                    required>
            </div>

            <div class="input-group">
                <label>Card Number</label>
                <input type="text"
                    name="card_number"
                    required>
            </div>

            <div class="input-group">
                <label>Expiry Date</label>
                <input type="text"
                    name="expiry"
                    placeholder="MM/YY"
                    required>
            </div>

            <div class="input-group">
                <label>CVV</label>
                <input type="password"
                    name="cvv"
                    required>
            </div>

            <button type="submit" onclick="submitPayment()">
                Pay Now
            </button>

        </form>

    </div>

</div>

<script>

const cardNumber = document.getElementById('cardNumber');
const cardHolder = document.getElementById('cardHolder');
const expiry = document.getElementById('expiry');

cardNumber.addEventListener('input', function() {

    let value = this.value.replace(/\D/g,'');

    value = value.replace(/(.{4})/g, '$1 ').trim();

    this.value = value;

    document.getElementById('previewCardNumber').innerText =
        value || 'XXXX XXXX XXXX XXXX';

});

cardHolder.addEventListener('input', function() {

    document.getElementById('previewHolder').innerText =
        this.value.toUpperCase() || 'CARD HOLDER';

});

expiry.addEventListener('input', function() {

    let value = this.value.replace(/\D/g,'');

    if(value.length > 2){
        value = value.substring(0,2) + '/' + value.substring(2,4);
    }

    this.value = value;

    document.getElementById('previewExpiry').innerText =
        value || 'MM/YY';

});
function submitPayment() {

    let transactionType =
        document.querySelector(
            'input[name="transactionType"]:checked'
        ).value;

    const form = document.getElementById('paymentForm');

    if (transactionType === 'SALE'  || transactionType === 'AUTHORIZE') {
        form.action = '/getthreeds';
    } else if (transactionType === 'NON 3DS SALE') {
        transactionType = 'SALE';
            alert(transactionType);

            form.action = '/charge';
    }

    form.submit();
}

</script>

</body>
</html>