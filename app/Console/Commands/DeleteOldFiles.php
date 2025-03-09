<?php

namespace App\Console\Commands;

use App\Models\File\File;
use Illuminate\Console\Command;

class DeleteOldFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        File::where(
            'created_at',
            '<=',
            now()->subSeconds(
                config('custom.file.expire_time')
            )
        )->delete();

        $this->info('File deleted successfully.');
    }
}
