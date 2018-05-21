<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        //'name', 'email', 'password',
        'first_name', 'last_name', 'address', 'phone', 'birthdate', 'gender', 'type_document', 'document_number', 'health_insurance', 'created_at', 'update_at',
    ];

}
