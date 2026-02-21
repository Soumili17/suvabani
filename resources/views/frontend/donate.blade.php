<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donate Now | SUVABANI FOUNDATION</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Razorpay Checkout Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #f8fafc, #e0f2f1);
        }

        .donation-wrapper {
            padding: 80px 20px;
        }

        .donation-card {
            max-width: 550px;
            margin: auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        }

        .donation-card h2 {
            text-align: center;
            color: #0f766e;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            color: #555;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        input:focus, textarea:focus {
            border-color: #14b8a6;
            outline: none;
        }

        .donate-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            color: white;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
        }

        .donate-btn:hover {
            opacity: 0.9;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="donation-wrapper">
    <div class="donation-card">

        <h2>Support SUVABANI FOUNDATION</h2>
        <p class="subtitle">Your contribution helps us create a better future.</p>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert-danger">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('donate.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="donor_name" value="{{ old('donor_name') }}" required>
            </div>

            <div class="form-group">
                <label>Email Address *</label>
                <input type="email" name="donor_email" value="{{ old('donor_email') }}" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="donor_phone" value="{{ old('donor_phone') }}">
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="donor_address" rows="3">{{ old('donor_address') }}</textarea>
            </div>

            <div class="form-group">
                <label>Donation Amount (₹) *</label>
                <input type="number" name="amount" min="1" value="{{ old('amount') }}" required>
            </div>

            <button type="submit" class="donate-btn">
                Donate Securely
            </button>
        </form>

    </div>
</div>
<script>
document.querySelector("form").addEventListener("submit", function(e) {
    e.preventDefault();

    let form = this;

    let name = form.querySelector("input[name='donor_name']").value;
    let email = form.querySelector("input[name='donor_email']").value;
    let phone = form.querySelector("input[name='donor_phone']").value;
    let amount = form.querySelector("input[name='amount']").value;

    if(amount < 1){
        alert("Please enter valid amount");
        return;
    }

    var options = {
        "key": "{{ env('RAZORPAY_KEY') }}", // from .env
        "amount": amount * 100, // paise
        "currency": "INR",
        "name": "SUVABANI FOUNDATION",
        "description": "Donation Payment",
        "image": "",

        "handler": function (response){
            
            // Create hidden inputs to send razorpay data
            let inputPayment = document.createElement("input");
            inputPayment.type = "hidden";
            inputPayment.name = "razorpay_payment_id";
            inputPayment.value = response.razorpay_payment_id;
            form.appendChild(inputPayment);

            let inputSignature = document.createElement("input");
            inputSignature.type = "hidden";
            inputSignature.name = "razorpay_signature";
            inputSignature.value = response.razorpay_signature;
            form.appendChild(inputSignature);

            let inputStatus = document.createElement("input");
            inputStatus.type = "hidden";
            inputStatus.name = "payment_status";
            inputStatus.value = "Paid";
            form.appendChild(inputStatus);

            form.submit();
        },

        "prefill": {
            "name": name,
            "email": email,
            "contact": phone
        },

        "theme": {
            "color": "#0f766e"
        }
    };

    var rzp = new Razorpay(options);
    rzp.open();
});
</script>

</body>
</html>
