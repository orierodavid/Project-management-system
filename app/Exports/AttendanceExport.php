<?php

namespace App\Exports;

use App\Models\AttendanceRecord;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private readonly Collection $records) {}

    public function collection(): Collection
    {
        return $this->records;
    }

    public function headings(): array
    {
        return [
            'Employee',
            'Email',
            'Branch',
            'Clock In',
            'Clock In Latitude',
            'Clock In Longitude',
            'Clock In Accuracy (m)',
            'Clock In Distance (m)',
            'Clock Out',
            'Clock Out Latitude',
            'Clock Out Longitude',
            'Clock Out Accuracy (m)',
            'Clock Out Distance (m)',
            'Status',
            'Late Minutes',
        ];
    }

    public function map($record): array
    {
        /** @var AttendanceRecord $record */
        return [
            $record->user?->name,
            $record->user?->email,
            $record->branch?->name,
            $record->clock_in_at?->toDateTimeString(),
            $record->clock_in_lat,
            $record->clock_in_lng,
            $record->clock_in_accuracy,
            $record->clock_in_distance_meters,
            $record->clock_out_at?->toDateTimeString(),
            $record->clock_out_lat,
            $record->clock_out_lng,
            $record->clock_out_accuracy,
            $record->clock_out_distance_meters,
            $record->status,
            $record->late_minutes,
        ];
    }
}
