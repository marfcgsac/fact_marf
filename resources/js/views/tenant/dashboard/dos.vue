<template>
    <div>
   

        <div class="card mb-0">
            
            <div class="card-body">
                

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
                                            <td>{{ row.internal_id }}</td>
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


