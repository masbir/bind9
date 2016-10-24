<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\DNSView;

class DNSViewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
    	$dnsviews = DNSView::with("ips", "domains")->orderBy("created_at")->where("user_id", $request->user()->id)->paginate(20);
    	return view("dnsview.index", compact('dnsviews'));
    }

    public function view(Request $request, $id)
    {
    	$dnsview = DNSView::where("user_id", $request->user()->id)->findOrFail($id);
    	return view("dnsview.view", compact('dnsview'));
    }
}
