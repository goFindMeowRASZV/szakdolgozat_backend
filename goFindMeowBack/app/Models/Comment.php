<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;
    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('user', '=', $this->getAttribute('id'))
            ->where('report', '=', $this->getAttribute('report_id'));
        return $query;
    }
    protected $fillable = [
        'report',
        'user',
        'content',
        'photo'
    ];
    public function user()
{
    return $this->belongsTo(User::class, 'user');
}
public function report()
{
    return $this->belongsTo(Report::class, 'report');
}

}
