<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserJob extends Model{

protected $primaryKey = 'jobid';
protected $table = 'tbluserjob';
// column sa table

protected $fillable = [
'position'
];
}