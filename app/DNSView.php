<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DNSView extends Model
{
	protected $table = 'dnsviews';
    protected $fillable = ['warning', 'name'];
    public function ips()
    {
    	return $this->hasMany('App\DNSIP', 'dnsview_id', 'id');
    }

    public function domains()
    {
    	return $this->hasMany('App\DNSDomain', 'dnsview_id', 'id');
    }

    public function scopeFindOwned($query, $user_id, $view_id)
    {
        $query->where("user_id", $user_id)->where("id", $view_id);
    }

    public function buildConfFile()
    { 
        $html = \View::make('conf.view', ["dnsview" => $this])->render();
        file_put_contents($this->local_conf_file_path, $html);   
    }

    public function uploadConfFile($reload = true)
    {
        if(\Config::get("app.env") != "local"){
            \SSH::put($this->local_conf_file_path, $this->remote_conf_file_path);
            if($reload){
                \App\BindConfiguration::reloadBind();
            }
        }
    }

    public function getLocalConfFilePathAttribute()
    {
        return storage_path(sprintf("/app/bind/%s", $this->conf_file_name));
    }

    public function getRemoteConfFilePathAttribute()
    {
        return sprintf("/etc/bind/%s", $this->conf_file_name);
    }

    public function getConfFileNameAttribute()
    {
    	return sprintf("view-%s.conf", $this->id);
    }

    public function getClientsLabelAttribute()
    {
        return sprintf("user%sclients", $this->id);
    }

    public function getViewLabelAttribute()
    {
        return sprintf("user%s", $this->id);
    }
}
