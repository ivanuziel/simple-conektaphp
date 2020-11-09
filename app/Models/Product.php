<?php

namespace App\Models;

use App\Conekta\Billable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use Billable;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sku',
        'price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
    	'price' => 'double'
    ];
}
