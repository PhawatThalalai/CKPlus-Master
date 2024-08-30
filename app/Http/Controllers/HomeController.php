<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\api\sendNotificationApp;
use App\Services\ClicknextApiService;

use ConnectCredo;


class HomeController extends Controller
{
    protected $clicknextApiService;

    public function index(Request $request)
    {
        if (isset($request->page)) {
            session()->put('h_page', $request->page);
        }

        $page = $request->page;
        if (session()->get('h_page') == 'backend') {
            return view('home-backend', compact('page'));
        } else {
            return view('home-frontend', compact('page'));
        }
    }

    public function store(Request $request)
    {
        // Handle the request data
        // e.g., validate and save the data to the database

        // Return a response
        return response()->json(['message' => 'Data saved successfully!']);
    }
}
