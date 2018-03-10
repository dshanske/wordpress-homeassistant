<?php

class HA_Debugger {
	/**
	* Initialize the plugin.
	*/
	public function __construct() {
		add_filter( 'query_vars', array( $this, 'query_var' ) );
		add_action( 'parse_query', array( $this, 'parse_query' ) );
	}

	public function query_var( $vars ) {
		$vars[] = 'hadebug';
		return $vars;
	}

	public function parse_query( $wp ) {
		// check if it is a debug request or not
		if ( ! $wp->get( 'hadebug' ) ) {
			return;
		}
		$type = $wp->get( 'hadebug', 'form' );
		$name = $wp->get( 'name', 'form' );
		if ( 'form' === $type ) {
			status_header( 200 );
			self::form_header();
			self::post_form();
			self::form_footer();
			exit;
		}
		// If Not logged in, reject input
		if ( ! is_user_logged_in() ) {
			auth_redirect();
		}
		$HA = new Home_Assistant_State( $type, $name );
		header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
		status_header( 200 );
		$return = $HA->get();
		if ( ! is_wp_error( $return ) ) {
			echo wp_json_encode( $HA );
		}
		exit;
	}

	public function form_header() {
		header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
		<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<title><?php echo get_bloginfo( 'name' ); ?>  - <?php _e( 'Indieweb Post Kinds Debugger', 'homeassistant' ); ?></title> 
	   </head>
		<body>
		<header> 
		   <h3><a href="<?php echo site_url(); ?>"><?php echo get_bloginfo( 'name' ); ?></a>
		   <a href="<?php echo admin_url(); ?>">(<?php _e( 'Dashboard', 'homeassistant' ); ?>)</a></h3>
		   <hr />
		   <h1> <?php _e( 'HA Debugger', 'homeassistant' ); ?></h1>
		</header>
		<?php
	}

	public function form_footer() {
		?>
		</body>
		</html>
		<?php
	}

	public function post_form() {
		?>
	  <div>
		<form action="<?php echo site_url(); ?>/?hadebug=<?php echo $action; ?>" method="post" enctype="multipart/form-data">
		<p>
			<?php _e( 'Type:', 'homeassistant' ); ?>
			<select id="hadebug" name="hadebug">
				<?php Home_Assistant_State::type_select( '', true ); ?>
			</select>
		</p>
		<p>
			<?php _e( 'Name: ', 'homeassistant' ); ?>
		<input type=text" name="name" size="70" />
		</p>
			<input type="submit" />
	  </form>
	</div>
	<?php
	}

}
