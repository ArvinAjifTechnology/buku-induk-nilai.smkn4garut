<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
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

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function entryYear()
    {
        return $this->belongsTo(EntryYear::class);
    }

    public function graduationYear()
    {
        return $this->belongsTo(GraduationYear::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'grades');
    }

    public function getScoreForSubjectAndSemester($subjectId, $semesterId)
    {
        $grade = $this->grades->where('subject_id', $subjectId)
                              ->where('semester_id', $semesterId)
                              ->first();
        return $grade ? $grade->score : '';
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'uniqid';
    }
}
