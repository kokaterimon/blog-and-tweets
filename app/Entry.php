<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    // La relación entre $entriy y user ($entry->user)
    //eager loading
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
