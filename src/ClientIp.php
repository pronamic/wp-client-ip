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

use JsonSerializable;

/**
 * Client IP
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class ClientIp implements JsonSerializable {
	/**
	 * Value.
	 *
	 * @var string
	 */
	private $value;

	/**
	 * Provider.
	 *
	 * @var object|null
	 */
	private $provider;

	/**
	 * Construct client IP object.
	 *
	 * @param string $value IP value.
	 */
	public function __construct( $value ) {
		$this->value = $value;
	}

	/**
	 * Set provider.
	 *
	 * @param object $provider Provider.
	 */
	public function set_provider( $provider ) {
		$this->provider = $provider;
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
	 * Serialize to JSON.
	 *
	 * @return mixed
	 */
	public function jsonSerialize() {
		$object = (object) array(
			'value'    => $this->value,
			'provider' => $this->provider,
		);

		return $object;
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
	 * @return self|null
	 */
	public static function get() {
		return ClientIps::get()->first();
	}
}
