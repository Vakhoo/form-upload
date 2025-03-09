<?php

namespace App\Observers;

use App\Jobs\FileDeletedNotificationJob;
use App\Models\File\File;

class FileObserver
{
    /**
     * Handle the File "deleted" event.
     */
    public function deleted(File $file): void
    {
        FileDeletedNotificationJob::dispatch();
    }
}
