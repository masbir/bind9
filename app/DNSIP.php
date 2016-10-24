<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DNSIP extends Model
{
	protected $table = 'dnsips';
	protected $fillable = ["ipstart", "range"];
    public function view()
    {
    	return $this->belongsTo('App\DNSView', 'dnsview_id', 'id');
    }

    public function getIpstartAttribute($value)
    {
    	return long2ip($value);
    }

    public function setIpstartAttribute($value)
    { 
    	$this->attributes['ipstart'] =  ip2long($value);
    }

    public function getIpendAttribute($value)
    {
        return long2ip($value);
    }

    public function setIpendAttribute($value)
    { 
        $this->attributes['ipend'] =  ip2long($value);
    }

    public function getCidrAttribute()
    {
    	return $this->ipstart . "/" . $this->range;
    }

    public function scopeIpExists($query, $ip)
    {
        $iplong = ip2long($ip);
        return $query->where("ipstart", "<=", $iplong)->where("ipend", ">=", $iplong);
    }
}
