<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDosis extends Model
{
    use HasFactory;

    protected $table = 'm_dosis';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $guarded = ['id'];
}
