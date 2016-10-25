<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DNSIP;
use App\Http\Requests;

class StatsController extends Controller
{
    public function track(Request $request)
    {
        //referrer is admin, do not track
        if(\Auth::check()) return response("ADMIN");

    	$ip = $request->ip(); 
    	
        //referrer not found, terminate
    	if($request->header('referer') == null) return response("REF");

    	$referer_parts = parse_url($request->header('referer'));
    	$host = strtolower(trim($referer_parts['host']));  

        //current referrer is the same as HEROIC's domain, terminate
        if($host == env("APP_HOST")) return response("PREVIEW");

    	$ipRecord = DNSIP::ipExists($ip)->first(); 
        //no matching IP address found, terminate
    	if($ipRecord == null) return response("IP"); 

    	$domains = $ipRecord->view->domains()->where("domain", $host)->get();

        //no view found under ip
    	if($ipRecord->view == null) return response("VIEW");

        //no domain found
    	if($domains->count() == 0) return response("DOMAIN");

    	//cache count;
        foreach($domains as $domain)
        {
            $domain->increaseViewCount();    
        }
        


    	return response("OK");
    }
}
