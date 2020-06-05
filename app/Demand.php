<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'city', 'postal_code', 'category_id', 'description', 'project_delay'];
}
