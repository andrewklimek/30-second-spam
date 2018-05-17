<?php
/*
Plugin Name: 30-Second Spam Comment Prevention
Description: Disables the comment submit button for 30 seconds after page load, providing a very simple layer of spam protection with no bloat (1 line of JavaScript)
Version:     0.1
Author:      Andrew J Klimek
Author URI:  
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

30 Second Spam is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
30 Second Spam is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License along with 
30 Second Spam. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/



add_action( 'pre_comment_on_post', function($id){ error_log("someone tried posting a comment on non-existing post ID $id"); });

// add_filter( 'comment_form_submit_field', 'add_30_sec_spam_code', 10, 2 );

function add_30_sec_spam_code( $submit_field, $args ) {
    
    return str_replace( 'type="submit"', 'type="submit" disabled', $submit_field )
    . "<script>setTimeout(\"document.querySelector('#{$args['id_form']} #{$args['id_submit']}').disabled=0\",5e4);</script>";

}



add_filter('comment_form_defaults', function($args){ $args['action'] = ''; return $args; });

add_filter( 'comment_form_submit_field', function( $submit_field, $args ){ return $submit_field . "<script>setTimeout(\"document.getElementById('{$args['id_form']}').action='/wp-comments-post.php'\",3e4);</script>"; }, 10, 2);

	

/*
another idea:

document.querySelector('#{$args['id_form']} textarea').addEventListener('keyup', function(e){ if (5==this.value.length) { [enable submit] } });

*/