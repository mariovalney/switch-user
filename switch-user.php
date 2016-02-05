<?php
/*
Plugin Name: Switch User
Description: Switch to another user account quickly. Do not activate in production!
Version: 1.0
Author: Mário Valney
Author URI: http://www.mariovalney.com
Text Domain: switchuser
*/

function su_frontend() {
    if (is_user_logged_in()) : 
        $users = get_users(array('order_by' => 'login'));

        if (!empty($users)) : ?>
        <style type="text/css">
            .su-wrapper {
                display: block;
                position: fixed;
                top: 20%;
                right: -200px;
                width: 200px;
                background: #FFFFFF;
                z-index: 999999;
                color: #000000;
                border-top-left-radius: 10px;
                border-bottom-left-radius: 10px;
                max-height: 300px;
                overflow: visible;
                padding: 0 0 0 0;
                -webkit-transition: all 0.3s ease-in-out;
                -moz-transition: all 0.3s ease-in-out;
                -o-transition: all 0.3s ease-in-out;
                transition: all 0.3s ease-in-out;
            }

            .su-wrapper.open {
                right: 0;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            }

            .su-wrapper-toggle {
                position: absolute;
                left: -40px;
                top: 50%;
                font-size: 30px;
                width: 40px;
                height: 50px;
                text-align: center;
                background: #FFFFFF;
                border-top-left-radius: 10px;
                border-bottom-left-radius: 10px;
                margin-top: -25px;
                -webkit-transition: all 0.3s ease-in-out;
                -moz-transition: all 0.3s ease-in-out;
                -o-transition: all 0.3s ease-in-out;
                transition: all 0.3s ease-in-out;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
                cursor: pointer;
            }

            .su-wrapper-toggle:before {
                content: "<";
                line-height: 47px;
            }

            .su-wrapper.open .su-wrapper-toggle:before {
                content: ">";
            }

            .su-wrapper h1 {
                font-size: 18px;
                text-align: center;
                margin-bottom: 20px;
                color: #000;
                margin: 15px 20px 0 20px;
            }

            .su-wrapper hr {
                display: block;
            }

            .su-wrapper ul {
                display: block;
                margin: 0;
                max-height: 230px;
                padding: 0;
                overflow-y: scroll;
            }

            .su-wrapper li {
                display: block;
                padding: 5px 10px 5px 20px;
                cursor: pointer;
            }

            .su-wrapper li.current-user {
                background: #CCCCCC;
                cursor: default;
            }

            .su-wrapper li:hover {
                background: #CCCCCC;
            }

        </style>

        <div class="su-wrapper">
            <span class="su-wrapper-toggle"></span>
            <h1>Trocar usuário:</h1>
            <hr>
            <ul>
                <?php
                    foreach ($users as $user) {
                        if ($user->ID == get_current_user_id()) {
                            echo '<li class="current-user" data-user-id="' . $user->ID . '">' . $user->user_login . '</li>';    
                        } else {
                            echo '<li class="js-su-user" data-user-id="' . $user->ID . '">' . $user->user_login . '</li>';
                        }
                    }
                ?>
            </ul>
            <?php wp_nonce_field('su-change-user-nonce', 'su-change-user-security'); ?>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.js-su-user').on('click', function(event) {
                    event.preventDefault();
                    if (!$('.su-wrapper').hasClass('working')) {
                        $('.su-wrapper').addClass('working');
                        $('.su-wrapper').removeClass('open');

                        var user_id = $(this).attr('data-user-id');
                        var su_security = $('.su-wrapper').find('#su-change-user-security').val();

                        $.ajax({
                            url: "<?php echo admin_url('admin-ajax.php') ?>",
                            type: 'POST',
                            data: {action: 'su_change_user', user_id: user_id, su_nonce: su_security},
                        })
                        .done(function(data) {
                            if (data.status == 'ok') {
                                alert('Usuário alterado com sucesso.');
                                window.location.reload(true);
                            } else if (data.msg != '') {
                                alert(data.msg);
                            } else {
                                alert('Houve um erro, tente novamente.');
                            }
                        })
                        .fail(function() {
                            alert('Houve um erro de conexão, tente novamente.');
                        });
                    }
                });

                $('.su-wrapper-toggle').on('click', function(event) {
                    event.preventDefault();
                    $('.su-wrapper').toggleClass('open');
                });
            });
        </script>
    <?php endif; endif;
}
add_action('wp_footer', 'su_frontend');

// PARA O LOGIN
add_action('wp_ajax_su_change_user', 'su_change_user');
function su_change_user(){
    // Checa a referência (wp_nonce)
    check_ajax_referer('su-change-user-nonce', 'su_nonce');

    $return = array("status" => "error");

    if (isset($_POST['user_id']) && $_POST['user_id'] != '') {

        wp_set_auth_cookie($_POST['user_id']);
        $return = array("status" => "ok");

    } else {
        $return = array("status" => "error", "msg" => __("ID de usuário inválido.", LW_TEXTDOMAIN));
    }

    wp_send_json($return);
}