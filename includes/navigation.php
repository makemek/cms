<?php 
include('../includes/page.php');

class Navigation implements Pageable {

	private $menu;

	private function __construct() {

	}

	public static function getInstance() {
		static $inst = null;
		if($inst === null) {
			$inst = new Navigation();
		}
			
		return $inst;
	}

	public function set_selected($id) {

	}

	public function getHTML() {
		$output = '
			<div id="navigation">
				<a href="add_content.php">Add Content</a>
					<ul>
						<li><a href="add_content.php?add=tenant">Tenant</a></li>
						<li><a href="add_content.php?add=priv">Privilage</a></li>
						<li><a href="add_content.php?add=branch">Branch</a></li>
					</ul>
				<a href=\"browse.php\">Browse</a>
			</div>
		';
		return $output;
	}
}
?>
