<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class APIReferences extends Model
{
    //
    public $keyType = 'string';
    protected $primaryKey = 'reference';
    protected $table = 'api_reference';
}
