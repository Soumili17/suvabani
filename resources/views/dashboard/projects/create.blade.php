@extends('layouts.dashboard')
@section('content')
<h2>Add Project</h2>
@include('dashboard.projects.form', ['project' => null])
@endsection
