<?php
/** 
 * Plugin Name:   Lifesize Video Conferencing Call Widget
 * Plugin URI:    TBD
 * Description:   This widget will generate an incoming call link for the Lifesize cloud service. You will need to provide your 7-digit Lifesize Video ID in the widget after you drop it into any menu.
 * Version:       1.0
 * Author:        Lifesize
 * Author URI:    https://lifesize.com
 */

// Wordpress told me to ward off attackers this way: https://codex.wordpress.org/Writing_a_Plugin#Plugin_Files
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Extend WP_Widget, which carries core wordpress Widget functionality.
 */
class Lifesize_Widget extends WP_Widget {
    /**
     * Assigns an id, title, class name, and description to our widget.
     */
    public function __construct() {
        $widget_options = array( 
            'classname' => 'lifesize-widget',
            'description' => 'Generates a "Call Me On Lifesize!" link when provided a Lifesize video number. When left blank, it will show nothing.',
        );
        parent::__construct( 'lifesize-widget', 'Lifesize Widget', $widget_options );
    }
    /**
     * Define the widget output that will be displayed on the Wordpress front end.
     */
    public function widget( $args, $instance ) {
        if(empty($instance['video_id'])) {
            return;
        }
        $lifesize_video_url = "https://call.lifesizecloud.com/extension/" . $instance[ 'video_id' ]; ?>

        <p><strong><a href="<?php echo $lifesize_video_url ?>">Call me on Lifesize!</a></strong></p>

        <?php echo $args['after_widget'];
    }
    /**
     * Add setting fields ot the widget that will be displayed in the Wordpress menu.
     */
    public function form( $instance ) {
        $title = ! empty( $instance['video_id'] ) ? $instance['video_id'] : ''; ?>
        <p>Enter your Lifesize Video address here. It should be a 7 digit number.</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'video_id' ); ?>">Lifesize Video ID:</label> 
            <input type="text" id="<?php echo $this->get_field_id( 'video_id' ); ?>" name="<?php echo $this->get_field_name( 'video_id' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
        </p><?php 
    }
    /**
     * Update our Wordpress database.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'video_id' ] = strip_tags( $new_instance[ 'video_id' ] );
        return $instance;
    }
}

/**
 * Will register our Lifesize widget.
 */
function register_lifesize_widget() { 
    register_widget( 'Lifesize_Widget' );
}
// Add our Lifesize Widget to the Widget menu.
add_action( 'widgets_init', 'register_lifesize_widget' );

?>