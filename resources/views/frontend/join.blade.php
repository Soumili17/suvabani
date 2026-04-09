<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:Segoe UI, sans-serif; } body { background:#eef3ff; color:#003f88; line-height:1.6; padding:20px; } /* HEADER */ .header { display:flex; justify-content:space-between; background:#ffffff; padding:15px 30px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1); margin-bottom:20px; } .header img { height:150px; width:110px; margin-top:10px; } .header .details { text-align:right; line-height:1.4; } .header .details h2 { color:#003f88; margin-bottom:5px; } .header .details p { font-size:14px; } /* FORM */ form { max-width:900px; margin:0 auto; background:#ffffff; padding:30px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1); position:relative; overflow:hidden; } fieldset { border:1px solid #003f88; border-radius:10px; padding:20px; display:none; } fieldset.active { display:block; animation:fadeIn 0.5s; } legend { font-weight:bold; color:#003f88; padding:0 10px; } label { display:block; margin-top:10px; font-weight:600; } /* INPUTS */ input[type="text"], input[type="email"], input[type="date"], input[type="file"], input[type="number"], select, textarea { width:100%; padding:8px 12px; margin-top:5px; border:1px solid #ccc; border-radius:6px; outline:none; transition:0.3s; } input:focus, textarea:focus, select:focus { border-color:#0d6efd; box-shadow:0 0 5px rgba(13,110,253,0.3); } textarea { resize:vertical; min-height:60px; } input[type="checkbox"], input[type="radio"] { margin-right:10px; } /* BUTTONS */ button { background:#0d6efd; color:white; border:none; padding:12px 25px; border-radius:6px; cursor:pointer; font-size:16px; margin-top:10px; transition:0.3s; } button:hover { background:#003f88; } .prevBtn { background:#dc3545; color:white; margin-right:10px; } /* IMAGE PREVIEW */ #photoPreview, #signaturePreview { margin-top:10px; max-width:150px; max-height:150px; border-radius:8px; border:1px solid #ccc; } /* PROGRESS BAR */ #progressbar { display:flex; justify-content:space-between; margin-bottom:20px; counter-reset: step; } #progressbar li { list-style-type:none; width:100%; text-align:center; position:relative; color:#ccc; font-weight:600; } #progressbar li::before { content:counter(step); counter-increment:step; width:30px; height:30px; line-height:30px; display:block; margin:0 auto 10px; border-radius:50%; background:#ccc; color:white; } #progressbar li.active { color:#003f88; } #progressbar li.active::before { background:#0d6efd; } #progressbar li::after { content:''; position:absolute; width:100%; height:3px; background:#ccc; top:15px; left:-50%; z-index:-1; } #progressbar li:first-child::after { content:none; } #progressbar li.active + li::after { background:#0d6efd; } /* LINE */ hr { border:none; height:1px; background:linear-gradient(to right, rgba(0,63,136,0), rgba(0,63,136,0.5), rgba(0,63,136,0)); margin:15px 0 20px; } /* ANIMATION */ @keyframes fadeIn { from {opacity:0; transform:translateX(50px);} to {opacity:1; transform:translateX(0);} } /* RESPONSIVE */ @media(max-width:768px){ form { padding:20px; } .header { flex-direction:column; text-align:center; } .header .details { text-align:center; margin-top:10px; } }
</style>
<div class="header">
<img src="{{ asset('assests/images/formlogo.png') }}">
<div class="details"> <h2>SUVABANI FOUNDATION ( শুভাবনী ফাউন্ডেশন )</h2> <p>Govt. Registration No. IV-160300107/2025</p> <p>Rania Pravat Pally, P.O. Boral, P.S. Narendrapur, Kolkata- 700 154</p> <p>Contact No.: 7059590022 | Email: suvabanifoundation@gmail.com</p> </div> </div>

<h1 style="text-align:center; margin-bottom:20px;">Membership Application Form</h1>
<!-- Progress Bar --> 
<ul id="progressbar"> <li class="active">Photo</li> <li>Personal</li> <li>ID Proof</li> <li>Membership</li> <li>Interest</li> <li>Other</li> <li>Declaration</li> </ul> <form id="membershipForm" action="{{ route('membership.submit') }}" method="POST" enctype="multipart/form-data"> @csrf


<!-- PHOTO UPLOAD -->
<fieldset class="active">
<legend>Upload Photo</legend>
<label for="photo">Upload Your Photo:</label>
<input type="file" id="photo" name="photo" accept="image/*">
<img id="photoPreview" src="#" alt="Photo Preview" style="display:none;">
<br>
<!--  -->
<button type="button" class="nextBtn">Next</button>
<!--  -->
</fieldset>

<!-- PERSONAL DETAILS -->
<fieldset>
<legend>Personal Details</legend>
<label for="fullname">Your Full Name:</label>
<input type="text" name="fullname" id="fullname">
<label for="parent_type">Relation:</label>
<select id="parent_type" name="parent_type">
    <option value="">Select</option>
    <option value="Father">Father</option>
    <option value="Mother">Mother</option>
    <option value="Spouse">Spouse</option>
</select>

<label for="parentname">Gardian Name:</label>
<input type="text" id="parentname" name="parentname">

<label for="dob">Date of Birth:</label>
<input type="date" id="dob" name="dob">
<label>Gender:</label>
<input type="radio" name="gender" value="Male"> Male
<input type="radio" name="gender" value="Female"> Female
<input type="radio" name="gender" value="Other"> Other
<label for="nationality">Nationality:</label>
<input type="text" id="nationality" name="nationality">
<label for="occupation">Occupation:</label>
<input type="text" id="occupation" name="occupation">
<label for="address">Address:</label>
<textarea id="address" name="address"></textarea>
<label for="phone">Phone:</label>
<input type="text" id="phone" name="phone">
<label for="email">Email:</label>
<input type="email" id="email" name="email">
<br>
<!--  -->
<button type="button" class="prevBtn">Previous</button>
<button type="button" class="nextBtn">Next</button>
<!--  -->
</fieldset>

<!-- ID PROOF -->
<fieldset>
<legend>ID Proof</legend>
<label>ID Proof:</label>
<input type="radio" name="idproof" value="Aadhar"> Aadhaar
<input type="radio" name="idproof" value="PAN"> PAN
<input type="radio" name="idproof" value="Voter"> Voter ID
<input type="radio" name="idproof" value="Passport"> Passport
<label for="idnumber">ID Number:</label>
<input type="text" id="idnumber" name="idnumber">
<label for="idfile">Upload ID Proof:</label>
<input type="file" id="idfile" name="idfile" accept=".pdf,.jpg,.jpeg,.png">
<br>
<!--  -->
<button type="button" class="prevBtn">Previous</button>
<button type="button" class="nextBtn">Next</button>
<!--  -->
</fieldset>

<!-- MEMBERSHIP TYPE -->
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

<!-- AREAS OF INTEREST -->
<fieldset>
<legend>Areas of Interest</legend>
<input type="checkbox" name="interest[]" value="Child Education"> Child Education
<input type="checkbox" name="interest[]" value="Senior Citizens Welfare"> Senior Citizens Welfare
<input type="checkbox" name="interest[]" value="Health & Nutrition"> Health & Nutrition
<input type="checkbox" name="interest[]" value="Disaster Relief"> Disaster Relief
<input type="checkbox" name="interest[]" value="Water & Sanitation"> Water & Sanitation
<input type="checkbox" name="interest[]" value="Tribal & Rural Development"> Tribal & Rural Development
<input type="checkbox" name="interest[]" value="Other"> Other: <input type="text" name="interest_other">
<br>
<!--  -->
<button type="button" class="prevBtn">Previous</button>
<button type="button" class="nextBtn">Next</button>
<!--  -->
</fieldset>

<!-- OTHER INFORMATION -->
<fieldset>
<legend>Other Information</legend>
<label>Previous Experience:</label>
<textarea name="experience"></textarea>
<label>Languages Known:</label>
<input type="text" name="languages">
<label>Time You Can Dedicate:</label>
<input type="radio" name="time" value="1-2 hrs"> 1-2 hrs
<input type="radio" name="time" value="3-5 hrs"> 3-5 hrs
<input type="radio" name="time" value="Weekends only"> Weekends only
<input type="radio" name="time" value="Full-time"> Full-time
<label>Reason for Joining:</label>
<textarea name="reason"></textarea>
<label>Reference (if any):</label>
Name: <input type="text" name="ref_name">
Mobile: <input type="text" name="ref_mobile">
<br>
<!--  -->
<button type="button" class="prevBtn">Previous</button>
<button type="button" class="nextBtn">Next</button>
<!--  -->
</fieldset>

<!-- DECLARATION WITH SIGNATURE IMAGE -->
<fieldset>
<legend>Declaration</legend>
<p>I hereby declare that the information provided is true and correct. I agree to follow the constitution, rules, and code of conduct of SUVABANI FOUNDATION.</p>
<label>Signature Upload:</label>
<input type="file" id="signature" name="signature" accept="image/*">
<img id="signaturePreview" src="#" alt="Signature Preview" style="display:none;">
<input type="date" name="declaration_date" id="declaration_date">
<br>
<!--  -->
<button type="button" class="prevBtn">Previous</button>
<button type="submit" class="submitBtn">Submit Application</button>
<!--  -->
</fieldset>


</form>
<div id="successModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
    <div style="background:#fff; padding:30px; border-radius:10px; text-align:center; max-width:400px;">
        <h3 style="color:#008080;">Success</h3>
        <p>Your application is submitted successfully.<br>Wait for approval.</p>
        <button onclick="closeModal()">OK</button>
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

// ---------- VALIDATION ----------
function validateStep(step){

    switch(step){

        case 0:
            if(!form.photo.files.length) return alert('Upload photo'), false;
        break;

        case 1:
            if(!form.fullname.value.trim()) return alert('Name required'), false;
            if(!form.parent_type.value) return alert('Select relation'), false;
            if(!form.parentname.value.trim()) return alert('Relation name required'), false;
            if(!form.dob.value) return alert('DOB required'), false;
            if(!form.querySelector('[name="gender"]:checked')) return alert('Select gender'), false;
            if(!form.nationality.value.trim()) return alert('Nationality required'), false;
            if(!form.occupation.value.trim()) return alert('Occupation required'), false;
            if(!form.address.value.trim()) return alert('Address required'), false;
            if(!/^\d{10}$/.test(form.phone.value)) return alert('Invalid phone'), false;
            if(!/^\S+@\S+\.\S+$/.test(form.email.value)) return alert('Invalid email'), false;
        break;

        case 2:
            if(!form.querySelector('[name="idproof"]:checked')) return alert('Select ID proof'), false;
            if(!form.idnumber.value.trim()) return alert('Enter ID number'), false;
            if(!form.idfile.files.length) return alert('Upload ID file'), false;
        break;

        case 3:
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

        case 4:
            if(!form.querySelector('[name="interest[]"]:checked')) return alert('Select interest'), false;
        break;

        case 5:
            if(!form.querySelector('[name="time"]:checked')) return alert('Select time'), false;
        break;

        case 6:
            if(!form.signature.files.length) return alert('Upload signature'), false;
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

    for(let i=0;i<fieldsets.length;i++){
        if(!validateStep(i)){
            current = i;
            showStep(i);
            return;
        }
    }

    const membershipType = form.querySelector('[name="membership_type"]:checked');

    // NON-PAID
    if(membershipType.value === "Non-Paid"){
        const res = await fetch(form.action,{
            method:"POST",
            headers:{ "X-CSRF-TOKEN":"{{ csrf_token() }}" },
            body: new FormData(form)
        });

        const result = await res.json();

        if(result.success){
            document.getElementById("successModal").style.display="flex";
        } else {
            alert(result.error || "Error");
        }
        return;
    }

    // PAID
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

        if(!data.subscription_id){
            alert("Subscription failed");
            return;
        }

        const rzp = new Razorpay({
            key: "{{ config('services.razorpay.key') }}",
            subscription_id: data.subscription_id,

            // ✅ ADD THIS
            prefill: {
                name: form.fullname.value || '',
                email: form.email.value || '',
                contact: form.phone.value || ''
            },

            // ✅ OPTIONAL BUT USEFUL
            notes: {
                name: form.fullname.value,
                email: form.email.value,
                phone: form.phone.value
            },

            handler: async function(response){

                const formData = new FormData(form);
                formData.append('razorpay_payment_id', response.razorpay_payment_id);
                formData.append('razorpay_subscription_id', data.subscription_id);

                const save = await fetch(form.action,{
                    method:"POST",
                    headers:{ "X-CSRF-TOKEN":"{{ csrf_token() }}" },
                    body: formData
                });

                const result = await save.json();

                if(result.success){
                    document.getElementById("successModal").style.display="flex";
                } else {
                    alert(result.error || "Save failed");
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
</script>