@extends('tenant.layouts.app')

@section('content')
    <div class="page-header pr-0">
        <h2><a href="/receipt"><i class="fas fa-tachometer-alt"></i></a></h2>
        <ol class="breadcrumbs">
            <li class="active"><span>Detalle del comprobante qqqq</span> </li>
            <!-- <li><span class="text-muted">Facturas - Notas <small>(crédito y débito)</small> - Boletas - Anulaciones</small></span></li> -->
        </ol>
        <div class="right-wrapper pull-right">
            
        </div>
    </div>
    <div class="card mb-0 card-without-radius">
        <div class="card-title p-1">
    
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                 <!-- <div class="col-md-6">
                    <section class="card card-horizontal card-without-radius">
                        <div class="card-body text-center">
                            <p class="font-weight-semibold mb-0 mx-2">Crear venta</p> 
                             @if($quotation->state_type_id == '01')
                            <h3 class="font-bold mt-0 text-success" href="/documents/create2/{{$quotation->id}}">crear venta </h3>
                            @endif
                        </div>
                    </section>
                </div>  -->
                <div class="col-md-6">
                    <section class="card card-horizontal card-without-radius">
                        <div class="card-body text-center">
                            <p class="font-weight-semibold mb-0 mx-1 fa-2x">Valor Total</p>
                            <h4 class="font-bold mt-2 text-success fa-lg">S/. {{ $quotation->total }}</h4>
                            @if($quotation->state_type_id == '01')
                            <a class="font-bold text-warning fa-lg " href="/documents/create2/{{$quotation->id}}">crear venta </a>
                            @endif
                        </div>
                    </section>
                </div>
                 <!-- <div class="col-md-3">
                    <section class="card card-horizontal card-without-radius">
                        <div class="card-body text-center">
                            <p class="font-weight-semibold mb-0 mx-w">Por cobrar</p>
                            <a href="/documents/create2/{{$quotation->id}}">Crear venta</a>
                            <a>{{$quotation->state_type_id}}</a>
                        </div>
                    </section>
                </div>  -->
            </div> 
            <div class="row">
                <div class="col-md-12">
                    <iframe src="{{route('tenant.print.external3', ['quotation', $quotation->id, 'a4'] )}}" frameborder="0" width="100%" height="550" marginheight="0" marginwidth="0" id="pdf"></iframe>
                </div>
            </div>
            <div class="row p-3">
               
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush

