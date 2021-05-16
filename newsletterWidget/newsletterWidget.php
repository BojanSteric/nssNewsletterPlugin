<?php

use Newsletter\FrontPage\NewsletterFrontPage;
use Newsletter\Subscribers\Actions\SubscribeAction;
use Subscriber\Mapper\Subscriber as SubMapper;
use Subscriber\Repository\Subscriber as SubRepository;
use Subscriber\Service\PostFormatter as SubscriberPostFormatter;

use Service\MailFormater\MailFormater as MailService;

use function Subscriber\Service\emailHash;

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
        <input class="newsletterInput" aria-label="email for newsletter" type="email" id="newsletter" name="email" placeholder="Unesite Vaš email" required>
        <input class="newsletterSubmit" type="submit" value="Prijavi se">
    </form>

    <?php
        echo $args['after_widget'];
    }
          
    
    public function subscribeToNewsletter(){
        if (SubscribeAction::subscribe($_POST)){
            wp_send_json_success([]);
        }
        wp_send_json_error([]);
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
        <p id="newsletterMesage" class="newsletterMesage"></p>
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