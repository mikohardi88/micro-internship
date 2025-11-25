<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Deliverable;

class DeliverableVerifiedNotification extends Notification
{
    use Queueable;

    protected $deliverable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Deliverable $deliverable)
    {
        $this->deliverable = $deliverable;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Deliverable Terverifikasi',
            'message' => 'Deliverable Anda "' . $this->deliverable->title . '" untuk proyek "' . $this->deliverable->placement->project->title . '" telah diverifikasi.',
            'url' => route('student.certificates.index'),
            'project_id' => $this->deliverable->placement->project->id,
            'deliverable_id' => $this->deliverable->id,
            'certificate_generated' => true,
        ];
    }
}
