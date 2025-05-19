<?php
define( 'WP_CACHE', true );
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u948061062_daportfolio' );

/** Database username */
define( 'DB_USER', 'u948061062_thedevcode' );

/** Database password */
define( 'DB_PASSWORD', 'C0&l>sye#eh' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '!=~W_%$Q0ZS,_>*SNE=|@79*1!(_k~v0m>)%N]3 +GwJsEKVCrgfdE$;|!EB[`Xw' );
define( 'SECURE_AUTH_KEY',   'i#XA>)I`&R*F1IQd[`!}R3l<!U#5/Q3tZo8`9@Cd5QrYrr<r}/HL?a-sM1 >z)rZ' );
define( 'LOGGED_IN_KEY',     '}$nx85h!jOs{x^H^*,zMvb}q&SwD7#4!W@@hF@U.KLIgl*wx|C;%7MFUsl-4,rya' );
define( 'NONCE_KEY',         'ij1{[}uk##%02T_#g52 Sr=v^#2o&i<g>x:{0HDM_(IDAb7H~QA/ZA(UdPvu-RTl' );
define( 'AUTH_SALT',         '6j^H2yl5e8KEYhZ`$k|R*@S[}CvuTEOGS~zQrJr<dJOlKU}hfl2Z5e8O@Ju3v@wi' );
define( 'SECURE_AUTH_SALT',  '7q4i]n3I<@pqb$?8wX:?c?/8;MdtHfMwvgXijvL*wJF Pn|3L%Roc2eSYe5pkT{w' );
define( 'LOGGED_IN_SALT',    'D(Q)SR;Uf2TpR>j=!F/F{Szn|?LOa&C4rrpYr^L4mERIPBHslGCnX^GseRM~?]Q$' );
define( 'NONCE_SALT',        'S4I=SSd9A*a?-weG@w[EG+& E0lK|dC,j+]D.GGRR3l/zO~mxw5+e-VgYb{)+&pO' );
define( 'WP_CACHE_KEY_SALT', 'fR0|nFF$JM&wKQ) b8E9b^46IGg7-8rX%=M~ A`4.!L+#6H(-,}Av[XE-hab?.q~' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
