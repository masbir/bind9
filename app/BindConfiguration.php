<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BindConfiguration extends Model
{
    public static function buildConfOptionsFile($views = null)
    { 
    	if($views == null){
    		$views = DNSView::all();
    	}
    	$html = \View::make('conf.options', ["views" => $views])->render();
    	file_put_contents(static::getConfOptionsFilePath(), $html);
    }

    public static function uploadConfFile()
    {
        \SSH::put(static::getConfOptionsFilePath(), static::getRemoteConfOptionsFilePath());
    }

    public static function getConfOptionsFilePath()
    {
        return storage_path("/app/bind/named.conf.options");
    }

    public static function getRemoteConfOptionsFilePath()
    {
        return "/etc/bind/named.conf.options";
    }

	public static function reloadBind()
	{
		$commands = ['cd /etc/bind', 'sudo rndc reload', 'sudo service bind9 restart'];
		\SSH::run($commands);
	}
}
