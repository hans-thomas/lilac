<?php

	if ( ! function_exists( 'liliac_config' ) ) {
		function liliac_config( string $key, $default = null ): mixed {
			return config( "liliac.$key", $default );
		}
	}
