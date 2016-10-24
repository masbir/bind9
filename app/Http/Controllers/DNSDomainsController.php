<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\DNSView;
use App\DNSDomain;

class DNSDomainsController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request, $view_id)
    {
    	$dnsview = DNSView::where("user_id", $request->user()->id)->findOrFail($view_id);
    	
    	$dnsip = new DNSDomain();
    	$dnsip->fill($request->all());
    	$dnsip->dnsview_id = $dnsview->id;
    	$dnsip->save();

        $dnsview->buildConfFile();
        $dnsview->uploadConfFile();

    	return redirect("/views/" . $dnsview->id);
    }

    public function delete(Request $request, $view_id, $id)
    {
        $dnsview = DNSView::where("user_id", $request->user()->id)->findOrFail($view_id);
        $dnsdomain = $dnsview->domains()->findOrFail($id);
        $dnsdomain->delete();

        $dnsview->buildConfFile();
        $dnsview->uploadConfFile();

        return redirect("/views/" . $dnsview->id);
    }
}
