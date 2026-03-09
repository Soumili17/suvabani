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

        .radio-group {
            display: flex;
            gap: 20px;
        }

        .preset-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            background: #e5e7eb;
        }

        .preset-btn.active {
            background: #14b8a6;
            color: white;
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

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-danger">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('donate.store') }}">
@csrf

<div class="form-group">
<label>Full Name *</label>
<input type="text" name="donor_name" required>
</div>

<div class="form-group">
<label>Email Address *</label>
<input type="email" name="donor_email" required>
</div>

<div class="form-group">
<label>Phone Number *</label>
<input type="text" name="donor_phone" required>
</div>

<div class="form-group">
<label>Address *</label>
<textarea name="donor_address" rows="3" required></textarea>
</div>

<div class="form-group">
<label>City *</label>
<input type="text" name="donor_city" required>
</div>

<div class="form-group">
<label>State *</label>
<input type="text" name="donor_state" required>
</div>

<div class="form-group">
<label>Pincode *</label>
<input type="text" name="donor_pincode" required>
</div>

<div class="form-group">
<label>Purpose of Donation</label>
<select name="donation_purpose">
<option value="General Donation">General Donation</option>
<option value="Education Support">Education Support</option>
<option value="Medical Help">Medical Help</option>
<option value="Food Distribution">Food Distribution</option>
</select>
</div>

<!-- 80G Selection -->
<div class="form-group">
<label>Do you require 80G tax exemption receipt? *</label>
<div class="radio-group">
<label><input type="radio" name="need_80g" value="Yes" required> Yes</label>
<label><input type="radio" name="need_80g" value="No"> No</label>
</div>
</div>

<div class="form-group" id="panField" style="display:none;">
<label>PAN Card Number *</label>
<input type="text" id="donorPan" name="donor_pan" placeholder="ABCDE1234F" style="text-transform:uppercase;">
</div>

<div class="form-group">
<label>Donation Amount (₹) *</label>
<input type="number" id="donationAmount" name="amount" min="1" required>

<div style="margin-top:10px;">
<button type="button" class="preset-btn" data-amount="100">₹100</button>
<button type="button" class="preset-btn" data-amount="500">₹500</button>
<button type="button" class="preset-btn" data-amount="1000">₹1000</button>
<button type="button" class="preset-btn" data-amount="5000">₹5000</button>
</div>
</div>

<input type="hidden" name="donation_date" value="{{ date('Y-m-d') }}">

<button type="submit" class="donate-btn">Donate Securely</button>

</form>

    </div>
</div>

<script>
const amountInput = document.getElementById('donationAmount');
const presetButtons = document.querySelectorAll('.preset-btn');

presetButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        amountInput.value = this.dataset.amount;
        presetButtons.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});

// 80G toggle
const panField = document.getElementById('panField');
const panInput = document.getElementById('donorPan');
const radioButtons = document.querySelectorAll("input[name='need_80g']");

radioButtons.forEach(radio => {
    radio.addEventListener("change", function () {
        if (this.value === "Yes") {
            panField.style.display = "block";
            panInput.setAttribute("required", "required");
        } else {
            panField.style.display = "none";
            panInput.removeAttribute("required");
            panInput.value = "";
        }
    });
});

// Razorpay Integration
document.querySelector("form").addEventListener("submit", function(e) {
    e.preventDefault();

    let form = this;
    let name = form.donor_name.value;
    let email = form.donor_email.value;
    let phone = form.donor_phone.value;
    let amount = form.amount.value;
    let need80g = form.need_80g.value;
    let pan = form.donor_pan.value;

    if (amount < 1) {
        alert("Enter valid donation amount");
        return;
    }

    if (need80g === "Yes") {
        let panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
        if (!panRegex.test(pan.toUpperCase())) {
            alert("Enter valid PAN number (Example: ABCDE1234F)");
            return;
        }
    }

    var options = {
        key: "{{ env('RAZORPAY_KEY') }}",
        amount: amount * 100,
        currency: "INR",
        name: "SUVABANI FOUNDATION",
        description: "Donation Payment",
        handler: function (response) {

            let inputPayment = document.createElement("input");
            inputPayment.type = "hidden";
            inputPayment.name = "razorpay_payment_id";
            inputPayment.value = response.razorpay_payment_id;
            form.appendChild(inputPayment);

            form.submit();
        },
        prefill: {
            name: name,
            email: email,
            contact: phone
        },
        theme: {
            color: "#0f766e"
        }
    };

    var rzp = new Razorpay(options);
    rzp.open();
});
</script>

</body>
</html>