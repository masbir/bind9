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
    	return 'domain.' . $domain->id .'.views';
    }

    public function getViewCountAttribute()
    {
    	return \Cache::get($this->view_count_cache_name);
    }

    public function increaseViewCount()
    {
    	if(!\Cache::has($this->view_count_cache_name)){
            \Cache::forever($this->view_count_cache_name);
        }
    	\Cache::increment($this->view_count_cache_name);
    }
}
