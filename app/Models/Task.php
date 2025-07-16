<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

    protected $fillable=['team_id','title','description','assignee','deadline','status'];

    public function team() { return $this->belongsTo(Team::class); }
    public function timeEntries() { return $this->hasMany(TimeEntry::class); }
}