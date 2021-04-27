<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;

class Comment extends Model
{
    use HasFactory, NodeTrait, Notifiable;

    protected $fillable = [
        'body',
        'post_id',
        'user_id',
    ];
}
