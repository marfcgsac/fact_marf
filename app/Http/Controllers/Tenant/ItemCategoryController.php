<?php

namespace App\Http\Controllers\Tenant;
use App\Imports\categoriaimport;
use Maatwebsite\Excel\Excel;
use App\Models\Tenant\ItemCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemCategoryController extends Controller
{

    function tables()
    {
        $parents = ItemCategory::WhereNull('parent_id')->get();
        return compact('parents');
    }

    public function records(Request $request)
    {
        $records = ItemCategory::WhereNull('parent_id')->get();

        return ['data' => $records];

        //return new PosCollection($records->paginate(env('ITEMS_PER_PAGE', 10)));
    }

    public function record($id)
    {
        $record = ItemCategory::findOrFail($id)->toArray();

        return ['data' => $record];
    }


    public function store(Request $request)
    {

        try {

            $id = $request->input('id');
            $trademark = ItemCategory::firstOrNew(['id' => $id]);
            $trademark->fill($request->all());
            $trademark->save();

            return [
                'success' => true,
                'message' => ($id) ? 'Marca editada con éxito' : 'Marca registrada con éxito'
            ];

        } catch (QueryException $e) {

            return [
                'success' => false,
//                'message' => 'Marca ya existente en el registro'//$e->getMessage()
                'message' => $e->getMessage()
            ];

        }


    }
    public function destroy($id)
    {
        $record = ItemCategory::findOrFail($id);
        $record->delete();

        return [
            'success' => true,
            'message' => 'Atributo eliminado con Ã©xito'
        ];
    }


    public function disponible()
    {

    //     $data = Itemcategory::
    //    where("active",1)
    //     ->get();
  
        
            $data = Itemcategory::where("active", 1 )
            ->orderby('description', 'asc')
            ->get();
            return $data;
     }
//aumentar import categoria
     public function import(Request $request)
     {
         if ($request->hasFile('file')) {
             try {
                 $import = new categoriaimport();
                 $import->import($request->file('file'), null, Excel::XLSX);
                 $data = $import->getData();
                 return [
                     'success' => true,
                     'message' => __('app.actions.upload.success'),
                     'data' => $data
                 ];
             } catch (Exception $e) {
                 return [
                     'success' => false,
                     'message' => $e->getMessage()
                 ];
             }
         }
         return [
             'success' => false,
             'message' => __('app.actions.upload.error'),
         ];
     }
 
}

