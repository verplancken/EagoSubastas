<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitaciones extends Model
{
    protected $table = 'invitaciones';
    protected $primary = 'id';

    public $timestamps = false;

    protected $flillable=[
    	'name',
    	'email',
        'auction_id',
        'estatus',
    ];

    protected $guarded=[

    ];
}