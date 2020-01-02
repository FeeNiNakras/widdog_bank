<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable=['fname','lname','phone','email','address','image'];
    //protected $fillable=['fname','lname','phone','email','address'];
}
