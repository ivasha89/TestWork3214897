<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'middle_name',
    ];

    public $timestamps = false;

    protected $appends = [
        'full_name'
    ];

    public function getFullNameAttribute() {
        return $this->first_name . " " . $this->last_name[0] . ". " . $this->middle_name[0] . ".";
    }
}
