<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_0');

/** MySQL database username */
define('DB_USER', 'wordpress_8');

/** MySQL database password */
define('DB_PASSWORD', 'Homebound591');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Ri1IX4X8D^)kDES7H(FwlYXg%wqo2rHmXr89BRrq12W9ZvdT&0h0@*VTa#^MZgq)');
define('SECURE_AUTH_KEY',  '04zBC%lHMb45UW@Hhx1SMpQ)mRjLppX6ZmAho!pUEaNKvu8K*7W&5gX2((fLZMXi');
define('LOGGED_IN_KEY',    'C&u(LIQjGM2vwfv#6WeNy1ccAhLX0!EJOuCUa*SeMZN6!ZFsQ3EOI)AEbbuLgg73');
define('NONCE_KEY',        '045yOlI6e3pPw5lDCOuXzMLkdW!hp(XWaa7cThTMI3YD07!HgEXaSzbQpTPJPCiD');
define('AUTH_SALT',        'V#25MjTvJi5k&iy3dQKGUrKs%qkd8f2sZAuEbh&CNEAh!EntLH&28IUt#^2g^Yu&');
define('SECURE_AUTH_SALT', 'D3VP6XLm84#rARe(Mej4oPe113gCKH!WCv8PlwUdENs@Ehrizg)fIxj)yW6MbvdK');
define('LOGGED_IN_SALT',   '*rDRXttOaS)PvP#dXJvN&koFB0lB%84h35ZXztMBxTcmeHP6FC1lqbjcXJw0ogiy');
define('NONCE_SALT',       '2Ho2mhoa!#yCdd88TUx^9Ro7)!JQy4D&KzSKQ0v6^vM^2BdD2KvQpvJpXjRktpnh');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'YTbK9_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define( 'WP_ALLOW_MULTISITE', true );

define ('FS_METHOD', 'direct');

//--- disable auto upgrade
define( 'AUTOMATIC_UPDATER_DISABLED', true );
?>
