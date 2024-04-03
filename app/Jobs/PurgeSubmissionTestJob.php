<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Storage;

class PurgeSubmissionTestJob implements ShouldQueue
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
        $storagePath = 'submission-tests/' . $this->submission->id;
        Storage::disk('local')->deleteDirectory($storagePath);
    }
}