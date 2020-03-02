@extends('tenant.layouts.app')

@section('content')

    <tenant-documentsgeneral-note :document="{{ json_encode($document) }}"></tenant-documentsgeneral-note>

@endsection