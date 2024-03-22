<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationModule extends Model
{
    protected $table = 'education_module'; // Specify the table name if it's different from the default naming convention

    protected $fillable = [
        'name_module',
        'education_course_id',
        'delete_flg',
        'created_date',
        'created_user',
        'updated_date',
        'updated_user',
    ];

    // If you don't want to use timestamps, you can set the following property to false
    public $timestamps = false;

    // You can define relationships with other models here
}
