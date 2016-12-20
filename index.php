<?php
/*
Plugin Name:    Oasis Package Demo Data
Plugin URI:     http://la-studioweb.com/
Description:    This plugin use only for Oasis Theme
Author:         LA Studio
Author URI:     http://la-studioweb.com/
Version:        1.1
Text Domain:    la-studioweb
*/

if (!defined('ABSPATH') && !defined('OASIS_OPTION') && !defined('OASIS_CUSTOMIZE_OPTION')){
    die();
}

defined( 'LA_TEXTDOMAIN' )     or  define( 'LA_TEXTDOMAIN',     'la-studio' );

class Oasis_Data_Demo_Plugin_Class{

    private static $instance = null;

    protected $demo_data = array();

    public static function instance() {
        if ( null === static::$instance ) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    protected function __construct( ) {
        require plugin_dir_path( __FILE__ ) . 'importer/importer.php';

        if(class_exists('LaStudio_Importer')){
            LaStudio_Importer::instance();
        }
        $this->overrideFilterByQueryString();
        $this->setDemoData();
        add_action( 'plugins_loaded', array( $this, 'initDemoPageTemplate' ) );
        add_filter('oasis/filter/demo_data', array( $this, 'getDemoData' ) );
        add_shortcode('la_select_demo', array( $this, 'registerShortcodeDemoSelect'));

        add_filter('oasis/filter/getOption', array( $this, 'overrideThemeOptions' ), 11, 3 );

//        //add_filter('vc_load_default_templates', array( $this, 'vc_load_default_templates' ) );
//
        if(self::isLocal()){
            add_action( 'wp_footer', array( $this, 'renderDemoSelector' ), 1234 );
        }

        add_action('LaStudio_Importer/copy_image', array( $this, 'copyImages') );
    }

    public function copyImages(){
        if(file_exists(plugin_dir_path(__FILE__) . 'demo-data/images.zip')){
            $theme_name = sanitize_key(wp_get_theme()->get('Name'));
            $status = get_option($theme_name . '_was_copy_image');
            if(!$status){
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $destination = wp_upload_dir();
                $destination_path = $destination['basedir'];
                $unzipfile = unzip_file( plugin_dir_path(__FILE__) . 'demo-data/images.zip', $destination_path);
                if($unzipfile){
                    update_option( $theme_name . '_was_copy_image' , true );
                }
            }
        }
    }

    public function initDemoPageTemplate(){
        $this->templates = array();
        add_filter(
            'page_attributes_dropdown_pages_args',
            array( $this, 'registerDemoPageTemplates' )
        );
        add_filter(
            'wp_insert_post_data',
            array( $this, 'registerDemoPageTemplates' )
        );
        add_filter(
            'template_include',
            array( $this, 'viewDemoPageTemplates')
        );
        $this->templates = array(
            'templates/select-demo.php'     => 'Select Demo',
        );
    }

    public function registerDemoPageTemplates( $atts ) {
        $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
        $templates = wp_get_theme()->get_page_templates();
        if ( empty( $templates ) ) {
            $templates = array();
        }
        wp_cache_delete( $cache_key , 'themes');
        $templates = array_merge( $templates, $this->templates );
        wp_cache_add( $cache_key, $templates, 'themes', 1800 );
        return $atts;
    }

    public function viewDemoPageTemplates( $template ) {
        global $post;
        if (!isset($post->ID) || !isset($this->templates[get_post_meta(
                    $post->ID, '_wp_page_template', true
                )] ) ) {
            return $template;
        }
        $file = plugin_dir_path(__FILE__). get_post_meta(
                $post->ID, '_wp_page_template', true
            );
        if( file_exists( $file ) ) {
            return $file;
        }
        else {
            echo $file;
        }
        return $template;
    }

    public function getDemoData(){
        return (array) $this->demo_data;
    }

    protected function setDemoData(){
        $this->demo_data = (array) $this->getDemoDataViaPhpFile();
    }

    protected function getDemoDataViaPhpFile(){
        $demo_array = array();
        include 'demo.php';
        return $demo_array;
    }

    public function registerShortcodeDemoSelect($atts, $content = null){

        ob_start();

        $demo = $this->getDemoData();
        if(!empty($demo)){
            $filters = array();
            foreach ( $demo as $item ) {
                if( !empty($item['tags']) ) {
                    $tags = explode(',', $item['tags']);
                    foreach( $tags as $tag ){
                        $filters[sanitize_key($tag)] = $tag;
                    }
                }
            }
            $rand_id = uniqid('la-');
            ?>
            <div class="mansory-select-demo <?php echo $rand_id?>">
                <div class="la-isotope-filter-container filter-style-select-demo hide" data-isotope_container=".<?php echo $rand_id?> .la-isotope-container">
                    <div class="la-toggle-filter">All</div>
                    <ul>
                        <li class="active" data-filter="*"><a href="#">All</a></li>
                        <?php foreach ( $filters as $k => $v ) { ?>
                            <li data-filter="demo-item-<?php echo esc_attr($k)?>"><a href="#"><?php echo $v; ?></a></li>
                        <?php }?>
                    </ul>
                </div>
                <div class="demo-loop la-isotope-container grid-items xlg-grid-5-items lg-grid-4-items md-grid-3-items sm-grid-2-items xs-grid-1-items" data-item_selector=".demo-item">
                    <?php foreach ( $demo as $item ) {

                        if(isset($item['tags'])){
                            $class_filter = $item['tags'];
                            $class_filter = explode(',', $class_filter);
                            $__tmp = '';
                            foreach ($class_filter as $css){
                                $__tmp .= ' demo-item-' . sanitize_key($css);
                            }
                            $class_filter = $__tmp;
                        }else{
                            $class_filter = '';
                        }
                        ?>
                        <div class="grid-item demo-item <?php echo esc_attr($class_filter)?>">
                            <div class="demo-item-inner item-overlay-effect">
                                <div class="item-image">
                                    <a target="_blank" href="<?php echo isset($item['demo_url']) ? $item['demo_url'] : '#'; ?>">
                                        <img class="size-full" width="600" height="800" src="<?php echo esc_url($item['preview'])?>" alt="<?php echo esc_attr( $item['title'] )?>"/>
                                        <div class="item--holder"><span class="btn">View Demo</span></div>
                                    </a>
                                </div>
                                <div class="item--info">
                                    <h2 class="h4 light"><a target="_blank" href="<?php echo isset($item['demo_url']) ? $item['demo_url'] : '#'; ?>"><?php echo esc_html($item['title']) ?></a></h2>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
            <?php
        }

        return ob_get_clean();
    }

    protected function overrideFilterByQueryString(){
        $allow = array(
            'getOptionByMetadata' => array(
                'name'  => 'oasis/filter/getOptionByMetadata',
                'key'   => '',
                'value' => array(
                    25
                )
            )
        );
        if(!empty($_GET['la_filter'])){
            $la_filter = $_GET['la_filter'];
            if(!empty($allow[$la_filter]) && !empty($_GET['la_value'])){
                $filter_name = false;
                if(!empty($allow[$la_filter]['name'])){
                    $filter_name = $allow[$la_filter]['name'];
                }
                if(false !== $filter_name){
                    if(!empty($_GET['la_key']) && !empty($allow[$la_filter]['key']) && in_array($_GET['la_key'], $allow[$la_filter]['key'])){
                        add_filter($filter_name, function($value, $key){
                            if($key == $_GET['la_key']){
                                return $_GET['la_value'];
                            }
                            return $value;
                        }, 10, 2);
                    }
                    else{
                        if(!empty($allow[$la_filter]['value']) && in_array($_GET['la_value'], $allow[$la_filter]['value'])){
                            add_filter($filter_name, function($value){
                                return $_GET['la_value'];
                            }, 10, 1);
                        }
                    }
                }
            }
        }
    }

    protected function getDemoWithPreset(){
        $lists = array();
        $demo_data = $this->getDemoData();
        if(!empty($demo_data) && is_array($demo_data)){
            foreach( $demo_data as $key => $value ){
                if(!empty($value['demo_preset'])){
                    $lists[$key] = $value['demo_preset'];
                }
            }
        }
        return $lists;
    }

    public function overrideThemeOptions( $options, $option_name, $default ){

        $global_options = isset($GLOBALS['oasis_theme_options']) && !empty($GLOBALS['oasis_theme_options']) ? $GLOBALS['oasis_theme_options'] : $options;

        if(isset($_GET['_preset']) && !empty($_GET['_preset'])){
            $global_options = array_merge( $global_options, $this->getPresetDataByFileName( $_GET['_preset'] ) );
            $GLOBALS['oasis_theme_options'] = $global_options;
        }

        if(self::isLocal() && is_page() && !is_front_page()){
            $lists_preset = $this->getDemoWithPreset();
            if(!empty($lists_preset)){
                $current_demo = get_queried_object()->post_name;
                if( array_key_exists( $current_demo, $lists_preset ) ) {
                    $global_options = array_merge( $global_options, $this->getPresetDataByFileName( $lists_preset[$current_demo] ) );
                    $GLOBALS['oasis_theme_options'] = $global_options;
                }
            }
        }

        return $global_options;
    }

    protected function getPresetDataByFileName( $preset ){
        $data = array();
        if ( ( $file = plugin_dir_path(__FILE__) . "presets/{$preset}.json" ) && file_exists( $file ) ) {
            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }
            $file_contents = $wp_filesystem->get_contents( $file );
            if( !is_wp_error( $file_contents ) ) {
                $file_contents  = json_decode( $file_contents, true );
                $data           = maybe_unserialize( $file_contents );
            }
        }
        return $data;
    }

    public static function isLocal(){
        $is_local = false;
        if (isset($_SERVER['X_FORWARDED_HOST']) && !empty($_SERVER['X_FORWARDED_HOST'])) {
            $hostname = $_SERVER['X_FORWARDED_HOST'];
        } else {
            $hostname = $_SERVER['HTTP_HOST'];
        }
        if (strpos($hostname, '.la-studioweb.com') !== false ) {
            $is_local = true;
        }
        return $is_local;
    }


    public function renderDemoSelector(){

        $demo_data = $this->getDemoData();

        if(!empty($demo_data)){
            ?>
            <div id="la-demo-selector" style="right: -280px">
                <div class="demo-toggle">
                    <i class="fa-cog fa-spin"></i>
                </div>
                <div id="la-demo-selector-container" class="clearfix">
                    <div class="demo-container clearfix">
                        <div class="before-demo-selector clearfix">
                            <a class="button primary" href="https://themeforest.net/item/oasis-modern-woocommerce-theme/18401438">BUY THEME NOW!</a>
                        </div>
                        <div class="demo-selector clearfix">
                            <?php foreach($demo_data as $demo):?>
                                <a target="_blank" href="<?php echo isset($demo['demo_url']) ? $demo['demo_url'] : '#'; ?>" title="<?php echo esc_attr( str_replace(array('main ','Main '), '', $demo['title']) )?>">
                                    <span style="background-image: url(<?php echo esc_url($demo['preview'])?>)"></span>
                                    <div class="holder"><span style="background-image: url(<?php echo esc_url($demo['preview'])?>)"></span></div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="append-css-to-head hide">
                #la-demo-selector {
                    position: fixed;
                    right: 0;
                    z-index: 11;
                    top: 0;
                    bottom: 0;
                    width: 280px;
                    background-color: #fff;
                    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.1);
                    -webkit-box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.1);
                    transition: all .3s ease;
                    -webkit-transition: all .3s ease
                }
                #la-demo-selector.open {
                    right: 0!important
                }
                #la-demo-selector .demo-container {
                    padding-top: 40px
                }
                .before-demo-selector {
                    text-align: center;
                    margin-top: 20px;
                    margin-bottom: 30px
                }
                #la-demo-selector .demo-toggle {
                    position: absolute;
                    top: 15%;
                    right: 100%;
                    background-color: #fff;
                    color: #000;
                    padding: 20px;
                    font-size: 25px;
                    line-height: 1;
                    border-radius: 0 2px 2px 0;
                    cursor: pointer;
                    margin-left: 100%;
                    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.1);
                    -webkit-box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.1)
                }
                #la-demo-selector-container {
                    height: 100%;
                    overflow: hidden
                }
                #la-demo-selector-container .demo-container {
                    height: 100%;
                    overflow-x: hidden;
                    overflow-y: auto;
                    margin-right: -25px;
                    padding-right: 25px
                }
                #la-demo-selector .demo-selector {
                    padding: 0 5px;
                    width: 280px
                }
                #la-demo-selector .demo-selector a {
                    display: block;
                    width: 125px;
                    height: 140px;
                    padding: 5px 5px 40px;
                    position: relative;
                    float: left;
                    margin: 0 5px 20px;
                    background-color: #f7f8fc;
                    border: 1px solid #e1e6fa
                }
                #la-demo-selector .demo-selector a:after {
                    content: attr(title);
                    text-transform: uppercase;
                    font-weight: 700;
                    display: block;
                    font-size: 12px;
                    line-height: normal;
                    text-align: center;
                    padding-top: 10px
                }
                #la-demo-selector .demo-selector a span {
                    display: block;
                    height: 100%;
                    width: 100%;
                    background-size: 100% auto
                }
                #la-demo-selector .demo-selector a .holder {
                    position: fixed;
                    top: 20%;
                    right: 280px;
                    width: 450px;
                    height: 500px;
                    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.07);
                    -webkit-box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.07);
                    background-color: #fff;
                    padding: 10px;
                    border-radius: 2px;
                    z-index: 2;
                    opacity: 0;
                    visibility: hidden;
                    margin-top: 20px
                }
                #la-demo-selector .demo-selector a:hover {
                    box-shadow: 0 0 12px 6px rgba(0, 0, 0, 0.07);
                    -webkit-box-shadow: 0 0 12px 6px rgba(0, 0, 0, 0.07)
                }
                #la-demo-selector .demo-selector a:hover .holder {
                    opacity: 1;
                    visibility: visible;
                    margin: 0;
                    transition: all .3s ease-in;
                    -webkit-transition: all .3s ease-in
                }
            </div>
            <script type="text/javascript">
                (function($) {
                    "use strict";
                    $('#la-demo-selector .demo-toggle').on('click', function(){
                        $('#la-demo-selector').toggleClass('open');
                    })
                })(jQuery);
            </script>
            <?php
        }
    }

    public static function compressText($content){
        $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
        $content = str_replace(array("\r\n", "\r", "\n", "\t", '	', '	', '	'), '', $content);
        return $content;
    }

    public function vc_load_default_templates( $templates ){

        if ( ( $file = plugin_dir_path(__FILE__) . "wpb_js_templates.json" ) && file_exists( $file ) ) {
            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }
            $data = $wp_filesystem->get_contents( $file );
            if( !is_wp_error( $data ) ) {
                return json_decode( $data, true );
            }
        }
        return $templates;
    }

    public static function writeLog($log){
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}

$oasis_demo_plugin = Oasis_Data_Demo_Plugin_Class::instance();

