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
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
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
define( 'AUTH_KEY',          'p@Fz D0{sPLm:ahhKW>Bq^]3<unrC>+n}@1>W7{:$mt%tc8b8+?1$f_4W=4|xZny' );
define( 'SECURE_AUTH_KEY',   '`-Q=KJJ(30)LGmO#1`jRF$1(bxt?l*,vtub pO5DFE)qBHE.Mv%R^C5m*E<d]WO]' );
define( 'LOGGED_IN_KEY',     '9b%ZF1uCm%dZ;_pej)nfN[Kao&r&;k$KUnGoyN;LCS*$#$!g kb)pFe8;di.p?t@' );
define( 'NONCE_KEY',         'pZR!F9ytLgs]g#fG1M7C7L/3p9KubLwd36 xg8XJHq~N+N5ypr.%!z~2QE^_nk*H' );
define( 'AUTH_SALT',         'YWm3f<m-b(#ho+KL(MD2np:c:wx^7MDWQ2;R$w,UeL|=NOFo7~tc$GL}:;IF]]WF' );
define( 'SECURE_AUTH_SALT',  'X.T!WLMrePm*vn^OJvnO={yz?2FLgfo!oe{>:,/|LT)71N#?}</pfO4oY~,3ILdH' );
define( 'LOGGED_IN_SALT',    '4Tljm+W(CF0$s-ajNq3+mvW)s4[&$H.Cr/^Oj32P3Bp~LE?{` 9J?mgo[oK9<la5' );
define( 'NONCE_SALT',        'sq1:aDsaX2e+>;QvM,Ah.ydV.OT1-_WJXZ:luxI7E([(S=JxRoG6U&~*8v[KL[ko' );
define( 'WP_CACHE_KEY_SALT', 'CZHb^.i6gpA1NSIxV?]pbjO$b9I(2@D1A$XigCBka*nS<,MKtvKTqnPcqqSFz.t}' );


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

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
