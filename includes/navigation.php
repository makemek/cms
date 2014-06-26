<?php 
require_once('../includes/page.php');

class Navigation implements Pageable {

	const TENANT = 0;
	const PRIV = 1;
	const BRANCH = 2;

	public static function getInstance() {
		static $inst = null;
		if($inst === null) {
			$inst = new Navigation();
		}
			
		return $inst;
	}

	public function set_selected($id) {

	}

	public function getContent() { ?>

		<div id="navigation">
			Add Content
				<ul>
					<li><a href="add_content.php?add=<?php echo Navigation::TENANT; ?>">Tenant</a></li>
					<li><a href="add_content.php?add=<?php echo Navigation::PRIV; ?>">Privilage</a></li>
					<li><a href="add_content.php?add=<?php echo Navigation::BRANCH; ?>">Branch</a></li>
				</ul>
			<a href="browser.php">Browse</a>
		</div>

	<?php }

	public function getHTML() {
		
	}
}
?>
