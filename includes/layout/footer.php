<?php include_once('../includes/page.php'); ?>

<?php
	class Footer extends Div {
		public function __construct () {
			parent::__construct('footer');			
		}
		
		protected function content() {
			$output = 'footer';
			return $output;
		}
	}
?>

		<?php $footer = new Footer(); ?>
		<?php echo $footer->getHTML(); ?>
	</body>
</html>

<?php
	// 5. Close database connection
	if(isset($dbc))
		mysqli_close($dbc);
?>