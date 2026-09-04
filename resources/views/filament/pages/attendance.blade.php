<x-filament-panels::page>
    <div x-data="attendancePage()" x-init="loadStatus()" class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Today's attendance</p>
                    <h2 class="mt-1 text-2xl font-semibold text-gray-950 dark:text-white" x-text="clockedIn ? 'You are clocked in' : 'You are not clocked in'"></h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300" x-text="message"></p>
                </div>
                <div class="flex gap-3">
                    <button type="button" @click="submit('clock-in')" :disabled="busy || clockedIn" class="rounded-xl bg-primary-600 px-5 py-3 text-sm font-semibold text-white shadow-sm disabled:cursor-not-allowed disabled:opacity-50">
                        <span x-text="busy && action === 'clock-in' ? 'Locating…' : 'Clock in'"></span>
                    </button>
                    <button type="button" @click="submit('clock-out')" :disabled="busy || !clockedIn" class="rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-900 shadow-sm disabled:cursor-not-allowed disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        <span x-text="busy && action === 'clock-out' ? 'Locating…' : 'Clock out'"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900" x-show="attendance" x-cloak>
            <div class="grid gap-4 sm:grid-cols-3">
                <div><p class="text-xs uppercase tracking-wide text-gray-500">Branch</p><p class="mt-1 font-medium" x-text="attendance?.branch?.name || '—'"></p></div>
                <div><p class="text-xs uppercase tracking-wide text-gray-500">Clocked in</p><p class="mt-1 font-medium" x-text="formatDate(attendance?.clock_in_at)"></p></div>
                <div><p class="text-xs uppercase tracking-wide text-gray-500">Status</p><p class="mt-1 font-medium capitalize" x-text="attendance?.status?.replace('_', ' ') || '—'"></p></div>
            </div>
        </div>

        <div x-show="error" x-cloak class="rounded-xl border border-danger-200 bg-danger-50 p-4 text-sm text-danger-700" x-text="error"></div>
    </div>

    <script>
        function attendancePage() {
            return {
                busy: false,
                action: null,
                clockedIn: false,
                attendance: null,
                message: 'Location is required for secure attendance verification.',
                error: null,
                async loadStatus() {
                    const response = await fetch('{{ route('attendance.status') }}', { headers: { 'Accept': 'application/json' } });
                    if (response.ok) {
                        const data = await response.json();
                        this.clockedIn = data.clocked_in;
                        this.attendance = data.attendance;
                    }
                },
                async submit(action) {
                    this.busy = true;
                    this.action = action;
                    this.error = null;
                    if (!navigator.geolocation) {
                        this.error = 'Your browser does not support location services.';
                        this.busy = false;
                        return;
                    }
                    navigator.geolocation.getCurrentPosition(
                        position => this.send(action, position),
                        error => {
                            this.error = error.code === 1 ? 'Location permission was denied.' : 'Unable to determine your location. Please try again.';
                            this.busy = false;
                        },
                        { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                    );
                },
                async send(action, position) {
                    const response = await fetch(`/attendance/${action}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude,
                            accuracy: position.coords.accuracy
                        })
                    });
                    const data = await response.json().catch(() => ({}));
                    if (!response.ok) {
                        this.error = data.message || 'Attendance action failed.';
                    } else {
                        this.message = data.message;
                        await this.loadStatus();
                    }
                    this.busy = false;
                    this.action = null;
                },
                formatDate(value) {
                    return value ? new Date(value).toLocaleString() : '—';
                }
            }
        }
    </script>
</x-filament-panels::page>
