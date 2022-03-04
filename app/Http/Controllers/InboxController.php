<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inbox;
use Auth;
use Session;
use DataTables;

class InboxController extends Controller
{
    public function index()
    {
        return view('inbox.index');
    }
}
