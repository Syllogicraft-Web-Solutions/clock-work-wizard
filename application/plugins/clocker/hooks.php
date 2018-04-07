<?php
add_filter('plugin_test.name', [$this,'alter_name'], 10);

add_action('plugin_test.log', [$this, 'log_stuff']);
add_action('clocker.clocker_menu_button', [$this, 'add_menu']);
add_action('clocker.clock', [$this, 'display_realtime_clock'], 1);
add_action('clocker.display_buttons', [$this, 'display_clocker_buttons']);
add_action('clocker.check_clocker_status', [$this, 'check_clocker_status']);

add_action('clocker.punch-in-btn', [$this, 'display_punch_in_btn']);
add_action('clocker.punch-out-btn', [$this, 'display_punch_out_btn']);
add_action('clocker.break-in-btn', [$this, 'display_break_in_btn']);
add_action('clocker.break-out-btn', [$this, 'display_break_out_btn']);

add_action('clocker.sample', [$this, 'do_punch_in']);

add_action('clocker.punch-in', [$this, 'do_punch_in']);
add_action('clocker.punch-out', [$this, 'do_punch_out']);
add_action('clocker.break-in', [$this, 'do_break_in']);
add_action('clocker.break-out', [$this, 'do_break_out']);

add_action('clocker.default_timezone', [$this, 'set_default_timezone']);
add_action('clocker.clock', [$this, 'nyea'], 10);


add_action('clocker.get_clocker_status', [$this, 'get_clocker_status']);
//add_action('hello.person', [$this,'hello_age'], 4);
//add_action('hello.person', [$this,'hello_name'], 3);
//add_action('hello.person', [$this,'hello_height'], 3);
// do_action('clocker.check_clocker_status');
do_action('clocker.clocker_menu_button');
do_action('clocker.default_timezone', ['Asia/Manila']);

/**
 * Start adding hooks here
 */
function remove_clocker_status_on_edit_profile($data) {
     if ($data == 'clocker_status')
          return 'remove';
}
add_action('users.edit_profile.filter_meta_key.remove_meta', 'remove_clocker_status_on_edit_profile');

function pre_add_button_links() {
     ?>
          <a href="<?= base_url('mdl/clocker/verification') ?>" class="w3-button w3-theme-action w3-hover-theme">Verify</a>
     <?php
}
add_action('clocker.mdl.button-links', 'pre_add_button_links');

function add_attendance_sheet_widget() {
     
}


/** Don't remove this */
// require_once(__DIR__ . '/hook-functions.php');