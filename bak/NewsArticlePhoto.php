<?php 
class NewsArticlePhoto extends DataObject {

	private static $has_one = array (
			'Photo' => 'Image',
			'ParentPage' => 'NewsArticle'
	);
	
	private static $summary_fields = array (
			'GridThumbnail' => '',
	);
	
	public function getGridThumbnail() {
		if($this->Photo()->exists()) {
			return $this->Photo()->SetWidth(100);
		}
	
		return "(no image)";
	}
	
	public function getCMSFields() {
		$fields = FieldList::create(
				$uploader = UploadField::create('Photo')
		);

		$uploader->getValidator()->setAllowedExtensions(array('png','gif','jpeg','jpg'));

		return $fields;
	}
}
?>