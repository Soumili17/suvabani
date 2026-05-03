@extends('frontend.layouts.app')

@section('title', 'Donate Now | SUVABANI FOUNDATION')

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endpush

@push('styles')
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #f8fafc, #e0f2f1);
}

.wrapper {
    padding: 60px 20px;
}

.card {
    max-width: 550px;
    margin: auto;
    background: #fff;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

h2 {
    text-align: center;
    color: #0f766e;
}

.subtitle {
    text-align: center;
    font-size: 14px;
    color: #555;
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 18px;
}

label {
    font-weight: 600;
    display: block;
    margin-bottom: 5px;
}

input, textarea, select {
    width: 100%;
    padding: 11px;
    border-radius: 8px;
    border: 1px solid #ddd;
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
    background: #e5e7eb;
    border: none;
    border-radius: 6px;
    cursor: pointer;
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
.submit-btn {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(135deg, #0f766e, #14b8a6);
    color: #fff;
    font-weight: bold;
    cursor: pointer;
}

.hidden {
    display: none;
}

.alert-success {
    background: #dcfce7;
    color: #166534;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.alert-danger {
    background: #fee2e2;
    color: #991b1b;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
}
</style>
<link rel="stylesheet" href="{{ asset('assests/css/style.css') }}">
</head>

<body>

@include('frontend.partials.navbar')
<div class="donation-wrapper">
    <div class="donation-card">

<h2>Support SUVABANI FOUNDATION</h2>
<p class="subtitle">Your contribution makes a difference</p>

<div style="margin-bottom: 25px; text-align: center;">
    <a href="{{ route('80g.form') }}" style="display:inline-block; padding: 10px 20px; background: linear-gradient(135deg, #1e3a8a, #2563eb); color: white; border-radius: 6px; text-decoration: none; font-weight: bold;">
        🔍 Search & Download 80G Certificate
    </a>
</div>

@if(session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
<div class="alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('donate.store') }}">
@csrf

<!-- 80G Choice -->
<div class="form-group">
<label>Do you need 80G receipt? *</label>
<div class="radio-group">
<label><input type="radio" name="need_80g" value="Yes"> Yes</label>
<label><input type="radio" name="need_80g" value="No" checked> No</label>
</div>
</div>

<!-- BASIC -->
<div class="form-group">
<label>Phone Number *</label>
<input type="text" name="donor_phone" required>
</div>

<div class="form-group">
<label>Email (Optional)</label>
<input type="email" name="donor_email">
</div>

<!-- EXTRA (80G) -->
<div id="extraFields" class="hidden">

<div class="form-group">
<label>Full Name *</label>
<input type="text" name="donor_name">
</div>

<div class="form-group">
<label>Address *</label>
<textarea name="donor_address"></textarea>
</div>

<div class="form-group">
<label>City *</label>
<input type="text" name="donor_city">
</div>

<div class="form-group">
<label>State *</label>
<input type="text" name="donor_state">
</div>

<div class="form-group">
<label>Pincode *</label>
<input type="text" name="donor_pincode">
</div>

<div class="form-group">
<label>PAN Number *</label>
<input type="text" name="donor_pan" placeholder="ABCDE1234F">
</div>

</div>

<!-- PURPOSE -->
<div class="form-group">
<label>Purpose</label>
<select name="donation_purpose">
<option>General Donation</option>
<option>Education Support</option>
<option>Medical Help</option>
<option>Food Distribution</option>
</select>
</div>

<!-- AMOUNT -->
<div class="form-group">
<label>Amount (₹) *</label>
<input type="number" name="amount" id="amount" required>

<div style="margin-top:10px;">
<button type="button" class="preset-btn" data-amt="100">₹100</button>
<button type="button" class="preset-btn" data-amt="500">₹500</button>
<button type="button" class="preset-btn" data-amt="1000">₹1000</button>
<button type="button" class="preset-btn" data-amt="5000">₹5000</button>
</div>
</div>

<button type="submit" class="submit-btn">Donate Securely</button>

</form>
<!-- <div style="margin-top:15px;text-align:center;">
    <a href="{{ route('80g.form') }}" class="donate-btn" 
       style="display:block;background:linear-gradient(135deg,#1e3a8a,#2563eb);text-decoration:none;">
        🔍 Search & Download 80G Certificate
    </a>
</div> -->
</div>
</div>

<script>

// =======================
// PRESET AMOUNT BUTTONS
// =======================
const amountInput = document.getElementById('amount');

document.querySelectorAll('.preset-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        amountInput.value = btn.dataset.amt;

        document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});


// =======================
// 80G TOGGLE
// =======================
const radios = document.querySelectorAll("input[name='need_80g']");
const extra = document.getElementById("extraFields");
const requiredFields = extra.querySelectorAll("input, textarea");

function update80GFields(value) {
    if (value === "Yes") {
        extra.classList.remove("hidden");
        requiredFields.forEach(f => f.setAttribute("required", "required"));
    } else {
        extra.classList.add("hidden");
        requiredFields.forEach(f => f.removeAttribute("required"));
    }
}

radios.forEach(r => {
    r.addEventListener("change", function(){
        update80GFields(this.value);
    });
});

window.addEventListener("DOMContentLoaded", function () {
    const selected = document.querySelector("input[name='need_80g']:checked");
    if (selected) {
        update80GFields(selected.value);
    }
});


// =======================
// HELPER FUNCTION
// =======================
function createHiddenInput(name, value){
    let input = document.createElement("input");
    input.type = "hidden";
    input.name = name;
    input.value = value;
    return input;
}


// =======================
// MAIN SUBMIT LOGIC (FIXED FLOW)
// =======================
document.querySelector("form").addEventListener("submit", async function(e){

    e.preventDefault();

    let form = this;
    let formData = new FormData(form);

    try {

        // =======================
        // STEP 1: VALIDATE FIRST
        // =======================
        let validateRes = await fetch("/validate-donation", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        });

        if (!validateRes.ok) {
            alert("Validation failed. Please check your inputs.");
            return;
        }


        // =======================
        // STEP 2: CREATE ORDER
        // =======================
        let res = await fetch("/create-order", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                amount: form.amount.value
            })
        });

        let data = await res.json();


        // =======================
        // STEP 3: OPEN RAZORPAY
        // =======================
        let options = {
            key: "{{ env('RAZORPAY_KEY') }}",
            amount: data.amount,
            currency: "INR",
            name: "SUVABANI FOUNDATION",
            description: "Donation",
            order_id: data.order_id,

            handler: function (response) {

                // attach payment data
                form.appendChild(createHiddenInput("razorpay_payment_id", response.razorpay_payment_id));
                form.appendChild(createHiddenInput("razorpay_order_id", response.razorpay_order_id));
                form.appendChild(createHiddenInput("razorpay_signature", response.razorpay_signature));

                // =======================
                // STEP 4: FINAL SUBMIT
                // =======================
                form.submit();
            },

            prefill: {
                name: form.donor_name?.value || "",
                email: form.donor_email?.value || "",
                contact: form.donor_phone.value
            },

            theme: {
                color: "#0f766e"
            }
        };

        let rzp = new Razorpay(options);
        rzp.open();

    } catch (error) {
        console.error(error);
        alert("Something went wrong. Try again.");
    }

});

</script>

@endsection