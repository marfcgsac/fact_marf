@extends('tenant.pos.register_layout')

@section('content')

    @if(is_null($pos))
        @include('tenant.partials.validated_box')
    @else
        <tenant-pos1-register></tenant-pos1-register>
    @endif

@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            'use strict';
            $(".tableScrollTop,.tableWide-wrapper").scroll(function () {
                $(".tableWide-wrapper,.tableScrollTop")
                    .scrollLeft($(this).scrollLeft());
            });
        });
    </script>
@endpush
