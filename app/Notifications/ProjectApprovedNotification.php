<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Project;

class ProjectApprovedNotification extends Notification
{
    use Queueable;

    protected $project;

    /**
     * Create a new notification instance.
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
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
            'title' => 'Proyek Disetujui',
            'message' => 'Proyek "' . $this->project->title . '" telah disetujui oleh admin dan siap untuk dibuka.',
            'url' => route('admin.projects.publish', $this->project),
            'project_id' => $this->project->id,
            'status' => $this->project->status,
        ];
    }
}
