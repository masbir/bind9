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

    public function getViewCountCacheNameAttribute()
    {
    	return 'domain.' . $this->id .'.views';
    }

    public function getViewCountAttribute()
    {
        if(\Cache::has($this->view_count_cache_name)){
        	return intval(\Cache::get($this->view_count_cache_name));
        }else{
            return 0;
        }
    }

    public function increaseViewCount()
    {
    	if(!\Cache::has($this->view_count_cache_name)){
            \Cache::forever($this->view_count_cache_name, 0); 
        } 
    	\Cache::increment($this->view_count_cache_name);
    }
}
