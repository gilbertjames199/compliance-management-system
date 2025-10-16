<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    //
    protected $guarded=['id'];

    public function office()
    {
        // 'requiring_agency' is the column on requirements table
        // 'department_code' is the matching column on offices table
        return $this->belongsTo(Office::class, 'requiring_agency', 'department_code');
    }
}
