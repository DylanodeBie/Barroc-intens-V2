<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;

class MaintenanceReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'issue_description',
        'used_parts',
        'follow_up_notes',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}


class MaintenanceReportObserver
{
    public function created(MaintenanceReport $report)
    {
        if ($report->used_parts) {
            $usedParts = json_decode($report->used_parts, true);

            foreach ($usedParts as $partId => $quantity) {
                $part = Part::find($partId);
                if ($part) {
                    $part->decrement('stock', $quantity);

                    if ($part->stock < 10) {
                        Notification::create([
                            'message' => "Onderdeel ID {$partId} is bijna op voorraad.",
                        ]);
                    }
                }

                Notification::create([
                    'message' => "Onderdeel ID {$partId} is gebruikt.",
                ]);
            }
        }
    }
}
