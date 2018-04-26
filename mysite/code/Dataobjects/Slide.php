<?php 
class Slide extends DataObject {
	static $db = array(
		//'Position' => 'Int'
		'Title' => 'Varchar(250)',
		'Content' => 'Varchar(250)',
		'VideoEmbedCode' => 'Varchar(250)',
		'Link' => 'Varchar(250)',
		'Arrow' => 'Boolean',
		'TopMargin' => 'Boolean'
	 );
	
	static $has_one = array(
        'Page' => 'Page',
		'Image' => 'Image',
		'ImageOverlay' => 'Image'
	);

}