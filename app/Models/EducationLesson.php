<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationLesson extends Model
{
    protected $table = 'education_lesson'; // Specify the table name if it's different from the default naming convention

    protected $fillable = [
        'name_lesson',
        'content_lesson',
        'time_lesson',
        'education_module_id',
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
