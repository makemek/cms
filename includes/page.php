<?php
interface Pageable {
	public getHTML();
}

abstract class Div implements Pageable {
	private $cssFile;
	private $id;
	private $subpage;
	
	public Div($id, $stylesheet) {
		$this->subpage = array();
	}
	
	abstract protected content();
	
	public getHTML() {
		$output = "<div id=\"{$this->id}\">";
		foreach($this->subpage as $page)
			$output .= $page->content();
		$output .= '</div>';
		
		return $output;
	}
	
	public addSubpage($page) {
		$this->subpage[] = $page;
	}
	
	public getId() {
		return $id;
	}
}
?>