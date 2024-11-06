<?php

namespace App\Observers;

use App\Models\Student;
use App\Models\SubjectType;

class SubjectTypeObserver
{
    /**
     * Handle the Student "created" event.
     */
    public function created(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "updated" event.
     */
    public function updated(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "deleted" event.
     */
    public function deleted(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "restored" event.
     */
    public function restored(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "force deleted" event.
     */
    public function forceDeleted(Student $student): void
    {
        //
    }

    /**
     * Handle the Subject "deleting" event.
     *
     * @param  \App\Models\SubjectType  $subjectType
     * @return void
     */
    public function deleting(SubjectType $subjectType)
    {
        // Hapus semua grades yang terkait dengan subject ini
        $subjectType->subjects()->delete();
    }
}
