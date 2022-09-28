<?php


class MaildevPlugin
{
    public static function php_mailer(\PHPMailer\PHPMailer\PHPMailer $phpmailer){
        $phpmailer->Host = 'localhost';
        $phpmailer->Port = 1025;
        $phpmailer->SMTPAuth = false;
        $phpmailer->IsSMTP();
    }

    public static function notice_wp(){
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e( 'Votre message a été envoyé!', 'maildev' ); ?></p>
        </div>
        <?php
    }

    public static function test_email_page(){
        if ( isset($_POST['_send_email_maildev']) ){
            if ( wp_verify_nonce( $_POST['_nonce'], 'maildev_send_test' ) ){
                wp_mail($_POST['to'], $_POST['subject'], $_POST['mail-content'], [
                  'From: Mail sender <sender.test@mail.com>'
                ]);
                add_action('admin_notices', [self::class, 'notice_wp']);
            }
        }
        ob_start();
        ?>
        <div class="wrap">
            <form action="" method="post">
                <input type="hidden" name="_send_email_maildev" value="mail_<?= time(); ?>">
                <input type="hidden" name="_nonce" value="<?= wp_create_nonce('maildev_send_test'); ?>">
                <div class="acf-columns-2">
                    <div class="acf-column-1">
                        <h2><?= __('Envoyer un mail de test', 'maildev') ?></h2>
                        <table class="form-table" role="presentation">
                            <tbody>
                                <tr>
                                    <th>
                                        <label for="to"><?= __('Destinataire', 'maildev') ?></label>
                                    </th>
                                    <td>
                                        <input required name="to" id="to" type="email" class="regular-text" placeholder="to@to.com">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="subject"><?= __('Sujet', 'maildev') ?></label>
                                    </th>
                                    <td>
                                        <input required name="subject" id="subject" type="text" class="regular-text" placeholder="Objet de l'email">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="mail-content"><?= __('Contenu', 'maildev') ?></label>
                                    </th>
                                    <td>
                                        <textarea required placeholder="<?= __('Saisissez quelques chose içi...', 'maildev') ?>" class="large-text" name="mail-content" id="mail-content" cols="50" rows="10"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>

                                    </th>
                                    <td>
                                        <input type="submit" class="button button-primary button-large" value="<?= __('Envoyer', 'maildev'); ?>">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }
}