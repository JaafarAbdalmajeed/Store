<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;
    const CREATED_AT  = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $connection = 'mysql';
    protected $table = 'stores';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps =  true;
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
