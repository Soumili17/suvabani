<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Form 10AC - Provisional Approval</title>

<style>
body{font-family: Arial;margin:40px;}
h1{text-align:center;}
.subtitle{text-align:center;margin-bottom:20px;}
table{width:100%;border-collapse:collapse;}
td,th{border:1px solid #000;padding:8px;vertical-align:top;}
.label{width:25%;font-weight:bold;}
.number{width:5%;}
</style>

</head>

<body>

<h1>FORM NO. 10AC</h1>
<div class="subtitle">(See rule 17A/11AA)</div>
<div class="subtitle"><b>Order for provisional approval</b></div>

<table>

<tr>
<td class="number">1</td>
<td class="label">PAN</td>
<td>{{ $form->pan }}</td>
</tr>

<tr>
<td>2</td>
<td class="label">Name</td>
<td>{{ $form->name }}</td>
</tr>

<tr>
<td>2a</td>
<td class="label">Nature of Activities</td>
<td>{{ $form->activity }}</td>
</tr>

<tr>
<td rowspan="8">2b</td>
<td class="label">Flat/Door/Building</td>
<td>{{ $form->building }}</td>
</tr>

<tr>
<td class="label">Name of premises/Building/Village</td>
<td>{{ $form->village }}</td>
</tr>

<tr>
<td class="label">Road/Street/Post Office</td>
<td>{{ $form->post }}</td>
</tr>

<tr>
<td class="label">Area/Locality</td>
<td>{{ $form->locality }}</td>
</tr>

<tr>
<td class="label">Town/City/District</td>
<td>{{ $form->district }}</td>
</tr>

<tr>
<td class="label">State</td>
<td>{{ $form->state }}</td>
</tr>

<tr>
<td class="label">Country</td>
<td>{{ $form->country }}</td>
</tr>

<tr>
<td class="label">Pin Code/Zip Code</td>
<td>{{ $form->pincode }}</td>
</tr>

<tr>
<td>3</td>
<td class="label">Document Identification Number</td>
<td>{{ $form->din }}</td>
</tr>

<tr>
<td>4</td>
<td class="label">Application Number</td>
<td>{{ $form->application_no }}</td>
</tr>

<tr>
<td>5</td>
<td class="label">Unique Registration Number</td>
<td>{{ $form->registration_no }}</td>
</tr>

<tr>
<td>6</td>
<td class="label">Section/sub-section/clause</td>
<td>{{ $form->section }}</td>
</tr>

<tr>
<td>7</td>
<td class="label">Date of provisional approval</td>
<td>{{ $form->approval_date }}</td>
</tr>

<tr>
<td>8</td>
<td class="label">Assessment year</td>
<td>{{ $form->assessment_year }}</td>
</tr>

<tr>
<td>9</td>
<td colspan="2">
<b>Order for provisional approval:</b>

<p>{{ $form->order_a }}</p>
<p>{{ $form->order_b }}</p>
<p>{{ $form->order_c }}</p>

</td>
</tr>

<tr>
<td>10</td>
<td colspan="2">

<b>Conditions:</b>

<p>{{ $form->condition_a }}</p>
<p>{{ $form->condition_b }}</p>
<p>{{ $form->condition_c }}</p>
<p>{{ $form->condition_d }}</p>

</td>
</tr>

<tr>
<td></td>
<td class="label">Approving Authority</td>
<td>{{ $form->authority }}</td>
</tr>

</table>

</body>
</html>