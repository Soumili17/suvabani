<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

/* Lock the PDF page to the card's own size — no extra page space to spill into */
@page{
    size:410px 640px;
    margin:0;
}

html, body{
    margin:0;
    padding:0;
    width:410px;
    height:620px;
    background:#fff;
}

/***************************
 CARD
****************************/

.card{
    width:390px;
    height:600px;
    margin:10px auto;
    border-radius:18px;
    overflow:hidden;
    border:1px solid #d7d7d7;
    background:#fff;
    page-break-inside:avoid;
    display:flex;
    flex-direction:column;
}

/***************************
 HEADER
****************************/

.header{
    background:#0099ff;
    color:#fff;
    padding:10px 18px;
    border-bottom:3px solid #d63d3d;
}

.header table{
    width:100%;
}

.logo{
    width:50px;
}

.logo img{
    width:42px;
}

.title{
    text-align:left;
    padding-left:8px;
}

.title h1{
    font-size:22px;
    line-height:22px;
}

.title h2{
    font-size:12px;
    letter-spacing:1.5px;
    font-weight:normal;
}

/***************************
 BODY
****************************/

.content{
    padding:12px 18px;
    flex:1;
}

.content table{
    width:100%;
}

.photo{
    width:105px;
    vertical-align:top;
}

.photo img{
    width:95px;
    height:115px;
    border:2px solid #214e77;
    object-fit:cover;
}

.details{
    vertical-align:top;
    padding-left:15px;
}

.field{
    margin-bottom:7px;
}

.label{
    color:#666;
    font-size:12px;
}

.value{
    font-size:16px;
    font-weight:bold;
    color:#111;
}

.status{
    color:#10a542;
}

/***************************
 FOOTER
****************************/

.footer{
    background:#0099ff;
    color:#fff;
    padding:12px 18px;
    border-radius:0 0 16px 16px;
    border-top:3px solid #d63d3d;
}

.footer table{
    width:100%;
}

.website{
    font-size:12px;
}

.location{
    font-size:12px;
    margin-top:4px;
}

.signature{
    text-align:center;
    width:140px;
}

.signature img{
    width:110px;
    height:auto;
    display:block;
    margin:0 auto 4px auto;
}

.signature span{
    display:block;
    text-align:center;
    font-size:10px;
    color:#fff;
}
</style>

</head>

<body>

<div class="card">

    <!-- Header -->

    <div class="header">

        <table>

            <tr>

                <td class="logo">
                    <img src="{{ public_path('assests/images/formlogo.png') }}">
                </td>

                <td class="title">

                    <h1>SUVABANI FOUNDATION</h1>

                    <h2></h2>

                </td>

            </tr>

        </table>

    </div>

    <!-- Body -->

    <div class="content">

        <table>

            <tr>

                <td class="photo">

                    <img src="{{ public_path('storage/'.$member->photo) }}">

                </td>

                <td class="details">

                    <div class="field">
                        <div class="label">Member Name</div>
                        <div class="value">
                            {{ $member->fullname }}
                        </div>
                    </div>

                    <div class="field">
                        <div class="label">Designation</div>
                        <div class="value">
                            {{ $member->membertype }}
                        </div>
                    </div>

                    <div class="field">
                        <div class="label">Membership ID</div>
                        <div class="value">
                            {{ $member->membership_id }}
                        </div>
                    </div>

                    <div class="field">
                        <div class="label">Status</div>
                        <div class="value status">
                            ACTIVE MEMBER
                        </div>
                    </div>

                    <div class="field">
                        <div class="label">Valid From</div>
                        <div class="value">
                            {{ date('d-m-Y', strtotime($member->approved_at ?? $member->created_at)) }}
                        </div>
                    </div>

                    <!-- <div class="field">
                        <div class="label">Valid Till</div>
                        <div class="value">
                            {{ date('d-m-Y', strtotime(($member->approved_at ?? $member->created_at).' +3 months')) }}
                        </div>
                    </div> -->

                    <div class="field">
                        <div class="label">Contact</div>
                        <div class="value">
                            {{ $member->phone }}
                        </div>
                    </div>

                </td>

            </tr>

        </table>

    </div>

    <!-- Footer -->

    <div class="footer">

        <table>

            <tr>

                <td>

                    <div class="website">
                         www.suvabanifoundation.com
                    </div>

                    <div class="location">
                         Rania Pravat Pally, Kolkata – 700154
                    </div>

                </td>

                <td class="signature">

                    <img src="{{ public_path('assests/images/sign_suvoda.png') }}" >

                    <span>
                        President Signature
                    </span>

                </td>

            </tr>

        </table>

    </div>

</div>

</body>
</html>