@extends('layouts.dashboard')
@section('content')
<h2>Edit Project</h2>
@include('dashboard.projects.form', ['project' => $project])
@endsection
