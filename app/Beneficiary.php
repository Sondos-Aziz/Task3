<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    public function batch(){
        return $this->belongsTo('App/Batches');
    }

    protected $fillable =[ 'batch_No','currency','amount'  ];
}
