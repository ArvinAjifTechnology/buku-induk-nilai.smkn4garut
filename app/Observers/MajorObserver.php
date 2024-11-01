<?php

namespace App\Observers;

use App\Models\Major;

class MajorObserver
{
    // public function updated(Major $major)
    // {
    //     // Jalankan job untuk memperbarui template
    //     UpdateDropdownTemplate::dispatch();
    // }

    /**
     * Handle the Major "deleting" event.
     *
     * @param  \App\Models\Major  $major
     * @return void
     */
    public function deleting(Major $major)
    {
        // Soft delete all related school classes, and students
        $major->schoolClasses()->delete();
        $major->students()->delete();;
    }
}
