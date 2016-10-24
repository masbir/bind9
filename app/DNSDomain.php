<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DNSDomain extends Model
{ 
	protected $table = 'dnsdomains';
	protected $fillable = ["domain"];
    public function view()
    {
    	return $this->belongsTo('App\DNSView');
    }
}
