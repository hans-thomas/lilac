<?php

	if ( ! function_exists( 'lilac_config' ) ) {
		function lilac_config( string $key, $default = null ): mixed {
			return config( "lilac.$key", $default );
		}
	}
