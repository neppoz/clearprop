<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Mode extends Model
{
    use SoftDeletes;

    public $table = 'modes';

    public $translatable = ['name'];

}
