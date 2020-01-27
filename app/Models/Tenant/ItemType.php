<?php

namespace App\Models\Tenant;

class ItemType extends ModelTenant
{
   
    protected $fillable = [
    'id',
        //
     'description', 
    ];
        
    public $incrementing = false;
    public $timestamps = false;




}