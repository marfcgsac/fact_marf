<?php

namespace App\Imports;

use App\Models\Tenant\Item;
use App\Models\Tenant\Warehouse;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\ItemCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\DB;

class categoriaimport implements ToCollection
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
                // $parent_id = '01';
                $active = '01';
                $created_at = Carbon::now();
                $updated_at = Carbon::now();
                $deleted_at = null;

                // if($active)
                // {
                //     $item = Itemcategory::where('active', $active)->first();
                // }
                // else
                // {
                //     $item = null;
                // }

               // if(!$item) {
                    $register = Itemcategory::create([
                        'description' => $description,
                        //auenmtnar detalle
                        'active' =>$active,
                        //fin auamentar dewtalle
                        'created_at' => $created_at,
                        'updated_at' => $updated_at,
                        'deleted_at' => $deleted_at,
                        
                    ]);
                $registered += 1;
                //}
            }
        }

        $this->data = compact('total', 'registered');
    }

    public function getData()
    {
        return $this->data;
    }
}
