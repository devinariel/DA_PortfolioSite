<?php

namespace Cleantalk\Variables;

use Cleantalk\ApbctWP\Escape;

/**
 * Class Server
 * Wrapper to safely get $_SERVER variables
 *
 * @usage \CleantalkSP\Variables\Server::get( $name );
 *
 * @package \CleantalkSP\Variables
 */
class Server extends ServerVariables
{
    /**
     * Gets given $_SERVER variable and save it to memory
     *
     * @param string $name
     *
     * @return mixed|string
     */
    protected function getVariable($name)
    {
        // Return from memory. From $this->server
        if (isset(static::getInstance()->variables[$name])) {
            return static::getInstance()->variables[$name];
        }

        $name = strtoupper($name);

        if ( isset($_SERVER[$name]) ) {
            $raw_value = $_SERVER[$name];
            if ($name === 'REQUEST_URI') {
                //skip default getAndSanitize to keep special symbols to decode unicode chars on REQUEST_URI
                $value = Escape::escJs(Escape::escHtml($raw_value));
            } else {
                $value = $this->getAndSanitize($raw_value);
            }
        } else {
            $value = '';
        }

        // Convert to upper case for REQUEST_METHOD
        if ( is_string($value) && $name === 'REQUEST_METHOD' ) {
            $value = strtoupper($value);
        }

        // Convert HTML chars for HTTP_USER_AGENT, HTTP_USER_AGENT, SERVER_NAME
        if ( is_string($value) && in_array($name, array('HTTP_USER_AGENT', 'HTTP_USER_AGENT', 'SERVER_NAME')) ) {
            $value = htmlspecialchars($value);
        }

        // Remember for further calls
        static::getInstance()->rememberVariable($name, $value);

        return $value;
    }

    /**
     * Checks if $_SERVER['REQUEST_URI'] contains string
     *
     * @param string $needle
     *
     * @return bool
     * @psalm-suppress PossiblyUnusedMethod
     */
    public static function inUri($needle)
    {
        return self::hasString('REQUEST_URI', $needle);
    }

    /**
     * Is the host contains the string
     *
     * @param string $needle
     *
     * @return bool
     * @psalm-suppress PossiblyUnusedMethod
     */
    public static function inHost($needle)
    {
        return self::hasString('HTTP_HOST', $needle);
    }

    /**
     * Getting domain name
     *
     * @return false|string
     * @psalm-suppress PossiblyUnusedMethod
     */
    public static function getDomain()
    {
        preg_match('@\S+\.(\S+)\/?$@', self::getString('HTTP_HOST'), $matches);

        return isset($matches[1]) ? $matches[1] : false;
    }

    /**
     * Checks if $_SERVER['REQUEST_URI'] contains string
     *
     * @param string $needle needle
     *
     * @return bool
     * @psalm-suppress PossiblyUnusedMethod
     */
    public static function inReferer($needle)
    {
        return self::hasString('HTTP_REFERER', $needle);
    }

    /**
     * Checks if the current request method is POST
     *
     * @return bool
     * @psalm-suppress PossiblyUnusedMethod
     */
    public static function isPost()
    {
        return self::get('REQUEST_METHOD') === 'POST';
    }

    /**
     * Checks if the current request method is GET
     *
     * @return bool
     * @psalm-suppress PossiblyUnusedMethod
     */
    public static function isGet()
    {
        return self::get('REQUEST_METHOD') === 'GET';
    }

    /**
     * Determines if SSL is used.
     *
     * @return bool True if SSL, otherwise false.
     * @psalm-suppress PossiblyUnusedMethod
     */
    public static function isSSL()
    {
        return self::get('HTTPS') === 'on' ||
               self::get('HTTPS') === '1' ||
               self::get('SERVER_PORT') == '443';
    }

    protected function sanitizeDefault($value)
    {
        return sanitize_textarea_field($value);
    }
}
