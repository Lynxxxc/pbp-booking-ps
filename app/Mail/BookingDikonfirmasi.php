<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PsUnit;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingDikonfirmasi extends Mailable
{
    use Queueable, SerializesModels;

    public PsUnit $unit;

    public ?Payment $payment;

    public function __construct(
        public Booking $booking,
        public User $penyewa,
    ) {
        $unit = PsUnit::whereIn('_id', Booking::bentukId($booking->ps_unit_id))->first();
        if (! $unit) {
            $unit = new PsUnit();
            $unit->name = 'Unit PS';
            $unit->type = '';
        }
        $this->unit = $unit;

        $this->payment = Payment::whereIn('booking_id', Booking::bentukId($booking->_id))->first();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Kamu Sudah Dikonfirmasi - Save Point PlayStation',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-dikonfirmasi',
        );
    }
}
