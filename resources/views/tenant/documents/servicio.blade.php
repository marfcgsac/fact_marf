@extends('tenant.layouts.app')

@section('content')

    <tenant-documents-servicio></tenant-documents-servicio>

@endsection

@push('scripts')
<script type="text/javascript">
	$(function(){
    'use strict';
        $(".tableScrollTop,.tableWide-wrapper").scroll(function(){
            $(".tableWide-wrapper,.tableScrollTop")
                .scrollLeft($(this).scrollLeft());
        });
    });
</script>
@endpush