<?php

namespace App\Observers;

use App\Models\Student;

class StudentObserver
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
     * Handle the Student "deleting" event.
     *
     * Saat data siswa dihapus, fungsi ini akan dijalankan
     * untuk melakukan soft delete pada semua data nilai (grades)
     * yang terkait dengan siswa tersebut.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function deleting(Student $student)
    {
        // Soft delete semua nilai yang terkait dengan siswa yang sedang dihapus
        $student->grades()->delete();
    }
}
