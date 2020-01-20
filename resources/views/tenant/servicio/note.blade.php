@extends('tenant.layouts.app')

@section('content')

   <tenant-servicio-note :document="{{ json_encode($document) }}"></tenant-servicio-note>

@endsection