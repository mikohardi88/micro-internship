<?php

namespace App\Notifications;

use App\Models\Placement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PlacementCreatedNotification extends Notification
{
    use Queueable;

    protected Placement $placement;

    public function __construct(Placement $placement)
    {
        $this->placement = $placement;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🎉 Selamat! Anda Ditempatkan di Proyek Magang')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Kami senang menginformasikan bahwa Anda telah ditempatkan di proyek magang berikut:')
            ->line('**Proyek:** ' . $this->placement->project->title)
            ->line('**Perusahaan:** ' . $this->placement->project->company->name)
            ->line('**Tanggal Mulai:** ' . ($this->placement->start_date ? $this->placement->start_date->format('d M Y') : 'Tanggal belum ditentukan'))
            ->line('**Tanggal Selesai:** ' . ($this->placement->end_date ? $this->placement->end_date->format('d M Y') : 'Tanggal belum ditentukan'))
            ->line('**Pembimbing:** ' . $this->placement->supervisor_name)
            ->action('Lihat Detail Penempatan', route('student.placements.show', $this->placement))
            ->line('Silakan login ke sistem untuk melihat detail lengkap dan tugas yang harus dikerjakan.')
            ->line('Terima kasih telah berpartisipasi dalam program magang kami!');
    }

    public function toArray($notifiable): array
    {
        return [
            'placement_id' => $this->placement->id,
            'project_id' => $this->placement->project_id,
            'project_title' => $this->placement->project->title,
            'company_name' => $this->placement->project->company->name,
            'start_date' => $this->placement->start_date ? $this->placement->start_date->format('Y-m-d') : null,
            'end_date' => $this->placement->end_date ? $this->placement->end_date->format('Y-m-d') : null,
            'message' => 'Anda telah ditempatkan di proyek magang: ' . $this->placement->project->title,
            'type' => 'placement_created',
        ];
    }
}
