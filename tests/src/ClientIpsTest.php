<?php
/**
 * Client IP's Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Payments
 */

namespace Pronamic\WordPress\ClientIp;

/**
 * Client IP's Test
 *
 * @link https://github.com/woocommerce/woocommerce/blob/5.3.0/tests/legacy/unit-tests/geolocation/class-wc-test-gelocation.php
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class ClientIpsTest extends \WP_UnitTestCase {
	/**
	 * Test.
	 */
	public function test_client_ips() {
		$factory = new Factory( array(
			'REMOTE_ADDR'    => '127.0.0.1',
		) );

		$client_ips = $factory->get_client_ips();

		$client_ip = $client_ips->first();

		$this->assertEquals( '127.0.0.1', $client_ip->get_value() );
	}
}
