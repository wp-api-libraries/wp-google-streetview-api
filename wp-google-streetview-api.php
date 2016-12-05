<?php
/**
 * WP Google Streetview API (https://developers.google.com/maps/documentation/streetview)
 *
 * @package WP-StreetView-API
 */

/*
* Plugin Name: WP Google StreetView API
* Plugin URI: https://github.com/wp-api-libraries/wp-google-streetview-api
* Description: Perform API requests to Google Streetview API in WordPress.
* Author: WP API Libraries
* Author URI: https://wp-api-libraries.com
* Version: 1.0.0
* GitHub Plugin URI: https://github.com/wp-api-libraries/wp-google-streetview-api
* GitHub Branch: master
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'GoogleStreetViewAPI' ) ) {

	/**
	 * GoogleStaticMapAPI class.
	 */
	class GoogleStreetViewAPI {

		 /**
		 * API Key.
		 *
		 * @var mixed
		 * @access private
		 * @static
		 */
		static private $api_key;

		/**
		 * Base URI.
		 *
		 * @var string
		 * @access protected
		 */
		protected $base_uri = 'https://maps.googleapis.com/maps/api/streetview';

		/**
		 * Construct.
		 *
		 * @access public
		 * @param mixed $api_key API Key.
		 * @param mixed $output Output.
		 * @return void
		 */
		public function __construct( $api_key ) {

			static::$api_key = $api_key;
			static::$output = $output;

		}

		/**
		 * Fetch the request from the API.
		 *
		 * @access private
		 * @param mixed $request Request URL.
		 * @return $body Body.
		 */
		private function fetch( $request ) {

			$response = wp_remote_get( $request );
			$code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Server response code: %d', 'text-domain' ), $code ) );
			}

			$body = wp_remote_retrieve_body( $response );

			return json_decode( $body );

		}

		/**
		 * Get StreetView.
		 *
		 * @access public
		 * @param mixed $location
		 * @param mixed $pano
		 * @param mixed $size
		 * @param string $signature (default: '')
		 * @param string $heading (default: '')
		 * @param string $fov (default: '90')
		 * @param string $pitch (default: '0')
		 * @return void
		 */
		function get_streetview( $location, $pano, $size, $signature = '', $heading = '', $fov = '90', $pitch = '0' ) {

			$request = $this->base_uri . '?location=' . $location . '&pano=' . $pano . '&size=' . $size . '&heading=' . $heading . '&fov=' . $fov . '&pitch=' . $pitch . '&key=' . static::$api_key;

			return $this->fetch( $request );


		}

	}
}