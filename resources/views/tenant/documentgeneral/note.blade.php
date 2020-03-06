@extends('tenant.layouts.app')

@section('content')

    <tenant-documentgeneral-note :document="{{ json_encode($document) }}"></tenant-documentgeneral-note>

@endsection