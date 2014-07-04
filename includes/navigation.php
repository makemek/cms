<?php 
require_once('../includes/page.php');

class Navigation implements Pageable {

	private $main_menu;

    // ID Tag
    const HOME = 'home';
    const ADD_CONTENT = 'add_content';
    const BRANCH = 'branch';
    const PRIV = 'priv';
    const TENANT = 'tenant';
    const BROWSE = 'browse';

	public function __construct() {
		$this->main_menu = new Menu('');

        // -------- Home Page ---------- //
        $home_page = new Menu('Home', self::HOME, '../public/admin.php');

		// -------- Add Content -------- //
		$add_content = new Menu('Add Content', self::ADD_CONTENT);
		$branch = new Menu('Branch', self::BRANCH);
		$priv = new Menu('Privilege', self::PRIV);
		$tenant = new Menu('Tenant', self::TENANT);

            // attach link
        $link = '../public/add_content.php';
        $to_send = 'add';
        $branch->link_to($link, array($to_send => self::BRANCH));
        $priv->link_to($link, array($to_send => self::PRIV));
        $tenant->link_to($link, array($to_send => self::TENANT));

		$add_content->add_sub_menu($branch);
		$add_content->add_sub_menu($priv);
		$add_content->add_sub_menu($tenant);
		// ---------------------------- //

		// -------- Browse -------- //
		$browse = new Menu('Browse', self::BROWSE, '../public/manage_content.php');
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

    private $parent = null;
    private $id;

	public function __construct($name, $id=null, $link='') {
		$this->name = $name;
        $this->id = $id;

		if(!empty($link))
			$this->link_to($link);

	}

	public function getTitle() {
		return $this->name;
	}

	public function add_sub_menu(Menu $sub_menu) {
		$this->sub_menu[$sub_menu->getId()] = $sub_menu;
	}

    public function getId() {
        return $this->id;
    }

	public function display() {
		if(!empty($this->link))
			$content = $this->link;
		else
			$content = $this->getTitle();

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

	public function link_to($link, $args=null) {

        if(!is_null($args)) {
            $link .= '?';
            foreach($args as $name => $value) {
                $link .= $name . '=' . $value;
                $link .= '&';
            }
        }

		$this->link = "<a href=\"{$link}\">{$this->getTitle()}</a>";
		$this->set_selected($this->selected);
	}

	public function set_selected($is_select) {
		$this->selected = $is_select;
		if(!empty($this->link) && $this->selected)
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

