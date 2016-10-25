<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\DNSView;
use App\BindConfiguration;

class DNSViewsController extends Controller
{ 
    
    public function index(Request $request)
    {
    	$dnsviews = DNSView::with("ips", "domains")->orderBy("created_at")->where("user_id", $request->user()->id)->paginate(20);
    	return view("dnsview.index", compact('dnsviews'));
    }

    public function view(Request $request, $id)
    {
    	$dnsview = DNSView::where("user_id", $request->user()->id)->findOrFail($id);
        if($request->session()->has("message")){
            $message = new \stdClass();
            $message->content = $request->session()->get("message");
            $message->type = $request->session()->get("message-type");
        }

    	return view("dnsview.view", compact('dnsview', 'message'));
    }

    public function updateMessage(Request $request, $id)
    {
        $this->validate($request, [
            'warning' => 'max:255',
        ]);

        $dnsview = DNSView::where("user_id", $request->user()->id)->findOrFail($id);
        $dnsview->fill($request->only("warning"));
        $dnsview->save();

        $request->session()->flash('message', "Message successfully saved");
        $request->session()->flash('message-type', "success");
        return redirect("/views/" . $dnsview->id);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'max:255',
        ]);

        $dnsview = new DNSView();
        $dnsview->fill($request->only("name"));
        $dnsview->user_id = $request->user()->id;
        $dnsview->save();

        $dnsview->buildConfFile();
        $dnsview->uploadConfFile();

        BindConfiguration::buildConfOptionsFile();
        BindConfiguration::uploadConfFile();


        return redirect("/views/" . $dnsview->id); 
    }
}
