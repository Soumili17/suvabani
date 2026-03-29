<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Donate Now | SUVABANI FOUNDATION</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

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
</head>

<body>

<div class="wrapper">
<div class="card">

<h2>Support SUVABANI FOUNDATION</h2>
<p class="subtitle">Your contribution makes a difference</p>

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
<div style="margin-top:15px;text-align:center;">
    <a href="{{ route('80g.form') }}" class="donate-btn" 
       style="display:block;background:linear-gradient(135deg,#1e3a8a,#2563eb);text-decoration:none;">
        Get 80G Tax Exemption Certificate
    </a>
</div>
</div>
</div>

<script>

// preset buttons
const amount = document.getElementById('amount');
document.querySelectorAll('.preset-btn').forEach(btn => {
    btn.onclick = () => {
        amount.value = btn.dataset.amt;
        document.querySelectorAll('.preset-btn').forEach(b=>b.classList.remove('active'));
        btn.classList.add('active');
    }
});

// 80G toggle
const radios = document.querySelectorAll("input[name='need_80g']");
const extra = document.getElementById("extraFields");
const requiredFields = extra.querySelectorAll("input, textarea");

function update80GFields(value) {
    if (value === "Yes") {
        extra.classList.remove("hidden");
        requiredFields.forEach(f => f.setAttribute("required", "required"));
    } else {
        extra.classList.add("hidden");
        requiredFields.forEach(f => {
            f.removeAttribute("required");
            // ❗ DO NOT clear values automatically (better UX)
        });
    }
}

// event listeners
radios.forEach(r => {
    r.addEventListener("change", function(){
        update80GFields(this.value);
    });
});

// INIT on load
window.addEventListener("DOMContentLoaded", function () {
    const selected = document.querySelector("input[name='need_80g']:checked");
    if (selected) {
        update80GFields(selected.value);
    }
});


// Razorpay
document.querySelector("form").addEventListener("submit", async function(e){

e.preventDefault();

let form = this;

let res = await fetch("/create-order",{
    method:"POST",
    headers:{
        "Content-Type":"application/json",
        "X-CSRF-TOKEN":"{{ csrf_token() }}"
    },
    body:JSON.stringify({
        amount:form.amount.value
    })
});

let data = await res.json();

let options = {

key: "{{ env('RAZORPAY_KEY') }}",
amount: data.amount,
currency: "INR",
name: "SUVABANI FOUNDATION",
description: "Donation",
order_id: data.order_id,

handler: function (response) {

    let input1 = document.createElement("input");
    input1.type = "hidden";
    input1.name = "razorpay_payment_id";
    input1.value = response.razorpay_payment_id;

    let input2 = document.createElement("input");
    input2.type = "hidden";
    input2.name = "razorpay_order_id";
    input2.value = response.razorpay_order_id;

    let input3 = document.createElement("input");
    input3.type = "hidden";
    input3.name = "razorpay_signature";
    input3.value = response.razorpay_signature;

    form.appendChild(input1);
    form.appendChild(input2);
    form.appendChild(input3);

    form.submit();
},

prefill:{
name: form.donor_name?.value || "",
email: form.donor_email?.value || "",
contact: form.donor_phone.value
}

};

new Razorpay(options).open();

});

</script>

</body>
</html>