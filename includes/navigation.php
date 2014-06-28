<?php 
require_once('../includes/page.php');

// TODO: add sticky form functionality

class Navigation implements Pageable {

	private $main_menu;

	private function __construct() {
		$this->main_menu = new Menu('');

		// -------- Add Content -------- //
		$add_content = new Menu('Add Content');
		$branch = new Menu('Branch', '../public/add_branch.php');
		$priv = new Menu('Privilage', '../public/add_priv.php');
		$tenant = new Menu('Tenant', '../public/add_tenant.php');
		$add_content->add_sub_menu($branch);
		$add_content->add_sub_menu($priv);
		$add_content->add_sub_menu($tenant);
		// ---------------------------- //

		// -------- Browse -------- //
		$browse = new Menu('Browse', '../public/manage_content.php');
		// ------------------------ //

		$this->main_menu->add_sub_menu($add_content);
		$this->main_menu->add_sub_menu($browse);
	}

	public static function getInstance() {
		static $instance = null;
		if(!$instance)
			$instance = new Navigation();
		return $instance;
	}

	public function getContent() {
		$content = '';
		// foreach($this->main_menu as $menu)
		// 	$content .= $menu->display();
		$content .= $this->main_menu->display();
		return $content;
	}
}

// will use this instead of navigation soon! ...
class Menu
{
	private $sub_menu = array();
	private $name = '';
	private $link = '';
	private $selected = FALSE;

	public function __construct($name, $link='') {
		$this->name = $name;

		if(!empty($link))
			$this->link_to($link);
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
		$this->set_selected($this->selected);
	}

	public function set_selected($is_select) {
		$this->selected = $is_select;
		if(!empty($this->link))
			$this->link = str_replace("<a ", "<a class=\"selected\" ", $this->link);
	}
}

