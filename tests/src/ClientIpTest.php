<?php
/**
 * Client IP Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Payments
 */

namespace Pronamic\WordPress\ClientIp;

/**
 * Client IP Test
 *
 * @link https://github.com/woocommerce/woocommerce/blob/5.3.0/tests/legacy/unit-tests/geolocation/class-wc-test-gelocation.php
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class ClientIpTest extends \WP_UnitTestCase {
	/**
	 * Test `REMOTE_ADDR`.
	 */
	public function test_client_remote_addr() {
		$factory = new Factory( array(
			'REMOTE_ADDR' => '127.0.0.1',
		) );

		$client_ip = $factory->get_client_ip();

		$this->assertEquals( '127.0.0.1', $client_ip->get_value() );
	}

	/**
	 * Test `HTTP_X_REAL_IP`.
	 */
	public function test_client_http_x_real_ip() {
		$factory = new Factory( array(
			'REMOTE_ADDR'    => '127.0.0.1',
			'HTTP_X_REAL_IP' => '208.67.220.220',
		) );

		$client_ip = $factory->get_client_ip();

		$this->assertEquals( '208.67.220.220', $client_ip->get_value() );
	}
}
