@extends('layouts.app')
@section('title','Team Details')
@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow space-y-6">
  <h1 class="text-2xl font-bold">{{ $team->name }} Tasks</h1>
  <h2 class="text-xl font-semibold">Task Assignment</h2>
  <table class="w-full table-auto mb-6"><thead class="bg-gray-100"><tr><th>Task</th><th>Assignee</th><th>Deadline</th><th>Status</th></tr></thead><tbody>
    @foreach($team->tasks as $task)
    <tr class="hover:bg-gray-50"><td>{{ $task->title }}</td><td>{{ $task->assignee }}</td><td>{{ $task->deadline }}</td><td>{{ str_replace('_',' ',$task->status) }}</td></tr>
    @endforeach
  </tbody></table>
  <h2 class="text-xl font-semibold">Time Tracking</h2>
  <table class="w-full table-auto"><thead class="bg-gray-100"><tr><th>Task</th><th>Check-In</th><th>Check-Out</th><th>Hours</th></tr></thead><tbody>
    @foreach($team->tasks as $task)
      @foreach($task->timeEntries as $entry)
      <tr class="hover:bg-gray-50"><td>{{ $task->title }}</td><td>{{ $entry->check_in }}</td><td>{{ $entry->check_out }}</td><td>{{ $entry->hours_worked }}</td></tr>
      @endforeach
    @endforeach
  </tbody></table>
</div>
@endsection