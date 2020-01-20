<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExpenseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    private $decimal;

    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {
//
$has_xml = true;
$has_pdf = true;
$has_cdr = false;
$btn_note = false;
$btn_resend = false;
$btn_voided = false;
$btn_consult_cdr = false;
//
     
            return [
                'id' => $row->id,
                'description' => $row->description,
                'date_of_issue' => $row->date_of_issue,
                'usuario' => $row->user->name,
                'total' => "{$row->currency_type->symbol} {$row->total}",
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),

                //
                'has_xml' => $has_xml,
                'has_pdf' => $has_pdf,
                'has_cdr' => $has_cdr,


                'download_xml' => $row->download_external_xml,
                'download_pdf' => $row->download_external_pdf,
                'download_cdr' => $row->download_external_cdr,
                //



            ];
        });
    }
}