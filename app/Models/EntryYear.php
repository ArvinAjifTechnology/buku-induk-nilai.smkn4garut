<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EntryYear extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uniqid)) {
                $model->uniqid = Str::uuid()->toString();
            }
        });
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'entry_year_major')->withTimestamps();;
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'uniqid';
    }
}
