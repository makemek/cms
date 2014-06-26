<?php include('../includes/page.php'); ?>
<?php
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
				<div class="navigation">
					<a href="add_content.php">Add Content</a>
						<ul>
							<li><a href="add_content.php?menu=0">Tenant</a></li>
							<li><a href="add_content.php?menu=1">Privilage</a></li>
							<li><a href="add_content.php?menu=2">Branch</a></li>
						</ul>
					<a href=\"browse.php\">Browse</a>
				</div>
			';
			return $output;
		}
	}
?>
