<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DNSIP;
use App\DNSView;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { 
    } 

    public function warningPage(Request $request)
    {
        //get ip address
        $ip = $request->ip(); 

        //get current server name
        $server_name = strtolower(trim($request->server("HTTP_HOST")));  

        $ipRecord = DNSIP::ipExists($ip)->first();  
        
        //ip not found in database
        if($ipRecord == null){
            return $this->genericWarning();
        } 

        $domain = $ipRecord->view->domains()->where("domain", $server_name)->first();
        if($domain == null){
            return $this->genericWarning();
        }

        return response()->view("home.warning-page", ["view" => $ipRecord->view], 403);
    }

    public function previewWarningPage(Request $request, $view_id)
    {   
        $dnsview = DNSView::findOwned($request->user()->id, $view_id)->firstOrFail(); 
        return response()->view("home.warning-page", ["view" => $dnsview]);
    }

    private function genericWarning()
    {
        return response()->view("home.generic-warning-page", [], 403);
    }
}
