<div>
    <!-- Main container for the component, provides overall padding and centering -->
    <div class="container my-5">
      

        <!-- Rain Data Display Section Card -->
        <div class="card shadow-lg rounded-4 border-0">
            <div class="card-body p-4 p-md-5">
                <h2 class="card-title text-center mb-4 fs-3 fw-bold text-success">
                    <i class="bi bi-cloud-rain-fill me-2"></i> Rain Records
                </h2>
                                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6">
                        <label for="startDate" class="form-label fw-semibold">Start Date</label>
                        <!-- Input for start date, bound to $startDate property via wire:model.live -->
                        <input type="date" id="startDate" wire:model.live="startDate"
                               class="form-control form-control-lg rounded-3 shadow-sm @error('startDate') is-invalid @enderror">
                        <!-- Display validation error for startDate, if any -->
                        @error('startDate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="endDate" class="form-label fw-semibold">End Date</label>
                        <!-- Input for end date, bound to $endDate property via wire:model.live -->
                        <input type="date" id="endDate" wire:model.live="endDate"
                               class="form-control form-control-lg rounded-3 shadow-sm @error('endDate') is-invalid @enderror">
                        <!-- Display validation error for endDate, if any -->
                        @error('endDate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mb-3">
                    <!-- Button to apply the date filter -->
                    <button wire:click="applyFilter"
                            class="btn btn-primary btn-lg rounded-pill shadow-sm px-5 py-2 animate-hover">
                        <i class="bi bi-calendar-check me-2"></i> Apply Filter
                    </button>
                    <!-- Button to reset the filter -->
                    <button wire:click="resetFilter"
                            class="btn btn-outline-secondary btn-lg rounded-pill shadow-sm px-5 py-2 animate-hover">
                        <i class="bi bi-arrow-counterclockwise me-2"></i> Reset Filter
                    </button>
                </div>

                @if ($rainData->isEmpty())
                    <!-- Bootstrap Alert for no data -->
                    <div class="alert alert-info text-center py-4 rounded-3" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i> No rain data available for the selected period.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered align-middle text-center rounded-3 overflow-hidden">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="py-3">Amount (mm)</th>
                                    <th scope="col" class="py-3">Day</th>
                                    <th scope="col" class="py-3">Date</th>
                                    {{-- <th scope="col" class="py-3">Time</th> --}}
                                    <th scope="col" class="py-3">Device ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rainData as $data)
                                    <tr>
                                        <td><span class="badge bg-primary fs-6">{{ $data->amount }}</span></td>
                                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('l') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('F j, Y') }}</td>
                                        {{-- <td>{{ \Carbon\Carbon::parse($data->created_at)->format('h:i A') }}</td> --}}
                                        <td><span class="text-muted">{{ $data->device_id ?? 'N/A' }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Custom CSS for subtle animations and improved aesthetics -->
    <style>
        .animate-hover {
            transition: transform 0.2s ease-in-out, background-color 0.2s ease-in-out, border-color 0.2s ease-in-out;
        }
        .animate-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.03); /* Light stripe for better readability */
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075); /* Darker hover effect */
        }
        .card {
            border-radius: 1.25rem !important; /* More rounded corners for cards */
        }
    </style>
</div>
