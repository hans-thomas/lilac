<?php

	if ( ! function_exists( 'lilac_config' ) ) {
		function lilac_config( string $key, $default = null ): mixed {
			return config( "lilac.$key", $default );
		}
	}

	if ( ! function_exists( 'lilac_relation_config' ) ) {
		function lilac_relation_config( string $key, $default = null ): mixed {
			return array_merge(
				lilac_config( "relations.$key", $default ),
				[ 'entity' => $key ]
			);
		}
	}
