@extends('frontend.layouts.app')

@section('title', 'Join Us | SUVABANI FOUNDATION')

@push('styles')
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:Segoe UI, sans-serif; } body { background:#eef3ff; color:#003f88; line-height:1.6; padding:20px; } /* HEADER */ .header { display:flex; justify-content:space-between; background:#ffffff; padding:15px 30px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1); margin-bottom:20px; } .header img { height:150px; width:110px; margin-top:10px; } .header .details { text-align:right; line-height:1.4; } .header .details h2 { color:#003f88; margin-bottom:5px; } .header .details p { font-size:14px; } /* FORM */ form { max-width:900px; margin:0 auto; background:#ffffff; padding:30px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1); position:relative; overflow:hidden; } fieldset { border:1px solid #003f88; border-radius:10px; padding:20px; display:none; } fieldset.active { display:block; animation:fadeIn 0.5s; } legend { font-weight:bold; color:#003f88; padding:0 10px; } label { display:block; margin-top:10px; font-weight:600; } /* INPUTS */ input[type="text"], input[type="email"], input[type="date"], input[type="file"], input[type="number"], select, textarea { width:100%; padding:8px 12px; margin-top:5px; border:1px solid #ccc; border-radius:6px; outline:none; transition:0.3s; } input:focus, textarea:focus, select:focus { border-color:#0d6efd; box-shadow:0 0 5px rgba(13,110,253,0.3); } textarea { resize:vertical; min-height:60px; } input[type="checkbox"], input[type="radio"] { margin-right:10px; } /* BUTTONS */ button { background:#0d6efd; color:white; border:none; padding:12px 25px; border-radius:6px; cursor:pointer; font-size:16px; margin-top:10px; transition:0.3s; } button:hover { background:#003f88; } .prevBtn { background:#dc3545; color:white; margin-right:10px; } /* IMAGE PREVIEW */ #photoPreview, #signaturePreview { margin-top:10px; max-width:150px; max-height:150px; border-radius:8px; border:1px solid #ccc; } /* PROGRESS BAR */ #progressbar { display:flex; justify-content:space-between; margin-bottom:20px; counter-reset: step; } #progressbar li { list-style-type:none; width:100%; text-align:center; position:relative; color:#ccc; font-weight:600; } #progressbar li::before { content:counter(step); counter-increment:step; width:30px; height:30px; line-height:30px; display:block; margin:0 auto 10px; border-radius:50%; background:#ccc; color:white; } #progressbar li.active { color:#003f88; } #progressbar li.active::before { background:#0d6efd; } #progressbar li::after { content:''; position:absolute; width:100%; height:3px; background:#ccc; top:15px; left:-50%; z-index:-1; } #progressbar li:first-child::after { content:none; } #progressbar li.active + li::after { background:#0d6efd; } /* LINE */ hr { border:none; height:1px; background:linear-gradient(to right, rgba(0,63,136,0), rgba(0,63,136,0.5), rgba(0,63,136,0)); margin:15px 0 20px; } /* ANIMATION */ @keyframes fadeIn { from {opacity:0; transform:translateX(50px);} to {opacity:1; transform:translateX(0);} } /* RESPONSIVE */ @media(max-width:768px){ form { padding:20px; } .header { flex-direction:column; text-align:center; } .header .details { text-align:center; margin-top:10px; } }
</style>
@endpush

@section('content')


<h1 style="text-align:center; margin-bottom:10px;">Membership Application Form</h1>

<!-- DOWNLOAD ID CARD BUTTON -->
<div style="text-align:center; margin-bottom:20px;">
    <a href="{{ route('member.search.page') }}"
       style="display:inline-block; padding:10px 24px; background:#008080; color:white;
              border-radius:25px; text-decoration:none; font-size:14px; font-weight:600;
              box-shadow:0 4px 12px rgba(0,128,128,0.3); transition:0.3s;"
       onmouseover="this.style.background='#006666'" onmouseout="this.style.background='#008080'">
        🪪 Already a Member? Download Your ID Card
    </a>
</div>

<!-- Progress Bar --> 
<ul id="progressbar"> <li class="active">Info</li> <li>Membership</li> <li>Declaration</li> </ul> <form id="membershipForm" action="{{ route('membership.submit') }}" method="POST" enctype="multipart/form-data"> @csrf


<!-- PAGE 1: PERSONAL INFO & PHOTO -->
<fieldset class="active">
<legend>Personal Details</legend>
<h4 style="color:#003f88; margin-bottom:8px;">📷 passport-size Photo</h4>
<p style="color:#555; font-size:13px; margin-bottom:10px;">Please upload a clear, recent passport-size photograph of yourself.</p>
<label for="photo">Select Photo (JPEG/PNG):</label>
<input
    type="file"
    id="photo"
    name="photo"
    accept="image/*"
    > 
<img id="photoPreview" src="#" alt="Photo Preview" style="display:none;">
<hr>

<label for="fullname">Your Full Name:</label>
<input type="text" name="fullname" id="fullname">

<div class="form-group half">
  <label for="dob">Date of Birth: <span style="color:red;">*</span></label>
  <input type="date" id="dob" name="dob" required>
</div>

<label>Gender:</label>
<input type="radio" name="gender" value="Male"> Male
<input type="radio" name="gender" value="Female"> Female
<input type="radio" name="gender" value="Other"> Other

<label for="blood_group">Blood Group (Optional):</label>
<select id="blood_group" name="blood_group">
    <option value="">Select Blood Group</option>
    <option value="A+">A+</option>
    <option value="A-">A-</option>
    <option value="B+">B+</option>
    <option value="B-">B-</option>
    <option value="AB+">AB+</option>
    <option value="AB-">AB-</option>
    <option value="O+">O+</option>
    <option value="O-">O-</option>
</select>

<label for="phone">Phone:</label>
<input type="text" id="phone" name="phone">

<label for="email">Email / Gmail:</label>
<input type="email" id="email" name="email">
<br>
<!--  -->
<button type="button" class="nextBtn">Next</button>
<!--  -->
</fieldset>

<!-- PAGE 2: MEMBERSHIP TYPE -->
<fieldset>
<legend>Membership Type</legend>
<label>
<input type="radio" name="membership_type" value="Paid"> Paid
</label>

<label>Select Membership Plan:</label>

<input type="radio" name="plan_id" value="plan_SVaR3a1MmEmmuJ">
₹100 - Basic Plan

<input type="radio" name="plan_id" value="plan_SRFl5J5teuIStk">
₹200 - Standard Plan

<input type="radio" name="plan_id" value="plan_SVaS0xDMQ4kpaE">
₹500 - Premium Plan

<input type="radio" name="plan_id" value="plan_SVaSS6ttAXZDx3">
₹1000 - Gold Plan



<label>
<input type="radio" name="membership_type" value="Non-Paid"> Non-Paid
</label>

<label>Type of Membership:</label>
<input type="radio" name="membertype" value="General Member"> General Member
<input type="radio" name="membertype" value="Student Member"> Student Member
<input type="radio" name="membertype" value="Donor Member"> Donor Member
<input type="radio" name="membertype" value="Advisory Member"> Advisory Member
<br>
<!--  -->
<button type="button" class="prevBtn">Previous</button>
<button type="button" class="nextBtn">Next</button>
<!--  -->
</fieldset>

<!-- PAGE 3: DECLARATION -->
<fieldset>
<legend>Declaration</legend>
<p>I hereby declare that the information provided is true and correct. I agree to follow the constitution, rules, and code of conduct of SUVABANI FOUNDATION.</p>

<label for="declaration_date" style="margin-top:12px;">Date of Declaration:</label>
<input type="date" name="declaration_date" id="declaration_date">
<br>
<!--  -->
<button type="button" class="prevBtn">Previous</button>
<button type="submit" class="submitBtn">Submit Application</button>
<!--  -->
</fieldset>


</form>
<div id="successModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">
    <div style="background:#fff; padding:30px; border-radius:10px; text-align:center; max-width:400px; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
        <div style="color:green; font-size:50px; margin-bottom:15px;">&#10003;</div>
        <h3 style="color:#008080; margin-bottom:10px;">Membership Submitted!</h3>
        <p style="margin-bottom:20px; color:#555;">Your membership application has been submitted successfully. Once the admin verifies your uploaded documents and approves it, you will be able to download your ID card.</p>
        <button onclick="closeModal()" type="button" style="background:#0d6efd; color:#fff; border:none; border-radius:5px; padding:10px 20px; cursor:pointer;">OK</button>
    </div>
</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
const form = document.getElementById('membershipForm');
const fieldsets = document.querySelectorAll('form fieldset');
const progressItems = document.querySelectorAll('#progressbar li');

let current = 0;

// ---------- STEP ----------
function showStep(n){
    fieldsets.forEach((fs,i)=> fs.classList.remove('active'));
    fieldsets[n].classList.add('active');
    progressItems.forEach((item,i)=> item.classList.toggle('active', i<=n));
}
showStep(current);

document.querySelectorAll('.nextBtn').forEach(btn=>{
    btn.onclick = ()=>{
        if(validateStep(current)){
            current++;
            showStep(current);
        }
    }
});

document.querySelectorAll('.prevBtn').forEach(btn=>{
    btn.onclick = ()=>{
        current--;
        showStep(current);
    }
});

// ---------- PHOTO PREVIEW ----------
document.getElementById('photo').onchange = evt => {
    const [file] = evt.target.files;
    if (file) {
        const preview = document.getElementById('photoPreview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
};

// ---------- VALIDATION ----------
function validateStep(step){
    switch(step){
        case 0:
            if(!form.photo.files.length) return alert('Upload photo'), false;
            if(!form.fullname.value.trim()) return alert('Name required'), false;
            if(!form.dob.value) return alert('DOB required'), false;
            if(!form.querySelector('[name="gender"]:checked')) return alert('Select gender'), false;
            if(!/^\d{10}$/.test(form.phone.value)) return alert('Invalid phone'), false;
            if(!/^\S+@\S+\.\S+$/.test(form.email.value)) return alert('Invalid email'), false;
        break;

        case 1:
            const membershipType = form.querySelector('[name="membership_type"]:checked');
            if(!membershipType) return alert('Select membership'), false;

            if(!form.querySelector('[name="membertype"]:checked')){
                return alert('Select member type'), false;
            }

            if(membershipType.value === "Paid"){
                const plan = form.querySelector('[name="plan_id"]:checked');
                if(!plan) return alert('Select plan'), false;
            }
        break;

        case 2:
            if(!form.declaration_date.value) return alert('Select date'), false;
        break;
    }
    return true;
}

// ---------- DISABLE PLAN ----------
const plans = document.querySelectorAll('[name="plan_id"]');
document.querySelectorAll('[name="membership_type"]').forEach(r=>{
    r.onchange = ()=>{
        if(r.value === "Non-Paid"){
            plans.forEach(p=>{
                p.checked = false;
                p.disabled = true;
            });
        } else {
            plans.forEach(p=> p.disabled = false);
        }
    }
});

// ---------- SUBMIT ----------
form.addEventListener('submit', async (e)=>{
    e.preventDefault();

    // validate all steps
    for(let i=0;i<fieldsets.length;i++){
        if(!validateStep(i)){
            current = i;
            showStep(i);
            return;
        }
    }

    const membershipType = form.querySelector('[name="membership_type"]:checked');

    // =========================
    // NON-PAID FLOW
    // =========================
    if(membershipType.value === "Non-Paid"){
        try{
            const res = await fetch(form.action,{
                method:"POST",
                headers:{
                    "X-CSRF-TOKEN":"{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: new FormData(form)
            });

            console.log("STATUS:", res.status);

            const result = await res.json();
            console.log("RESULT:", result);

            if(result.success){
                document.getElementById("successModal").style.display="flex";
            } else if(result.errors){
                alert(Object.values(result.errors)[0][0]);
            } else {
                alert(result.error || "Something went wrong");
            }

        } catch(err){
            console.error(err);
            alert("Request failed");
        }

        return;
    }

    // =========================
    // PAID FLOW (RAZORPAY)
    // =========================
    const plan = form.querySelector('[name="plan_id"]:checked');

    try{
        const res = await fetch("/create-membership-subscription",{
            method:"POST",
            headers:{
                "Content-Type":"application/json",
                "X-CSRF-TOKEN":"{{ csrf_token() }}"
            },
            body: JSON.stringify({ plan_id: plan.value })
        });

        const data = await res.json();
        console.log("SUBSCRIPTION:", data);

        if(!data.subscription_id){
            alert("Subscription failed");
            return;
        }

        const rzp = new Razorpay({
            key: "{{ config('services.razorpay.key') }}",
            subscription_id: data.subscription_id,

            prefill: {
                name: form.fullname.value || '',
                email: form.email.value || '',
                contact: form.phone.value || ''
            },

            handler: async function(response){
                try{
                    const formData = new FormData(form);
                    formData.append('razorpay_payment_id', response.razorpay_payment_id);
                    formData.append('razorpay_subscription_id', data.subscription_id);

                    const save = await fetch(form.action,{
                        method:"POST",
                        headers:{
                            "X-CSRF-TOKEN":"{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        body: formData
                    });

                    console.log("SAVE STATUS:", save.status);

                    const result = await save.json();
                    console.log("SAVE RESULT:", result);

                    if(result.success){
                        document.getElementById("successModal").style.display="flex";
                    } else if(result.errors){
                        alert(Object.values(result.errors)[0][0]);
                    } else {
                        alert(result.error || "Save failed");
                    }

                } catch(err){
                    console.error(err);
                    alert("Save error");
                }
            }
        });

        rzp.open();

    } catch(err){
        console.error(err);
        alert("Payment error");
    }
});

// ---------- DATE ----------
const today = new Date().toISOString().split('T')[0];
const dateInput = document.getElementById('declaration_date');
dateInput.value = today;
dateInput.min = today;
dateInput.max = today;

// ---------- MODAL ----------
function closeModal(){
    document.getElementById("successModal").style.display="none";
}
</script>@endsection
