<?php

// http://www.wprecipes.com/how-to-display-a-custom-message-on-wordpress-registration-page
// tested on single site; not working in multisite

add_action('register_form', 'erric_register_message');
function erric_register_message() {
    $html = '
        <div style="margin:10px 0;border:1px solid #e5e5e5;padding:10px">
            <p style="margin:5px 0;">
            Joining this site you agree to the following terms. Do no harm!
            </p>
        </div>';
    echo $html;
}