```html
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>

body{
    margin:0;
    font-family: Arial, Helvetica, sans-serif;
    background:#ffffff;
}

/* CARD */
.card{
    width:350px;
    height:220px;
    border:3px solid #ff003c; /* RED BORDER */
    border-radius:12px;
    overflow:hidden;
    background:#fff;
}

/* HEADER */
.header{
    background:#2d0b91; /* WEBSITE BLUE */
    color:#fff;
    text-align:center;
    font-size:16px;
    font-weight:bold;
    padding:10px 0;
    letter-spacing:0.5px;
}

/* MAIN CONTENT */
.content{
    width:100%;
    border-collapse:collapse;
}

/* PHOTO SECTION */
.photo{
    width:90px;
    padding:8px;
    text-align:center;
    vertical-align:top;
}

.photo img{
    width:78px;
    height:95px;
    object-fit:cover;
    border:2px solid #2d0b91; /* BLUE */
    border-radius:4px;
}

/* DETAILS */
.details{
    padding:8px 5px;
    font-size:12px;
    vertical-align:top;
    color:#000;
}

.details p{
    margin:4px 0;
}

.member-id{
    color:#ff003c; /* RED */
    font-weight:bold;
    font-size:14px;
}

/* RIGHT LOGO */
.side-logo{
    width:80px;
    text-align:center;
    vertical-align:middle;
}

.side-logo img{
    width:65px;
    height:65px;
    object-fit:contain;
}

/* FOOTER */
.footer{
    width:100%;
    border-top:1px solid #ddd;
    background:#f8f8f8;
}

.footer td{
    padding:6px;
    vertical-align:middle;
}

/* SIGNATURE */
.signature{
    width:50%;
}

.signature img{
    height:40px;
    width:auto;
    display:block;
}

.sign-label{
    font-size:9px;
    margin-top:2px;
    color:#000;
}

/* VALID MEMBER */
.valid-text{
    width:50%;
    text-align:right;
}

.valid-title{
    font-size:16px;
    font-weight:bold;
    color:#2d0b91; /* BLUE */
}

.valid-date{
    font-size:11px;
    color:#000;
    margin-top:2px;
}

</style>

</head>

<body>

<div class="card">

    <!-- HEADER -->
    <div class="header">
        SUVABANI FOUNDATION
    </div>

    <!-- BODY -->
    <table class="content">
        <tr>

            <!-- PHOTO -->
            <td class="photo">
                <img src="{{ public_path('storage/'.$member->photo) }}">
            </td>

            <!-- DETAILS -->
            <td class="details">

                <p class="member-id">
                    ID: {{ $member->membership_id }}
                </p>

                <p>
                    <strong>Name:</strong>
                    {{ $member->fullname }}
                </p>

                <p>
                    <strong>Phone:</strong>
                    {{ $member->phone }}
                </p>

                <p>
                    <strong>Type:</strong>
                    {{ $member->membertype }}
                </p>

                <p>
                    <strong>Joined:</strong>
                    {{ date('d-m-Y', strtotime($member->created_at)) }}
                </p>

            </td>

            <!-- RIGHT SIDE LOGO -->
            <td class="side-logo">
                <img src="{{ public_path('assests/images/formlogo.png') }}">
            </td>

        </tr>
    </table>

    <!-- FOOTER -->
    <table class="footer">
        <tr>

            <!-- SIGNATURE -->
            <td class="signature">

                <img src="{{ public_path('assests/images/sign_suvoda.png') }}">

                <div class="sign-label">
                    President Signature
                </div>

            </td>

            <!-- VALID MEMBER -->
            <td class="valid-text">

                <div class="valid-title">
                    Valid Member
                </div>

                <div class="valid-date">
                    Valid Upto:
                    {{ date('d-m-Y', strtotime(($member->approved_at ?? $member->created_at) . ' + 3 months')) }}
                </div>

            </td>

        </tr>
    </table>

</div>

</body>
</html>
```
