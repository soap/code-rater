<?php

namespace App\Jobs;

use Zip;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\AssignmentSubmission;

class PrepareSubmissionTestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected AssignmentSubmission $submission)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $file = $this->submission->getFilePath();
        if (Zip::check($file)) {
            Zip::open($file)->extract(storage_path() . '/app/submission-tests/' . $this->submission->id);
        } else {
            $this->submission->update([
                'status' => 'failed',
            ]);    
        }
    }
}
