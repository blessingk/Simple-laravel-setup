<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BirthdayWish extends Mailable
{
    use Queueable, SerializesModels;

    private $employee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = "Happy Birthday {$this->employee->name} {$this->employee->lastname}";
        return $this->html($message)->subject('Birthday Wish')->from('hello@realmdigital.co.za', 'Realm Digital');
    }
}
