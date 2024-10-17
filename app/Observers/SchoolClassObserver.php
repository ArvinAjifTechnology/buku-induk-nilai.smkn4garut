<?php

namespace App\Observers;

use App\Models\SchoolClass;

class SchoolClassObserver
{
    public function updated(SchoolClass $schoolClass)
    {
        // Jalankan job untuk memperbarui template
        UpdateDropdownTemplate::dispatch();
    }
}
