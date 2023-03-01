<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MObat extends Model
{
    use HasFactory;

    protected $table = 'm_obat';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $guarded = ['id'];

    public function scopeSearch($query, $search)
    {
        $query->orWhere('name', 'like', "%" . $search . "%")
            ->orWhere('mg', 'like', "%" . $search . "%")
            ->orWhere('company', 'like', "%" . $search . "%")
            ->orWhereRelation('dosis', 'name', 'like', "%" . $search . "%")
            ->orWhere('stock', 'like', "%" . $search . "%")
        ->orWhere('stock_alert', 'like', "%" . $search . "%");
    }

    public function scopeStockAlert($query)
    {
        $query->whereRaw('stock <= stock_alert');
    }

    public function trxObat()
    {
        return $this->hasMany(TrxObat::class, 'obat_id', 'id');
    }

    public function dosis()
    {
        return $this->hasOne(MDosis::class, 'id', 'dosis_id');
    }
}
