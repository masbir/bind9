<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DNSIP;
use App\Http\Requests;

class StatsController extends Controller
{
    public function track(Request $request)
    {
    	$ip = $request->ip(); 
    	
    	if($request->header('referer') == null) return response("REF");

    	$referer_parts = parse_url($request->header('referer'));
    	$host = strtolower(trim($referer_parts['host']));  

    	$ipRecord = DNSIP::ipExists($ip)->first(); 
    	if($ipRecord == null) return response("IP"); 

    	$domain = $ipRecord->view->domains()->where("domain", $host)->first();
    	if($ipRecord->view == null) return response("VIEW");
    	if($domain == null) return response("DOMAIN");

    	//cache count;
    	\Cache::increment('domain.' . $domain->id .'.views');

    	return response("OK");
    }
}
