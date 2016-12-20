<?php
$file_url = plugin_dir_path( __FILE__ ) . 'demo-data/';
$image_url  = plugin_dir_url( __FILE__ ) . 'previews/';
$demo_array = array(
    'main-fashion-01' => array(
        'title' 		=> 'Fashion 01',
        'tags'          => 'Fashion',
        'slider' 		=> $file_url . 'main-fashion-01.zip',
        'content' 		=> $file_url . 'data-sample.xml',
        'widget' 		=> $file_url . 'widgets.json',
        'option' 		=> $file_url . 'main-fashion-01.json',
        'preview'		=> $image_url  . 'fashion-01.jpg',
        'menu-locations'=> array(
            'main-nav' 		=> 'Primary Navigation',
            'top-nav'       => 'Top Navigation',
            'footer-nav'    => 'Footer Menu'
        ),
        'pages'			=> array(
            'page_on_front' 	=> 'Main Fashion 01',
            'page_for_posts' 	=> 'Blog'
        ),
        'demo_preset'   => 'main-fashion-01',
        'demo_url'      => 'http://oasis.la-studioweb.com/main-fashion-01'
    ),
    'main-fashion-03' => array(
        'title' 		=> 'Fashion 03',
        'tags'          => 'Fashion',
        'slider' 		=> $file_url . 'main-fashion-03.zip',
        'content' 		=> $file_url . 'data-sample.xml',
        'widget' 		=> $file_url . 'widgets.json',
        'option' 		=> $file_url . 'main-fashion-03.json',
        'preview'		=> $image_url  . 'fashion-03.jpg',
        'menu-locations'=> array(
            'main-nav' 		=> 'Primary Navigation',
            'top-nav'       => 'Top Navigation',
            'footer-nav'    => 'Footer Menu'
        ),
        'pages'			=> array(
            'page_on_front' 	=> 'Main Fashion 03',
            'page_for_posts' 	=> 'Blog'
        ),
        'demo_preset'   => 'main-fashion-03',
        'demo_url'      => 'http://oasis.la-studioweb.com/main-fashion-03'
    ),
    'main-fashion-04' => array(
        'title' 		=> 'Fashion 04',
        'tags'          => 'Fashion',
        'content' 		=> $file_url . 'data-sample.xml',
        'widget' 		=> $file_url . 'widgets.json',
        'option' 		=> $file_url . 'main-fashion-04.json',
        'preview'		=> $image_url  . 'fashion-04.jpg',
        'menu-locations'=> array(
            'main-nav' 		=> 'Primary Navigation',
            'top-nav'       => 'Top Navigation',
            'footer-nav'    => 'Footer Menu'
        ),
        'pages'			=> array(
            'page_on_front' 	=> 'Main Fashion 04',
            'page_for_posts' 	=> 'Blog'
        ),
        'demo_preset'   => 'main-fashion-04',
        'demo_url'      => 'http://oasis.la-studioweb.com/main-fashion-04'
    ),
    'main-fashion-05' => array(
        'title' 		=> 'Fashion 05',
        'tags'          => 'Fashion',
        'slider' 		=> $file_url . 'main-fashion-05.zip',
        'content' 		=> $file_url . 'data-sample.xml',
        'widget' 		=> $file_url . 'widgets.json',
        'option' 		=> $file_url . 'main-fashion-05.json',
        'preview'		=> $image_url  . 'fashion-05.jpg',
        'menu-locations'=> array(
            'main-nav' 		=> 'Primary Navigation',
            'top-nav'       => 'Top Navigation',
            'footer-nav'    => 'Footer Menu'
        ),
        'pages'			=> array(
            'page_on_front' 	=> 'Main Fashion 05',
            'page_for_posts' 	=> 'Blog'
        ),
        'demo_preset'   => 'main-fashion-05',
        'demo_url'      => 'http://oasis.la-studioweb.com/main-fashion-05'
    ),
    'main-fashion-06' => array(
        'title' 		=> 'Fashion 06',
        'tags'          => 'Fashion',
        'slider' 		=> $file_url . 'main-fashion-06.zip',
        'content' 		=> $file_url . 'data-sample.xml',
        'widget' 		=> $file_url . 'widgets.json',
        'option' 		=> $file_url . 'main-fashion-06.json',
        'preview'		=> $image_url  . 'fashion-06.jpg',
        'menu-locations'=> array(
            'main-nav' 		=> 'Menu Fashion 06',
            'top-nav'       => 'Top Navigation',
            'footer-nav'    => 'Footer Menu'
        ),
        'pages'			=> array(
            'page_on_front' 	=> 'Main Fashion 06',
            'page_for_posts' 	=> 'Blog'
        ),
        'demo_preset'   => 'main-fashion-06',
        'demo_url'      => 'http://oasis.la-studioweb.com/main-fashion-06'
    ),
    'main-electronic' => array(
        'title' 		=> 'Electronic',
        'tags'          => 'Electronic',
        'content' 		=> $file_url . 'data-sample.xml',
        'widget' 		=> $file_url . 'widgets.json',
        'option' 		=> $file_url . 'main-electronic.json',
        'preview'		=> $image_url  . 'electronic-01.jpg',
        'menu-locations'=> array(
            'main-nav' 		=> 'Main Electronic',
            'top-nav'       => 'Top Navigation',
            'footer-nav'    => 'Footer Menu'
        ),
        'pages'			=> array(
            'page_on_front' 	=> 'Main Electronic',
            'page_for_posts' 	=> 'Blog'
        ),
        'demo_preset'   => 'main-electronic',
        'demo_url'      => 'http://oasis.la-studioweb.com/main-electronic'
    ),
    'main-furniture' => array(
        'title' 		=> 'Furniture',
        'tags'          => 'Furniture',
        'slider' 		=> $file_url . 'main-furniture.zip',
        'content' 		=> $file_url . 'data-sample.xml',
        'widget' 		=> $file_url . 'widgets.json',
        'option' 		=> $file_url . 'main-electronic.json',
        'preview'		=> $image_url  . 'furniture-01.jpg',
        'menu-locations'=> array(
            'main-nav' 		=> 'Primary Navigation',
            'top-nav'       => 'Top Navigation',
            'footer-nav'    => 'Footer Menu'
        ),
        'pages'			=> array(
            'page_on_front' 	=> 'Main Furniture',
            'page_for_posts' 	=> 'Blog'
        ),
        'demo_preset'   => 'main-furniture',
        'demo_url'      => 'http://oasis.la-studioweb.com/main-furniture'
    ),
    'main-book' => array(
        'title' 		=> 'Book',
        'tags'          => 'Book',
        'slider' 		=> $file_url . 'main-book.zip',
        'content' 		=> $file_url . 'data-sample.xml',
        'widget' 		=> $file_url . 'widgets.json',
        'option' 		=> $file_url . 'main-book.json',
        'preview'		=> $image_url  . 'book-01.jpg',
        'menu-locations'=> array(
            'main-nav' 		=> 'Primary Navigation',
            'top-nav'       => 'Top Navigation',
            'footer-nav'    => 'Footer Menu'
        ),
        'pages'			=> array(
            'page_on_front' 	=> 'Main Book',
            'page_for_posts' 	=> 'Blog'
        ),
        'demo_preset'   => 'main-book',
        'demo_url'      => 'http://oasis.la-studioweb.com/main-book'
    ),
    'main-fitness' => array(
        'title' 		=> 'Gym - Fitness',
        'tags'          => 'Sport',
        'slider' 		=> $file_url . 'main-fitness.zip',
        'content' 		=> $file_url . 'data-sample.xml',
        'widget' 		=> $file_url . 'widgets.json',
        'option' 		=> $file_url . 'main-fitness.json',
        'preview'		=> $image_url  . 'fitness-01.jpg',
        'menu-locations'=> array(
            'main-nav' 		=> 'Primary Navigation',
            'top-nav'       => 'Top Navigation',
            'footer-nav'    => 'Footer Menu'
        ),
        'pages'			=> array(
            'page_on_front' 	=> 'Main Fitness',
            'page_for_posts' 	=> 'Blog'
        ),
        'demo_preset'   => 'main-fitness',
        'demo_url'      => 'http://oasis.la-studioweb.com/main-fitness'
    )
);