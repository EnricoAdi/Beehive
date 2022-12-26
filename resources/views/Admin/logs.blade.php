@extends('Admin.layout.masterapp')
@section('title', 'Logs Beehive')

@section('content')
    <h1 class="text-3xl ml-20 mt-5 font-semibold block">Admin Logs</h1>
    <div class="overflow-x-auto p-10 ml-10">

    <table class="table table-zebra w-full rounded-md">
        <!-- head -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>IP Address</th>
                <th>URL</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $l)
                <tr>
                    <th>{{ $l->ID }}</th>
                    <th>{{ $l->EMAIL }}</th>
                    <td>{{ $l->IP }}</td>
                    <td>{{ $l->URL }}</td>
                    <td>{{$l->STATUS_CODE}}</td>
                    <td>{{$l->created_at}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
        {{ $logs->links() }}
    </div>
@endsection
