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
define( 'DB_NAME', 'kinkytee' );

/** MySQL database username */
define( 'DB_USER', 'kinkytee' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Georgije31!' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY',         'hN;f1-Fmlav4v}i(Xa5uC*~#o:T(d!CrgEX<q7l~-p`a[>Ts.}-_,nvG^Y|!Qm7y');
define('SECURE_AUTH_KEY',  'kLEF9~owZ@2b(38z|ipF`Zg-J2][&*b=P.- y+CO$;{|[{)rh/>+B-yVgJL?2tm8');
define('LOGGED_IN_KEY',    'NF0~g+,:l<C>q$Tk0%+75,stq_!Pq-cO7RzhZ`&Ks$^aAl^A8VI0$t51GT@]GyU*');
define('NONCE_KEY',        '1$GSPPoW?d]Q%8{JD:TN>(Eh=#OfIxW!@rudN*/}>keg=od=>(CCtNCLY|Q@2v<J');
define('AUTH_SALT',        'AH,PS_y:z!U,_*H]o;W=4Kj}[vyi;Tw;:,Jh00EE-yEomp(WVwIo]g%<~0K<BEp7');
define('SECURE_AUTH_SALT', '&-GA9h!=5INB<V`G}$ii>M^!cpF%Zpv><Lf>>.jaFsR|5(<Ne-DQ/hzj^`wr~P=n');
define('LOGGED_IN_SALT',   '|@JJ0@jv=ib|SFgRd[Ns0KP=g+I&Miqp[ROF9etme/YXK|mAd+Mmn)@$O>;EE&4w');
define('NONCE_SALT',       'S>g6wc|>EOS_K$04>n90P=T||!*nkhW_d&ZMZ*xspI(pE?c#mx8C)uZ`SoAov(HN');


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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

define('FS_METHOD', 'direct');
