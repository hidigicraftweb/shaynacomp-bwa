<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\OurTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OurTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = OurTeam::orderByDesc('id')->paginate(10);
        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        // Closure-based transaction
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $validated['avatar'] = $avatarPath;
            }

            $newDataRecord = OurTeam::create($validated);
        });

        return redirect()->route('admin.teams.index')->with('success', 'Team member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OurTeam $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OurTeam $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, OurTeam $team)
    {
        // Closure-based transaction
        DB::transaction(function () use ($request, $team) {
            $validated = $request->validated();
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $validated['avatar'] = $avatarPath;
     }

            $team->update($validated);
        });

        return redirect()->route('admin.teams.index')->with('success', 'Team member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OurTeam $team)
    {
        // Closure-based transaction
        DB::transaction(function () use ($team) {
            $team->delete();
        });

        return redirect()->route('admin.teams.index')->with('success', 'Team member deleted successfully.');
    }
}
