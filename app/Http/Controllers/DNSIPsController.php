<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\DNSView;
use App\DNSIP;

class DNSIPsController extends Controller
{ 
    
    public function create(Request $request, $view_id)
    { 
        $this->validate($request, [
            'ipstart' => 'required|ipv4|max:15',
            'range' => 'required|integer|between:16,32',
        ],[
            'ipv4' => 'IP address is not a valid IPv4 format.',
        ]);

    	$dnsview = DNSView::where("user_id", $request->user()->id)->findOrFail($view_id);
    	
    	$dnsip = new DNSIP();
    	$dnsip->fill($request->all()); 
        $ips = \App\IPHelpers::cidrToRange($dnsip->ipstart . "/" . $dnsip->range); 
        $dnsip->ipend = $ips[1];
    	$dnsip->dnsview_id = $dnsview->id;
    	$dnsip->save();

        $dnsview->buildConfFile();
        $dnsview->uploadConfFile();

        $request->session()->flash('message', $dnsip->cidr . " successfully added");
        $request->session()->flash('message-type', "success");

    	return redirect("/views/" . $dnsview->id);
    }

    public function delete(Request $request, $view_id, $id)
    {
        $dnsview = DNSView::where("user_id", $request->user()->id)->findOrFail($view_id);
        $dnsip = $dnsview->ips()->findOrFail($id);

        $request->session()->flash('message', $dnsip->cidr . " successfully removed");
        $request->session()->flash('message-type', "danger");

        $dnsip->delete();

        $dnsview->buildConfFile();
        $dnsview->uploadConfFile();

        return redirect("/views/" . $dnsview->id);
    }
}
