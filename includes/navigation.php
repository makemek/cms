<?php include_once('../includes/page.php'); ?>

<?php
	class Navigation extends Div {
		
		public static $TENANT = 0;
		
		public function __construct($name='') {
			parent::__construct($name);
		}
		
		public function content() {
			$parent_menu = array();
			$parent_menu[] = "<li class=\"parent\"><a href=\"../public/add_content.php\">Add content</a></li>";
			
			return
			"
			<li class=\"parent\"><a href=\"../public/add_content.php\">Add content</a></li>
				<ul class=\"sub\">
				<li><a href=\"../public/add_content.php?new=tenant\">Tenant</a><br /></li>
				<li><a href=\"../public/add_content.php?new=priv\">Privilege</a><br /></li>
				<li><a href=\"../public/add_content.php?new=branch\">Branch</a><br /></li>
				</ul>	
			<li class=\"parent\"><a href=\"../public/browse.php\">Browse</a></li>
			";
		}
		
	}
?>