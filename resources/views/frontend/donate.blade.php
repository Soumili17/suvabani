@extends('frontend.layouts.app')

@section('title', 'Donate Now | SUVABANI FOUNDATION')

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endpush

@push('styles')
<style>
.donation-wrapper {
    padding: 32px 16px 64px;
    background: #f5f9ff;
}

.donation-card {
    max-width: 760px;
    margin: auto;
    background: #fff;
    padding: 28px;
    border-radius: 18px;
    box-shadow: 0 8px 28px rgba(0,43,92,.10);
}

h2 {
    color: #003f88;
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
    background: linear-gradient(135deg, #003f88, #1a73e8);
    color: #fff;
    font-weight: bold;
    cursor: pointer;
}
.campaign-donate-button { background:#003f88; border-color:#003f88; color:#fff; }

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
.campaign-donation-media.slide {
    position: relative;
    top: auto;
    left: auto;
    width: 100%;
    height: 360px;
    display: block;
    align-items: initial;
    opacity: 1;
    z-index: auto;
    background: #eaf2fb;
    border-radius: 16px;
    overflow: hidden;
}
.campaign-donation-media .carousel-inner,
.campaign-donation-media .carousel-item { height: 100%; }
.campaign-donation-media img, .campaign-donation-media video { width:100%; height:360px; object-fit:cover; }
.campaign-donation-thumbnails { display:flex; gap:8px; overflow-x:auto; padding:2px 0 4px; }
.campaign-donation-thumbnail { position:relative; flex:0 0 78px; height:56px; padding:0; border:2px solid transparent; border-radius:8px; overflow:hidden; background:#eaf2fb; }
.campaign-donation-thumbnail.active { border-color:#003f88; }
.campaign-donation-thumbnail img, .campaign-donation-thumbnail video { width:100%; height:100%; object-fit:cover; }
.campaign-donation-thumbnail .video-icon { position:absolute; inset:0; display:grid; place-items:center; color:#fff; background:rgba(0,43,92,.35); }
.campaign-stat { border:1px solid #e0e8f2; border-radius:12px; padding:14px; background:#f8fbff; }
.campaign-stat strong { display:block; color:#003f88; font-size:1.15rem; }
.share-button { border-color:#003f88; color:#003f88; }
.share-fallback[hidden] { display:none !important; }
@media (max-width: 576px) {
    .donation-card { padding: 20px 16px; }
    .campaign-donation-media.slide, .campaign-donation-media img, .campaign-donation-media video { height: 235px; }
}
</style>
@endpush

@section('content')
<div class="donation-wrapper">
    <div class="donation-card">

@if($campaign)
    @php
        $raised = $campaign->totalDonations();
        $progress = $campaign->progressPercentage();
        $mediaItems = collect();
        if ($campaign->cover_media_path) {
            $mediaItems->push((object) ['media_type' => 'image', 'file_path' => $campaign->cover_media_path, 'caption' => $campaign->title]);
        }
        foreach ($campaign->media as $media) {
            $mediaItems->push($media);
        }
    @endphp
    <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
        <div>
            <a href="{{ route('campaigns.show', $campaign->slug) }}" class="text-decoration-none small">&larr; Campaign details</a>
            <h1 class="h3 mb-0 mt-1 text-primary">{{ $campaign->title }}</h1>
        </div>
        <button type="button" class="btn btn-outline-primary btn-sm share-button" data-share-url="{{ route('campaigns.show', $campaign->slug) }}" data-share-title="{{ $campaign->title }}">
            <i class="fas fa-share-alt me-1"></i> Share
        </button>
    </div>
    <p class="subtitle text-start">{{ $campaign->short_description ?? 'Your contribution makes a difference.' }}</p>

    @if($mediaItems->isNotEmpty())
        <div id="campaignDonationCarousel" class="carousel slide campaign-donation-media mb-4" data-bs-ride="carousel" data-bs-interval="5000">
            @if($mediaItems->count() > 1)
                <div class="carousel-indicators">
                    @foreach($mediaItems as $media)
                        <button type="button" data-bs-target="#campaignDonationCarousel" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-label="Slide {{ $loop->iteration }}"></button>
                    @endforeach
                </div>
            @endif
            <div class="carousel-inner h-100">
                @foreach($mediaItems as $media)
                    <div class="carousel-item h-100 {{ $loop->first ? 'active' : '' }}">
                        @if($media->media_type === 'video')
                            <video src="{{ asset('storage/'.$media->file_path) }}" controls preload="metadata"></video>
                        @else
                            <img src="{{ asset('storage/'.$media->file_path) }}" alt="{{ $media->caption ?: $campaign->title }}">
                        @endif
                    </div>
                @endforeach
            </div>
            @if($mediaItems->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#campaignDonationCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span><span class="visually-hidden">Previous</span></button>
                <button class="carousel-control-next" type="button" data-bs-target="#campaignDonationCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span><span class="visually-hidden">Next</span></button>
            @endif
        </div>
        @if($mediaItems->count() > 1)
            <div class="campaign-donation-thumbnails mb-4" aria-label="Campaign media thumbnails">
                @foreach($mediaItems as $media)
                    <button type="button" class="campaign-donation-thumbnail {{ $loop->first ? 'active' : '' }}"
                            data-bs-target="#campaignDonationCarousel" data-bs-slide-to="{{ $loop->index }}"
                            aria-label="Show media {{ $loop->iteration }}">
                        @if($media->media_type === 'video')
                            <video src="{{ asset('storage/'.$media->file_path) }}" muted preload="metadata"></video>
                            <span class="video-icon"><i class="fas fa-play"></i></span>
                        @else
                            <img src="{{ asset('storage/'.$media->file_path) }}" alt="">
                        @endif
                    </button>
                @endforeach
            </div>
        @endif
    @endif

    <section class="mb-4" aria-labelledby="campaign-progress-heading">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 id="campaign-progress-heading" class="h5 mb-0">Fundraising progress</h2>
            <strong class="text-primary">{{ number_format($progress, 1) }}%</strong>
        </div>
        <div class="progress" style="height:12px;" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-success" style="width:{{ $progress }}%"></div>
        </div>
        <div class="row g-2 mt-2">
            <div class="col-4"><div class="campaign-stat"><small class="text-muted">Goal</small><strong>₹{{ number_format($campaign->goal_amount / 100, 0) }}</strong></div></div>
            <div class="col-4"><div class="campaign-stat"><small class="text-muted">Raised</small><strong>₹{{ number_format($raised / 100, 0) }}</strong></div></div>
            <div class="col-4"><div class="campaign-stat"><small class="text-muted">Donors</small><strong>{{ $campaign->donorCount() }}</strong></div></div>
        </div>
    </section>
@else
    <h1 class="h3 text-center">Support SUVABANI FOUNDATION</h1>
    <p class="subtitle">Your contribution makes a difference.</p>
    @if(request()->has('campaign'))
        <div class="alert alert-info">This campaign is unavailable. Please open the Donate button from an active campaign.</div>
    @endif
@endif
<div class="share-fallback border rounded p-3 mt-3" hidden id="shareFallback">
    <label for="shareUrl" class="form-label fw-semibold">Campaign link</label>
    <div class="input-group">
        <input id="shareUrl" class="form-control" readonly>
        <button type="button" class="btn btn-outline-primary" id="copyShareUrl">Copy link</button>
    </div>
    <small id="copyShareFeedback" class="text-success d-block mt-2" role="status"></small>
</div>

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
@if($campaign)
<input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
@endif

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
<label>Full Name *</label>
<input type="text" name="donor_name" required placeholder="Enter your full name">
</div>

<div class="form-group">
<label><input type="checkbox" name="anonymous" value="1" style="width:auto;"> Display me as Anonymous on the donor list</label>
</div>

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

@if($campaign)
    <section class="mt-5" aria-labelledby="donor-list-heading">
        <h2 id="donor-list-heading" class="h5">Recent supporters</h2>
        @forelse($donors as $donor)
            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                <span>{{ $donor->anonymous || !$donor->donor_name ? 'Anonymous' : $donor->donor_name }}</span>
                <strong>₹{{ number_format($donor->amount, 0) }}</strong>
            </div>
        @empty
            <p class="text-muted mb-0">Be the first to support this campaign.</p>
        @endforelse
    </section>
@endif
<!-- <div style="margin-top:15px;text-align:center;">
    <a href="{{ route('80g.form') }}" class="donate-btn" 
       style="display:block;background:linear-gradient(135deg,#1e3a8a,#2563eb);text-decoration:none;">
        🔍 Search & Download 80G Certificate
    </a>
</div> -->
</div>
</div>

<script>
document.querySelectorAll('[data-share-url]').forEach(button => {
    button.addEventListener('click', async () => {
        const url = button.dataset.shareUrl;
        const title = button.dataset.shareTitle || document.title;
        if (navigator.share) {
            try {
                await navigator.share({ title, text: title, url });
            } catch (error) {
                if (error.name !== 'AbortError') console.error('Campaign sharing failed:', error);
            }
            return;
        }

        const fallback = document.getElementById('shareFallback');
        const input = document.getElementById('shareUrl');
        input.value = url;
        fallback.hidden = false;
        input.select();
    });
});

document.getElementById('copyShareUrl')?.addEventListener('click', async () => {
    const input = document.getElementById('shareUrl');
    await navigator.clipboard.writeText(input.value);
    document.getElementById('copyShareFeedback').textContent = 'Link copied successfully.';
});

document.getElementById('campaignDonationCarousel')?.addEventListener('slid.bs.carousel', event => {
    document.querySelectorAll('.campaign-donation-thumbnail').forEach((thumbnail, index) => {
        thumbnail.classList.toggle('active', index === event.to);
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const carouselElement = document.getElementById('campaignDonationCarousel');
    if (!carouselElement || typeof bootstrap === 'undefined') {
        return;
    }

    const carousel = bootstrap.Carousel.getOrCreateInstance(carouselElement, {
        interval: 5000,
        ride: 'carousel',
        touch: true,
        wrap: true,
    });

    document.querySelectorAll('.campaign-donation-thumbnail').forEach(thumbnail => {
        thumbnail.addEventListener('click', () => {
            carousel.to(Number(thumbnail.dataset.bsSlideTo));
        });
    });

    carousel.cycle();
});

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
                amount: form.amount.value,
                campaign_id: form.campaign_id?.value || null
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

                // Attach payment data to a hidden form and submit to get PDF receipt
                let hiddenForm = document.createElement('form');
                hiddenForm.method = 'POST';
                hiddenForm.action = form.action;

                // Copy all original form fields
                new FormData(form).forEach(function(value, key) {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    hiddenForm.appendChild(input);
                });

                // Append payment IDs
                [
                    ['razorpay_payment_id', response.razorpay_payment_id],
                    ['razorpay_order_id', response.razorpay_order_id],
                    ['razorpay_signature', response.razorpay_signature]
                ].forEach(([name, value]) => {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = name;
                    input.value = value;
                    hiddenForm.appendChild(input);
                });

                document.body.appendChild(hiddenForm);
                hiddenForm.submit();

                // =======================
                // RESET FORM AFTER SUBMIT
                // =======================
                setTimeout(function() {
                    form.reset();
                    document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('active'));
                    document.getElementById('extraFields').classList.add('hidden');
                    document.querySelectorAll('#extraFields input, #extraFields textarea').forEach(f => f.removeAttribute('required'));
                }, 500);
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