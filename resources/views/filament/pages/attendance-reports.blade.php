<x-filament-panels::page>
    <div class="space-y-6">
        <form wire:submit="export" class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            {{ $this->form }}
            <div class="mt-6 flex justify-end">
                <x-filament::button type="submit" icon="heroicon-o-arrow-down-tray">
                    Export Excel
                </x-filament::button>
            </div>
        </form>

        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 dark:bg-white/5">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Employee</th>
                            <th class="px-4 py-3 font-semibold">Branch</th>
                            <th class="px-4 py-3 font-semibold">Clock in</th>
                            <th class="px-4 py-3 font-semibold">Clock out</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold">Late</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                        @forelse ($this->getRecords() as $record)
                            <tr>
                                <td class="px-4 py-3">{{ $record->user?->name ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $record->branch?->name ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $record->clock_in_at?->format('d M Y, H:i') ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $record->clock_out_at?->format('d M Y, H:i') ?? 'Open' }}</td>
                                <td class="px-4 py-3">{{ ucfirst($record->status) }}</td>
                                <td class="px-4 py-3">{{ $record->late_minutes ? $record->late_minutes . ' min' : '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">No attendance records match the selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>
