<?php
/**
 * Client IP
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Payments
 */

namespace Pronamic\WordPress\ClientIp;

/**
 * Client IP
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class ClientIp {
	/**
	 * Construct client IP object.
	 *
	 * @param string $value IP value.
	 */
	public function __construct( $value ) {
		$this->value = $value;
	}

	/**
	 * Get value.
	 *
	 * @return string
	 */
	public function get_value() {
		return $this->value;
	}

	/**
	 * Create string representation of this client IP.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->value;
	}

	/**
	 * Get the client IP.
	 *
	 * @return self
	 */
	public static function get() {
		// In order of preference, with the best ones for this purpose first.
		$keys = array(
			/**
			 * It seems that NGINX sometimes uses the `X-Real-IP` header,
			 * WooCommerce prefers this header in its geo features:
			 *
			 * @link https://github.com/woocommerce/woocommerce/blob/5.3.0/includes/class-wc-geolocation.php#L81-L83
			 * @link http://nginx.org/en/docs/http/ngx_http_realip_module.html
			 * @link https://www.nginx.com/resources/wiki/start/topics/examples/forwarded/
			 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Forwarded-For
			 */
			'HTTP_X_REAL_IP',
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR',
		);

		$keys = \array_filter( $keys, function( $key ) {
			return \array_key_exists( $key, $_SERVER );
		} );

		foreach ( $keys as $key ) {
			/*
			 * HTTP_X_FORWARDED_FOR can contain a chain of comma-separated
			 * addresses. The first one is the original client. It can't be
			 * trusted for authenticity, but we don't need to for this purpose.
			 */
			$addresses = explode( ',', (string) filter_var( wp_unslash( $_SERVER[ $key ] ) ) );

			$addresses = array_slice( $addresses, 0, 1 );

			foreach ( $addresses as $address ) {
				$address = trim( $address );

				$address = filter_var( $address, FILTER_VALIDATE_IP );

				if ( false === $address ) {
					continue;
				}

				return new ClientIp( $address );
			}
		}

		return null;
	}
}
