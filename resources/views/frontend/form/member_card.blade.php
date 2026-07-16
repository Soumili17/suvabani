<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>

body{
    margin:0;
    padding:0;
    font-family:Arial, Helvetica, sans-serif;
}

/* CARD */
.card{
    width:350px;
    height:220px;
    border:2px solid #ff003c;
    border-radius:12px;
    overflow:hidden;
    background:#fff;
    position:relative;
    box-sizing:border-box;
}

/* HEADER */
.header{
    height:38px;
    line-height:38px;
    background:#2d0b91;
    color:#fff;
    text-align:center;
    font-size:16px;
    font-weight:bold;
    border-bottom:2px solid #ff003c;
}

/* MAIN CONTENT */
.content{
    width:100%;
    border-collapse:collapse;
}

.content td{
    vertical-align:top;
}

/* PHOTO */
.photo{
    width:82px;
    padding:8px 5px 0 8px;
}

.photo img{
    width:68px;
    height:82px;
    object-fit:cover;
    border:2px solid #2d0b91;
    border-radius:4px;
}

/* DETAILS */
.details{
    width:170px;
    padding-top:8px;
    font-size:12px;
    color:#000;
}

.details p{
    margin:0 0 5px 0;
}

.member-id{
    color:#ff003c;
    font-size:15px;
    font-weight:bold;
}

/* LOGO */
.side-logo{
    width:70px;
    text-align:center;
    padding-top:18px;
}

.side-logo img{
    width:55px;
    height:55px;
    object-fit:contain;
}

/* FOOTER */
.footer{
    position:absolute;
    bottom:0;
    left:0;
    width:100%;
    height:65px;
    border-top:1px solid #dcdcdc;
    background:#fafafa;
}

.footer-table{
    width:100%;
    height:65px;
    border-collapse:collapse;
}

.footer-table td{
    vertical-align:middle;
}

/* SIGNATURE */
.signature-cell{
    width:55%;
    padding-left:10px;
}

.signature-cell img{
    width:45px;
    height:24px;
    object-fit:contain;
    display:block;
}

.sign-label{
    font-size:8px;
    color:#000;
    margin-top:-2px; /* was 2px */
}

/* VALID MEMBER */
.valid-cell{
    width:45%;
    text-align:right;
    padding-right:10px;
}

.valid-title{
    color:#2d0b91;
    font-size:15px;
    font-weight:bold;
    line-height:16px;
}

.valid-date{
    margin-top:3px;
    font-size:10px;
    color:#000;
}

</style>
</head>

<body>

<div class="card">

    <!-- HEADER -->
    <div class="header">
        SUVABANI FOUNDATION
    </div>

    <!-- CONTENT -->
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

            <!-- LOGO -->
            <td class="side-logo">
                <img src="{{ public_path('assests/images/formlogo.png') }}">
            </td>

        </tr>

    </table>

    <!-- FOOTER -->
    <div class="footer">

        <table class="footer-table">

            <tr>

                <!-- SIGNATURE -->
                <td class="signature-cell">

                    <!-- IMPORTANT:
                         Rotate the actual PNG file and save it as:
                         sign_suvoda_rotated.png
                    -->
                    <img src="{{ public_path('assests/images/sign_suvoda.png') }}">

                    <div class="sign-label">
                        President Signature
                    </div>

                </td>

                <!-- VALID MEMBER -->
                <td class="valid-cell">

                    <div class="valid-title">
                        Active Member
                    </div>

                    <div class="valid-date">
                        Valid Upto:
                        {{ date('d-m-Y', strtotime(($member->approved_at ?? $member->created_at).' +3 months')) }}
                    </div>

                </td>

            </tr>

        </table>

    </div>

</div>

</body>
</html>