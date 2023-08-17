<?php

namespace App\Http\Controllers;

use App\Http\Requests\AllRequiredRequest;
use App\Models\Attendee;
use App\Models\Meeting;
use App\Models\User;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AllRequiredRequest $request)
    {
        $event = new Event;
        $event->name = $request->subject;
        $event->startDateTime = Carbon::parse($request->start_time);
        $event->endDateTime = Carbon::parse($request->end_time);
        $event->addAttendee([
            'email' => Auth::user()->email,
            'name' => Auth::user()->name,
        ]);
        $event->addAttendee([
            'email' => User::find($request->recipient_email,['name'])->name,
            'name' => User::find($request->recipient_email,['email'])->email,
        ]);
        $event->addMeetLink();// optionally add a google meet link to the event
//        $event->save();
dd($request->all(),$event,Event::get());
        $meeting = Meeting::create($request->only(app(Meeting::class)->getFillable()));

        Attendee::create([
            'user_id' => Auth::id(),
            'meeting_id' => $meeting->id,
        ], [
            'user_id' => $request->recipient_email,
            'meeting_id' => $meeting->id,
        ]);

        session()->forget('addMeeting');
        return redirect()->back()->with('success', 'Meeting Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'meeting'=>Meeting::findOrFail($id),
            'attendees'=>Attendee::where('meeting_id',$id)->get()
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->json([
            'meeting'=>Meeting::findOrFail($id),
            'attendees'=>Attendee::where('meeting_id',$id)->get()
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AllRequiredRequest $request, string $id)
    {

        Meeting::updateOrCreate(
            ['id'=>$id],
            $request->only(app(Meeting::class)->getFillable()));

        session()->forget('updateMeeting');
        return redirect()->back()->with('success', 'Meeting Update Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Attendee::where('meeting_id',$id)->delete();
        Meeting::destroy($id);
        return redirect()->back()->with('success','Meeting Deleted Successfully.');
    }
}
