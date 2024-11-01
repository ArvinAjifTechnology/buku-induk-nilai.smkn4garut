<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function subjectType()
    {
        return $this->belongsTo(SubjectType::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'major_subjects')->withPivot('entry_year_id')->withTimestamps();
    }

    public function majorsForEntryYear($entryYearId)
    {
        return $this->belongsToMany(Major::class, 'major_subjects')
                    ->withPivot('entry_year_id')
                    ->wherePivot('entry_year_id', $entryYearId);
    }

    public function entryYears()
    {
        return $this->belongsToMany(EntryYear::class, 'major_subjects', 'subject_id', 'entry_year_id');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'uniqid';
    }
}
