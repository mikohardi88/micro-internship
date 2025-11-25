<?php

namespace App\Notifications;

use App\Models\Placement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PlacementStatusUpdatedNotification extends Notification
{
    use Queueable;

    protected Placement $placement;
    protected string $oldStatus;
    protected string $newStatus;

    public function __construct(Placement $placement, string $oldStatus, string $newStatus)
    {
        $this->placement = $placement;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $statusMessages = [
            'matched' => 'Anda telah cocok dengan proyek magang',
            'in_progress' => 'Proyek magang Anda sedang berlangsung',
            'completed' => 'Selamat! Proyek magang Anda telah selesai',
            'terminated' => 'Proyek magang Anda telah dihentikan',
        ];

        $message = $statusMessages[$this->newStatus] ?? 'Status penempatan Anda telah diperbarui';

        return (new MailMessage)
            ->subject('📋 Update Status Penempatan Magang')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line($message)
            ->line('**Proyek:** ' . $this->placement->project->title)
            ->line('**Perusahaan:** ' . $this->placement->project->company->name)
            ->line('**Status Baru:** ' . ucfirst(str_replace('_', ' ', $this->newStatus)))
            ->action('Lihat Detail Penempatan', route('student.placements.show', $this->placement))
            ->line('Login ke sistem untuk melihat detail lengkap.');
    }

    public function toArray($notifiable): array
    {
        return [
            'placement_id' => $this->placement->id,
            'project_id' => $this->placement->project_id,
            'project_title' => $this->placement->project->title,
            'company_name' => $this->placement->project->company->name,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => 'Status penempatan Anda diperbarui menjadi: ' . ucfirst(str_replace('_', ' ', $this->newStatus)),
            'type' => 'placement_status_updated',
        ];
    }
}
