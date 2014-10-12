<?php
if( !is_user_logged_in() ){ die('Not Login'); exit; };
$javo_this_user = wp_get_current_user();