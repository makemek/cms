<?php 
require_once('../includes/page.php');

class Navigation implements Pageable {

	private $main_menu;

	public function __construct() {
		$this->main_menu = new Menu('');

        // -------- Home Page ---------- //
        $home_page = new Menu('Home', '../public/admin.php');

		// -------- Add Content -------- //
		$add_content = new Menu('Add Content');
		$branch = new Menu('Branch');
		$priv = new Menu('Privilege');
		$tenant = new Menu('Tenant');

            // attach link
        $link = '../public/add_content.php?add=';
        $branch->link_to($link . $branch->getName());
        $priv->link_to($link . $priv->getName());
        $tenant->link_to($link . $tenant->getName());

		$add_content->add_sub_menu($branch);
		$add_content->add_sub_menu($priv);
		$add_content->add_sub_menu($tenant);
		// ---------------------------- //

		// -------- Browse -------- //
		$browse = new Menu('Browse', '../public/manage_content.php');
		// ------------------------ //

        $this->main_menu->add_sub_menu($home_page);
		$this->main_menu->add_sub_menu($add_content);
		$this->main_menu->add_sub_menu($browse);
	}

    public function getMenu() {
        return $this->main_menu->get_sub_menu();
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
class Menu implements ArrayAccess
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

	public function add_sub_menu(Menu $sub_menu) {
		$this->sub_menu[$sub_menu->getName()] = $sub_menu;
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

    public function get_sub_menu() {
        return $this->sub_menu;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->sub_menu[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->sub_menu[$offset];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->sub_menu[$offset] = $value;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->sub_menu[$offset]);
    }
}

