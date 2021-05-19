<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $table = 'posts';
    protected $guarded = ['id'];
    protected $fillable = [
    	'user_id',
		'title',
        'publish-date',
        'status',
        'content',
        'categories',
        'rating'
	];
}
