# WordPress Client IP

WordPress library to retrieve the client IP address.

## To-Do

```json
ips: [
	{
		"value": "127.0.0.1",
		"source": "header",
		"header": "X-Real-IP"
	},
	{
		"ip": "127.0.0.1",
		"source": "header",
		"header": "Client-IP"
	},
	{
		"ip": "127.0.0.1",
		"source": "php",
		"server": "REMOTE_ADDR"
	}
],
ip: {
	"value": "127.0.0.1",
	"confidence": 100
}
```

## WordPress

- https://github.com/wp-pay/core/blob/2.7.0/src/Core/Util.php#L341-L386
- https://github.com/WordPress/WordPress/blob/5.7/wp-admin/includes/class-wp-community-events.php#L215-L279
- https://github.com/woocommerce/woocommerce/blob/5.3.0/includes/class-wc-geolocation.php#L75-L91
- https://github.com/easydigitaldownloads/easy-digital-downloads/blob/2.10.5/includes/misc-functions.php#L168-L205
- https://github.com/wp-premium/gravityforms/blob/2.4.20/forms_model.php#L2728-L2755

## Links

- https://github.com/Josantonius/PHP-Ip
- https://github.com/ElMijo/php-cliente-addr
- https://github.com/yogeshkoli/user-ip
- https://stackoverflow.com/questions/33268683/how-to-get-client-ip-address-in-laravel-5
- https://laravel.com/docs/8.x/requests#request-ip-address
- https://github.com/symfony/http-foundation/blob/5.4/Request.php#L806-L829
- https://stackoverflow.com/questions/1634782/what-is-the-most-accurate-way-to-retrieve-a-users-correct-ip-address-in-php
- https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Forwarded-For
- http://nginx.org/en/docs/http/ngx_http_realip_module.html
- https://www.php.net/manual/en/reserved.variables.server.php#122495
- https://support.cloudflare.com/hc/en-us/articles/200170786-Restoring-original-visitor-IPs
- https://docs.php.earth/faq/misc/ip/
