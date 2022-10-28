<?php

namespace Src\Electricity\Readings\Infrastructure\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;

class EloquentReadingModel extends Model
{
    protected $table = 'readings';

    public $timestamps = false;

    protected $fillable = [
        'client',
        'period',
        'reading_value',
    ];
}
