<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobList extends Model
{
    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    protected $casts = [
        'job_category_ids' => 'array', // Mengonversi JSON menjadi array
        'job_position_ids' => 'array', // Mengonversi JSON menjadi array
    ];
}
