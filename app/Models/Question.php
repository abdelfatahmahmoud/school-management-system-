<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Question extends Model
{
    use HasTranslations;
    public $translatable = ['title'];
    protected $guarded= [];
    public function quizze()
    {
        return $this->belongsTo('App\Models\Quizze');
    }
}
