<?php
if ( ! function_exists('ribuan')) {
	function ribuan($angka,$decimals = 0) {
		return number_format((float)$angka, $decimals, ',', '.');
	}
}
?>
