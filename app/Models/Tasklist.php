<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasklist extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'name',
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the category
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the tasklist
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the tasks for the tasklist
     */
    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
