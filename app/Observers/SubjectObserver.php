<?php

namespace App\Observers;

use App\Models\Subject;

class SubjectObserver
{
    // /**
    //  * Handle the Subject "created" event.
    //  */
    // public function created(Subject $subject): void
    // {
    //     //
    // }

    // /**
    //  * Handle the Subject "updated" event.
    //  */
    // public function updated(Subject $subject): void
    // {
    //     //
    // }

    // /**
    //  * Handle the Subject "deleted" event.
    //  */
    // public function deleted(Subject $subject): void
    // {
    //     //
    // }

    // /**
    //  * Handle the Subject "restored" event.
    //  */
    // public function restored(Subject $subject): void
    // {
    //     //
    // }

    // /**
    //  * Handle the Subject "force deleted" event.
    //  */
    // public function forceDeleted(Subject $subject): void
    // {
    //     //
    // }

    /**
     * Handle the Subject "deleting" event.
     *
     * @param  \App\Models\Subject  $subject
     * @return void
     */
    public function deleting(Subject $subject)
    {
        // Hapus semua grades yang terkait dengan subject ini
        $subject->grades()->delete();
    }

}
