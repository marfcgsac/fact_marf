<?php

use Illuminate\Support\Facades\Route;

$hostname = app(Hyn\Tenancy\Contracts\CurrentHostname::class);

if ($hostname)  {
    Route::domain($hostname->fqdn)->group(function () {

        Auth::routes();

        Route::get('search', 'Tenant\SearchController@index')->name('search.index');
        Route::get('buscar', 'Tenant\SearchController@index')->name('search.index');
        Route::get('search/tables', 'Tenant\SearchController@tables');
        Route::post('search', 'Tenant\SearchController@store');

        Route::get('downloads/{model}/{type}/{external_id}/{format?}', 'Tenant\DownloadController@downloadExternal')->name('tenant.download.external_id');
        Route::get('print/{model}/{external_id}/{format?}', 'Tenant\DownloadController@toPrint')->name('tenant.print.external');
        //Route::get('print/{model}/{id}/{format?}', 'Tenant\DownloadController@toPrint')->name('tenant.print.external2');
        Route::get('print2/{model}/{id}/{format?}', 'Tenant\DownloadController@toPrint2');
        Route::get('print3/{model}/{id}/{format?}', 'Tenant\DownloadController@toPrint3')->name('tenant.print.external3');
        /*cotizacion*/
        Route::get('download/{model}/{type}/{id}/{format?}', 'Tenant\DownloadController@downloadExternal2')->name('tenant.download.id');
        Route::get('download_cot/{model}/{type}/{id}/{format?}', 'Tenant\DownloadController@downloadExternalcot')->name('tenant.download.id');
        /*fin cotizacion*/


        //Route::middleware(['auth', 'module'])->group(function() {
        Route::middleware(['auth'])->group(function () {
            Route::get('/', function () {
                return redirect()->route('tenant.dashboard');
            });

            //dashboard
            
            Route::get('dashboard', 'Tenant\HomeController@index')->name('tenant.dashboard');
            Route::get('dashboard/sells', 'Tenant\HomeController@sells')->name('tenant.dashboard.sells');

            Route::get('dashboard/load_sells/{establishment_id}/{range}', 'Tenant\HomeController@load_sells');
            Route::get('dashboard/establishments', 'Tenant\HomeController@establishments');
            Route::get('dashboard/load/{establishment_id}', 'Tenant\HomeController@load');
            Route::get('dashboard/chart_cash_flow/{establishment_id}', 'Tenant\HomeController@chart_cash_flow');
            Route::get('dashboard/chart_pie_total/{establishment_id}', 'Tenant\HomeController@chart_pie_total');

            //alerts
            Route::get('alerts/documents', 'Tenant\AlertDocumentController@index')->name('tenant.alerts.documents.index');
            Route::get('alerts/documents/records', 'Tenant\AlertDocumentController@records');

            Route::get('catalogs', 'Tenant\CatalogController@index')->name('tenant.catalogs.index');
            Route::get('advanced', 'Tenant\AdvancedController@index')->name('tenant.advanced.index');

            //Company
            Route::get('companies/create', 'Tenant\CompanyController@create')->name('tenant.companies.create');
            Route::get('companies/tables', 'Tenant\CompanyController@tables');
            Route::get('companies/record', 'Tenant\CompanyController@record');
            Route::post('companies', 'Tenant\CompanyController@store');
            Route::post('companies/uploads', 'Tenant\CompanyController@uploadFile');

            //Configurations
            Route::get('configurations/create', 'Tenant\ConfigurationController@create')->name('tenant.configurations.create');
            Route::get('configurations/record', 'Tenant\ConfigurationController@record');
            Route::post('configurations', 'Tenant\ConfigurationController@store');

            //Certificates
            Route::get('certificates/record', 'Tenant\CertificateController@record');
            Route::post('certificates/uploads', 'Tenant\CertificateController@uploadFile');
            Route::delete('certificates', 'Tenant\CertificateController@destroy');

            //Establishments
            Route::get('establishments', 'Tenant\EstablishmentController@index')->name('tenant.establishments.index');
            Route::get('establishments/create', 'Tenant\EstablishmentController@create');
            Route::get('establishments/tables', 'Tenant\EstablishmentController@tables');
            Route::get('establishments/record/{establishment}', 'Tenant\EstablishmentController@record');
            Route::post('establishments', 'Tenant\EstablishmentController@store');
            Route::get('establishments/records', 'Tenant\EstablishmentController@records');
            Route::delete('establishments/{establishment}', 'Tenant\EstablishmentController@destroy');

            //Bank Accounts 
            Route::get('bank_accounts', 'Tenant\BankAccountController@index')->name('tenant.bank_accounts.index');
            Route::get('bank_accounts/records', 'Tenant\BankAccountController@records');
            Route::get('bank_accounts/create', 'Tenant\BankAccountController@create');
            Route::get('bank_accounts/tables', 'Tenant\BankAccountController@tables');
            Route::get('bank_accounts/record/{bank_account}', 'Tenant\BankAccountController@record');
            Route::post('bank_accounts', 'Tenant\BankAccountController@store');
            Route::delete('bank_accounts/{bank_account}', 'Tenant\BankAccountController@destroy');

            //Series
            Route::get('series/records/{establishment}', 'Tenant\SeriesController@records');
            Route::get('series/create', 'Tenant\SeriesController@create');
            Route::get('series/tables', 'Tenant\SeriesController@tables');
            Route::post('series', 'Tenant\SeriesController@store');
            Route::delete('series/{series}', 'Tenant\SeriesController@destroy');

            //Users
            Route::get('users', 'Tenant\UserController@index')->name('tenant.users.index');
            Route::get('users/create', 'Tenant\UserController@create')->name('tenant.users.create');
            Route::get('users/tables', 'Tenant\UserController@tables');
            Route::get('users/record/{user}', 'Tenant\UserController@record');
            Route::post('users', 'Tenant\UserController@store');
            Route::get('users/records', 'Tenant\UserController@records');
            Route::delete('users/{user}', 'Tenant\UserController@destroy');

            //ChargeDiscounts
            Route::get('charge_discounts', 'Tenant\ChargeDiscountController@index')->name('tenant.charge_discounts.index');
            Route::get('charge_discounts/records/{type}', 'Tenant\ChargeDiscountController@records');
            Route::get('charge_discounts/create', 'Tenant\ChargeDiscountController@create');
            Route::get('charge_discounts/tables/{type}', 'Tenant\ChargeDiscountController@tables');
            Route::get('charge_discounts/record/{charge}', 'Tenant\ChargeDiscountController@record');
            Route::post('charge_discounts', 'Tenant\ChargeDiscountController@store');
            Route::delete('charge_discounts/{charge}', 'Tenant\ChargeDiscountController@destroy');

            //Items
            Route::get('items', 'Tenant\ItemController@index')->name('tenant.items.index');
            Route::get('items/columns', 'Tenant\ItemController@columns');
            Route::get('items/records', 'Tenant\ItemController@records');
            Route::get('items/tables', 'Tenant\ItemController@tables');
            Route::get('items/record/{item}', 'Tenant\ItemController@record');
            Route::get('items/stocks/{item}', 'Tenant\ItemController@stocks');
            Route::post('items', 'Tenant\ItemController@store');
            Route::delete('items/{item}', 'Tenant\ItemController@destroy');
            Route::post('items/import', 'Tenant\ItemController@import');
            Route::get('items/stock_details/{item}', 'Tenant\ItemController@stock_details');


/////////////categoria
            Route::get('items/load/{establishment_id}', 'Tenant\ItemController@load');
            Route::get('items/uldato', 'Tenant\ItemController@uldato');

            Route::get('items/List', 'Tenant\ItemController@List');
            Route::get('items/visible', 'Tenant\ItemController@visible');
            Route::get('items/tables', 'Tenant\ItemController@tables');
            Route::get('item_category/disponible','Tenant\ItemCategoryController@disponible');
            Route::post('item_category/import', 'Tenant\ItemCategoryController@import');

////////////fin categoria
     
            //Price List
            Route::get('price-list', 'Tenant\PriceListController@index')->name('tenant.price_list.index');
            Route::get('price-list/columns', 'Tenant\PriceListController@columns');
            //Route::get('expenses/tables', 'Tenant\ExpenseController@tables');
            Route::get('price-list/record/{price_list}', 'Tenant\PriceListController@record');
            Route::post('price-list', 'Tenant\PriceListController@store');
            Route::get('price-list/records', 'Tenant\PriceListController@records');
            Route::delete('price-list/{price_list}', 'Tenant\PriceListController@destroy');

            //Expenses
            Route::get('expenses', 'Tenant\ExpenseController@index')->name('tenant.expenses.index');
            Route::get('expenses/columns', 'Tenant\ExpenseController@columns');
            Route::get('expenses/tables', 'Tenant\ExpenseController@tables');
            Route::get('expenses/record/{expense}', 'Tenant\ExpenseController@record');
            Route::post('expenses', 'Tenant\ExpenseController@store');
            Route::get('expenses/records', 'Tenant\ExpenseController@records');
            Route::get('expenses/totals', 'Tenant\ExpenseController@totals');
            Route::delete('expenses/{expense}', 'Tenant\ExpenseController@destroy');

            //Payments
            Route::get('payments', 'Tenant\PaymentController@index')->name('tenant.payments.index');
            Route::get('payments/columns', 'Tenant\PaymentController@columns');
            Route::get('payments/tables', 'Tenant\PaymentController@tables');
            Route::get('payments/records', 'Tenant\PaymentController@records');
            Route::get('payments/totals', 'Tenant\PaymentController@totals');
            Route::post('payments/', 'Tenant\PaymentController@store');
            Route::delete('payments/{payment}', 'Tenant\PaymentController@destroy');

            //Accounts
            Route::get('accounts', 'Tenant\AccountController@index')->name('tenant.accounts.index');
            Route::get('accounts/columns', 'Tenant\AccountController@columns');
            Route::get('accounts/tables', 'Tenant\AccountController@tables');
            Route::get('accounts/record/{account}', 'Tenant\AccountController@record');
            Route::post('accounts', 'Tenant\AccountController@store');
            Route::get('accounts/records', 'Tenant\AccountController@records');
            Route::delete('accounts/{account}', 'Tenant\AccountController@destroy');

            //Customers
//            Route::get('customers', 'Tenant\CustomerController@index')->name('tenant.customers.index');
//            Route::get('customers/columns', 'Tenant\CustomerController@columns');
//            Route::get('customers/records', 'Tenant\CustomerController@records');
//            Route::get('customers/tables', 'Tenant\CustomerController@tables');
//            Route::get('customers/record/{item}', 'Tenant\CustomerController@record');
//            Route::post('customers', 'Tenant\CustomerController@store');
//            Route::delete('customers/{customer}', 'Tenant\CustomerController@destroy');
//
//            //Suppliers
//            Route::get('suppliers', 'Tenant\SupplierController@index')->name('tenant.suppliers.index');
//            Route::get('suppliers/columns', 'Tenant\SupplierController@columns');
//            Route::get('suppliers/records', 'Tenant\SupplierController@records');
//            Route::get('suppliers/tables', 'Tenant\SupplierController@tables');
//            Route::get('suppliers/record/{item}', 'Tenant\SupplierController@record');
//            Route::post('suppliers', 'Tenant\SupplierController@store');
//            Route::delete('suppliers/{supplier}', 'Tenant\SupplierController@destroy');

            //Persons
            Route::get('persons/columns', 'Tenant\PersonController@columns');
            Route::get('persons/tables', 'Tenant\PersonController@tables');
            Route::get('persons/{type}', 'Tenant\PersonController@index')->name('tenant.persons.index');
            Route::get('persons/{type}/view/{person}', 'Tenant\PersonController@view')->name('tenant.persons.view');
            Route::get('persons/{type}/records', 'Tenant\PersonController@records');
            Route::get('persons/record/{person}', 'Tenant\PersonController@record');
            Route::get('persons/{type}/view/{person}/sells/columns', 'Tenant\PersonController@sell_columns');
            Route::get('persons/{type}/view/{person}/sells', 'Tenant\PersonController@sells');
            Route::get('persons/{type}/view/{person}/payments/columns', 'Tenant\PersonController@payments_columns');
            Route::get('persons/{type}/view/{person}/payments', 'Tenant\PersonController@payments');

            Route::post('persons', 'Tenant\PersonController@store');
            Route::delete('persons/{person}', 'Tenant\PersonController@destroy');
            Route::post('persons/import', 'Tenant\PersonController@import');

            //POS - Punto de Venta
            // juliocapuano@gmail.com

            Route::post('pos', 'Tenant\PosController@store');
            Route::post('pos/destroy', 'Tenant\PosController@destroy');
            Route::get('pos/{id}/details', 'Tenant\PosController@details');
            Route::get('pos/{id}/itemsventa', 'Tenant\PosController@itemsventa');
            Route::get('pos/{id}/detailsitem', 'Tenant\PosController@detailsitem');
            Route::get('pos', 'Tenant\PosController@index')->name('tenant.pos.index');
            Route::get('pos/columns', 'Tenant\PosController@columns');
            Route::get('pos/records', 'Tenant\PosController@records');
            Route::get('pos/tables', 'Tenant\PosController@tables');
            Route::post('pos/{id}/operations', 'Tenant\PosController@operations');
            Route::get('pos/register', 'Tenant\PosController@register')->name('tenant.pos.register');
            
            Route::get('pos/report/pdf/{id}', 'Tenant\PosController@pdf');
            //otro pos


            Route::post('pos1', 'Tenant\PosController1@store');
            Route::post('pos1/destroy', 'Tenant\PosController1@destroy');
            Route::get('pos1/{id}/details', 'Tenant\PosController1@details');
            Route::get('pos1', 'Tenant\PosControlle1r@index')->name('tenant.pos1.index');
            Route::get('pos1/columns', 'Tenant\PosController1@columns');
            Route::get('pos1/records', 'Tenant\PosController1@records');
            Route::get('pos1/tables', 'Tenant\PosController1@tables');
            Route::post('pos1/{id}/operations', 'Tenant\PosController1@operations');
            Route::get('pos1/register', 'Tenant\PosController1@register')->name('tenant.pos1.register');
           
            Route::get('pos1/report/pdf/{id}', 'Tenant\PosController1@pdf');
            //fin otro pos


            //Documents
            Route::get('documents', 'Tenant\DocumentController@index')->name('tenant.documents.index');
            Route::get('documents/view/{document}', 'Tenant\DocumentController@view')->name('tenant.documents.view');
            Route::get('documents/columns', 'Tenant\DocumentController@columns');
            Route::get('documents/columns1', 'Tenant\DocumentController@columns1');
            Route::get('documents/records', 'Tenant\DocumentController@records');
         
            Route::get('documents/vistag', 'Tenant\DocumentController@vistag')->name('vistag');
            Route::get('documents/servicio', 'Tenant\DocumentController@servicio')->name('servicio');
            
            Route::get('documents/records1', 'Tenant\DocumentController@records1');
            Route::get('documents/records1/{document}', 'Tenant\DocumentController@records1');
          
            Route::get('documents/records2', 'Tenant\DocumentController@records2');
            Route::get('documents/records2/{document}', 'Tenant\DocumentController@records2');

            
       
            //Route::resource('documents/pay', 'Tenant\DocumentController@pay');


            Route::get('documents/totals', 'Tenant\DocumentController@totals');
            Route::get('documents/create', 'Tenant\DocumentController@create')->name('tenant.documents.create');
            Route::get('documents/create2/{document}', 'Tenant\DocumentController@create2')->name('tenant.documents.create2');
            Route::get('documents/create3/{document}', 'Tenant\DocumentController@create3')->name('tenant.documents.create3');
            Route::get('documents/tables', 'Tenant\DocumentController@tables');
            Route::get('documents/tables2/{document}', 'Tenant\DocumentController@tables2');
            Route::get('documents/record/{document}', 'Tenant\DocumentController@record');
            Route::post('documents', 'Tenant\DocumentController@store');
            //Route::post('documents/{document}', 'Tenant\DocumentController@store2');
            Route::get('documents/send/{document}', 'Tenant\DocumentController@send');
            Route::get('documents/send1/{document}', 'Tenant\DocumentController@send1');
            Route::get('documents/consult_cdr/{document}', 'Tenant\DocumentController@consultCdr');
            Route::post('documents/email', 'Tenant\DocumentController@email');
            Route::post('documents/email1', 'Tenant\DocumentController@email1');
            Route::get('documents/note/{document}', 'Tenant\NoteController@create');
            Route::get('documents/item/tables', 'Tenant\DocumentController@item_tables');
            Route::get('documents/item/tables2/{document}', 'Tenant\DocumentController@item_tables2');
            Route::get('documents/table/{table}', 'Tenant\DocumentController@table');
            Route::get('documents/cambiar_estado_pago/{document}', 'Tenant\DocumentController@cambiar_estado_pago');
            Route::get('configuration/documents', 'Tenant\DocumentController@configuration')->name('tenant.documents.configuarion');
            Route::get('configuration/documents/record', 'Tenant\DocumentController@configuration_record');
            Route::post('configuration/documents', 'Tenant\DocumentController@configuration_store');

         
            //Docuemntos general
            Route::get('documentgeneral', 'Tenant\DocumentgeneralController@index')->name('tenant.documentsgeneral.index');
            Route::get('documentsgeneral/view/{documentgeneral}', 'Tenant\DocumentgeneralController@view')->name('tenant.documentsgeneral.view');
            Route::get('documentsgeneral/columns', 'Tenant\DocumentgeneralController@columns');
            Route::get('documentsgeneral/records', 'Tenant\DocumentgeneralController@');
            
            Route::get('documentsgeneral/totals', 'Tenant\DocumentgeneralController@totals');
            Route::get('documentsgeneral/create', 'Tenant\DocumentgeneralController@create')->name('tenant.documentsgeneral.create');
            Route::get('documentsgeneral/create2/{document}', 'Tenant\DocumentgeneralController@create2')->name('tenant.documentsgeneral.create2');
            Route::get('documentsgeneral/tables', 'Tenant\DocumentgeneralController@tables');
            Route::get('documentsgeneral/tables2/{document}', 'Tenant\DocumentgeneralController@tables2');
            Route::get('documentsgeneral/record/{documentgeneral}', 'Tenant\DocumentgeneralController@record');
            Route::post('documentsgeneral', 'Tenant\DocumentgeneralController@store');
            //Route::post('documentsgeneral/{document}', 'Tenant\DocumentgeneralController@store2');
            Route::get('documentsgeneral/send/{document}', 'Tenant\DocumentgeneralController@send');
            Route::get('documentsgeneral/consult_cdr/{document}', 'Tenant\DocumentgeneralController@consultCdr');
            Route::post('documentsgeneral/email', 'Tenant\DocumentgeneralController@email');
            Route::get('documentsgeneral/note/{document}', 'Tenant\NoteController@create');
            Route::get('documentsgeneral/item/tables', 'Tenant\DocumentgeneralController@item_tables');
            Route::get('documentsgeneral/item/tables2/{document}', 'Tenant\DocumentgeneralController@item_tables2');
            Route::get('documentsgeneral/table/{table}', 'Tenant\DocumentgeneralController@table');
            Route::get('documentsgeneral/cambiar_estado_pago/{document}', 'Tenant\DocumentgeneralController@cambiar_estado_pago');
            Route::get('configuration/documentsgeneral', 'Tenant\DocumentgeneralController@configuration')->name('tenant.documentsgeneral.configuarion');
            Route::get('configuration/documentsgeneral/record', 'Tenant\DocumentgeneralController@configuration_record');
            Route::post('configuration/documentsgeneral', 'Tenant\DocumentgeneralController@configuration_store');



//agregar servicio

//Documents
Route::get('servicio', 'Tenant\ServicioController@index')->name('tenant.servicio.index');
Route::get('servicio/view/{servicio}', 'Tenant\ServicioController@view')->name('tenant.servicio.view');
Route::get('servicio/columns', 'Tenant\ServicioController@columns');
Route::get('servicio/records', 'Tenant\ServicioController@records');
Route::get('servicio/totals', 'Tenant\ServicioController@totals');
Route::get('servicio/create', 'Tenant\ServicioController@create')->name('tenant.servicio.create');
Route::get('servicio/create2/{servicio}', 'Tenant\ServicioController@create2')->name('tenant.servicio.create2');
Route::get('servicio/tablas', 'Tenant\ServicioController@tablas');
Route::get('servicio/tables2/{document}', 'Tenant\ServicioController@tables2');
//Route::get('servicio/record/{document}', 'Tenant\DocumentController@record');
Route::post('servicio', 'Tenant\ServicioController@store');
Route::post('servicio/{document}', 'Tenant\DocumentController@store2');
Route::get('servicio/send/{document}', 'Tenant\ServicioController@send');
Route::get('servicio/consult_cdr/{document}', 'Tenant\ServicioController@consultCdr');
Route::post('servicio/email', 'Tenant\ServicioController@email');
Route::get('servicio/note/{document}', 'Tenant\NoteController@create');
Route::get('servicio/items/tables', 'Tenant\ServicioController@item_tables');
Route::get('servicio/item/tables2/{document}', 'Tenant\ServicioController@item_tables2');
Route::get('servicio/table/{table}', 'Tenant\ServicioController@table');
Route::get('servicio/cambiar_estado_pago/{document}', 'Tenant\ServicioController@cambiar_estado_pago');
Route::get('configuration/servicio', 'Tenant\ServicioController@configuration')->name('tenant.servicio.configuarion');
Route::get('configuration/servicio/record', 'Tenant\ServicioController@configuration_record');
Route::post('configuration/servicio', 'Tenant\ServicioController@configuration_store');


//agregar servicio


            //Credit Notes
            Route::get('credit-notes', 'Tenant\CreditNoteController@index')->name('tenant.credit_notes.index');
            Route::get('credit-notes/columns', 'Tenant\CreditNoteController@columns');
            Route::get('credit-notes/records', 'Tenant\CreditNoteController@records');
            Route::get('credit-notes/totals', 'Tenant\CreditNoteController@totals');

            //Caja
            Route::get('box', 'Tenant\PosController@index')->name('tenant.box.index');

            //Quotations
            Route::get('quotations/view/{quotation}', 'Tenant\QuotationController@view')->name('tenant.quotations.view');


            Route::get('quotations/send/{docotizacion}', 'Tenant\DocumentController@send');
          

            Route::get('quotations', 'Tenant\QuotationController@index')->name('tenant.quotations.index');
            Route::get('quotations/columns', 'Tenant\QuotationController@columns');
            Route::get('quotations/records', 'Tenant\QuotationController@records');
            Route::get('quotations/totals', 'Tenant\QuotationController@totals');
            Route::get('quotations/create', 'Tenant\QuotationController@create')->name('tenant.quotations.create');
            Route::get('quotations/edit/{quotation}', 'Tenant\QuotationController@edit')->name('tenant.quotations.edit');
            Route::get('quotations/tables', 'Tenant\QuotationController@tables');
            Route::get('quotations/record/{quotation}', 'Tenant\QuotationController@record');
            Route::post('quotations', 'Tenant\QuotationController@store');
            Route::post('quotations/update/{quotation}', 'Tenant\QuotationController@update');
            Route::get('quotations/send/{quotation}', 'Tenant\QuotationController@send');
            Route::post('quotations/email', 'Tenant\QuotationController@email');
            Route::get('quotations/item/tables', 'Tenant\QuotationController@item_tables');
            Route::get('quotations/table/{table}', 'Tenant\QuotationController@table');

            //NoteSales
            Route::get('sale-notes', 'Tenant\SaleNoteController@index')->name('tenant.sale_notes.index');
            Route::get('sale-notes/columns', 'Tenant\SaleNoteController@columns');
            Route::get('sale-notes/records', 'Tenant\SaleNoteController@records');
            Route::get('sale-notes/totals', 'Tenant\SaleNoteController@totals');
            Route::get('sale-notes/create', 'Tenant\SaleNoteController@create')->name('tenant.sale_notes.create');
            // Route::get('sale-notes/edit/{quotation}', 'Tenant\SaleNoteController@edit')->name('tenant.quotations.edit');
            Route::get('sale-notes/tables', 'Tenant\SaleNoteController@tables');
            Route::get('sale-notes/record/{id}', 'Tenant\SaleNoteController@record');
            Route::post('sale-notes', 'Tenant\SaleNoteController@store');
            // Route::post('sale-notes/update/{quotation}', 'Tenant\SaleNotesController@update');
            // Route::get('sale-notes/send/{quotation}', 'Tenant\SaleNotesController@send');
            Route::post('sale-notes/email', 'Tenant\SaleNoteController@email');
            Route::delete('sale-notes/{salenote}', 'Tenant\SaleNoteController@destroy');
            // Route::get('sale-notes/item/tables', 'Tenant\SaleNotesController@item_tables');
            // Route::get('sale-notes/tab/{table}', 'Tenant\SaleNotesController@table');



            Route::get('sale-notes/view/{sale-note}', 'Tenant\SaleNoteController@view')->name('tenant.sale_notes.view');
            
            //Summaries
            Route::get('summaries', 'Tenant\SummaryController@index')->name('tenant.summaries.index');
            Route::get('summaries/records', 'Tenant\SummaryController@records');
            Route::post('summaries/documents', 'Tenant\SummaryController@documents');
            Route::post('summaries', 'Tenant\SummaryController@store');
            Route::get('summaries/status/{summary}', 'Tenant\SummaryController@status');

            //Voided
            Route::get('voided', 'Tenant\VoidedController@index')->name('tenant.voided.index');
            Route::get('voided/columns', 'Tenant\VoidedController@columns');
            Route::get('voided/records', 'Tenant\VoidedController@records');
            Route::post('voided', 'Tenant\VoidedController@store');
//            Route::get('voided/download/{type}/{voided}', 'Tenant\VoidedController@download')->name('tenant.voided.download');
            Route::get('voided/status/{voided}', 'Tenant\VoidedController@status');
//            Route::get('voided/ticket/{voided_id}/{group_id}', 'Tenant\VoidedController@ticket');

            //Retentions
            Route::get('retentions', 'Tenant\RetentionController@index')->name('tenant.retentions.index');
            Route::get('retentions/columns', 'Tenant\RetentionController@columns');
            Route::get('retentions/records', 'Tenant\RetentionController@records');
            Route::get('retentions/create', 'Tenant\RetentionController@create')->name('tenant.retentions.create');
            Route::get('retentions/tables', 'Tenant\RetentionController@tables');
            Route::get('retentions/record/{retention}', 'Tenant\RetentionController@record');
            Route::post('retentions', 'Tenant\RetentionController@store');
            Route::delete('retentions/{retention}', 'Tenant\RetentionController@destroy');
            Route::get('retentions/document/tables', 'Tenant\RetentionController@document_tables');
            Route::get('retentions/table/{table}', 'Tenant\RetentionController@table');

            //Dispatches
            Route::get('dispatches', 'Tenant\DispatchController@index')->name('tenant.dispatches.index');
            Route::get('dispatches/columns', 'Tenant\DispatchController@columns');
            Route::get('dispatches/records', 'Tenant\DispatchController@records');
            Route::get('dispatches/create', 'Tenant\DispatchController@create');
            Route::get('dispatches/create2/{dispatche}', 'Tenant\DispatchController@create2');
            Route::get('dispatches/datos/{dispatche}', 'Tenant\DispatchController@datos');
            Route::post('dispatches/tables', 'Tenant\DispatchController@tables');
            Route::post('dispatches', 'Tenant\DispatchController@store');

            Route::get('dispatches/resend/{document}', 'Tenant\DispatchController@resend');

            Route::get('reports', 'Tenant\ReportController@index')->name('tenant.reports.index');
            Route::post('reports/search', 'Tenant\ReportController@search')->name('tenant.search');
            Route::post('reports/pdf', 'Tenant\ReportController@pdf')->name('tenant.report_pdf');
            Route::post('reports/excel', 'Tenant\ReportController@excel')->name('tenant.report_excel');

            Route::get('reports/purchases', 'Tenant\ReportPurchaseController@index')->name('tenant.reports.purchases.index');
            Route::post('reports/purchases/search', 'Tenant\ReportPurchaseController@search')->name('tenant.reports.purchases.search');
            Route::post('reports/purchases/pdf', 'Tenant\ReportPurchaseController@pdf')->name('tenant.report.purchases.pdf');
            Route::post('reports/purchases/excel', 'Tenant\ReportPurchaseController@excel')->name('tenant.report.purchases.report_excel');

            Route::get('reports/inventories', 'Tenant\ReportInventoryController@index')->name('tenant.reports.inventories.index');
            Route::post('reports/inventories/search', 'Tenant\ReportInventoryController@search')->name('tenant.reports.inventories.search');
            Route::post('reports/inventories/pdf', 'Tenant\ReportInventoryController@pdf')->name('tenant.report.inventories.pdf');
            Route::post('reports/inventories/excel', 'Tenant\ReportInventoryController@excel')->name('tenant.report.inventories.report_excel');

            Route::get('reports/sells', 'Tenant\ReportSellController@index')->name('tenant.reports.sells.index');
            Route::post('reports/sells/search', 'Tenant\ReportSellController@search')->name('tenant.reports.sells.search');
            Route::post('reports/sells/search2', 'Tenant\ReportSellController@search2')->name('tenant.reports.sells.search2');
            Route::post('reports/sells/pdf', 'Tenant\ReportSellController@pdf')->name('tenant.report.sells.pdf');
            Route::post('reports/sells/excel', 'Tenant\ReportSellController@excel')->name('tenant.report.sells.excel');

///auemntar reprote item detalle


            Route::get('reports/items_detalle', 'Tenant\ReportItems_detalleController@index')->name('tenant.reports.items_detalle.index');
            Route::post('reports/items_detalle/search', 'Tenant\ReportItems_detalleController@search')->name('tenant.reports.items_detalle.search');
            Route::post('reports/items_detalle/search2', 'Tenant\ReportItems_detalleController@search2')->name('tenant.reports.items_detalle.search2');
            Route::post('reports/items_detalle/pdf', 'Tenant\ReportItems_detalleController@pdf')->name('tenant.report.items_detalle.pdf');
            Route::post('reports/items_detalle/excel', 'Tenant\ReportItems_detalleController@excel')->name('tenant.report.items_detalle.excel');



            Route::get('reports/customers', 'Tenant\ReportCustomerController@index')->name('tenant.reports.customers.index');
            Route::post('reports/customers/search', 'Tenant\ReportCustomerController@search')->name('tenant.reports.customers.search');
            Route::post('reports/customers/pdf', 'Tenant\ReportCustomerController@pdf')->name('tenant.report.customers.pdf');
            Route::post('reports/customers/excel', 'Tenant\ReportCustomerController@excel')->name('tenant.report.customers.excel');

            // Route::get('reports/customers/{person}', 'Tenant\ReportCustomerController@detail')->name('tenant.reports.customer.detail');            
            // Route::get('reports-customers/columns', 'Tenant\ReportCustomerController@columns');
            // Route::get('reports-customers/records', 'Tenant\ReportCustomerController@records');
            // Route::get('reports-customers/{person}/sells/columns', 'Tenant\ReportCustomerController@sell_columns');
            // Route::get('reports-customers/{person}/sells', 'Tenant\ReportCustomerController@sells');
            
            Route::get('documents/view/{document}', 'Tenant\DocumentController@view')->name('tenant.documents.view');
            Route::get('documentsgeneral/view/{document}', 'Tenant\DocumentgeneralController@view')->name('tenant.documentsgeneral.view');

          

            //report expense
            Route::get('reports/expenses', 'Tenant\ReportExpenseController@index')->name('tenant.reports.expenses.index');
            Route::post('reports/expenses/search', 'Tenant\ReportExpenseController@search')->name('tenant.expenses.search');
            Route::post('reports/expenses/pdf', 'Tenant\ReportExpenseController@pdf')->name('tenant.expenses.report_pdf');
            Route::post('reports/expenses/excel', 'Tenant\ReportExpenseController@excel')->name('tenant.expenses.report_excel');

            Route::post('options/delete_documents', 'Tenant\OptionController@deleteDocuments');

            Route::get('services/ruc/{number}', 'Tenant\Api\ServiceController@ruc');
            Route::get('services/dni/{number}', 'Tenant\Api\ServiceController@dni');
            Route::post('services/exchange_rate', 'Tenant\Api\ServiceController@exchange_rate');
            Route::post('services/search_exchange_rate', 'Tenant\Api\ServiceController@searchExchangeRateByDate');
            Route::get('services/exchange_rate/{date}', 'Tenant\Api\ServiceController@exchangeRateTest');

            //BUSQUEDA DE DOCUMENTOS
            // Route::get('busqueda', 'Tenant\SearchController@index')->name('search');
            // Route::post('busqueda', 'Tenant\SearchController@index')->name('search');

            //Codes
            Route::get('codes/records', 'Tenant\Catalogs\CodeController@records');
            Route::get('codes/tables', 'Tenant\Catalogs\CodeController@tables');
            Route::get('codes/record/{code}', 'Tenant\Catalogs\CodeController@record');
            Route::post('codes', 'Tenant\Catalogs\CodeController@store');
            Route::delete('codes/{code}', 'Tenant\Catalogs\CodeController@destroy');

            //Units
            Route::get('unit_types/records', 'Tenant\UnitTypeController@records');
            Route::get('unit_types/record/{code}', 'Tenant\UnitTypeController@record');
            Route::post('unit_types', 'Tenant\UnitTypeController@store');
            Route::delete('unit_types/{code}', 'Tenant\UnitTypeController@destroy');

            //Banks
            Route::get('banks/records', 'Tenant\BankController@records');
            Route::get('banks/record/{bank}', 'Tenant\BankController@record');
            Route::post('banks', 'Tenant\BankController@store');
            Route::delete('banks/{bank}', 'Tenant\BankController@destroy');

            //Exchange Rates
            Route::get('exchange_rates/records', 'Tenant\ExchangeRateController@records');
            Route::post('exchange_rates', 'Tenant\ExchangeRateController@store');

            //Currency Types
            Route::get('currency_types/records', 'Tenant\CurrencyTypeController@records');
            Route::get('currency_types/record/{currency_type}', 'Tenant\CurrencyTypeController@record');
            Route::post('currency_types', 'Tenant\CurrencyTypeController@store');
            Route::delete('currency_types/{currency_type}', 'Tenant\CurrencyTypeController@destroy');

            //Perceptions
            Route::get('perceptions', 'Tenant\PerceptionController@index')->name('tenant.perceptions.index');
            Route::get('perceptions/columns', 'Tenant\PerceptionController@columns');
            Route::get('perceptions/records', 'Tenant\PerceptionController@records');
            Route::get('perceptions/create', 'Tenant\PerceptionController@create')->name('tenant.perceptions.create');
            Route::get('perceptions/tables', 'Tenant\PerceptionController@tables');
            Route::get('perceptions/record/{perception}', 'Tenant\PerceptionController@record');
            Route::post('perceptions', 'Tenant\PerceptionController@store');
            Route::delete('perceptions/{perception}', 'Tenant\PerceptionController@destroy');
            Route::get('perceptions/item/tables', 'Tenant\PerceptionController@item_tables');

            //Tribute Concept Type
            Route::get('tribute_concept_types/records', 'Tenant\TributeConceptTypeController@records');
            Route::get('tribute_concept_types/record/{id}', 'Tenant\TributeConceptTypeController@record');
            Route::post('tribute_concept_types', 'Tenant\TributeConceptTypeController@store');
            Route::delete('tribute_concept_types/{id}', 'Tenant\TributeConceptTypeController@destroy');

            //Trademarks // juliocapuano@gmail.com
            Route::get('trademarks/records', 'Tenant\TrademarksController@records');
            Route::get('trademarks/record/{id}', 'Tenant\TrademarksController@record');
            Route::post('trademarks', 'Tenant\TrademarksController@store');
            Route::delete('trademarks/{id}', 'Tenant\TrademarksController@destroy');

            //Trademarks // juliocapuano@gmail.com
            Route::get('item_category/tables', 'Tenant\ItemCategoryController@tables');
            Route::get('item_category/records', 'Tenant\ItemCategoryController@records');
            Route::get('item_category/record/{id}', 'Tenant\ItemCategoryController@record');
            Route::post('item_category', 'Tenant\ItemCategoryController@store');
            Route::delete('item_category/{id}', 'Tenant\ItemCategoryController@destroy');

            //purchases
            Route::get('purchases', 'Tenant\PurchaseController@index')->name('tenant.purchases.index');
            Route::get('purchases/columns', 'Tenant\PurchaseController@columns');
            Route::get('purchases/records', 'Tenant\PurchaseController@records');
            Route::get('purchases/totals', 'Tenant\PurchaseController@totals');
            Route::get('purchases/create', 'Tenant\PurchaseController@create')->name('tenant.purchases.create');
            Route::get('purchases/edit/{purchase}', 'Tenant\PurchaseController@edit')->name('tenant.purchases.edit');
            Route::post('purchases/update/{purchase}', 'Tenant\PurchaseController@update');
            Route::get('purchases/tables2/{purchase}', 'Tenant\PurchaseController@tables2');
            Route::get('purchases/tables', 'Tenant\PurchaseController@tables');
            Route::get('purchases/table/{table}', 'Tenant\PurchaseController@table');
            Route::post('purchases', 'Tenant\PurchaseController@store');
            Route::get('purchases/record/{document}', 'Tenant\PurchaseController@record');
            Route::get('purchases/item/tables', 'Tenant\PurchaseController@item_tables');
            Route::get('purchases/item/tables2/{purchase}', 'Tenant\PurchaseController@item_tables2');

        });
    });
} else {
  Route::domain(env('APP_URL_BASE'))->group(function () {
        Route::get('login', 'System\LoginController@showLoginForm')->name('login');
        Route::post('login', 'System\LoginController@login');
        Route::post('logout', 'System\LoginController@logout')->name('logout');

        Route::middleware('auth:admin')->group(function () {
            Route::get('/', function () {
                return redirect()->route('system.dashboard');
            });
            Route::get('dashboard', 'System\HomeController@index')->name('system.dashboard');
            
            //Clients
            Route::get('clients', 'System\ClientController@index')->name('system.clients.index');
            Route::get('clients/records', 'System\ClientController@records');
            Route::get('clients/create', 'System\ClientController@create');
            Route::get('clients/tables', 'System\ClientController@tables');
            Route::get('clients/charts', 'System\ClientController@charts');
            Route::get('clients/record/{client}', 'System\ClientController@record');
            Route::post('clients', 'System\ClientController@store');
            Route::post('clients/update/{client}', 'System\ClientController@update');
            Route::delete('clients/{client}', 'System\ClientController@destroy');
            Route::post('clients/password/{client}', 'System\ClientController@password');

            //Planes
            Route::get('plans', 'System\PlanController@index')->name('system.plans.index');
            Route::get('plans/records', 'System\PlanController@records');
            Route::get('plans/tables', 'System\PlanController@tables');
            Route::get('plans/record/{plan}', 'System\PlanController@record');
            Route::post('plans', 'System\PlanController@store');
            Route::delete('plans/{plan}', 'System\PlanController@destroy');


            //Users
            Route::get('users/create', 'System\UserController@create')->name('system.users.create');
            Route::get('users/record', 'System\UserController@record');
            Route::post('users', 'System\UserController@store');

            Route::get('services/ruc/{number}', 'System\ServiceController@ruc');
        });
  });
}

