@extends('tenant.layouts.app')

@section('content')

    <tenant-documentgeneral-index></tenant-documentgeneral-index>

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