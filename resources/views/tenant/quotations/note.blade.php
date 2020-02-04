@extends('tenant.layouts.app')

@section('content')

    <tenant-quotation-note :docotizacion="{{ json_encode($docotizacion) }}"></tenant-quotation-note>

@endsection