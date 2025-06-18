<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminActivity;

class AdminActivityController extends Controller
{
    public function index()
    {
        $activities = AdminActivity::with('user')->latest()->get();

        return view('dashboard.activities.index', compact('activities'));
    }
}
