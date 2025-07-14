@extends('dashboard')

@section('content')
    <div class="container">
        <h4 class="mb-4 text-dark">
            <i class="bi bi-tools me-2 text-dark"></i>Admin Activity Log
        </h4>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0 enquiry-table-wrapper">
                <table class="table table-bordered table-hover mb-0 align-middle text-center">
                    <thead class="table-primary text-dark">
                        <tr>
                            <th>SN</th>
                            <th>Admin Name</th>
                            <th>Activity</th>
                            <th>Description</th>
                            <th>Date/Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $index => $activity)
                            <tr>
                                <td>{{ $activities->firstItem() + $index }}</td>
                                <td>{{ $activity->user->name }}</td>
                                <td>{{ $activity->activity_type }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->created_at->format('d M Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3">No admin activities yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- pagination --}}
        @include('components.shared-pagination', ['paginator' => $activities])
    </div> 
@endsection
