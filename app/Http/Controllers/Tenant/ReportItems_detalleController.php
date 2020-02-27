<?php

namespace App\Http\Controllers\Tenant;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Document;
use App\Models\Tenant\Person;
use App\Models\Tenant\Company;
use App\Http\Controllers\Controller;
use App\Exports\DocumentExport;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ReportTrait;
use Carbon\Carbon;



use App\Exports\PurchaseExport;





class ReportItems_detalleController extends Controller
{
    use ReportTrait;

    public function index()
    {
        $establishments = Establishment::all();
       
        $documentTypes = DocumentType::query()
            ->whereIn('id', ['01', '03', '07','08', '100','80'])
            ->get();
        
        // return view('tenant.reports.sells.index', compact('establishments'));
        
        return view('tenant.reports.items_detalle.index', compact('documentTypes','establishments'));
    
    }

    // public function search(Request $request)
    // {
    //     $d = $request->d;
    //     $a = $request->a;
    //     $establishment_td = $this->getEstablishment($request->establishment);;
        

    //     $establishments = Establishment::all();

    //     $records = $this->records($d, $a, $establishment_td);
        
    //     return view('tenant.reports.sells.index', compact('records', 'd', 'a', 'establishment_td', 'establishments'));
    // }

    

    public function search(Request $request) 
    {
    
        // $documentTypes = DocumentType::query()
        // ->whereIn('id', ['01', '03', '07','08', '100','80'])
        // ->get();
        
        // $td = $this->getTypeDoc($request->document_type);
        $d = $request->d;
        $a = $request->a;
        $establishment_td = $this->getEstablishment($request->establishment);;
        

        $establishments = Establishment::all();

        $records2 = $this->records2($d, $a, $establishment_td);
        
        return view('tenant.reports.items_detalle.index', compact('records2', 'd', 'a', 'establishment_td', 'establishments','td'));
        // return view('tenant.reports.purchases.index', compact('reports', 'a', 'd', 'td', 'documentTypes'));
    
     }

    // public function pdf(Request $request)
    // {        
    //     $d = $request->d;
    //     $a = $request->a;
    //     $establishment_td = $request->establishment_td;
        
    //     $company = Company::first();
    //     $establishment = Establishment::where('id', $establishment_td)->first();
        
    //     $records = $this->records($d, $a, $establishment_td);
        
    //     $pdf = PDF::loadView('tenant.reports.sells.report_pdf', compact("records", "company", "establishment"));
    //     $filename = 'Reporte_Ventas_Cliente'.date('YmdHis');
        
    //     return $pdf->download($filename.'.pdf');
    // }
    public function pdf(Request $request)
    {       
        $td= $request->td;
        $d = $request->d;
        $a = $request->a;
        $establishment_td = $request->establishment_td;
        
        $company = Company::first();
        $establishment = Establishment::where('id', $establishment_td)->first();
        
        $records = $this->records2($d, $a, $establishment_td, $td);
        
        $pdf = PDF::loadView('tenant.reports.items_detalle.report_pdf', compact("records", "company", "establishment"));
        $filename = 'Reporte_Ventas_Cliente'.date('YmdHis');
        
        return $pdf->download($filename.'.pdf');
    }

    public function excel(Request $request)
    {
        $td= $request->td;
        $d = $request->d;
        $a = $request->a;
        $establishment_td = $request->establishment_td;
        
        
        $company = Company::first();
        $establishment = Establishment::where('id', $establishment_td)->first();
        
        $records = $this->records2($d, $a, $establishment_td, $td);
        
        return (new DocumentExport)
                ->excel_view('tenant.reports.items_detalle.report_excel')
                ->records($records)
                ->company($company)
                ->establishment($establishment)
                ->download('ReporteVentasCliente'.Carbon::now().'.xlsx');
    }

    // public function records($d, $a, $establishment_id)
    // {
    //     $condition = "";

    //     if($d != null && $a != null)
    //     {
    //         $condition .= "AND doc.date_of_issue BETWEEN '".$d."' AND '".$a."'";
    //     }

    //     if(!is_null($establishment_id))
    //     {
    //         $establishment_id = (int)$establishment_id;
    //         $condition .= " AND doc.establishment_id = $establishment_id";
    //     }

    //     $sql =  "SELECT rep.*, per.number as document_number, per.name
    //     FROM(
    //     SELECT doc.customer_id, doc.`total`, doc.`total_paid`, cdt.description AS type, doc.`date_of_issue`, doc.`series`, doc.`number`
    //     FROM documents doc
    //     INNER JOIN cat_document_types cdt ON cdt.id = doc.document_type_id
    //     WHERE (doc.`document_type_id` = '01' OR doc.`document_type_id` = '03')
    //     AND (doc.`state_type_id` = '01' OR doc.`state_type_id` = '03' OR doc.`state_type_id` = '05' OR doc.`state_type_id` = '07')
    //     $condition
    //     UNION ALL
    //     SELECT doc.customer_id, doc.`total`, doc.`total_paid`, 'Nota de Venta', doc.`date_of_issue`, doc.`series`, doc.`number`
    //     FROM sale_notes doc
    //     WHERE doc.`document_type_id` = '100' $condition) AS rep
    //     INNER JOIN persons per ON per.id = rep.`customer_id`
    //     ORDER BY rep.date_of_issue DESC";
    //     // "SELECT rep.*, per.number as document_number, per.name
    //     // FROM(
    //     // SELECT doc.customer_id, doc.`total`, doc.`total_paid`, cdt.description AS type, doc.`document_type`, doc.`series`, doc.`number`
    //     // FROM documents doc
    //     // INNER JOIN cat_document_types cdt ON cdt.id = doc.document_type_id
    //     // WHERE (doc.`document_type_id` = '01' OR doc.`document_type_id` = '03')
    //     // AND (doc.`state_type_id` = '01' OR doc.`state_type_id` = '03' OR doc.`state_type_id` = '05' OR doc.`state_type_id` = '07')
    //     // $condition
    //     // UNION ALL
    //     // SELECT doc.customer_id, doc.`total`, doc.`total_paid`, 'Nota de Venta', doc.`document_type`, doc.`series`, doc.`number`
    //     // FROM sale_notes doc
    //     // WHERE doc.`document_type_id` = '100' $condition) AS rep
    //     // INNER JOIN persons per ON per.id = rep.`customer_id`
    //     // ORDER BY rep.document_type DESC";
    //             // "SELECT rep.*, per.number as document_number, per.name
    //             // FROM(
    //             // SELECT doc.customer_id, doc.`total`, doc.`total_paid`, cdt.description AS type, doc.`document_type`, doc.`series`, doc.`number`
    //             // FROM documents doc
    //             // INNER JOIN cat_document_types cdt ON cdt.id = doc.document_type_id
    //             // WHERE (doc.`document_type_id` = '01' OR doc.`document_type_id` = '03' OR doc.`document_type_id` = '80')
    //             // AND (doc.`state_type_id` = '01' OR doc.`state_type_id` = '03' OR doc.`state_type_id` = '05' OR doc.`state_type_id` = '07'  OR doc.`state_type_id` = '14')
    //             // $condition
    //             // UNION ALL
    //             // SELECT doc.customer_id, doc.`total`, doc.`total_paid`, 'Nota de Venta', doc.`document_type`, doc.`series`, doc.`number`
    //             // FROM sale_notes doc
    //             // WHERE doc.`document_type_id` = '100' $condition) AS rep
    //             // INNER JOIN persons per ON per.id = rep.`customer_id`
    //             // ORDER BY rep.document_type DESC";
                
      

        
    //     $records = DB::connection('tenant')->select($sql);

    //     return $records;
    // }
    public function records2($d, $a, $establishment_id)
    {
    //     $condition = "";
    //     $condition2= "";
    //     $condition3= "";

    //     if($d != null && $a != null)
    //     {
    //         $condition .= "AND doc.date_of_issue BETWEEN '".$d."' AND '".$a."'";
    //         $condition3 .= "doc.date_of_issue BETWEEN '".$d."' AND '".$a."'";
           
    //     }

    //     if(!is_null($establishment_id))
    //     {
    //        $establishment_id = (int)$establishment_id;
    //        $condition .= " AND doc.establishment_id = $establishment_id";
    //     }
    //     if(!is_null($td == 100))
    //     {
          
    //         $condition2 .=  $td;
    //     }
    //     else
    //     {
          
    //         $condition2 .=  (int)$td;
    //     }

    //  $sql = 
    //     "SELECT rep.*, per.number as document_number, per.name
    //     FROM(
    //     SELECT doc.customer_id, doc.`total`, doc.`total_paid`, cdt.description AS type, doc.`date_of_issue`, doc.`series`, doc.`number`
    //     FROM documents doc
    //     INNER JOIN cat_document_types cdt ON cdt.id = doc.document_type_id
    //     WHERE (doc.`document_type_id` ='$condition2')
        
    //     AND (doc.`state_type_id` = '01' OR doc.`state_type_id` = '03' OR doc.`state_type_id` = '05' OR doc.`state_type_id` = '07' OR doc.`document_type_id` = '80')
    //     $condition
    //     UNION ALL
    //     SELECT doc.customer_id, doc.`total`, doc.`total_paid`, 'NOTA DE VENTA', doc.`date_of_issue`, doc.`series`, doc.`number`
    //     FROM sale_notes doc
    //     WHERE doc.`document_type_id` = '$condition2' $condition) AS rep
    //     INNER JOIN persons per ON per.id = rep.`customer_id`
    //     ORDER BY rep.date_of_issue DESC";
        
        
    //     if($td == null){
           
    //         $sql =   "SELECT rep.*, per.number as document_number, per.name
    //         FROM(
    //         SELECT doc.customer_id, doc.`total`, doc.`total_paid`, cdt.description AS type, doc.`date_of_issue`, doc.`series`, doc.`number`
    //         FROM documents doc
    //         INNER JOIN cat_document_types cdt ON cdt.id = doc.document_type_id
    //         WHERE (doc.`document_type_id` = '01' OR doc.`document_type_id` = '03'OR doc.`document_type_id` = '07' OR doc.`document_type_id` = '08' OR doc.`document_type_id` = '80')
    //         AND (doc.`state_type_id` = '01' OR doc.`state_type_id` = '03' OR doc.`state_type_id` = '05'  OR doc.`state_type_id` = '07' OR doc.`state_type_id` = '14')
    //         AND $condition3
    //         UNION ALL
    //         SELECT doc.customer_id, doc.`total`, doc.`total_paid`, 'NOTA DE VENTA', doc.`date_of_issue`, doc.`series`, doc.`number`
    //         FROM sale_notes doc
    //         WHERE   $condition3)  AS rep
    //         INNER JOIN persons per ON per.id = rep.`customer_id`
    //         ORDER BY rep.date_of_issue asc";


    //     }
      
    //     $records = DB::connection('tenant')->select($sql);

    //     return $records;
    $condicion = "";
    $condicion1 = "";
    $condicion2 = "";

        if($d != null && $a != null)
        {
            $condicion1.= " dat.date_of_issue BETWEEN '".$d."' AND '".$a."'";
        }

        // if(!is_null($td))
        // {
        //     $condicion .= " AND doc.document_type_id = '".$td."'";
        // }
       
        if(!is_null($establishment_id))
        {
            $condicion2 .= " AND dat.pos_id = '".$establishment_id."'";
           
        }

        $sql = " SELECT  dat.*, symbol FROM (SELECT  MAX(tab.id) AS id, tab.series, tab.number, tab.`currency_type_id`, pay.total, 'Venta' AS operation_type, null as detail,it.description,tab.date_of_issue,pay.pos_id
        FROM payments pay
        INNER JOIN documents tab ON tab.id = pay.document_id
        INNER JOIN document_items tabit on tabit.document_id = tab.id
        inner join items it ON it.id= tabit.item_id
        and tab.document_type_id  NOT LIKE '%2'
        WHERE pay.pos_id =pos_id
         group BY tab.series,tab.number , tab.`currency_type_id`,pay.total,it.description,tab.date_of_issue,pay.pos_id
        UNION ALL
        SELECT MAX(tab.id) AS id, tab.series, tab.number, tab.`currency_type_id`, pay.total, 'Nota de Venta' AS operation_type, NULL,it.description,tab.date_of_issue,pay.pos_id
        FROM payments pay
        INNER JOIN sale_notes tab ON tab.id = pay.sale_note_id
        INNER JOIN sale_note_items tabit on tabit.sale_note_id = tab.id
        inner join items it ON it.id= tabit.item_id
        WHERE pay.pos_id =pos_id
        group BY tab.series,tab.number , tab.`currency_type_id`,pay.total,it.description,tab.date_of_issue,pay.pos_id
        UNION ALL
        SELECT tab.id, '-', '-', tab.`currency_type_id`, - tab.`total`, 'Gasto', tab.description,NULL,pos.created_at AS date_of_issue,pos.pos_id AS pos_id
        FROM pos_sales pos
        INNER JOIN pos ps ON ps.id=pos.id
        INNER JOIN expenses tab ON tab.id = pos.`document_id`
        WHERE table_name = 'expenses' 
  
    ) dat
    INNER JOIN cat_currency_types cur ON cur.id = dat.currency_type_id 
                WHERE $condicion1 $condicion2 ";
        
       

        $records = DB::connection('tenant')->select($sql);

        return $records;
    }
}
