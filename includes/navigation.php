<?php 
require_once('../includes/page.php');

class Navigation implements Pageable {

	const TENANT = 0;
	const PRIV = 1;
	const BRANCH = 2;
	private $menu_list = array('TENANT' => 0, 'PRIV' => 1, 'BRANCH' => 2);
	private $selected = -1;

	public static function getInstance() {
		static $inst = null;
		if($inst === null) {
			$inst = new Navigation();
		}
			
		return $inst;
	}

	public function set_selected($menu_const) {
		$this->selected = $menu_const;
	}

	public function getContent() { ?>

		<div id="navigation">
			Add Content
				<ul>
					<?php 
						foreach($this->menu_list as $menu => $id) {
							$link = '<li ';
							if($id == $this->selected)
								$link .= "class=\"selected\"";
							$link .= "><a href=\"add_content.php?add={$id}\">{$menu}</a></li>";
							echo $link;
						}
					?>
				</ul>
			<a href="browser.php">Browse</a>
		</div>

	<?php }

	public function getHTML() {
		
	}

	public function getMenu() {
		return $this->menu_list;
	}
}
?>
