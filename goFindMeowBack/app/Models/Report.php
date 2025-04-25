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
        'address',
        'lat',
        'lon',
        'color',
        'pattern',
        'other_identifying_marks',
        'health_status',
        'photo',
        'chip_number',
        'circumstances',
        'number_of_individuals',
        'disappearance_date',
        'activity'
    ];
    protected $attributes = [
        'activity' => 1,
    ];


    public function shelteredCat()
    {
        return $this->hasOne(ShelteredCat::class, 'report_id');
    }
}
