<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
     * Get notes for the category
     */
    public function notes() {
        return $this->hasMany(Note::class);
    }

    /**
     * Get tasklists for the category
     */
    public function tasklists() {
        return $this->hasMany(Tasklist::class);
    }
}
