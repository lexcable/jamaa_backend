@extends('layouts.app')
@section('title','Teams & Tasks')
@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow space-y-4">
  <h1 class="text-2xl font-bold">Teams & Tasks</h1>
  <table class="w-full table-auto">
    <thead class="bg-gray-100"><tr><th>Team</th><th>Tasks</th><th>Actions</th></tr></thead>
    <tbody>
      @foreach($teams as $t)
      <tr class="hover:bg-gray-50"><td class="p-2">{{ $t->name }}</td><td class="p-2">{{ $t->tasks_count }}</td><td class="p-2"><a href="{{ route('teams.show',$t) }}" class="text-blue-600">View</a></td></tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection