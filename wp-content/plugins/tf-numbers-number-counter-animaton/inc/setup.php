<?php

if( !class_exists( 'TF_Numbers' ) )
{
  class TF_Numbers
  {
    static $version = TF_NUMBERS_VERSION;
    static $tf = TF_NUMBERS_STRING;

    protected static function hooks()
      { 
         //enqueue front-end scripts and styles 
         add_action( 'wp_enqueue_scripts', array( 'TF_Numbers', 'enqueue_scripts' ) );
         //enqueue back-end scripts and styles
         add_action( 'admin_enqueue_scripts', array( 'TF_Numbers', 'admin_enqueue_scripts' ) ); 
         add_action( 'init', array( 'TF_Numbers', 'tf_stats_init' ) );
         add_action( 'cmb2_init', array( 'TF_Numbers', 'numbers_metabox_init' ) );
         add_filter( "manage_edit-tf_stats_columns", array( 'TF_Numbers', "tf_number_post_columns" ) );
         add_action( "manage_tf_stats_posts_custom_column", array( 'TF_Numbers', "tf_number_custom_columns" ), 10, 2 );
         add_action( 'admin_head', array( 'TF_Numbers', 'collect_numbers' ) );
         //add_filter( 'post_row_actions', array( 'TF_Numbers', 'remove_view_link' ) ); Depricated
         add_action( 'add_meta_boxes', array( 'TF_Numbers', 'tf_ops_thanks' ) );
         add_action( 'admin_menu', array( 'TF_Numbers', 'replace_submit_meta_box' ) );
         add_filter( 'mce_buttons', array( 'TF_Numbers', 'register_button' ) );
         add_filter( 'mce_external_plugins', array( 'TF_Numbers', 'add_button_js' ) );
         add_action( 'plugins_loaded', array( 'TF_Numbers', 'vc_support' ) ); 
         add_action( 'admin_footer', array( 'TF_Numbers', 'tf_icons_panel' ) );
      }

      /**
      * Enqueue scripts and styles
      *
      */
      public static function enqueue_scripts()
      {     
         wp_enqueue_style( 'awesome-admin', TF_NUMBERS_DIR . 'assets/css/font-awesome.min.css', self::$version );
         wp_enqueue_style( 'tf_numbers-style', TF_NUMBERS_DIR . 'assets/css/style.css', self::$version );
         wp_enqueue_script( 'tf_numbers', TF_NUMBERS_DIR . 'assets/js/tf_numbers.js', array('jquery'), self::$version, true );
      }

      public static function admin_enqueue_scripts()
      { 
          $screen = get_current_screen(); 
          if( is_admin() && 'tf_stats' === $screen->post_type ) {
             wp_enqueue_style( 'tf-admin', TF_NUMBERS_DIR . 'assets/css/admin.css', self::$version );
             wp_enqueue_script( 'tf-admin-js', TF_NUMBERS_DIR . 'assets/js/admin.js', array('jquery'), self::$version, true );
             wp_localize_script( 'tf-admin-js', 'url', array(
                    'path' => TF_NUMBERS_DIR.'assets/images/',
                    'admin' => admin_url( 'admin-ajax.php' )
              ) ); 
          }
         ?>
          <style>
               .cmb2_select{font-family: 'FontAwesome'; font-size: 1.2em;}
              .tf_numbers.vc_element-icon,
              .mce-ico.tf_numbers {background: none;}
              .mce-ico.tf_numbers:before,
              .tf_numbers.vc_element-icon:before{font-size: 31px}
          </style>
         <?php
      }

     /**
      * Register tf numbers button
      * to tinyMCE buttons
      *
      * @since   1.4.5
      */
      public static function register_button($buttons)
      { 
        global $current_screen;
        $type = $current_screen->post_type;

        if( is_admin() )
          array_push( $buttons, 'tf_numbers' );

        return $buttons;
      }


     /**
      * Add script callback to tf numbers
      * shortcode button in tinyMCE editor
      *
      * @since   1.4.5
      */
      public static function add_button_js($plugins)
      { 
        if( is_admin() )
          $plugins['tf_numbers'] = TF_NUMBERS_DIR . 'assets/js/shortcode.js';

        return $plugins;
      }


     /**
      * Collect Stats for inclusion
      * into shortcode selection.
      *
      * @since   1.4.5
      */
      public static function collect_numbers(){
        $args = array(
          'post_type' => 'tf_stats',
          'posts_per_page' => -1
        );
         $stats = get_posts($args);
         ?>
         <script type="text/javascript">
           var names = {}; 
           <?php foreach( $stats as $stat ): ?>
           names['<?php echo $stat->post_name ?>'] = ['<?php echo $stat->post_name; ?>'];
           <?php endforeach; ?>  
         </script>
         <?php 
       } 

     /**
      * Initialize Stats custom
      * post_type
      *
      * @since   1.0.0
      */
      public static function tf_stats_init()
      { 
        $labels = array(
            'name'          => __( 'Random Numbers', 'TF' ),
            'singlular_name'   => __( 'Random Number', 'TF' ),
            'plural_name'   => __( 'Random Numbers', 'TF' ),
            'add_new'       => __('Add Numbers', 'TF'),
            'add_new_item'  => __('Add Numbers', 'TF'),
            'new_item'      => __('New Numbers', 'TF'),
            'edit_item'     => __('Edit Numbers', 'TF'),
            'all_items'     => __('All Numbers', 'TF'),
            'not_found'     => __('No Numbers found', 'TF'),
            'not_found_in_trash'  => __('No Numbers found in trash', 'TF'),
        );  
        register_post_type( 
          'tf_stats', array( 
            'labels' => $labels,
            'public'  => false,
            'supports' => array('title'),
            'rewrite' => false,
            'publicly_queriable' => false, 
            'show_ui' => true, 
            'exclude_from_search' => true,  
            'show_in_nav_menus' => false,  
            'has_archive' => false,
            'menu_icon' => 'dashicons-slides',
            'menu_position'  => 65
          )
        );  
      }

      /**
       * Create metaboxes for options
       *
       */
       public static function numbers_metabox_init()
       {
          $prefix = '_tf_';

          $hgh = new_cmb2_box( array( 
              'id' => $prefix . 'stats_box',
              'title' => __('Random Numbers', 'TF'),
              'object_types' => array( 'tf_stats' )
           ) );

          $hgh_group = $hgh->add_field( array( 
              'id'    => $prefix . 'stat',
              'type'        => 'group',
              'description' => __( 'Add/Remove New Random Number', 'TF' ),
              'options'     => array(
                  'group_title'   => __( 'Random Numbers {#}', 'cmb' ), 
                  'add_button'    => __( 'Add Another Random Number', 'cmb' ),
                  'remove_button' => __( 'Remove Random Number', 'cmb' ),
                  'sortable'      => true,
              ),
            ) 
          );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-visibility"></span> ' . __('Icon', 'TF'),
              'id'   => $prefix . 'icon',
              'type' => 'text',
              'row_classes' => 'tf_icon'
          ) );

         $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons dashicons-edit"></span> ' . __('Number', 'TF'),
              'id'   => $prefix . 'number',
              'desc' => __('Enter some number.', 'TF'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Title', 'TF'),
              'id'   => $prefix . 'title',
              'type' => 'text',
          ) );

          //custom fields
          $new_line = array();
          $new_line = apply_filters( 'tf_add_element', $new_line );
          if( !empty($new_line) && is_array( $new_line ) ) {
            foreach( $new_line as $op )
            {
              $hgh->add_group_field( $hgh_group, array(
                  'name'  => '<span class="dashicons dashicons-edit"></span> ' . __($op['name'], 'TF'),
                  'id'    => $prefix . $op['id'],
                  'type'  => $op['type'],
                  'default' => isset($op['default']) ? $op['default'] : '',
                  'options' => isset($op['options']) ? $op['options'] : ''
                ) 
              );
            }
          }

          // Hook for appending new fields to the elements
          do_action('tf_elements_reg_fields',$hgh, $hgh_group);

          $side = new_cmb2_box( array( 
              'id' => $prefix . 'side',
              'context'       => 'side',
              'priority'   => 'high',
              'title' => __('More Options', 'TF'),
              'object_types' => array( 'tf_stats' )
          ) );

          //layouts
          $layouts = array(
             0 =>  array(
               'name' => 'Layout',
                'id'   => 'layout',
                'type' => 'radio',
                'options' => array(
                    'n1' => __( '1', 'cmb2' ),
                    'n2'   => __( '2', 'cmb2' )
                 ),
             )
          );
          $layouts = apply_filters( 'tf_layouts', $layouts );
          if( !empty($layouts) && is_array( $layouts ) ) {
            foreach( $layouts as $op )
            {
              $side->add_field( array(
                  'name'  => '<span class="dashicons dashicons-edit"></span> ' . __($op['name'], 'TF'),
                  'id'    => $prefix . $op['id'],
                  'type'  => $op['type'],
                  'default' => isset($op['default']) ? $op['default'] : '',
                  'options' => isset($op['options']) ? $op['options'] : ''
              ) );
            }
          }

          $options = new_cmb2_box( array( 
              'id' => $prefix . 'stats_bg',
              'context'       => 'normal',
              'priority'   => 'core',
              'title' => __('Options', 'TF'),
              'object_types' => array( 'tf_stats' )
           ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Background Image', 'TF'),
              'id'   => $prefix . 'bg',
              'type' => 'file',
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Background Color', 'TF'),
              'id'   => $prefix . 'bgc',
              'type' => 'colorpicker',
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Use Transparent Background', 'TF'),
              'id'   => $prefix . 'bgct',
              'type' => 'checkbox',
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Section Title Color', 'TF'),
              'id'   => $prefix . 'tc',
              'type' => 'colorpicker',
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Section Title Vertical Margin', 'TF'),
              'id'   => $prefix . 'tvm',
              'type' => 'text',
              'desc' => __('Add px, em, or % with value.', 'TF')
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Icons Color', 'TF'),
              'id'   => $prefix . 'ic',
              'type' => 'colorpicker',
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Numbers Color', 'TF'),
              'id'   => $prefix . 'nc',
              'type' => 'colorpicker',
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Numbers Title Color', 'TF'),
              'id'   => $prefix . 'ctc',
              'type' => 'colorpicker',
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Numbers Size', 'TF'),
              'id'   => $prefix . 'nbs',
              'type' => 'text',
              'desc' => __('Add value that will be applied to numbers size. Value will be applied in em.', 'TF')
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Titles Size', 'TF'),
              'id'   => $prefix . 'tts',
              'type' => 'text',
              'desc' => __('Add value that will be applied to titles size. Value will be applied in em.', 'TF')
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Icons Size', 'TF'),
              'id'   => $prefix . 'ics',
              'type' => 'text',
              'desc' => __('Add value that will be applied to icons size. Value will be applied in em.', 'TF')
          ) );

          //custom options
          $new_ops = array();
          $new_ops = apply_filters( 'tf_add_options', $new_ops );
          if( !empty($new_ops) && is_array( $new_ops ) ) {
            foreach( $new_ops as $op )
            {
              $options->add_field( array(
                  'name'  => '<span class="dashicons dashicons-edit"></span> ' . __($op['name'], 'TF'),
                  'id'    => $prefix . $op['id'],
                  'type'  => $op['type'],
                  'default' => isset($op['default']) ? $op['default'] : '',
                  'options' => isset($op['options']) ? $op['options'] : '',
                  'desc' => isset($op['desc']) ? $op['desc'] : ''
              ) );
            }
          }

          // Hook for appending new option fields
          do_action('tf_add_option',$options);

          //addon backdoor ! do not modify this
          $addon = array();
          $addon = apply_filters( 'tf_addon_options', $addon );
          if( !empty($addon) && is_array( $addon ) ) {
            foreach( $addon as $op )
            {
              $options->add_field( array(
                  'name'  => '<span class="dashicons dashicons-edit"></span> ' . __($op['name'], 'TF'),
                  'id'    => $prefix . $op['id'],
                  'type'  => $op['type'],
                  'default' => isset($op['default']) ? $op['default'] : '',
                  'options' => isset($op['options']) ? $op['options'] : '',
                  'desc' => isset($op['desc']) ? $op['desc'] : ''
              ) );
            }
          }

     }  

   /**
    * Include icons menu
    *
    * @since    1.0.0
    */
    public static function tf_icons_panel() { 
      $screen = get_current_screen(); 
      if( is_admin() && 'post' === $screen->base && 'tf_stats' === $screen->post_type ) {
          $srch = '';
          $srch = apply_filters( 'tf_numbers_icon_search', $srch );
          //icons tabs
          $li = array( '<li class="active">Font-Awesome</li>' );
          $li = apply_filters( 'tf_icons_tabs', $li );
          $total = count($li);
          //tabs markup
          $ul = '<ul>';
          foreach( $li as $el ) {
            $ul .= $el;
          }
          $ul .= '</ul>';
          //tab content
          $tab  = '<div>';
          for($n = 0; $n < $total; $n++){
            if( $n === 0 ) $tab  .= '<div class="active"></div>';
            else if( $n === 1 ) $tab .= '<div>'.apply_filters( 'tf_custom_icons', '' ).'</div>';
            else $tab .= '<div></div>';
          }
          $tab .= '</div>';
          $html = '<div id="icons-wrap"><div id="icons"><i class="ic-remove">✖</i>';
          $html .= $srch;
          $html .= $ul;
          $html .= $tab;
          $html .= '</div>';     
          $html .= '<div id="size_prev">';
          $html .= '<span></span>';
          $html .= '<span></span>';
          $html .= '<span></span>';
          $html .= '</div></div>';

          echo $html; 
      }
    }

     /**
      * Add Custom Columns
      * post edit screen
      *
      */
      public static function tf_number_post_columns($cols)
      {
        $cols = array(
          'cb' => '<input type="checkbox" />',
          'title' => __('Title', 'tf'),
          'shortcode' => __('Shortcode', 'tf')
        );
        return $cols;
      }

     /**
     * custom columns callback
     *
     * @since    1.0.0
     */
      public static function tf_number_custom_columns( $column, $post_id )
      {
        switch( $column )
        {
          case 'shortcode':
            global $post;
            $name = $post->post_name;
            $shortcode = '<span style="border: solid 2px cornflowerblue; background:#fafafa; padding:2px 7px 5px; font-size:17px; line-height:40px;">[tf_numbers name="'.$name.'"]</strong>';
          echo $shortcode; 
          break;
        }
      }

      public static function replace_submit_meta_box() {
          $item = 'tf_stats';
          remove_meta_box('submitdiv', $item, 'core');
          add_meta_box('submitdiv', __('Save/Update Numbers', 'tf_numbers'), array( 'TF_Numbers', 'submit_meta_box' ), $item, 'side', 'low');
     }

     /**
      * Custom edit of default wordpress publish box callback
      * loop through each custom post type and remove default
      * submit box, replacing it with custom one that has
      * only submit button with custom text on it (add/update)
      *
      * @global $action, $post
      * @see wordpress/includes/metaboxes.php
      * @since  1.0
      *
      */ 
      public static  function submit_meta_box() {
          global $action, $post;
         
          $post_type = $post->post_type;
          $post_type_object = get_post_type_object($post_type);
          $can_publish = current_user_can($post_type_object->cap->publish_posts);
          $item = 'tf_stats';
          ?>
          <div class="submitbox" id="submitpost">
           <div id="major-publishing-actions">
           <?php
           do_action( 'post_submitbox_start' );
           ?>
           <div id="delete-action">
           <?php
           if ( current_user_can( "delete_post", $post->ID ) ) {
             if ( !EMPTY_TRASH_DAYS )
                  $delete_text = __('Delete Permanently');
             else
                  $delete_text = __('Move to Trash');
           ?>
           <a class="submitdelete deletion" href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo $delete_text; ?></a><?php
           } //if ?>
          </div>
           <div id="publishing-action">
           <span class="spinner"></span>
           <?php
           if ( !in_array( $post->post_status, array('publish', 'future', 'private') ) || 0 == $post->ID ) {
                if ( $can_publish ) : ?>
                  <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Save Numbers') ?>" />
                  <?php submit_button( sprintf( __( 'Save %' ), $item ), 'primary button-large', 'publish', false, array( 'accesskey' => 'p' ) ); ?>
           <?php   
                endif; 
           } else { ?>
                  <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Update ') . $item; ?>" />
                  <input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="<?php esc_attr_e('Update ') . $item; ?>" />
           <?php
           } //if ?>
           </div>
           <div class="clear"></div>
           </div>
           </div>
        <?php
      } //som_submit_meta_box()

      /**
      * add thanks and addons metaboxes
      *
      * @since    1.0.0
      */
      public static function tf_ops_thanks()
      {
        add_meta_box('tf_tnk', '<b style="color:indianred">Thank You For Using TF Numbers Plugin</b>', array( 'TF_Numbers', 'tf_ops_thanks_meta' ), 'tf_stats', 'normal', 'low');
        add_meta_box('tf_ad', '<b style="color:green">Advanced</b>', array( 'TF_Numbers', 'tf_advanced' ), 'tf_stats', 'side', 'core');
      }

     /**
     * Addons box in sidebar
     *
     * @since    1.2.0
     */
     public static function tf_advanced() {
          $ul = '<i style="display:block;color: brown">Make your numbers more beautiful</i>';
          $ul .= '<a target="_blank" href="http://themeflection.com/plugins/wordpress/tf-numbers/demo2.html">Demo With Addons</a>';
          $ul .= '<ul id="tf-links">';
          $ul .= '<li><a href="http://themeflection.com/forums/">' .'<i class="dashicons dashicons-sos"></i>'. __('Support') . '</a></li>';
          $ul .= '<li><a href="http://themeflection.com/docs/tf-numbers/">' .'<i class="dashicons dashicons-book"></i>'. __('Documentation') . '</a></li>';
          $ul .= '<li><a href="http://themeflection.com/docs/tf-numbers/index.html#video">' .'<i class="dashicons dashicons-video-alt3"></i>'. __('Video Tutorials') . '</a></li>';
          $ul .= '<li><a href="admin.php?edit.php?post_type=tf_stats&page=tf-addons">' .'<i class="dashicons dashicons-archive"></i>'. __('Addons', 'tf-numbers') . '</a></li>';
          $ul .= '</ul>';
          //$body = '<div id="tf-sidebar">';
          //$body .= '<div class="tf-half">';
          $body = '<img src="'.TF_NUMBERS_DIR . 'assets/images/controller.jpg'.'"/>';
          $body .= '<p class="desc"><strong class="h4">Controller Addon</strong> gives you more controlls over TF Numbers plugin. It will alow you to change numbers counting speed, unlock 4 more layouts and let you include "," comma separator for better looking numbers (like 10,000, 7,800 etc.). It also gives you an option to start counting immediatelly after page is loaded. Also get Section Padding And Margin Options and choose to show, or hide Section Title. <a target="_blank" href="http://themeflection.com/plug/controller-addon/" class="learn-more">Get It</a></p>';
          $body .= '<img src="'.TF_NUMBERS_DIR . 'assets/images/iconizer.jpg'.'"/>';
          $body .= '<p class="desc"><strong class="h4">Iconizer Addon</strong> - It makes icons more powerfull. <strong>Iconizer</strong> will let you add your own image icons to the TF Numebrs plugin icons panel. You will be able to add your icons directly from icons panel. It also includes 2 more options your custom image icons width and height, and it unlocks search field in the icons panel so you can search through your icons and built-in font-awesome icons.<a target="_blank" href="http://themeflection.com/plug/iconizer-addon/" class="learn-more">Get It</a></p>';
          $body .= '<img src="'.TF_NUMBERS_DIR . 'assets/images/parallax.jpg'.'"/>';
          $body .= '<p class="desc"><strong class="h4">Parallax Addon</strong> - Add Parallax Effect To Backgound Image. <strong>Parallax</strong> will let you add the parallax effect to the background image of your numbers section. You will have new option to enable or disable parallax image effect, and a new option to change the image\'s transparent overlay background color.<a target="_blank" href="http://themeflection.com/plug/parallax-addon/" class="learn-more">Get It</a></p>';
          //$body .= '<div><div class="tf-half">';
          $body .= '<img src="'.TF_NUMBERS_DIR . 'assets/images/animator.jpg'.'"/>';
          $body .= '<p class="desc"><strong class="h4">Animator Addon</strong> will extend the TF Numbers by allowing you to add powerful animations to the static numbers section. Add more dynamic to your website by choosing from 14 available animations. You can change animation duration and delay for each number. You can also apply animation to the numbers section title and entire section container itself.<a target="_blank" href="http://themeflection.com/plug/animator-addon/" class="learn-more">Get It</a></p>';
          $body .= '<img src="'.TF_NUMBERS_DIR . 'assets/images/currencies.jpg'.'"/>';
          $body .= '<p class="desc"><strong class="h4">Currencies Addon</strong> allows showing of currencies in 4 ways: before number, after number, in form of superscipt, or subscript. You can choose between 16 currencies. Full list of available currencies can be found on the addon\'s page.<a target="_blank" href="http://themeflection.com/plug/currencies-addon/" class="learn-more">Get It</a></p>';
          $body .= '<img src="'.TF_NUMBERS_DIR . 'assets/images/bundle.jpg'.'"/>';
          $body .= '<p class="desc"><strong style="font-size: 1.18em" class="h4">Addons Bundle</strong> <span style="font-size: 1.3em; margin: 0"><span style="color: crimson;">Save 40%</span> by getting all 4 addons for small price.</p><a target="_blank" href="http://themeflection.com/plug/tf-numbers-addons-bundle/" class="learn-more">Get It</a></span>';
          //$body .= '</div><div>';
          $html = $ul . $body;

          echo $html;
     }

     /**
     * custom metaboxes callback
     *
     * @since    1.1.0
     */
    public static function tf_ops_thanks_meta()
    {
        $html = '<div class="tnks">';
        $html .= '<p style="font-size: 1.1em;">If you like TF Numbers you can consider to support me by buying me a cup of coffee, or sharing TF Numbers on some of the available social netwoks. </p>';
        $html .= '<div class="tf-third" style="width: 30%; margin-right: 10px; display:inline-block; border: 1px solid #333;vertical-align: top;padding: 15px;background: rgb(203, 245, 217); height:145px">';
        $html .= '<h4 style="font-size:1.1em;color:#A14400;margin-top: 0">Buy Me a cup of coffee</h4>';
        $html .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="VU2F8A2SL3372">
                    <table>
                    <tr><td><input type="hidden" name="on0" value="Get me a:">Get me a:</td></tr><tr><td><select name="os0">
                      <option value="Cup Of Coffee">Cup Of Coffee $5.00 USD</option>
                      <option value="2 Cups Of Coffee">2 Cups Of Coffee $10.00 USD</option>
                      <option value="A beer :)">A beer :) $15.00 USD</option>
                    </select> </td></tr>
                    </table>
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                  </form>';
        $html .= '</div>';
        $html .= '<div class="tf-third" style="width: 30%; margin-right: 10px;padding: 15px; display:inline-block; border: 1px solid #333;vertical-align: top;background: rgb(178, 238, 243); height:145px">';
        $html .= '<h4 style="font-size:1.1em;color:#A14400;margin-top: 0">Spread The Word</h4>';
        $html .= '<p>Share TF Numbers On Social Networks:</p>';
        $html .= '<a style="padding: 5px;display:inline-block;margin-right: 10px;width: 24px;text-align:center; background: #3B5998" target="_BLANK" href="https://www.facebook.com/sharer/sharer.php?sdk=joey&u=http%3A%2F%2Fthemeflection.com%2Fplug%2Fnumber-counter-animation-wordpress-plugin%2F&display=popup&ref=plugin&src=share_button"><i class="fa fa-facebook fa-2x"  style="color: #fff"></i></a>';
        $html .= '<a style="padding: 5px;display:inline-block;margin-right: 10px; background: #00ACED" target="_BLANK" href="https://twitter.com/intent/tweet?hashtags=plugins&original_referer=http%3A%2F%2Fthemeflection.com%2Fplug%2Fnumber-counter-animation-wordpress-plugin%2F&ref_src=twsrc%5Etfw&text=Number%20Counter%20Animation%20Wordpress%20Plugin%20-%20TF_Numbers&tw_p=tweetbutton&url=http%3A%2F%2Fthemeflection.com%2Fplug%2Fnumber-counter-animation-wordpress-plugin%2F&via=aleksej"><i  style="color: #fff" class="fa fa-twitter fa-2x"></i></a>';
        $html .= '<a style="padding: 5px;display:inline-block;margin-right: 10px; background: #DD0F0E" target="_BLANK" href="https://plus.google.com/share?url=http%3A%2F%2Fthemeflection.com%2Fplug%2Fnumber-counter-animation-wordpress-plugin%2F"><i class="fa fa-google-plus fa-2x"  style="color: #fff"></i></a>';
        $html .= '</div>';
        $html .= '<div class="tf-third" style="position: relative;width: 22%;padding: 15px; display:inline-block; border: 1px solid #333;vertical-align: top;padding: 15px;background: rgb(216, 248, 178); height:145px">';
        $html .= '<h4 style="font-size:1.1em;color:#A14400;margin-top: 0">Rate/Review TF Numbers</h4>';
        $html .= '<a href="https://wordpress.org/support/view/plugin-reviews/tf-numbers-number-counter-animaton" target="_BLANK"><i style="color: #777" class="fa fa-wordpress fa-2x"></i></a>';
        $html .= '<div style="position:absolute;bottom: 5px"><i class="fa fa-star" style="color:gold"></i><i class="fa fa-star" style="color:gold"></i><i class="fa fa-star" style="color:gold"></i><i class="fa fa-star" style="color:gold"></i><i class="fa fa-star" style="color:gold"></i></div>';
        $html .= '</div>';
        $html .= '</div>';
        echo $html;
    }

    /**
    * Remove view post link from
    * post edit screen
    *
    * @param $action
    * @return $action
    * @since 1.1
    */
    public static function remove_view_link( $action )
    {
       /* DEPRICATED since 1.4.1
        * 
        unset ($action['view']);
        return $action;
        */
    }

    /**
    * Visual Composer Shortcode
    *
    * @since    1.4.8
    */
    public static function vc_support(){
      if( class_exists('WPBakeryVisualComposerAbstract') )
        require_once 'vc-shortcode.php';
    }

    /**
    * Initialize TF Numebrs
    *
    * @since    1.0.0
    */
    public static function init()
     {
       self::hooks();
     }
  }
}


?>