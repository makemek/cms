		<div id="footer">Copyright <?php echo date('Y'); ?>, Makemek</div>
	
	</body>
</html>
<?php
	// 5. Close database connection
	if(isset($dbc))
		mysqli_close($dbc);
?>