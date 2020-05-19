<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPlacedVendor extends Mailable
{
    use Queueable, SerializesModels;

    public $vendorOrder = [];
    public $vendorEmail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vendorOrder, $vendorEmail)
    {
        $this->vendorOrder = $vendorOrder;
        $this->vendorEmail = $vendorEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->vendorEmail)
        ->subject('Order from Lift Up')
        ->markdown('emails.orders.placedVendor');
    }
}