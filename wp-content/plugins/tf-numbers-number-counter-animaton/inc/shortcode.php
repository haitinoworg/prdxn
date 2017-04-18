<?php

if( !class_exists( 'TF_Numbers_Shortcode' ) )
{
  class TF_Numbers_Shortcode
  {
    // global style that will be 
    // colleted in this variable
    private $css = array();
    // global index that will be 
    //used in styles array
    private $n;

    function __construct()
    {
      add_shortcode( 'tf_numbers', array( $this, 'tf_numbers_shortcode' ) );
      add_action('wp_footer', array($this,'tf_print_style'));
    }

    public function tf_numbers_shortcode( $atts )
    {
      /**
        * Call post by name extracting the $name 
        * from the shortcode previously created
        * in custom post column
        */
        extract( shortcode_atts( array(
             'tf_numbers'  => '',
             'name' => ''
          ), $atts )
        );  
        
        $n = $this->n;  
        $args = array('post_type' => 'tf_stats', 'name' => $name);
        $numbers = get_posts( $args );
        $html = '';
        $ID = $name;
        if( $numbers )
        {
          foreach( $numbers as $number )
          { 
            setup_postdata($number); 
            $rand = 'abcdefghijklmnopqrstuvwxyz';
            $ID = 'a'.$rand[rand(0,25)] . get_the_time('s');
            $vals = get_post_meta( $number->ID, '_tf_stat', true );
            $image = get_post_meta( $number->ID, '_tf_bg', true );
            $bgc = get_post_meta( $number->ID, '_tf_bgc', true );
            $bgct = get_post_meta( $number->ID, '_tf_bgct', true );
            if( !$image ) $image = $bgc;
            else $image = 'url('.$image.')';
            $user_style = '';
            $addon_style = '';
            $tc = get_post_meta( $number->ID, '_tf_tc', true );
            $ic = get_post_meta( $number->ID, '_tf_ic', true );
            $ctc = get_post_meta( $number->ID, '_tf_ctc', true );
            $nc = get_post_meta( $number->ID, '_tf_nc', true );
            $ics = get_post_meta( $number->ID, '_tf_ics', true );
            $tts = get_post_meta( $number->ID, '_tf_tts', true );
            $nbs = get_post_meta( $number->ID, '_tf_nbs', true );
            $layout = get_post_meta( $number->ID, '_tf_layout', true );
            $nmh = get_post_meta( $number->ID, '_tf_nmh', true ) ? get_post_meta( $number->ID, '_tf_nmh', true ) : '';
            $sp = get_post_meta( $number->ID, '_tf_sp', true ) ? get_post_meta( $number->ID, '_tf_sp', true ) : 80;
            $nmt = get_post_meta( $number->ID, '_tf_nmt', true ) ? 'data-nmt="'.get_post_meta( $number->ID, '_tf_nmt', true ).'"' : '';
            $nmtd = get_post_meta( $number->ID, '_tf_nmtd', true ) ? ' data-nmtd="'.get_post_meta( $number->ID, '_tf_nmtd', true ).'"' : '';
            $nma = get_post_meta( $number->ID, '_tf_nma', true ) ? 'data-nma="'.get_post_meta( $number->ID, '_tf_nma', true ).'"' : '';
            $nmad = get_post_meta( $number->ID, '_tf_nmad', true ) ? ' data-nmad="'.get_post_meta( $number->ID, '_tf_nmad', true ).'"' : '';
            $cm = get_post_meta( $number->ID, '_tf_cm', true ) ? 'data-cm="'.get_post_meta( $number->ID, '_tf_cm', true ).'"' : '';
            $cmo = get_post_meta( $number->ID, '_tf_cmo', true ) ? 'data-cmo="'.get_post_meta( $number->ID, '_tf_cmo', true ).'"' : '';
            $tvm = get_post_meta( $number->ID, '_tf_tvm', true ) ? get_post_meta( $number->ID, '_tf_tvm', true ) : '';
            $stats = $this->apply_layout($number->ID);
            //$stats = apply_filters( 'tf_layouts_order', $stats ); 

            //css
            $css = '#'.$ID.'{background: '.$image.'; background-size: cover} @media only screen and (max-width: 860px){ #'.$ID.'{background-size: cover} }';
            if( strpos($image, 'url' ) !== false ) $css .= '#'.$ID.':after{content: " ";display: block;background: rgba(0,0,0,0.57);width: 100%;height: 100%;position: absolute;top:0;left:0}';
            if( 'on' == $nmh ) $css .= '#'.$ID.' .stat, #'.$ID.'{opacity: 0}';
            if( 'on' == $bgct ) $css .= '#'.$ID.'{background: transparent} #'.$ID.':after{display: none}';
            $css .= '#'.$ID.' .stat .fa{color: '.$ic.'; font-size: '.$ics.'em} ';
            $css .= '#'.$ID.' .stat .number{color: '.$nc.'; font-size: '.$nbs.'em} ';
            $css .= '#'.$ID.' .stat .count-title{color: '.$ctc.'; font-size: '.$tts.'em; margin-bottom: 0} .stat .count-subtitle{display: block;}';
            $css .= '#'.$ID.' h3{color: '.$tc.'; margin: '.$tvm.' 0;}';

            $user_style = apply_filters( 'tf_custom_styles', $user_style );
            if( $user_style ) {
              foreach( $user_style as $style ) {
                $selector = $style['selector'];
                $values = $style['values'];
                $css .= '#'.$ID.' '.$selector.'{';
                foreach( $values as $value ) {
                  $val = get_post_meta( $number->ID, '_tf_'.$value['id'], true );
                  $prop = $value['property'];
                  $css .= $prop.':'.$val.';';
                }
                $css .= '}';
              }
            }

            $css .= apply_filters('tf_numbers_after_style', $ID, $number->ID);

            $addon_style = apply_filters( 'tf_addon_styles', $addon_style );
            if( $addon_style ) {
              foreach( $addon_style as $style ) {
                $selector = $style['selector'];
                $values = $style['values'];
                $css .= '#'.$ID.' '.$selector.'{';
                foreach( $values as $value ) {
                  $val = get_post_meta( $number->ID, '_tf_'.$value['id'], true );
                  $prop = $value['property'];
                  $css .= $prop.':'.$val.';';
                }
                $css .= '}';
              }
            }

            $this->css[$n] = $css;
            $this->n++;
            
            $html .= '<section id="'.$ID.'" class="statistics '.$layout.'" '.$nma.$nmad.$cmo.' data-sp="'.$sp.'" '.$cm.'>';

            if( isset( $number->post_title ) && $number->post_title ) {
              $html .='<h3 '.$nmt.$nmtd.'>'. apply_filters('the_title', $number->post_title) .'</h3>';
            }

            $html .= '<div class="statistics-inner">';

            foreach( $vals as $key => $value )
            {
              $nm = isset($value['_tf_nm']) ? 'data-nm="'.$value['_tf_nm'].'"' : '';
              $nd = isset($value['_tf_nd']) ? ' data-nd="'.$value['_tf_nd'].'"' : '';
              $nl = isset($value['_tf_nl']) ? ' data-nl="'.$value['_tf_nl'].'"' : '';
              $html .= '<div class="stat" '.$nm.$nd.$nl.' data-count="'. ( isset($value['_tf_number']) ? $value['_tf_number'] : 0 ) .'">';
              $html .= $this->list_stats($stats, $value);
              $html .= '</div>';
            }   
            $html .= '</div></section>';
          }
        }
        return $html;
    }

    public function list_stats($stats, $value) {
      //elements
      $cs = isset($value['cr']) ? ' '.$value['cr'] : '';
      $cs .= isset($value['crp']) ? ' '.$value['crp'] : '';
      $icon = '<span class="'. (isset($value['_tf_icon']) ? $value['_tf_icon'] : '') .'"></span>';
      $number = '<span class="number'.$cs.'"></span>';
      $title = '<span class="count-title">'. $value['_tf_title']  .'</span>';
      $sub = '';
      if( isset($value['_tf_subt']) ) $sub = '<span class="count-subtitle">'. $value['_tf_subt']  .'</span>';
      for( $g = 0; $g < count($stats); $g++ )
       { 
         if( strpos( $stats[$g], "[val]" ) !== false ) 
         { 
            $split = explode('[val]', $stats[$g]);
            $val = $split[1];
            if( isset($value[$val]) )
            {
              $stats[$g] = $split[0].$value[$val].$split[2];
            } 
            else
            {
               $stats[$g] = '';
            } 
         }
         if( $stats[$g] === 'icon' ) $stats[$g] = $icon;
         if( $stats[$g] === 'number' ) $stats[$g] = $number;
         if( $stats[$g] === 'title' ) $stats[$g] = $title;
         if( $stats[$g] === 'sub' ) $stats[$g] = $sub;
       }
      $html = '';
      foreach( $stats as $stat )
      {
        $html .= $stat;
      }

      return $html;
    }

    public function apply_layout($id) {
       $layout = get_post_meta( $id, '_tf_layout', true );
       if( 'n2' === $layout || 'n4' === $layout )
       {
         $order = array(
               0 => 'icon',
               1 => 'title',
               2 => 'number'
          );
       } 
       elseif( 'n6' === $layout )
       {
         $order =  array(
             0 => 'number',
             1 => 'icon',
             2 => 'title'
          );  
       }
       elseif( 'n7' === $layout )
       {
         $order =  array(
             1 => 'icon',
             2 => 'number',
             0 => 'title',
             3 => 'sub'
          );  
       }
       elseif( 'n8' === $layout )
       {
         $order =  array(
             0 => 'number',
             1 => 'title',
             2 => 'sub'
          );  
       }
       elseif( 'n9' === $layout )
       {
         $order =  array(
             1 => 'title',
             0 => 'number',
             2 => 'sub'
          );  
       }
       else 
       {
         $order =  array(
             0 => 'icon',
             1 => 'number',
             2 => 'title'
          );  
       }

       return apply_filters( 'tf_layouts_order', $order );
    }

    public function tf_print_style(){     
        $styles = $this->css;
        $css = '<style type="text/css">';
        foreach( $styles as $style ) {
          $css .= $style;
        }
        $css .= '</style>';

        echo $css;
    }
  }//class ends
}//if !class_exists
    
?>