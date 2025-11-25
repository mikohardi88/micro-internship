<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ProjectApplication;

class ApplicationDecisionNotification extends Notification
{
    use Queueable;

    protected $application;
    protected $decision;

    /**
     * Create a new notification instance.
     */
    public function __construct(ProjectApplication $application, string $decision)
    {
        $this->application = $application;
        $this->decision = $decision;
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
        $title = $this->decision === 'accepted' ? 'Lamaran Diterima' : 'Lamaran Ditolak';
        $message = $this->decision === 'accepted'
            ? 'Lamaran Anda untuk proyek "' . $this->application->project->title . '" telah diterima.'
            : 'Lamaran Anda untuk proyek "' . $this->application->project->title . '" telah ditolak.';

        return [
            'title' => $title,
            'message' => $message,
            'url' => $this->decision === 'accepted'
                ? route('student.placements.index')
                : route('student.applications.index'),
            'project_id' => $this->application->project->id,
            'application_id' => $this->application->id,
            'decision' => $this->decision,
        ];
    }
}
