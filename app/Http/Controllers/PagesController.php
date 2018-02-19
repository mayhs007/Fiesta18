<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests\TeamRequest;
use App\Http\Requests\UploadTicketRequest;
use App\Team;
use App\Registration;
use App\TeamMember;
use App\User;
use App\Event;
use App\Confirmation;

use App\Rejection;
use Auth;
use Session;
use PDF;
use App\Traits\Utilities;
use Illuminate\Support\Facades\Input;

class PagesController extends Controller
{
    use Utilities;
    
    function root(){
        return view('pages.root');
    }
    function dashboard(){
        $events = Auth::user()->events;
        $user = Auth::user();
        $teamEvents = Auth::user()->teamEvents();        
        return view('pages.dashboard')->with('events', $events)->with('teamEvents', $teamEvents)->with('user', $user);
    }
    function help(){
        return view('pages.help');
    }
    function prizes(){
        $layout = Auth::check() && Auth::user()->type == 'admin' ? 'layouts.admin' : 'layouts.default';      
        $events = Event::all();
        return view('pages.prizes')->with('events', $events)->with('layout', $layout);
    }
    function offlineRegistration(){
        return view('pages.offline_registration');
    }
    function hospitality(){
        return view('pages.hospitality');
    }
    function about(){
        return view('pages.about');
    }
    function events(){
        $registeredTeam = null;
        if(Auth::check()){
            $events = Event::all()->reject(function($event, $key){          
                return Auth::user()->hasRegisteredEvent($event->id);
            });
        }
        else{
            $events = Event::all();                 
        }
        $page = Input::get('page', 1);
        $per_page = 10;
        $events = $this->paginate($page, $per_page, $events);
        return view('pages.events')->with('events', $events);
    }
    
    function register($id){
        $event = Event::find($id);
        $user = Auth::user();                                  
        $response = [];  
        $user->events()->save($event);
        $response['error'] = false;
        return response()->json($response);
    }
    function unregister($id){
        $event = Event::find($id);
        $user = Auth::user();
        $event->users()->detach($user->id);        
        return  redirect()->route('pages.dashboard');
    }
    function createTeam($event_id){
        $team = new Team();
        return view('teams.create')->with('team', $team);
    }
    function registerTeam(TeamRequest $request, $event_id){
        $event  = Event::find($event_id);              
        $inputs = Request::all();
        $team  = new Team($inputs);
        $team->user_id = Auth::user()->id;
        $team->save();
        $team_members_emails = explode(',', $inputs['team_members']);
        $team_members_users = User::all()->whereIn('email', $team_members_emails);
        foreach($team_members_users as $team_member_user){
            $team_member = new TeamMember();
            
            $team_member->team_id = $team->id;
            $team_member->user_id = $team_member_user->id;
            $team->teamMembers()->save($team_member);
        }
        $team->events()->save($event);
        Session::flash('success', 'Team registered and event added to dashboard!');
        return redirect()->route('pages.events');
    }
    function unregisterTeam($event_id, $id){
        $team = Team::find($id);
        $event  = Event::find($event_id);                         
        $event->teams()->detach($id);
        $team->teamMembers()->delete();
        Team::destroy($team->id);
        return  redirect()->route('pages.dashboard');
    }
    function getCollegeMates($user_id){
        $user  = User::find($user_id);
        $userEmails = User::where('id', '<>', $user->id)->where('type','student')->get(['email']);
        return response()->json($userEmails);
    }
    function confirm(){
        $confirmation = new Confirmation();
        Auth::user()->confirmation()->save($confirmation);
        return redirect()->route('pages.dashboard');
    }
    function downloadTicket(){
        $user = Auth::user();
        $pdf = PDF::loadView('pages.ticket', [ 'user' => $user]);
        return $pdf->download('ticket.pdf');
    }
    function uploadTicketImage(UploadTicketRequest $request){
        // Check if the student can upload ticket for approval
        if(!Auth::user()->needApproval()){
            Session::flash('success', 'Sorry! Your verification and payment will be done by one of your team leaders');
            return redirect()->route('pages.dashboard');            
        }
        $extension = $request->file('ticket')->getClientOriginalExtension();
        $filename = 'ticket_' . Auth::user()->id . '.' . $extension;
        $confirmation = Auth::user()->confirmation;
        $request->file('ticket')->move('uploads/tickets', $filename);
        $confirmation->file_name = $filename;
        $confirmation->save();
        Session::flash('success', 'Your ticket was uploaded');
        return redirect()->route('pages.dashboard');
    }
    
    function paymentReciept(){
        if(Auth::user()->hasPaid()){
            $user = Auth::user();
            $pdf = PDF::loadView('pages.payment.reciept', ['user' => $user]);
            return $pdf->download('payment-details.pdf');
        }
        else{
            Session::flash('success', 'You need to complete the payment first');
            return  redirect()->route('pages.dashboard');
        }
    }
}
