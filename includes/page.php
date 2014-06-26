<?php
interface Pageable {
	public function getHTML();
}

abstract class Div implements Pageable {
	private $cssFile;
	private $id;
	private $subpage;
	
	public function __construct ($id, $stylesheet='') {
		$this->subpage = array();
		$this->cssFile = $stylesheet;
		$this->id = $id;
	}
	
	abstract protected function content();
	
	public function getHTML() {
		$output = '';
		foreach($this->subpage as $page)
			$output .= $page->content();
		
		return $output;
	}
	
	public function addSubpage($page) {
		$this->subpage[] = $page;
	}
	
	public function getId() {
		return $id;
	}
}
?>