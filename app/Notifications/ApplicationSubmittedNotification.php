<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ProjectApplication;

class ApplicationSubmittedNotification extends Notification
{
    use Queueable;

    protected $application;

    /**
     * Create a new notification instance.
     */
    public function __construct(ProjectApplication $application)
    {
        $this->application = $application;
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
            'title' => 'Lamaran Baru',
            'message' => 'Anda memiliki lamaran baru untuk proyek "' . $this->application->project->title . '" dari ' . $this->application->user->name,
            'url' => route('company.projects.applications.index', $this->application->project),
            'project_id' => $this->application->project->id,
            'application_id' => $this->application->id,
            'applicant_name' => $this->application->user->name,
        ];
    }
}
