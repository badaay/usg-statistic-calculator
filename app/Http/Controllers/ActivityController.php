<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $users = collect(User::all())->pluck('email');
        $activity = collect(Activity::get()->toArray());
        $usageStats = [];
        foreach ($users as $email) {
            $filtered = $activity->filter(function ($item) use ($email) {
                return $item['email'] === $email;
            })
            ->sortBy('createdAt')
            ->map(function ($item) {
                $data['email'] = $item['email'];

                $date = new DateTime($item['createdAt']);
                if ($item['type']=='login') {
                    $data['login'] = $date->format("Y-m-d h:i:s");
                }
                if ($item['type']=='logout') {
                    $data['logout'] = $date->format("Y-m-d h:i:s");
                }
                $data['date'] = $date->format("Y-m-d");
                return $data;
            });

            $login = '';
            $logout= '';
            $accumulateDay = 0;
            foreach ($filtered as $value) {
                if (isset($value['login']) && empty($login)) {
                    $login = $value['login'];
                }
                if (isset($value['logout']) && empty($logout)) {
                    $logout = $value['logout'];
                }

                $time = 0;
                if ($login && $logout) {
                    $time = (strtotime($logout) - strtotime($login)) / 60;
                    $logout = '';
                    $login = '';
                }

                if ($time) {
                    if ($time < 3600) {
                        $accumulateDay += $time;
                    }
                }
            }
            $usageStats[] = round($accumulateDay);
            dump($usageStats);
        }
        // $activity = $activity
        // ->map(function ($item) use ($users) {
        //     // if( in_array($item['email'], $users)){

        //     // }
        //     return [
        //         'email' => $item['email']
        //     ];
        // });
        $activity = $usageStats;
        return view('welcome', compact('activity', 'users'));
    }

    public function graph()
    {
        $graph = [];
        $activity = collect(Activity::all());


        return $graph;
    }
}
