<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\DNSView;
use App\DNSIP;

class DNSIPsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create(Request $request, $view_id)
    { 
    	$dnsview = DNSView::where("user_id", $request->user()->id)->findOrFail($view_id);
    	
    	$dnsip = new DNSIP();
    	$dnsip->fill($request->all()); 
        $ips = \App\IPHelpers::cidrToRange($dnsip->ipstart . "/" . $dnsip->range); 
        $dnsip->ipend = $ips[1];
    	$dnsip->dnsview_id = $dnsview->id;
    	$dnsip->save();

        $dnsview->buildConfFile();
        $dnsview->uploadConfFile();

    	return redirect("/views/" . $dnsview->id);
    }

    public function delete(Request $request, $view_id, $id)
    {
        $dnsview = DNSView::where("user_id", $request->user()->id)->findOrFail($view_id);
        $dnsip = $dnsview->ips()->findOrFail($id);
        $dnsip->delete();

        $dnsview->buildConfFile();
        $dnsview->uploadConfFile();

        return redirect("/views/" . $dnsview->id);
    }
}
