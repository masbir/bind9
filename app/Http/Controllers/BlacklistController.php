<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class BlacklistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function edit()
    {
    	$blacklist = new \App\Blacklist(); 

        //download, make sure latest copy is the one we're editing
        $blacklist->download();

        //parse each line and get domains array
    	$content = $blacklist->getParsedContent();

        //implode to multiline
    	$content = implode("\n", $content);
    	return view("blacklist.index", compact('content'));
    }

    public function save(Request $request)
    {
    	$content = $request->content;

        //explode
    	$content = explode("\n", $content);

    	$blacklist = new \App\Blacklist(); 

        //save to local
    	$blacklist->save($content);

        //upload to server
    	$blacklist->upload();

        //reload rndc and restart bind9
    	$blacklist->reloadBind();

    	return redirect()->back();
    }
}
