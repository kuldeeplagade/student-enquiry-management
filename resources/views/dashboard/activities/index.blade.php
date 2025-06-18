@extends('dashboard')

@section('content')
    <div class="container">
        <h4 class="mb-4">🛠️ Admin Activity Log</h4>
        <table class="table table-bordered bg-white">
            <thead class="table-dark">
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
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $activity->user->name }}</td>
                        <td>{{ $activity->activity_type }}</td>
                        <td>{{ $activity->description }}</td>
                        <td>{{ $activity->created_at->format('d M Y h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No admin activities yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
