<?php

namespace App\Observers;

use App\Models\Major;

class MajorObserver
{
    public function updated(Major $major)
    {
        // Jalankan job untuk memperbarui template
        UpdateDropdownTemplate::dispatch();
    }
}
