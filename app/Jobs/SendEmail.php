<?php

namespace App\Jobs;

use App\Traits\EMails;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, EMails;

    protected $data;
    protected $view;
    protected $subject;
    protected $replyTo;
    protected $from;
    protected $attachment= null;

    /**
     * Create a new job instance.
     *
     * @param $data
     * @param $view
     * @param $subject
     * @param $replyTo
     * @param $from
     * @param $attachment
     */
    public function __construct($data, $view, $subject,$replyTo = 'info@sdtyres.com',$from = 'info@sdtyres.com', $attachment= null)
    {
        $this->data = $data;
        $this->view = $view;
        $this->subject = $subject;
        $this->replyTo = $replyTo;
        $this->from = $from;
        $this->attachment = $attachment;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendMail($this->data, $this->view, $this->subject, $this->replyTo, $this->from, $this->attachment);
    }
}
