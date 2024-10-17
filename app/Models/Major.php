<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Major extends Model
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

    public function schoolClasses()
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function specializations()
    {
        return $this->hasMany(Specialization::class);
    }

    // Relasi many-to-many dengan EntryYear
    public function entryYears()
    {
        return $this->belongsToMany(EntryYear::class, 'entry_year_major')->withTimestamps();
    }

    // Relasi many-to-many dengan Subject
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'major_subjects')->withPivot('entry_year_id')->withTimestamps();
    }

    public function subjectsForEntryYear($entryYearId)
    {
        return $this->belongsToMany(Subject::class, 'major_subjects')
                    ->withPivot('entry_year_id')
                    ->wherePivot('entry_year_id', $entryYearId);
    }
    public function subjectTypes()
    {
        return $this->hasMany(SubjectType::class);
    }
    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'uniqid';
    }
}
