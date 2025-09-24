<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLeaveRequest;
use App\Http\Requests\UpdateLeaveRequest;
use App\Models\TimeLog;


class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('leaves.index', ['leaves' => Leave::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leaves.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeaveRequest $request)
    {
        $request->validated();
        $request->merge(['user_id' => auth()->id()]);

        $hasWorkLogs = TimeLog::where('user_id',auth()->id())
                        ->whereBetween('date',[$request->start_date,$request->end_date])
                        ->exists();
        if ($hasWorkLogs) {
            return back()->withErrors(['start_date'=>'Work log already submitted for these dates.']);
        }

        Leave::create($request->all());
        return redirect()->route('leaves.index')->with('success', 'Leave created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($leave)
    {
        $leave = Leave::find($leave);
        return view('leaves.edit', compact('leave'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeaveRequest $request, $leave)
    {
        $leave = Leave::find($leave);
        $leave->update($request->validated());
        return redirect()->route('leaves.index')->with('success', 'Leave updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($leave)
    {
        $leave = Leave::find($leave);
        $leave->delete();
        return redirect()->route('leaves.index')->with('success', 'Leave deleted successfully.');
    }
}
