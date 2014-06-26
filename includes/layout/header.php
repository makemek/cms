<?php include_once('../includes/page.php'); ?>

<?php
	class Header extends Div {
		private $cssFile;
		
		public function __construct ($stylesheet='') {
			parent::__construct('header');
			$this->cssFile = $stylesheet;
		}
		
		protected function content() {
			$output = '<h1>Makemek</h1>';
			return $output;
		}
		
		public function getCSS() {
			return $this->cssFile;
		}
	}	
?>

<?php $header = new Header('../public/stylesheets/public.css'); ?>

<html>
	<head lang="en">
		<link href="<?php echo $header->getCSS(); ?>" media="all" rel="stylesheet" type="text/css" />
	</head>
	
	<body>
		<?php echo $header->getHTML(); ?>