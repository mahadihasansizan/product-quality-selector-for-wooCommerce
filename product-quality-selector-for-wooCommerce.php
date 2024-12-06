<?php
/**
 * Plugin Name: Product Quality Selector For WooCommerce
 * Plugin URI: https://yourwebsite.com/plugins/product-quality-selector-for-woocommerce/
 * Description: Displays a dynamic dot selector on WooCommerce single product pages to show product quality. Integrates with Elementor as a widget with customizable colors and font styles.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com/
 * Text Domain: product-quality-selector-for-woocommerce
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Product_Quality_Selector_For_WooCommerce' ) ) :

class Product_Quality_Selector_For_WooCommerce {

    /**
     * Constructor to initialize the plugin
     */
    public function __construct() {
        // Load plugin textdomain
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

        // Register Custom Taxonomy: Condition
        add_action( 'init', array( __CLASS__, 'register_condition_taxonomy' ), 0 );

        // Add quality fields to product edit page
        add_action( 'woocommerce_product_options_general_product_data', array( $this, 'add_quality_fields' ) );

        // Save the quality fields
        add_action( 'woocommerce_process_product_meta', array( $this, 'save_quality_fields' ) );

        // Register shortcode
        add_shortcode( 'quality_dot_selector', array( $this, 'quality_dot_selector_shortcode' ) );

        // Enqueue frontend styles and scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );

        // Automatically display the selector on single product pages
        add_action( 'woocommerce_single_product_summary', array( $this, 'display_quality_dot_selector' ), 25 );

        // Initialize Elementor widget
        add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widget' ) );

        // Enqueue styles in Elementor's preview mode
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_elementor_preview_styles' ) );

    }

    /**
     * Load plugin textdomain for translations
     */
    public function load_textdomain() {
        load_plugin_textdomain( 'product-quality-selector-for-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Register Custom Taxonomy: Condition
     */
    public static function register_condition_taxonomy() {
        $labels = array(
            'name'                       => _x( 'Conditions', 'Taxonomy General Name', 'product-quality-selector-for-woocommerce' ),
            'singular_name'              => _x( 'Condition', 'Taxonomy Singular Name', 'product-quality-selector-for-woocommerce' ),
            'menu_name'                  => __( 'Conditions', 'product-quality-selector-for-woocommerce' ),
            'all_items'                  => __( 'All Conditions', 'product-quality-selector-for-woocommerce' ),
            'new_item_name'              => __( 'New Condition Name', 'product-quality-selector-for-woocommerce' ),
            'add_new_item'               => __( 'Add New Condition', 'product-quality-selector-for-woocommerce' ),
            'edit_item'                  => __( 'Edit Condition', 'product-quality-selector-for-woocommerce' ),
            'update_item'                => __( 'Update Condition', 'product-quality-selector-for-woocommerce' ),
            'view_item'                  => __( 'View Condition', 'product-quality-selector-for-woocommerce' ),
            'separate_items_with_commas' => __( 'Separate conditions with commas', 'product-quality-selector-for-woocommerce' ),
            'add_or_remove_items'        => __( 'Add or remove conditions', 'product-quality-selector-for-woocommerce' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'product-quality-selector-for-woocommerce' ),
            'popular_items'              => __( 'Popular Conditions', 'product-quality-selector-for-woocommerce' ),
            'search_items'               => __( 'Search Conditions', 'product-quality-selector-for-woocommerce' ),
            'not_found'                  => __( 'Not Found', 'product-quality-selector-for-woocommerce' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false, // Set to true if you want it to behave like categories
            'public'                     => false,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
        );
        register_taxonomy( 'condition', array( 'product' ), $args );
    }

    /**
     * Plugin Activation Hook
     */
    public static function activate() {
        // Ensure the taxonomy is registered before adding terms
        self::register_condition_taxonomy();

        // Flush rewrite rules to register the taxonomy
        flush_rewrite_rules();

        // Define default conditions
        $default_conditions = array( 'Good', 'Very Good', 'Excellent', 'Pristine', 'New' );

        foreach( $default_conditions as $condition ) {
            // Check if the term already exists to avoid duplicates
            if( ! term_exists( $condition, 'condition' ) ) {
                wp_insert_term( $condition, 'condition' );
            }
        }
    }

    /**
     * Add Quality and Enable Fields to Product General Tab
     */
    public function add_quality_fields() {
        echo '<div class="options_group">';

        // Enable Quality Selector Checkbox
        woocommerce_wp_checkbox( array(
            'id'            => '_enable_quality_selector',
            'label'         => __( 'Enable Quality Selector', 'product-quality-selector-for-woocommerce' ),
            'description'   => __( 'Check to display the quality selector on the frontend.', 'product-quality-selector-for-woocommerce' ),
        ) );

        // Product Quality Taxonomy Select Field
        $terms = get_terms( array(
            'taxonomy'   => 'condition',
            'hide_empty' => false,
        ) );

        $options = array( '' => __( 'Select Condition', 'product-quality-selector-for-woocommerce' ) );
        if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
            foreach ( $terms as $term ) {
                $options[ $term->term_id ] = $term->name;
            }
        } else {
            $options = array( '' => __( 'No Conditions Found', 'product-quality-selector-for-woocommerce' ) );
        }

        $current_condition = get_post_meta( get_the_ID(), '_product_quality', true );

        woocommerce_wp_select( array(
            'id'          => '_product_quality',
            'label'       => __( 'Product Condition', 'product-quality-selector-for-woocommerce' ),
            'options'     => $options,
            'desc_tip'    => true,
            'description' => __( 'Select the condition of the product.', 'product-quality-selector-for-woocommerce' ),
            'value'       => $current_condition,
        ));

        echo '</div>';
    }

    /**
     * Save Quality and Enable Fields
     */
    public function save_quality_fields( $post_id ) {
        // Check if the nonce field is set
        if ( ! isset( $_POST['woocommerce_meta_nonce'] ) ) {
            return;
        }

        // Unsheath and sanitize the nonce
        $nonce = sanitize_text_field( wp_unslash( $_POST['woocommerce_meta_nonce'] ) );

        // Verify the nonce
        if ( ! wp_verify_nonce( $nonce, 'woocommerce_save_data' ) ) {
            return;
        }

        // Save Enable Quality Selector
        $enable_quality = isset( $_POST['_enable_quality_selector'] ) ? 'yes' : 'no';
        update_post_meta( $post_id, '_enable_quality_selector', sanitize_text_field( $enable_quality ) );

        // Save Product Quality (Condition Term)
        if ( isset( $_POST['_product_quality'] ) && ! empty( $_POST['_product_quality'] ) ) {
            $term_id = intval( $_POST['_product_quality'] );
            $term = get_term( $term_id, 'condition' );
            if ( ! is_wp_error( $term ) && $term ) {
                wp_set_object_terms( $post_id, (int) $term_id, 'condition', false );
                update_post_meta( $post_id, '_product_quality', $term_id );
            }
        } else {
            // Remove the term if no condition is selected
            wp_set_object_terms( $post_id, null, 'condition', false );
            delete_post_meta( $post_id, '_product_quality' );
        }
    }

    /**
     * Shortcode to Display Dot Selector
     */
    public function quality_dot_selector_shortcode() {
        if ( ! is_product() ) {
            return '';
        }

        global $post;
        $enable_quality = get_post_meta( $post->ID, '_enable_quality_selector', true );
        if ( $enable_quality !== 'yes' ) {
            return '';
        }

        // Get the condition term
        $terms = wp_get_post_terms( $post->ID, 'condition' );

        if ( empty( $terms ) || is_wp_error( $terms ) ) {
            $current_conditions = array();
        } else {
            // Assuming only one condition per product
            $current_conditions = wp_list_pluck( $terms, 'term_id' );
        }

        // Get all condition terms
        $all_terms = get_terms( array(
            'taxonomy'   => 'condition',
            'hide_empty' => false,
        ) );

        if ( is_wp_error( $all_terms ) || empty( $all_terms ) ) {
            return '<p>' . esc_html__( 'No Conditions Available.', 'product-quality-selector-for-woocommerce' ) . '</p>';
        }

        // Get Primary Label (You can make this dynamic if needed)
        $primary_label = __( 'Condition', 'product-quality-selector-for-woocommerce' );

        // Start Output Buffering
        ob_start();
        ?>

        <div class="dot-selector-wrapper">
            <?php if ( ! empty( $primary_label ) ) : ?>
                <div class="primary-label"><?php echo esc_html( $primary_label ); ?></div>
            <?php endif; ?>
            <div class="dot-selector">
                <!-- Dots -->
                <div class="dots">
                    <?php foreach ( $all_terms as $term ) : ?>
                        <?php
                            $active_class = ( in_array( $term->term_id, $current_conditions ) ) ? 'active' : '';
                            // Calculate position based on term index
                            $index = array_search( $term, $all_terms );
                            $total = count( $all_terms );
                            $left_position = ($total > 1) ? ($index / ( $total - 1 )) * 100 : 50; // Avoid division by zero
                        ?>
                        <div class="dot <?php echo esc_attr( $active_class ); ?>" data-value="<?php echo esc_attr( $term->term_id ); ?>" style="left: <?php echo esc_attr( $left_position ); ?>%;"></div>
                    <?php endforeach; ?>
                </div>

                <!-- Labels -->
                <div class="labels">
                    <?php foreach ( $all_terms as $term ) : ?>
                        <?php
                            $index = array_search( $term, $all_terms );
                            $total = count( $all_terms );
                            $left_position = ($total > 1) ? ($index / ( $total - 1 )) * 100 : 50;
                        ?>
                        <span data-value="<?php echo esc_attr( $term->term_id ); ?>" style="left: <?php echo esc_attr( $left_position ); ?>%;"><?php echo esc_html( $term->name ); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }

     /**
    * Enqueue Styles for Elementor Preview Mode
    */
    public function enqueue_elementor_preview_styles() {
    wp_enqueue_style(
        'product-quality-selector-for-woocommerce-css',
        plugin_dir_url( __FILE__ ) . 'assets/css/product-quality-selector-for-woocommerce.css',
        array(),
        '1.0.0'
         );
    }


    /**
     * Enqueue Frontend Styles and Scripts
     */
    public function enqueue_styles_scripts() {
        if ( is_product() ) {
            // Enqueue CSS
            wp_enqueue_style( 'product-quality-selector-for-woocommerce-css', plugin_dir_url( __FILE__ ) . 'assets/css/product-quality-selector-for-woocommerce.css', array(), '1.0.0' );

            // Enqueue JS if needed for future enhancements
            wp_enqueue_script( 'product-quality-selector-for-woocommerce-js', plugin_dir_url( __FILE__ ) . 'assets/js/product-quality-selector-for-woocommerce.js', array( 'jquery' ), '1.0.0', true );

            // Localize script for any future use if needed
            wp_localize_script( 'product-quality-selector-for-woocommerce-js', 'pq_selector_params', array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'    => wp_create_nonce( 'update_quality_nonce' ),
            ) );
        }
    }
    /**
     * Automatically Display Dot Selector on Single Product Pages
     */
    public function display_quality_dot_selector() {
        echo do_shortcode( '[quality_dot_selector]' );
    }

    /**
     * Register Elementor Widget
     */
    public function register_elementor_widget() {
        // Check if Elementor is active
        if ( did_action( 'elementor/loaded' ) ) {
            require_once( __DIR__ . '/includes/class-quality-dot-selector-widget.php' );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Quality_Dot_Selector_Widget() );
        }
    }

}

endif;

// Register activation hook
register_activation_hook( __FILE__, array( 'Product_Quality_Selector_For_WooCommerce', 'activate' ) );

// Initialize the plugin
new Product_Quality_Selector_For_WooCommerce();
