<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalRequest extends Model
{
    protected $fillable = ['user_id','post_id','status'];
}
