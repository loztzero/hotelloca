<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Uuid;
class Emodel extends Model {
	public static function boot()
    {
        parent::boot();

        // static::creating(function($post)
        // {
        //     $post->id = Helpers::mysqlID();;
        // });

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string)$model->generateNewId();
        });

    }

    public function generateNewId()
    {
        return Uuid::generate(4);
    }

}