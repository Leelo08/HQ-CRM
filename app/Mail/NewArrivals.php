<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
class NewArrivals extends Mailable
{
    use Queueable, SerializesModels;

    protected $new_arrival;
    
    public function __construct($new_arrival)
    {
        $this->new_arrival = $new_arrival;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newarrivals')
                    ->subject($this->new_arrival->toName)
                    ->subject($this->new_arrival->toEmail)
                    ->from($this->new_arrival->fromEmail, $this->new_arrival->fromName)
                    ->with([
                        'new_arrival' => $this->new_arrival,
                    ]);
    }
}