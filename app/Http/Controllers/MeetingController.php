<?php

namespace App\Http\Controllers;

use App\Http\Requests\AllRequiredRequest;
use App\Models\Attendee;
use App\Models\Meeting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\GoogleCalendar\Event;
use Spatie\GoogleCalendar\GoogleCalendarFactory;

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
        try {
            DB::commit();

            $request->request->add(['created_by'=>Auth::id()]);

            $event = new Event;
            $event->name = $request->subject;
            $event->startDateTime = Carbon::parse($request->start_time);
            $event->endDateTime = Carbon::parse($request->end_time);
            $event->addAttendee([
                'email' => Auth::user()->email,
                'name' => Auth::user()->name,
            ]);
            $event->addAttendee([
//                'email' => User::find($request->recipient_email,['name'])->name,
                'email' => 'misterkamran93@gmail.com',
                'name' => User::find($request->recipient_email, ['email'])->email,
            ]);
            $event->addMeetLink();// optionally add a google meet link to the event

            $googleCalendar = GoogleCalendarFactory::createForCalendarId('e95d7837dc715960d86d0a3a8193ad7ed2f2db4de55cf5bab8e5ff5550dbab80@group.calendar.google.com');

            $event->save();

            $request->request->add(['event_id'=>$event->id]);
            
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
        } catch (\Exception $e) {
            DB::rollBack();
            session()->forget('addMeeting');
            return redirect()->back()->with('success',json_decode($e->getMessage())->error->message);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'meeting' => Meeting::findOrFail($id),
            'attendees' => Attendee::where('meeting_id', $id)->get()
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->json([
            'meeting' => Meeting::findOrFail($id),
            'attendees' => Attendee::where('meeting_id', $id)->get()
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AllRequiredRequest $request, string $id)
    {

        try {
            DB::commit();
            $meeting = Meeting::updateOrCreate(
                ['id' => $id],
                $request->only(app(Meeting::class)->getFillable()));

            if(empty($meeting->event_id)){
                $event = Event::find($meeting->event_id);
                $event->name = $request->subject;
                $event->startDateTime = Carbon::parse($request->start_time);
                $event->endDateTime = Carbon::parse($request->end_time);
                $googleCalendar = GoogleCalendarFactory::createForCalendarId('e95d7837dc715960d86d0a3a8193ad7ed2f2db4de55cf5bab8e5ff5550dbab80@group.calendar.google.com');
                $event->save();
            }

            session()->forget('updateMeeting');
            return redirect()->back()->with('success', 'Meeting Update Successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->forget('addMeeting');
            return redirect()->back()->with('success',json_decode($e->getMessage())->error->message);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::commit();
            $meeting = Meeting::find($id);
            if(empty($meeting->event_id)){
                $event = Event::find($meeting->event_id);
                $googleCalendar = GoogleCalendarFactory::createForCalendarId('e95d7837dc715960d86d0a3a8193ad7ed2f2db4de55cf5bab8e5ff5550dbab80@group.calendar.google.com');
                $event->delete();
            }
            Attendee::where('meeting_id', $id)->delete();
            $meeting->delete();



            return redirect()->back()->with('success', 'Meeting Deleted Successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->forget('addMeeting');
            return redirect()->back()->with('success',json_decode($e->getMessage())->error->message);
        }
    }
}
