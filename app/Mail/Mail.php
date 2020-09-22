<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Mail extends Mailable
{
    use Queueable, SerializesModels;

    protected $content;
	protected $EmailFrom;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content, $EmailFrom = '')
    {
        $this->content = $content;
		$this->EmailFrom = $EmailFrom;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		if (!empty($this->EmailFrom)) {
			return $this->from($this->EmailFrom)->view('mail.index')->with(['content' => $this->content]);
		}
        return $this->view('mail.index')->with(['content' => $this->content]);
    }
}
