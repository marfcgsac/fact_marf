@php
    $path_style = app_path('CoreFacturalo'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.'style.css');
    $accounts = \App\Models\Tenant\BankAccount::all();    
@endphp
<head>
    <link href="{{ $path_style }}" rel="stylesheet" />
</head>
<body>
<table class="border-topfooter m-10" width="100%" >
    <tr><td width="20%" style="text-align: center;"><h6>.</h6></td>

        </tr>

    </table>
 <table  width="70%" >

    <!-- <tr>
        <td><h6><strong>Cuentas bancarias: <strong></h6></td>
    </tr>
    <tr>
        <td>
            @foreach ($accounts as $account)
                <h6>{{ $account->description}} - {{ $account->bank->description}} - N° {{$account->number}} </h6>
            @endforeach
        </td>
    </tr>
    <tr>
        <td class="text-center desc font-bold">Para consultar el comprobante ingresar a {!! url('/buscar') !!}</td>
    </tr>
    <tr>
        <td class="text-center desc pt-3">Facturador electrónico</td>
    </tr>
     -->
     <tr>
        <td><td width="75%"  style="text-align: center;"><img src="{{ asset('logo/telefono.jpg') }}"></td></td>
        <td width="15%"><td width="75%" style="text-align: center;"><img src="{{ asset('logo/mail.jpg') }}"></td></td>
        <td width="15%"><td width="75%" style="text-align: center;"><img src="{{ asset('logo/paginaweb.jpg') }}"></td></td>
        <td width="15%"><td width="75%" style="text-align: center;"><img src="{{ asset('logo/gps.jpg') }}"></td></td>
    </tr></table>
    <table class="full-width">
    <tr><td width="20%" style="text-align: center;"><h6> 978 893 868</h6></td>
        <td width="25%" style="text-align: center;"><h6>marfcgsac@gmail.com</h6></td>
        <td width="25%" style="text-align: center;"><h6>wwww</h6></td>
        <td width="25%" style="text-align: center;"><h6>Prolong. Manco Capac 1155</h6>
        </tr>

    </table>
</body>