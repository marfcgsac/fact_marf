<template>
    <div>
        <div class="page-header pr-0">
            <h2><a href="/dashboard"><i class="fas fa-tachometer-alt"></i></a></h2>
            <ol class="breadcrumbs">
                <li class="active"><span>Dashboard</span> </li>
                <!-- <li><span class="text-muted">Facturas - Notas <small>(crédito y débito)</small> - Boletas - Anulaciones</small></span></li> -->
            </ol>
            <div class="right-wrapper pull-right">
                <el-select v-model="establishment_id" @change="changeEstablishment" class="pull-right mt-2 mr-2">
                    <el-option :key="0" :value="0" :label="'Todos los establecimientos'"></el-option>
                    <el-option v-for="option in establishments" :key="option.id" :value="option.id" :label="option.description"></el-option>
                </el-select>
                <!-- <a :href="`/${resource}/create`" class="btn btn-custom btn-sm  mt-2 mr-2"><i class="fa fa-plus-circle"></i> Nuevo</a> -->
            </div>
        </div>

        <div class="card mb-0">
            
            <div class="card-body">
                <div class="row" v-if="loaded">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="el-dialog__title" style="font-weight: 600;">Flujo de caja de la última semana (Todos los establecimientos)</h5>
                                <chart-line :data="dataChartLine"></chart-line>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="max-height: 300px; overflow-y: scroll">
                                <h5 class="el-dialog__title" style="font-weight: 600;">Productos por agotarse</h5>
                                <table class="table table-sm">
                                    <thead class="table-active">
                                        <tr>
                                            <td>Producto</td>
                                            <td>Cantidad</td>
                                            <td>Stock Mínimo</td>
                                            <td>Almacén</td>
                                            <td>Estado</td>
                                            <td>Opción</td>
                                        </tr>
                                    </thead>
                                    <tbody v-for="(row,index) in items">
                                        <tr>
                                            <td>{{ row.description }}</td>
                                            <td>{{ row.stock }}</td>
                                            <td>{{ row.stock_min }}</td>
                                            <td>{{ row.warehouse }}</td>
                                            <td>
                                                <span class="badge bg-secondary text-white bg-danger" v-if="row.stock < 1 ">Agotado</span>
                                                <span class="badge bg-secondary text-white bg-warning" v-if="row.stock > 0">Pocas unidades</span> 
                                            </td>
                                            <td>
                                                <a :href="`purchases/create`" class="btn waves-effect waves-light btn-xs btn-info m-1__2">Abastacer</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            
                            <div class="col-md-12" style="max-height: 300px; overflow-y: scroll">
                                 <h5 class="el-dialog__title" style="font-weight: 600;">Cuentas por cobrar</h5>
                                <table class="table table-sm">
                                    <thead class="table-active">
                                        <tr>
                                            <td>Cliente</td>
                                            <td>Documento</td>
                                            <td>Deuda</td>
                                            <td>Opción</td>
                                        </tr>
                                    </thead>
                                    <tbody v-for="(row,index) in customers" :key="`A-${index}`">
                                        <tr>
                                            <td>{{ row.name }}</td>
                                            <td>
                                                {{ row.series }}-{{ row.number }} <br>
                                                <small v-if="row.document_type_id == '01'">Factura Electrónica</small>
                                                <small v-if="row.document_type_id == '03'">Boleta de Venta Electrónica</small>
                                                <small v-if="row.document_type_id == '80'">Orden de Servicio</small>
                                            </td>
                                            <td>{{ row.total }}</td>
                                            <td><button type="button" class="btn waves-effect waves-light btn-xs btn-danger m-1__2" @click.prevent="clickPay(row.id, row.resource)">Pagar</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                        <!-- /*******MAS VENTAS  -->

                     
                        <!-- /*******MAS VENTAS  -->

                    <div class="col-md-4">
                        <section class="card card-horizontal card-tenant-dashboard">
                             <header class="card-header " style=" background: #f6212b;">
                                <div class="card-header-icon"><i class="fa fa-shopping-basket"></i></div>
                            </header>
                            <div class="card-body p-4 text-center">
                                <p class="font-weight-semibold mb-0 mx-4">Venta en el día</p>
                                <h5 class="font-weight-semibold mt-0">S/. {{ total_sell }}</h5>
                                <div class="summary-footer"><a :href="`dashboard/sells`" class="text-muted text-uppercase">Ver detalle</a></div>               
                            </div>
                        </section>
                        <section class="card card-horizontal card-tenant-dashboard">
                            <header class="card-header " style=" background: #00E775;">
                                <div class="card-header-icon"><i class="fas fa-donate"></i></div>
                            </header>
                            <div class="card-body p-4 text-center">
                                <p class="font-weight-semibold mb-0 mx-4">Total de Ingresos</p>
                                <h5 class="font-weight-semibold mt-0">S/. {{ total_invoices }}</h5>
                            </div>
                        </section>
                        <section class="card card-horizontal card-tenant-dashboard">
                           <header class="card-header" style="background: #FF074D;">
                                <div class="card-header-icon"><i class="fas fa-address-book"></i></div>
                            </header>
                            <div class="card-body p-4 text-center">
                                <p class="font-weight-semibold mb-0 mx-4">Cuentas por Cobrar</p>
                                <h5 class="font-weight-semibold mt-0">S/. {{ total_charge }}</h5>
                            </div>
                        </section>
                        <section class="card card-horizontal card-tenant-dashboard">
                            <h5 style="text-align: center;">Todos los establecimientos (% Pagos)</h5>
                            <chart-pie :data="dataChartPie"></chart-pie>
                        </section>
                    </div>
                </div>
                <div class="col-md-12">
                        
                        <div class="row">
                            <div class="col-md-6" style="max-height:auto; ">
                                <h5 class="el-dialog__title" style="font-weight: 600;">Top Clientes</h5>
                                <table class="table">
                                    <thead class="table-active">
                                        <tr>
                                            <td>#</td>
                                            <td>CLIENTE</td>
                                            <td>TOTAL VENTA</td>
                                          
                                        </tr>
                                    </thead>
                                 
                                    <tbody v-for="(row,index) in top_10">
                                        <tr>
                                            <td>{{ index+1 }}</td>
                                            <td>{{ row.name }}</td>
                                            <td>{{ row.total }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6" style="max-height:auto; ">
                                <h5 class="el-dialog__title" style="font-weight: 600;">Top Productos</h5>
                                <table class="table">
                                    <thead class="table-active">
                                        <tr>
                                            <td>#</td>
                                            <td>PRODUCTO</td>
                                            <td>CODIGO</td>
                                            <td>TOTAL</td>
                                          
                                        </tr>
                                    </thead>
                                 
                                    <tbody v-for="(row,index) in top_10_p">
                                        <tr>
                                            <td>{{ index+1 }}</td>
                                            <td>{{ row.name }}</td>
                                            <td>{{ row.codigo }}</td>
                                            <td>{{ row.total }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                           
                           
                        </div>
                    </div>
           
           
           
            </div>
        </div>

    
        <documents-pay :showDialog.sync="showDialogPay"
                            :recordId="recordId" :resource="resource_pay"></documents-pay>
    </div>


</template>


<script>   
    import ChartLine from './charts/Line'
    import ChartPie from './charts/Pie'
    import DocumentsPay from '../documents/partials/pay.vue'

    export default {
        components: {ChartLine, ChartPie, DocumentsPay},
        data() {
            return {
                resource: 'dashboard',
                resource_pay: 'documents',
                loaded: false,
                loaded_line: false,
                loaded_pie: false,
                showDialogPay: false,
                recordId: null,
                documents: [],
             
                establishments: [],
                establishment_id: 0,
                total_invoices: 0,
                total_charge: 0,
                total_sell: 0,
                items: [],
                customers: [], 
                top_10: [], 
                top_10_p:[],
                dataChartLine : null,
                dataChartPie : null
            }
        },
        async mounted() {
            this.loaded = false

            await this.$http.get(`/${this.resource}/chart_cash_flow/${this.establishment_id}`)
                .then(response => {
                    this.dataChartLine = null;
                    this.dataChartLine = {
                        labels: null,
                        datasets: [{
                            data: null,
                            label: "Total Facturado",
                            // backgroundColor: "#28a745",
                            // borderColor: "#28a745",
                             backgroundColor: "#00E775",
                            borderColor: "#28a745",
                            fill: false
                        }, {
                            data: null,
                            label: "Pagos pendientes",
                            // backgroundColor: "#ffcd56",
                            // borderColor: "#ffcd56",
                             backgroundColor: "#FF074D",
                            borderColor: "#ffcd56",
                            fill: false
                        }
                    ]}
                    let line = response.data.line
                    this.dataChartLine.labels = line.labels
                    this.dataChartLine.datasets[0].data = line.data
                    this.dataChartLine.datasets[1].data = line.data2
            })

            await  this.$http.get(`/${this.resource}/chart_pie_total/${this.establishment_id}`)
                .then(response => {
                    this.loaded_pie = false

                    this.dataChartPie = null;
                    this.dataChartPie =  {
                        labels: null,
                        datasets: [{
                            label: "",
                            //backgroundColor: ["#28a745", "#ffcd56"],
                            backgroundColor: ["#00E775", "#FF074D"],
                            data: null
                        }]
                    }
                    let pie = response.data.pie
                    this.dataChartPie.labels = pie.labels
                    this.dataChartPie.datasets[0].data = pie.data     
            })
            
            this.loaded = true 
        },
        created() {
            
            this.loaded = false
            this.$http.get(`/${this.resource}/establishments/`)
                .then(response => {
                    this.establishments = response.data.establishments
            })            

            this.$eventHub.$on('reloadData', () => {
                this.load()
            });

            this.load()
            this.loaded = true
        },
        methods: {

            load() {
                return this.$http.get(`/${this.resource}/load/${this.establishment_id}`)
                        .then(response => {
                            this.items = response.data.items
                            this.customers = response.data.customers
                            this.total_invoices = response.data.totals.total
                            this.total_charge = response.data.totals.total - response.data.totals.total_paid
                            this.total_sell = response.data.total_sells
                            this.top_10 = response.data.top_10
                            this.top_10_p = response.data.top_10_p 

                });
            },
            
            changeEstablishment() {
                this.load()
            },
            clickPay(recordId = null, resource_pay = 'documents') {
                this.recordId = recordId
                this.resource_pay = resource_pay
                this.showDialogPay = true
            }
        }
    }
</script>
<style>
    .div-lista{
        border: 1px solid #ccc;
        padding: 5px
    }
</style>


