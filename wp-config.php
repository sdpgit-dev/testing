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
define('DB_NAME', 'wpdemo');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '}%Ii_#A$of>AhEmzu~8jaHO2P7fDcg5j4.,N}@fim!!XO7U][Q8[`hiW:[+*_~QZ');
define('SECURE_AUTH_KEY',  'tu7f;zeANn9oTDf7K<kDPh<FqQan##=1H?n=(jh~w*soc>9k`vJvSOl8m@D7*VA$');
define('LOGGED_IN_KEY',    'Swc{z,tx$nw-LYxBy?A{qN_%ndMnB:29WG>sOn1u|KSCT$d}iVkn.}kY_r  er^=');
define('NONCE_KEY',        'lIBOAE_$%/Kk51u[DLE-109L2krKQo6@DyxiOFl(19UfFe.JD}u+i_1Na9E H$M?');
define('AUTH_SALT',        '3 s2F*Ay[|4t2.WX[4zshnL!UG(AqgMfXmg>vOs8>auLS#7^F>DJ%Z`I#e+&eRr%');
define('SECURE_AUTH_SALT', '$ZQ<de>@@?N1LoG{FqnRp`Tnd&~p?ly8NQz%apAV9GL.=|w?Fh9^ea7jws5/j+G]');
define('LOGGED_IN_SALT',   ']hRA>IrAe&bl.L$pe<AH#y)#|OJMjFHJr^cJu7&7PG<R6 $/WJ<GaMES5Pd-Nn^A');
define('NONCE_SALT',       'fA.wGG3WHIcIQQ2t4H~ft9]=VoY&~s A_8EmCcG(/Jm_bQdOS;J&h/Ul[F)8`i45');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wd_';

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
define("OTGS_DISABLE_AUTO_UPDATES", true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
