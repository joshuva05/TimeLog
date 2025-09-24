<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTimeLogRequest;
use App\Http\Requests\UpdateTimeLogRequest;
use App\Models\Project;
use App\Models\Leave;

class TimeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('time_logs.index', ['timeLogs' => TimeLog::with('project')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('time_logs.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimeLogRequest $request)
    {
        $request->validated();
        $leave = Leave::where('user_id',auth()->id())
                ->whereDate('start_date','<=',$request->date)
                ->whereDate('end_date','>=',$request->date)
                ->exists();

        if ($leave) {
            return back()->withErrors(['date'=>'Leave already applied for this date.']);
        }

        $totalTime = '00:00';
        $previousLogTime = '00:00';
        $previousLogs = TimeLog::where('user_id', auth()->id())
                        ->where('date', $request->date)
                        ->get();
        foreach ($previousLogs as $log) {
            $previousLogTime = date('H:i', strtotime($previousLogTime) + strtotime($log->hours_spent) - strtotime('00:00'));
        }
        foreach ($request->hours_spent as $time) {
            $totalTime = date('H:i', strtotime($totalTime) + strtotime($time) - strtotime('00:00'));
        }
        $totalTime = date('H:i', strtotime($totalTime) + strtotime($previousLogTime) - strtotime('00:00'));

        if ( strtotime($totalTime) > strtotime("10:00")) {
            return back()->withErrors(['hours_spent'=>'Total hours spent cannot exceed 10 hours per day.']);
        }

        for ($i = 0; $i < count($request->hours_spent); $i++) {
            TimeLog::create([
                'user_id' => auth()->id(),
                'project_id' => $request->project_id,
                'date' => $request->date,
                'hours_spent' => $request->hours_spent[$i],
                'task_description' => $request->task_description[$i],
            ]);
        }

        return redirect()->route('time-logs.index')->with('success', 'Time log created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TimeLog $timeLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeLog $timeLog)
    {
        return view('time_logs.edit', compact('timeLog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimeLog $timeLog)
    {
        $timeLog->update($request->validated());
        return redirect()->route('time-logs.index')->with('success', 'Time log updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimeLog $timeLog)
    {
        $timeLog->delete();
        return redirect()->route('time-logs.index')->with('success', 'Time log deleted successfully.');
    }
}
