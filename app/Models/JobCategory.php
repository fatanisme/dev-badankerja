<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    public function jobLists()
    {
        return $this->belongsToMany(JobList::class);
    }
}
