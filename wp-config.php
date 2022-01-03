<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'i6916619_wp23' );

/** MySQL database username */
define( 'DB_USER', 'i6916619_wp23' );

/** MySQL database password */
define( 'DB_PASSWORD', 'I.cupBrNBeXZMSlv4em79' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define('AUTH_KEY',         'H7zCpLUdWBcqbWi01vSFGd9pF8iFVhlYNsH59X1K7myBqHUMXZloxAX4c1armtuu');
define('SECURE_AUTH_KEY',  'FupW1Z0dQyEzbHTwB57gb3PKJns0toN6heSg4AGOhkT6vjqrVzzqnpyJff3M3OIH');
define('LOGGED_IN_KEY',    'MKqCXPRFsbiYGRE1a9iPweE7j7DfbA1zPIL1SxbnMCxIpHKb1ECzku1dVMF2ub5C');
define('NONCE_KEY',        '2iXwfUd8DRBsLkJmfIjwQUB42oZJZZiq7mc2pW7NQvpos0xJ6kTnIIF75TL7WZzw');
define('AUTH_SALT',        '1GIlKJ2Pb1i0IWauHhccYmSftueFcFW34mbGVg2aCTnJgnmmFBGxQk5EAp3Q82Mo');
define('SECURE_AUTH_SALT', 'X1BnUygi2FyIb1wO0jzlhNtuFcka1S1VXeRlPJPrqmCDvVXtIMMsi4RACAJoUAR7');
define('LOGGED_IN_SALT',   'hz5vXL61bjKKVicQyIayKU25j4mXUQ87PjKvbQPEQPuybqvCOidgYx9WtJvuU7Iw');
define('NONCE_SALT',       'OEMzb79k3ayAE2K8yFsrqxlRv9oG4PbZGXwgbmyRBbf51EagCdLppP6EDyzCx3rI');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed externally by Installatron.
 * If you remove this define() to re-enable WordPress's automatic background updating
 * then it's advised to disable auto-updating in Installatron.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
define( 'SHOW_MYCRED_IN_WOOCOMMERCE', true );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
