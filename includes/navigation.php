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

// will use this instead of navigation soon! ...
class Menu
{
	private $sub_menu = array();
	private $name = '';
	private $link = '';

	public function __construct($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function add_sub_menu($sub_menu) {
		$this->sub_menu[] = $sub_menu;
	}

	public function display() {
		if(!empty($this->link))
			$content = $this->link;
		else
			$content = $this->getName();

		if($this->has_sub_menu()) {
			$content .= '<ul>';
			foreach($this->sub_menu as $sub) {
				$content .= '<li>';
				$content .= $sub->display();
				$content .= '</li>';
			}
			$content .= '</ul>';
		}

		return $content;
	}

	private function has_sub_menu() {
		return count($this->sub_menu) > 0;
	}

	public function link_to($link) {
		$this->link = "<a href=\"{$link}\">{$this->getName()}</a>";
	}
}

// $a = new Menu('head');
// $b = new Menu('sub');
// $b->link_to('asdf');
// $b->add_sub_menu(new Menu('subsub'));
// $b->add_sub_menu(new Menu('subsub2'));
// $a->add_sub_menu($b);
// echo $a->display();
?>
