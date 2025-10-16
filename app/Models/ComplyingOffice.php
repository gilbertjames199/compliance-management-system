<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplyingOffice extends Model
{
    //
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'complying_offices';
    protected $guarded = [
        'id'
    ];
    public function office()
    {
        return $this->belongsTo(Office::class, 'department_code', 'department_code');
    }

    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'requirement_id', 'id');
    }
}
