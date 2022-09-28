<?php
/**
 * Plugin Name: Maildev
 * Author: rivomanana.dev@gmail.com
 * Description: Test mail in localhost with maildev
 * Text Domain: maildev
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'MaildevPlugin.php';

if ( in_array($_SERVER['REMOTE_ADDR'], ['::1', '127.0.0.1']) ){
    add_action('phpmailer_init', [MaildevPlugin::class, 'php_mailer']);

    add_action('admin_menu', function(){
        add_options_page(
            'Maildev',
            'Maildev',
            'manage_options',
            'h3-maildev',
            [MaildevPlugin::class, 'test_email_page']
        );
    });

    add_action( 'wp_mail_failed', function ( $error ) {
        echo '<pre>', print_r($error), '</pre>', exit;
        error_log( $error->get_error_message() );
    } );

}


