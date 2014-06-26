<?php
interface Pageable {
	public function getHTML();
}

abstract class Div implements Pageable {
	private $id;
	private $subpage;
	
	public function __construct ($name='') {
		$this->subpage = array();
		$this->id = $name;
	}
	
	abstract protected function content();
	
	public function getHTML() {
		if (empty($this->id))
			$output = '<div>';
		else
			$output = "<div class=\"{$this->id}\">";
		
		$output .= $this->content();
		foreach($this->subpage as $page)
			$output .= $page->content();
		
		$output .= '</div>';
		
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