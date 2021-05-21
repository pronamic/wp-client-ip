<?php
/**
 * Client IP's
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Payments
 */

namespace Pronamic\WordPress\ClientIp;

use ArrayIterator;
use IteratorAggregate;
use JsonSerializable;

/**
 * Client IP's
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class ClientIps implements IteratorAggregate, JsonSerializable {
	/**
	 * IP's.
	 *
	 * @var array
	 */
	private $ips;

	/**
	 * Construct client IP object.
	 */
	public function __construct() {
		$this->ips = array();
	}

	/**
	 * Add.
	 *
	 * @param ClientIp $ip Client IP object.
	 */
	public function add( ClientIp $ip ) {
		$this->ips[] = $ip;
	}

	/**
	 * First IP from colelction.
	 *
	 * @return ClientIP|null
	 */
	public function first() {
		if ( \array_key_exists( 0, $this->ips ) ) {
			return $this->ips[0];
		}

		return null;
	}

	/**
	 * Get iterator.
	 *
	 * @return ArrayIterator
	 */
	public function getIterator() {
		return new ArrayIterator( $this->ips );
	}

	/**
	 * Serialize to JSON.
	 *
	 * @return mixed
	 */
	public function jsonSerialize() {
		return $this->ips;
	}

	/**
	 * Get the client IP.
	 *
	 * @return self
	 */
	public static function get() {
		$factory = Factory::get_instance();

		return $factory->get_client_ips();
	}
}
