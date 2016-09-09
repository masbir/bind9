<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blacklist
{
	private $remote_file;
	private $local_file;
	private $zone_file;

	public function __construct(){
		$this->remote_file = env("REMOTE_BLACKLIST", '/etc/bind/blacklist');
		$this->local_file = env("LOCAL_BLACKLIST", resource_path('blacklist'));
		$this->zone_file = env("REMOTE_ZONE");
	}

	public function download()
	{
		\SSH::get($this->remote_file, $this->local_file);
	}

	public function upload()
	{
		\SSH::put($this->local_file, $this->remote_file);
	}

	public function reloadBind()
	{
		$commands = ['cd /etc/bind', 'sudo rndc reload', 'sudo service bind9 restart'];
		\SSH::run($commands);
	}

	public function getContent()
	{
		//$this->download();
		return file_get_contents($this->local_file);
	}

	public function getParsedContent()
	{ 
		$exploded = explode("\n",$this->getContent());
		$parsed = [];
		foreach ($exploded as $line) {
			$match = preg_match("/^\s*zone\s*\"(.*?)\"/", $line, $output);
			if($match){
				$parsed[] = $output[1];	
			}
		}
		return $parsed; 
	}

	public function save($lines)
	{
		$collect = collect($lines)->map(function($line){
			$line = str_ireplace(["\R", "\r", "\t"], "", $line);
			return sprintf('zone "%s" { type master; notify no; file "/etc/bind/null.zone.file"; };', trim($line));
		})->all();

		file_put_contents($this->local_file, implode("\n", $collect));
	}
}
