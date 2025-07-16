<?php

namespace App\Http\Controllers;

use App\Models\Team;

class TeamController extends Controller {
    public function index() {
        $teams=Team::withCount('tasks')->get();
        return view('admin.teams',compact('teams'));
    }

    public function show(Team $team) {
        $team->load('tasks.timeEntries');
        return view('teams.show',compact('team'));
    }
}