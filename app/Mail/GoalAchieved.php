<?php

namespace App\Mail;

use App\Models\FinancialGoal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GoalAchieved extends Mailable
{
    use Queueable, SerializesModels;

    public $goal;

    /**
     * Create a new message instance.
     */
    public function __construct(FinancialGoal $goal)
    {
        $this->goal = $goal;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat! Target Impianmu Tercapai! 🎯',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.goal-achieved',
            // Kita kirim data secara eksplisit disini
            with: [
                'goal' => $this->goal,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}