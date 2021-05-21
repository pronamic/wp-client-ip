<?php
/**
 * Factory
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Payments
 */

namespace Pronamic\WordPress\ClientIp;

/**
 * Factory
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class Factory {
	/**
	 * Instance.
	 *
	 * @var self|null
	 */
	protected static $instance;

	/**
	 * Server variables.
	 *
	 * @var string
	 */
	private $server_variables;

	/**
	 * Instance.
	 *
	 * @return self
	 */
	public static function instance() {
		if ( \is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Construct factory.
	 *
	 * @param array|null $server_veriables Server variables.
	 */
	public function __construct( $server_variables = null ) {
		$this->server_variables = ( null === $server_variables ) ? $_SERVER : $server_variables;
	}

	/**
	 * Get the client IP.
	 *
	 * @return ClientIp|null
	 */
	public function get_client_ip() {
		return $this->get_client_ips()->first();
	}

	/**
	 * Get the client IP.
	 *
	 * @return ClientIps
	 */
	public function get_client_ips() {
		/**
		 * Meta-variables with names beginning with "HTTP_" contain values read
		 * from the client request header fields, if the protocol used is HTTP.
		 * The HTTP header field name is converted to upper case, has all
		 * occurrences of "-" replaced with "_" and has "HTTP_" prepended to
		 * give the meta-variable name.  
		 *
		 * @link https://www.php.net/manual/en/reserved.variables.server.php
		 * @link http://www.faqs.org/rfcs/rfc3875.html
		 */
		$providers = array(
			/**
			 * It seems that NGINX sometimes uses the `X-Real-IP` header,
			 * WooCommerce prefers this header in its geo features:
			 *
			 * @link https://github.com/woocommerce/woocommerce/blob/5.3.0/includes/class-wc-geolocation.php#L81-L83
			 * @link http://nginx.org/en/docs/http/ngx_http_realip_module.html
			 * @link https://www.nginx.com/resources/wiki/start/topics/examples/forwarded/
			 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Forwarded-For
			 */
			(object) array(
				'header_name' => 'X-Real-IP',
				'server_name' => 'HTTP_X_REAL_IP',
			),
			/**
			 * Standard headers used by Amazon EC2, Heroku, and others.
			 *
			 * @link https://github.com/pbojinov/request-ip/blob/2.1.3/src/index.js#L53-L56
			 */
			(object) array(
				'header_name' => 'X-Client-IP',
				'server_name' => 'HTTP_X_CLIENT_IP',
			),
			(object) array(
				'header_name' => 'Client-IP',
				'server_name' => 'HTTP_CLIENT_IP',
			),
			/**
			 * Cloudflare.
			 *
			 * @link https://support.cloudflare.com/hc/en-us/articles/200170986-How-does-Cloudflare-handle-HTTP-Request-headers-
			 */
			(object) array(
				'header_name' => 'CF-Connecting-IP',
				'server_name' => 'HTTP_CF_CONNECTING_IP',
			),
			/**
			 * Akamai and Cloudflare: True-Client-IP.
			 *
			 * @link https://support.cloudflare.com/hc/en-us/articles/200170986-How-does-Cloudflare-handle-HTTP-Request-headers-
			 */
			(object) array(
				'header_name' => 'True-Client-IP',
				'server_name' => 'HTTP_TRUE_CLIENT_IP',
			),
			/**
			 * Fastly-Client-IP.
			 *
			 * @link https://developer.fastly.com/reference/http-headers/Fastly-Client-IP/
			 */
			(object) array(
				'header_name' => 'Fastly-Client-IP',
				'server_name' => 'HTTP_FASTLY_CLIENT_IP',
			),		
			/**
			 * The X-Forwarded-For (XFF) HTTP header field is a common method
			 * for identifying the originating IP address of a client
			 * connecting to a web server through an HTTP proxy or load
			 * balancer.
			 *
			 * @link https://en.wikipedia.org/wiki/X-Forwarded-For
			 * @link https://en.wikipedia.org/wiki/Talk%3AX-Forwarded-For#Variations
			 */
			(object) array(
				'header_name' => 'X-Forwarded-For',
				'server_name' => 'HTTP_X_FORWARDED_FOR',
			),
			(object) array(
				'header_name' => 'X-Forwarded',
				'server_name' => 'HTTP_X_FORWARDED',
			),
			/**
			 * Rackspace LB and Riverbed's Stingray
			 *
			 * @link http://www.rackspace.com/knowledge_center/article/controlling-access-to-linux-cloud-sites-based-on-the-client-ip-address
			 * @link https://splash.riverbed.com/docs/DOC-1926
			 */
			(object) array(
				'header_name' => 'X-Cluster-Client-IP',
				'server_name' => 'HTTP_X_CLUSTER_CLIENT_IP',
			),
			/**
			 * Alternatives and variations.
			 *
			 * @link https://en.wikipedia.org/wiki/X-Forwarded-For#Alternatives_and_variations
			 */
			(object) array(
				'header_name' => 'Forwarded-For',
				'server_name' => 'HTTP_FORWARDED_FOR',
			),
			(object) array(
				'header_name' => 'Forwarded',
				'server_name' => 'HTTP_FORWARDED',
			),
			/**
			 * `REMOTE_ADDR` still represents the most reliable source of an
			 * IP address. The other `$_SERVER` variables mentioned here can
			 * be spoofed by a remote client very easily.
			 *
			 * @link https://stackoverflow.com/questions/1634782/what-is-the-most-accurate-way-to-retrieve-a-users-correct-ip-address-in-php
			 * @link https://www.php.net/manual/en/reserved.variables.server.php
			 */
			(object) array(
				'header_name' => null,
				'server_name' => 'REMOTE_ADDR',
			),
		);

		$providers = \array_filter( $providers, function( $provider ) {
			return \array_key_exists( $provider->server_name, $this->server_variables );
		} );

		$ips = new ClientIps();

		foreach ( $providers as $provider ) {
			/*
			 * HTTP_X_FORWARDED_FOR can contain a chain of comma-separated
			 * addresses. The first one is the original client. It can't be
			 * trusted for authenticity, but we don't need to for this purpose.
			 */
			$addresses = \explode( ',', (string) \filter_var( \wp_unslash( $this->server_variables[ $provider->server_name ] ) ) );

			$addresses = \array_slice( $addresses, 0, 1 );

			foreach ( $addresses as $address ) {
				$address = \trim( $address );

				$address = \filter_var( $address, \FILTER_VALIDATE_IP );

				if ( false === $address ) {
					continue;
				}

				$client_ip = new ClientIp( $address );

				$client_ip->set_provider( $provider );

				$ips->add( $client_ip );
			}
		}

		return $ips;
	}
}
