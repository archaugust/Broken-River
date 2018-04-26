<?php

Class VideoCategory extends DataObject {
	
	private static $db = array(
		'Name' => 'Varchar(250)',
		'Content' => 'HTMLText'
	);
	
	static $has_one = array(
		'VideoPage' => 'VideoPage'
	);
	
	static $has_many = array(
		'Videos' => 'Video'
	);
	
	public function videosByDate(){
		$videos = $this->Videos();
		if( !$videos )
		  return null; // no videos, nothing to work with
		
		$videos = $videos->sort('Date', 'DESC');

		// return sorted set
		return $videos;
	}
}