<?php

namespace App\Observers;

use App\Models\EntryYear;

class EntryYearObserver
{
    public function updated(EntryYear $entryYear)
    {
        // Jalankan job untuk memperbarui template
        UpdateDropdownTemplate::dispatch();
    }
}
