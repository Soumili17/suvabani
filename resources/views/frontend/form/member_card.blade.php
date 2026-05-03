<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

/* CARD SIZE (ID CARD RATIO) */
.card {
  width: 350px;
  height: 220px;
  border: 2px solid #008080;
  border-radius: 10px;
  overflow: hidden;
}

/* HEADER */
.header {
  background: #008080;
  color: #fff;
  text-align: center;
  font-size: 14px;
  font-weight: bold;
  padding: 6px;
  position: relative;
}

.logo {
  position: absolute;
  left: 8px;
  top: 5px;
  height: 28px;
}

/* TABLE STRUCTURE */
.content {
  width: 100%;
  border-collapse: collapse;
}

/* PHOTO */
.photo {
  width: 90px;
  text-align: center;
  padding: 8px;
}

.photo img {
  width: 75px;
  height: 95px;
  object-fit: cover;
  border: 1px solid #ccc;
}

/* DETAILS */
.details {
  font-size: 12px;
  padding: 5px;
  vertical-align: top;
}

.details p {
  margin: 3px 0;
}

.member-id {
  font-weight: bold;
  color: #008080;
  font-size: 13px;
}

/* FOOTER */
.footer {
  background: #f5f5f5;
  font-size: 11px;
}

.footer td {
  padding: 5px;
}

/* SIGNATURE */
.signature img {
  height: 28px;
}

.sign-label {
  font-size: 9px;
  text-align: center;
}

/* RIGHT SIDE TEXT */
.valid-text {
  text-align: right;
  font-weight: bold;
}
</style>

</head>

<body>

<div class="card">

  <!-- HEADER -->
  <div class="header">
    <img src="{{ public_path('assets/images/formlogo.png') }}" class="logo">
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
        <p class="member-id">ID: {{ $member->membership_id }}</p>
        <p><strong>Name:</strong> {{ $member->fullname }}</p>
        <p><strong>Phone:</strong> {{ $member->phone }}</p>
        <p><strong>Type:</strong> {{ $member->membertype }}</p>
        <p><strong>Joined:</strong> {{ date('d-m-Y', strtotime($member->created_at)) }}</p>
      </td>

    </tr>
  </table>

  <!-- FOOTER -->
  <table class="footer" width="100%">
    <tr>

      <!-- SIGNATURE -->
      <td class="signature">
        <img src="{{ public_path('assets/images/sign.png') }}">
        <div class="sign-label">Chairman Signature</div>
      </td>

      <!-- VALID TEXT -->
      <td class="valid-text">
        Valid Member
      </td>

    </tr>
  </table>

</div>

</body>
</html>