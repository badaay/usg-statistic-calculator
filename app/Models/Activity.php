<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Activity extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'user_activity';
}
