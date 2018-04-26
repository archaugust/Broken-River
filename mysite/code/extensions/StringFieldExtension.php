<?php
class StringFieldExtension extends Extension {

	public function CSSSafe() {
		return Convert::raw2url($this->owner->value);
	}

}