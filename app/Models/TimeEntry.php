<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model {

    protected $fillable=['task_id','check_in','check_out'];
    
    public function task() { return $this->belongsTo(Task::class); }
    public function getHoursWorkedAttribute() {
        return \Carbon\Carbon::parse($this->check_in)
            ->diffInHours(\Carbon\Carbon::parse($this->check_out));
    }
}