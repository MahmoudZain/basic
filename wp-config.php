<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'basicDB');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '*Bic8c}G>i)s0YQwO^WNK* zGUrdn^i40+OPj[k|@HV|.*An0?XUOCHo5Xc>XA2)');
define('SECURE_AUTH_KEY',  'F~&rA{n b2m8JP_y`d(<[_Kq<5}c+#tyPB_nFhxi|D!/F-HXutc|m_==Pc=3qrGv');
define('LOGGED_IN_KEY',    '.xOoEk(rW2tE7rGUPzH{BNn/K)V8x#U))+,znj*IN|+-#>|yd`*M@3K]10Hr[D*:');
define('NONCE_KEY',        ' nE[~dt@3K?@naw,O={u7AmEqgpz|`+#p |qO:|[*}ES{j7U=+jRiYap@^@2[ju]');
define('AUTH_SALT',        'JGK OIAL9fI2plM^s7hS2BV!}::[-^pXFoGB%n-+aS?c{BrJ[/ivouMA$++%leXv');
define('SECURE_AUTH_SALT', '}g7I.EX*+| +;V3T(+-([Z4,(@8|-c=KSJ+I1ou3RO[Mr~$`TXGJ5I4[5y:`WPWH');
define('LOGGED_IN_SALT',   '9-Q=0ApxC_Ok]7|So@`5Ih#HB;m+!Ga}imic/4T|ps diP(9|xVfjo`.}obu-{gN');
define('NONCE_SALT',       '(g34D`1M&&/Of=yVPvz]0S3*ywVhk fl0L>3K-KFc9|Q_!W@_=LcR>cK9FE.6[{6');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';


//define ('WPLANG', 'ar_EG');
//define ('WPLANG', 'en_US');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');


/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
