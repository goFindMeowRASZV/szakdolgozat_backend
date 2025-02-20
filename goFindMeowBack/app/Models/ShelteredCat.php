<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelteredCat extends Model
{
    /** @use HasFactory<\Database\Factories\ShelteredCatFactory> */
    use HasFactory;
    protected $primaryKey = 'cat_id';
    protected $fillable = [
        'rescuer',
        'report',
        'owner',
        'adoption_date',
        'kennel_number',
        'medical_record',
        's_status',
        'chip_number',
        'breed',
   /*      'photo' */
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

}
