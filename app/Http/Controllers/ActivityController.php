<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityController extends Controller
{

    public function index()
    {
        $users = collect(User::all())->pluck('email');
        $activity = collect(Activity::all());
        dd($activity);
        return view('welcome', compact('activity', 'users'));
    }

    public function graph()
    {
        $graph = [];
        $activity = collect(Activity::all());


        return $graph;
    }
}
