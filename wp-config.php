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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wastinglight' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '[g?=JH7L2rWC|m1*IS@M$*~FD&4.t;IhhbK),iHI6#vXV6SKUy4<>~F-C%;TZrzC' );
define( 'SECURE_AUTH_KEY',  'w)|)Wh3`I2nUQuD8g:G~ +L-Zgg[>b9[$agK4B_!_]E.Y4EMJ@8 ms^~(0gN-Rlq' );
define( 'LOGGED_IN_KEY',    '=#2OUm5D.f#ZZDa7+wEj2>VVQ^jj&LpE_HZhKY*xzxP2db_8kE<WU$Ly62?N6T~7' );
define( 'NONCE_KEY',        '=m5B:hOAr@+rU1s>oCg..R;U<`H{!BpIOXr|g`l>g%K,;B;7ZpEM`AYDi:|3~0Zj' );
define( 'AUTH_SALT',        'H<LC?*!3KoIQu;#4 duE.mxG>8=~_PbAHD>w#l[}256DI$1~P(i)r<8)f UIX<ML' );
define( 'SECURE_AUTH_SALT', 'p#s`R3By5B!2mWa_<FZoJDh}EaTmXyCc4e~2isk}]fzv} (k4LFD?=93$}#xT&3P' );
define( 'LOGGED_IN_SALT',   '+6JP%F[ :>NuLGiO?i/.5y5/|vx`IOd.+8rhE=TqAZm++PIkH$SPn[9ch:uT~^|f' );
define( 'NONCE_SALT',       'UGwKs,9}I.DO`p1LYun9uR3Zl%r&D~b.Do)Zp{{3ww+C;|M8QMA[W2IvtCE62(^=' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
