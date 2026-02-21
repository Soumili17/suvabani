<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:Segoe UI, sans-serif; }
body { background:#f0f8f8; color:#033; line-height:1.6; padding:20px; }
.header { display:flex; justify-content:space-between; background:#fff; padding:15px 30px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1); margin-bottom:20px; }
.header img { height:150px; width:110px; margin-top:2.7%; }
.header .details { text-align:right; line-height:1.4; }
.header .details h2 { color:#008080; margin-bottom:5px; }
.header .details p { font-size:14px; }
form { max-width:900px; margin:0 auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1); position:relative; overflow:hidden; }
fieldset { border:1px solid #008080; border-radius:10px; padding:20px; display:none; }
fieldset.active { display:block; animation:fadeIn 0.5s; }
legend { font-weight:bold; color:#008080; padding:0 10px; }
label { display:block; margin-top:10px; font-weight:600; }
input[type="text"], input[type="email"], input[type="date"], input[type="file"], input[type="number"], select, textarea { width:100%; padding:8px 12px; margin-top:5px; border:1px solid #ccc; border-radius:6px; outline:none; transition:0.3s; }
input:focus, textarea:focus, select:focus { border-color:#008080; box-shadow:0 0 5px rgba(0,128,128,0.3); }
textarea { resize:vertical; min-height:60px; }
input[type="checkbox"], input[type="radio"] { margin-right:10px; }
button { background:#008080; color:white; border:none; padding:12px 25px; border-radius:6px; cursor:pointer; font-size:16px; margin-top:10px; transition:0.3s; }
button:hover { background:#006666; }
/*  */
.prevBtn { background:#ccc; color:#033; margin-right:10px; }
/*  */
#photoPreview, #signaturePreview { margin-top:10px; max-width:150px; max-height:150px; border-radius:8px; border:1px solid #ccc; }
#progressbar { display:flex; justify-content:space-between; margin-bottom:20px; counter-reset: step; }
#progressbar li { list-style-type:none; width:100%; text-align:center; position:relative; color:#ccc; font-weight:600; }
#progressbar li::before { content:counter(step); counter-increment:step; width:30px; height:30px; line-height:30px; display:block; margin:0 auto 10px; border-radius:50%; background:#ccc; color:white; }
#progressbar li.active { color:#008080; }
#progressbar li.active::before { background:#008080; }
#progressbar li::after { content:''; position:absolute; width:100%; height:3px; background:#ccc; top:15px; left:-50%; z-index:-1; }
#progressbar li:first-child::after { content:none; }
#progressbar li.active + li::after { background:#008080; }
hr { border:none; height:1px; background:linear-gradient(to right, rgba(0,128,128,0), rgba(0,128,128,0.5), rgba(0,128,128,0)); margin:15px 0 20px; }
@keyframes fadeIn { from {opacity:0; transform:translateX(50px);} to {opacity:1; transform:translateX(0);} }
@media(max-width:768px){ form { padding:20px; } .header { flex-direction:column; text-align:center; } .header .details { text-align:center; margin-top:10px; } }
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
<label for="fullname">Full Name:</label>
<input type="text" id="fullname" name="fullname">
<label for="parentname">Father's/Mother's/Spouse's Name:</label>
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
<input type="checkbox" name="idproof[]" value="Aadhaar"> Aadhaar
<input type="checkbox" name="idproof[]" value="PAN"> PAN
<input type="checkbox" name="idproof[]" value="Voter ID"> Voter ID
<input type="checkbox" name="idproof[]" value="Passport"> Passport
<input type="checkbox" name="idproof[]" value="Other"> Other: <input type="text" name="idproof_other">
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
<label><input type="checkbox" name="membership[]" value="Paid"> Paid - Rs. 200 or More Rs. <input type="number" name="paidamount" min="200"></label>
<label><input type="checkbox" name="membership[]" value="Non-Paid"> Non-Paid</label>
<label>Type of Membership:</label>
<input type="checkbox" name="membertype[]" value="General Member"> General Member
<input type="checkbox" name="membertype[]" value="Student Member"> Student Member
<input type="checkbox" name="membertype[]" value="Donor Member"> Donor Member
<input type="checkbox" name="membertype[]" value="Advisory Member"> Advisory Member
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
<input type="checkbox" name="time[]" value="1-2 hrs"> 1-2 hrs
<input type="checkbox" name="time[]" value="3-5 hrs"> 3-5 hrs
<input type="checkbox" name="time[]" value="Weekends only"> Weekends only
<input type="checkbox" name="time[]" value="Full-time"> Full-time
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
<label>Date:</label>
<input type="date" name="declaration_date">
<br>
<!--  -->
<button type="button" class="prevBtn">Previous</button>
<button type="submit" class="submitBtn">Submit Application</button>
<!--  -->
</fieldset>


</form>
<script>
    // STEP-WISE FORM VALIDATION
    const fieldsets = document.querySelectorAll('form fieldset');
    const progressItems = document.querySelectorAll('#progressbar li');
    let current = 0;
    
    function showStep(n){
        fieldsets.forEach((fs,i)=> fs.classList.remove('active'));
        fieldsets[n].classList.add('active');
        progressItems.forEach((item,i)=> item.classList.toggle('active', i<=n));
    }
    showStep(current);

// <!--  -->
   // NEXT BUTTON
document.querySelectorAll('.nextBtn').forEach(btn=>{
    btn.addEventListener('click', ()=>{
        if(validateStep(current)){
            if(current < fieldsets.length - 1){
                current++;
                showStep(current);
            }
        }
    });
});

// PREVIOUS BUTTON
document.querySelectorAll('.prevBtn').forEach(btn=>{
    btn.addEventListener('click', ()=>{
        if(current > 0){
            current--;
            showStep(current);
        }
    });
});
// <!--  -->

    // STEP-WISE VALIDATION
    function validateStep(step){
        const form = document.getElementById('membershipForm');
        switch(step){
            case 0: // Photo
                if(!form.photo.files.length){
                    alert('Please upload your photo.');
                    return false;
                }
                break;
            case 1: // Personal Details
                if(form.fullname.value.trim()===''){ alert('Full Name is required.'); return false; }
                if(form.parentname.value.trim()===''){ alert("Parent/Spouse Name is required."); return false; }
                if(form.dob.value===''){ alert('Date of Birth is required.'); return false; }
                if(!form.querySelector('input[name="gender"]:checked')){ alert('Please select gender.'); return false; }
                if(form.nationality.value.trim()===''){ alert('Nationality is required.'); return false; }
                if(form.occupation.value.trim()===''){ alert('Occupation is required.'); return false; }
                if(form.address.value.trim()===''){ alert('Address is required.'); return false; }
                if(form.phone.value.trim()===''){ alert('Phone number is required.'); return false; }
                if(!/^\d{10}$/.test(form.phone.value)){ alert('Phone must be 10 digits.'); return false; }
                if(form.email.value.trim()===''){ alert('Email is required.'); return false; }
                if(!/^\S+@\S+\.\S+$/.test(form.email.value)){ alert('Enter a valid email.'); return false; }
                break;
            case 2: // ID Proof
                if(!form.querySelector('input[name="idproof[]"]:checked')){ alert('Please select at least one ID proof.'); return false; }
                if(form.idnumber.value.trim()===''){ alert('ID Number is required.'); return false; }
                if(!form.idfile.files.length){ alert('Please upload your ID proof file.'); return false; }
                break;
            case 3: // Membership Type
                if(!form.querySelector('input[name="membership[]"]:checked')){ alert('Please select at least one membership type.'); return false; }
                if(!form.querySelector('input[name="membertype[]"]:checked')){ alert('Please select at least one member type.'); return false; }
                break;
            case 4: // Areas of Interest
                if(!form.querySelector('input[name="interest[]"]:checked')){ alert('Please select at least one area of interest.'); return false; }
                break;
            case 5: // Other Information
                // optional step, you can enforce certain fields if needed
                break;
            case 6: // Declaration
                if(!form.signature.files.length){ alert('Please upload your signature image.'); return false; }
                if(form.declaration_date.value===''){ alert('Please select declaration date.'); return false; }
                break;
        }
        return true;
    }
// <--!  -->
    // FINAL SUBMIT VALIDATION
document.getElementById('membershipForm').addEventListener('submit', function(e){
    for(let i=0;i<fieldsets.length;i++){
        if(!validateStep(i)){ 
            e.preventDefault();
            current = i; 
            showStep(current);
            return;
        }
    }
});
// <--!  -->

    </script>