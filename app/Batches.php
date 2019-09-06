<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batches extends Model
{
   public function beneficiaries(){
       return $this->hasMany('App/Beneficiary');
   }

    protected $fillable =[ 'BatchNo','sponsorNo','dateOfPayment'  ];

}
