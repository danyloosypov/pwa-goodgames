<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\FastAdminPanel\Services\Crud\TableService;
use App\FastAdminPanel\Services\Crud\Entity\ShowService;

class OrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $item;
    public $entity;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $showService = new ShowService(new TableService());
        $this->subject = 'Заказы';
        $this->item = $item;
        $this->entity = $showService->get('orders', $item->id);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.order',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
