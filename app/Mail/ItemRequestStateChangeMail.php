<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ItemRequestStateChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    private $userName;
    private $newState;
    private $itemRequestId;

    /**
     * Create a new message instance.
     *
     * @param string $userName
     * @param string $newState
     * @param int $itemRequestId
     * @return void
     */
    public function __construct(string $userName, string $newState, int $itemRequestId)
    {
        $this->userName = $userName;
        $this->newState = $newState;
        $this->itemRequestId = $itemRequestId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.itemRequestStateChange', array('userName' => $this->userName, 'itemRequestState' => $this->newState, 'itemRequestId' => $this->itemRequestId));
    }
}
