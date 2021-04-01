<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'product';
    
    protected $fillable = [
        'name', 'price', 'quantity'
    ];

    /**
     * Get all of the history for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history()
    {
        return $this->hasMany(History::class, 'product_id', 'id');
    }
}
