<?php
// The widget class
class NewsletterWidget extends WP_Widget {
    
    function __construct() {
        parent::__construct(
          
            // Base ID of your widget
            'newsletter_widget', 
          
            // Widget name will appear in UI
            __('NSS Newsletter', ''), 
          
            // Widget description
            array( 'description' => __( 'Custom newsletter widget by Green Friends', '' ), ) 
            );
            add_action('wp_ajax_subscribeToNewsletter', [$this,'subscribeToNewsletter']);
	    add_action('wp_ajax_nopriv_subscribeToNewsletter', [$this,'subscribeToNewsletter']);
        }
          
    // Creating widget front-end
          
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
            
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
            
        // This is where you run the code and display the output
    ?>

    <form class="newsletterForma" action="" type="post">
        <input aria-label="email for newsletter" type="email" id="newsletter" name="email" placeholder="unesite svoju email adresu" required>
        <input type="submit" value="sign up">
    </form>

    <?php
        echo $args['after_widget'];
    }
          
    
    public function subscribeToNewsletter(){
	    global $wpdb;
	    $request = $_POST['request'];
	    $response = array();

	    $subscriberEmail = $_POST['email'];

	    /*$emailStatus= 'NOTCONFIRMED';
	    var_dump($subscriberEmail);
	    $createdAt=new date("Y-m-d H:i:s");
	    var_dump('uspeh2');
	    $data = array(
	            'wpUserId'=>'',
		    'email' => $subscriberEmail,
		    'emailStatus' => $emailStatus,
		    'firstName'=>'',
		    'lastName'=>'',
		    'createdAt'=> $createdAt,
            'updatedAt'=>'',
	    );
	    var_dump($data);
	    $table='wp_subscriber';
	    
	    $wpdb->insert( $table, $data,$format=null);
	    var_dump($data);*/
	    $response ="uspesno ste se prijavili";
	    echo json_encode($response);
	    wp_die();
    }


    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', '' );
        }
        // Widget admin form
    ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php 
    }
              
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }

}