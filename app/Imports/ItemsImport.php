<?php

namespace App\Imports;

use App\Models\Tenant\Item;
use App\Models\Tenant\Warehouse;
use App\Models\Tenant\ItemWarehouse;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class ItemsImport implements ToCollection
{
    use Importable;

    protected $data;

    public function collection(Collection $rows)
    {
        $total = count($rows);
        $registered = 0;
        unset($rows[0]);

        foreach ($rows as $row)
        {
            if($row[0] != "")
            {
                $description = $row[0];
                $item_type_id = '01';
                //aumentar detalle
                $detalle = $row[1];
                //fin aumentar detalle
                $internal_id = ($row[2])?:null;
                $item_code = ($row[3])?:null;
                $unit_type_id = $row[4];
                $currency_type_id = $row[5];
                $sale_unit_price = $row[6];
                $sale_affectation_igv_type_id = $row[7];
                $purchase_unit_price = ($row[8])?:0;
                $purchase_affectation_igv_type_id = ($row[9])?:null;

                $stock = $row[10];

                $stock_min = $row[11];
                $item_category_id = $row[12];

                if($internal_id)
                {
                    $item = Item::where('internal_id', $internal_id)->first();
                }
                else
                {
                    $item = null;
                }

                if(!$item) {
                    $register = Item::create([
                        'description' => $description,
                        //auenmtnar detalle
                        'detalle' =>$detalle,
                        //fin auamentar dewtalle
                        'item_type_id' => $item_type_id,
                        'internal_id' => $internal_id,
                        'item_code' => $item_code,
                        'unit_type_id' => $unit_type_id,
                        'currency_type_id' => $currency_type_id,
                        'sale_unit_price' => $sale_unit_price,
                        'sale_affectation_igv_type_id' => $sale_affectation_igv_type_id,
                        'purchase_unit_price' => $purchase_unit_price,
                        'purchase_affectation_igv_type_id' => $purchase_affectation_igv_type_id,
                        //'stock' => $stock, 
                        'stock_min' => $stock_min,
                        'item_category_id' => $item_category_id,
                    ]);
                    
                    $array_stock = explode(";", $stock);

                    $warehouses = Warehouse::all();

                    //$item_warehouse = [];

                    foreach($warehouses as $key => $warehouse)
                    {
                        if(!empty($array_stock[$key]))
                        {
                            $item_warehouse = new ItemWarehouse();
                            $item_warehouse->item_id = $register->id;
                            $item_warehouse->warehouse_id = $warehouse->id;
                            $item_warehouse->stock = $array_stock[$key];
                            $item_warehouse->save();
                        }
                    }

                    $registered += 1;
                }
            }
        }

        $this->data = compact('total', 'registered');
    }

    public function getData()
    {
        return $this->data;
    }
}
