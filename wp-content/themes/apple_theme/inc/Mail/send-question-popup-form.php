<?php
function send_question_popup_form()
{
    $name = sanitize_text_field($_POST['name']);
    $phone = sanitize_text_field($_POST['phone']);
    $message = empty($_POST['message']) ? 'Поле не заполнено' : sanitize_text_field($_POST['message']);

    $to = 'thedenbit2004@gmail.com';
    $subject = "Отправка с формы - Задайте вопрос";
    $headers = ['Content-Type: text/html; charset=UTF-8'];

    $message = '
        <html>
        <body style="margin: 0; padding: 0; background-color: #1e1e1e; font-family: Arial, sans-serif;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #1e1e1e; padding: 30px;">
            <tr>
                <td align="center">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 600px; background-color: #2a2a2a; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.4);">
                    <tr>
                    <td style="background-color: #111; padding: 20px 30px;">
                        <h2 style="color: #ffffff; margin: 0;">📩 Новый вопрос с сайта</h2>
                    </td>
                    </tr>
                    <tr>
                    <td style="padding: 30px;">
                        <p style="color: #bbbbbb; margin: 0 0 20px 0; font-size: 16px;">
                        <strong style="color: #ffffff;">Имя:</strong><br>
                        <span style="color: #dddddd; font-size: 18px;">' . $name . '</span>
                        </p>
                        <hr style="border: none; border-top: 1px solid #444; margin: 20px 0;">
                        <p style="color: #bbbbbb; margin: 0 0 20px 0; font-size: 16px;">
                        <strong style="color: #ffffff;">Телефон:</strong><br>
                        <span style="color: #dddddd; font-size: 18px;">' . $phone . '</span>
                        </p>
                        <hr style="border: none; border-top: 1px solid #444; margin: 20px 0;">
                        <p style="color: #bbbbbb; margin: 0 0 20px 0; font-size: 16px;">
                        <strong style="color: #ffffff;">Вопрос:</strong><br>
                        <span style="color: #dddddd; font-size: 18px;">' . $message . '</span>
                        </p>
                    </td>
                    </tr>
                    <tr>
                    <td style="background-color: #111; padding: 15px 30px; text-align: center;">
                        <p style="color: #555; font-size: 13px; margin: 0;">Это автоматическое уведомление с сайта. Пожалуйста, не отвечайте на это письмо.</p>
                    </td>
                    </tr>
                </table>
                </td>
            </tr>
            </table>
        </body>
        </html>
        ';
    if (wp_mail($to, $subject, $message, $headers)) {
        wp_send_json_success();
    } else {
        wp_send_json_error("Не удалось отправить письмо.");
    }

    wp_die();
}

add_action('wp_ajax_send_question_popup_form', 'send_question_popup_form');
add_action('wp_ajax_nopriv_send_question_popup_form', 'send_question_popup_form');