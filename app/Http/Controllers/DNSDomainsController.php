<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\DNSView;
use App\DNSDomain;

class DNSDomainsController extends Controller
{  

    public function create(Request $request, $view_id)
    {
        $this->validate($request, [
            'domain' => 'required|hostname|max:255'
        ],[
            'hostname' => 'Hostname is invalid',
        ]);

    	$dnsview = DNSView::where("user_id", $request->user()->id)->findOrFail($view_id);
    	
    	$dnsdomain = new DNSDomain();
    	$dnsdomain->fill($request->all());
    	$dnsdomain->dnsview_id = $dnsview->id;
    	$dnsdomain->save();

        $dnsview->buildConfFile();
        $dnsview->uploadConfFile();

        $request->session()->flash('message', $dnsdomain->domain . " successfully added");
        $request->session()->flash('message-type', "success");

    	return redirect("/views/" . $dnsview->id);
    }

    public function delete(Request $request, $view_id, $id)
    {
        $dnsview = DNSView::where("user_id", $request->user()->id)->findOrFail($view_id);
        $dnsdomain = $dnsview->domains()->findOrFail($id);

        $request->session()->flash('message', $dnsdomain->domain . " successfully removed");
        $request->session()->flash('message-type', "danger");

        $dnsdomain->delete();

        $dnsview->buildConfFile();
        $dnsview->uploadConfFile();

        return redirect("/views/" . $dnsview->id);
    }
}
