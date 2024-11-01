<?php

namespace App\Observers;

use App\Models\SchoolClass;
use App\Jobs\UpdateDropdownTemplate;

class SchoolClassObserver
{
    // public function updated(SchoolClass $schoolClass)
    // {
    //     // Jalankan job untuk memperbarui template
    //     UpdateDropdownTemplate::dispatch();
    // }

    /**
     * Handle the SchoolClass "deleting" event.
     *
     * Saat data kelas dihapus, fungsi ini akan dijalankan
     * untuk melakukan soft delete pada semua siswa (students)
     * yang terkait dengan kelas tersebut.
     *
     * @param  \App\Models\SchoolClass  $schoolClass
     * @return void
     */
    public function deleting(SchoolClass $schoolClass)
    {
        // Soft delete semua siswa yang terkait dengan kelas yang sedang dihapus
        $schoolClass->students()->delete();
    }

}
