<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;


class User extends Authenticatable
{
    protected $fillable = ['full_name','roll_no', 'email', 'password', 'gender', 'department_id','section_id','year_id'];
    function events(){
        return $this->morphToMany('\App\Event', 'registration');
    }
    function confirmation(){
        return $this->hasOne('App\Confirmation');
    }
    function roles(){
        return $this->belongsToMany('App\Role');
    }
    function rejections(){
        return $this->hasMany('App\Rejection');
    }
    function organizings(){
        return $this->belongsToMany('App\Event', 'organizings');
    }
    function prizes(){
        return $this->hasMany('App\Prize');
    }
    // Get all the users to be paid by the user eliminating duplicates

    // Check if the user is organizing an event
    function isOrganizing($event_id){
        if($this->organizings()->find($event_id)){
            return true;
        }
    }
    // Find the team a user has registered for an event
    function teamLeaderFor($event_id){
        $event = Event::find($event_id);
        return $event->teams->where('user_id', $this->id)->first();
    }
    // find the team for which the user has been selected as team member
    function teamMemberFor($event_id){
        $event = Event::find($event_id);
        foreach($event->teams as $team){
            if($team->teamMembers->where('user_id', $this->id)->count()){
                return $team;
            }
        }
    }
    function teamEvents(){
        $events = [];
        //  Add events in which the user is team leader
        foreach($this->teams as $team){
            array_push($events, $team->events()->first());
        }
        //  Add events in which the user is a team member        
        foreach($this->teamMembers as $teamMember){
            array_push($events, $teamMember->team->events()->first());
        }
        // Return as collections
        return collect($events);
    }
    function hasRegisteredEvent($event_id){
        $event = Event::find($event_id);
        if($event->isGroupEvent()){
            foreach($this->teams as $team){
                if($team->hasRegisteredEvent($event_id)){
                    return true;
                }
            }  
            if($this->isTeamMember($event_id)){
                return true;
            }
        }
        else{
             if($this->events()->find($event_id)){
                 return true;
             }
             else{
                 return false;
             }
        }
        return false;
    }
    function department(){
        // Get the college of the student
        return $this->belongsTo('App\Deparment');
    }
    function section(){
        // Get the college of the student
        return $this->belongsTo('App\Section');
    }
    function year(){
        // Get the college of the student
        return $this->belongsTo('App\Year');
    }
    function teams(){
        return $this->hasMany('App\Team');
    }
    function teamMembers(){
        return $this->hasMany('App\TeamMember');
    }
    function hasConfirmed(){
        if($this->confirmation == null){
            return false;
        }
        else{
            return true;
        }
    }
    function hasUploadedTicket(){
        if($this->hasConfirmed()){
            if(!empty($this->confirmation->file_name)){
                return true;
            }
        }
        return false;
    }
    function needApproval(){
        $teamCount = $this->teams->count();
        $teamMembersCount = $this->teamMembers->count();
        // Need approval if the user is not a team leader and does not belong to any team
        if($teamCount || !$teamMembersCount){
            return true;
        }
        else{
            return false;
        }
    }
    function isTeamMember($event_id){
        return $this->teamEvents()->where('id', $event_id)->count();
    }
    function isTeamLeader($event_id){
        $event = Event::find($event_id);
        if($event->teams()->where('user_id', $this->id)->count()){
            return true;
        }
        else{
            return false;
        }
    }
    function isParticipating(){
        if($this->events()->count() == 0 && $this->teams()->count() == 0 && $this->teamMembers()->count() == 0){
            return false;
        }
        else{
            return true;
        }
    }
    function hasConfirmedTeams(){
        foreach($this->teams as $team){
            if(!$team->isConfirmed()){
                return false;
            }
        }
        return true;
    }
    function canConfirm(){
        if($this->isParticipating()){
            if($this->hasSureEvents()){
                return true;
            }
            else{
                return false;                
            }
        }
        else{
            return false;
        }
    }
    function hasTeams(){
        $teamCount = $this->teams->count();  
        return $teamCount; 
    }
    function isAcknowledged(){
        if($this->hasConfirmed()){
            if($this->confirmation->status){
                return true;
            }
        }
        return false;
    }
    function isConfirmed(){
        if($this->needApproval()){
            if($this->hasConfirmed() && $this->confirmation->status == 'ack'){
                return true;                
            }
        }
        else{
            foreach($this->teamMembers as $teamMember){
                if($teamMember->team->user->isConfirmed()){
                    return true;
                }
            }
        }
        return false;
    }
    function hasRole($role_name){
        if($this->roles()->where('role_name', $role_name)->count()){
            return true;
        }
        return false;
   }
       function F18Id(){
        return "F'18" . $this->id;
    }
    function hasActivated(){
        if($this->activated == true){
            return true;
        }
        else{
            return false;
        }
    }
    function isRejected(){
        if($this->confirmation && $this->confirmation->status == 'nack'){
            return true;
        }
        return false;
    }
    function hasOnlyTeamEvents(){
        if($this->events()->count() == 0 && $this->teams()->count() == 0 && $this->teamMembers()->count() != 0){
            return true;
        }
        else{
            return false;
        }
    }
    function hasSureEvents(){
        if($this->events()->count() == 0 && $this->teams()->count() == 0 && $this->teamMembers()->count() != 0){
            foreach($this->teamMembers as $teamMember){
                if($teamMember->team->user->hasConfirmed()){
                    return true;
                }
            }
            return false;
        }
        else{
            return true;
        }
    }
    static function search($term){
        $college_ids = College::where('name', 'LIKE', $term)->pluck('id')->toArray();        
        $users = self::where('id', 'LIKE', $term)->orWhere('full_name', 'LIKE', $term)->orWhere('email', 'LIKE', $term)->orWhere('gender', 'LIKE', $term)->orWhere('mobile', 'LIKE', $term)->orWhereIn('college_id', $college_ids);  

        return $users;
    }
    function hasEvent()
    {
        $events=Event::all()->where('max_members',1);
        foreach($events as $event)
        {
            if($user->event)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}
