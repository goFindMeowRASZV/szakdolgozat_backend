<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;
    protected $primaryKey = 'report_id';
    protected $fillable = [
        'creator_id',
        'status',
        'expiration_date',
        'address',
        'latitude',
        'longitude',
        'color',
        'pattern',
        'other_identifying_marks',
        'needs_help',
        'health_status',
        'photo',
        'chip_number',
        'circumstances',
        'number_of_individuals',
        'disappearance_date'
    ];
}
