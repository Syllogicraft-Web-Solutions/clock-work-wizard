<?php 

/** USERS LIST */
function add_datatables_script_css() {
     ?>
          <script src="<?= base_url('public/assets/dataTables/dataTables.js') ?>"></script>
          <link rel="stylesheet" type="text/css" href="<?= base_url('public/assets/dataTables/dataTables.css') ?>">
     <?php
}
if (is_logged_in())
     add_action('head.do_content', 'add_datatables_script_css');

function add_datatables_js_script() {
     ?>
          <script>
               jQuery(window).load(function() {
                    jQuery('#users-list').DataTable();
               });
          </script>
     <?php
}
if (is_logged_in())
     add_action('body.the_content', 'add_datatables_js_script');

function list_users() {
     $CI =& get_instance();
     add_action('head.do_content', 'add_datatables_script_css');
     // users.index.do_content
     // $CI->load->library('table');
     // $sql = "SELECT users.id as ID, user_meta.first_name + ' ' + user_meta.last_name as 'Name', user_meta.user_role as 'Role' 
     //      FROM users join user_meta on users.id = user_meta.user_id
     //      ";
     // if (get_user_meta('user_role', get_current_user_id()) == 'manager')
     //      $sql .= "WHERE user_meta.manager = " . get_current_user_id();
     $sql = "SELECT * FROM users";
     $query = $CI->db->query($sql);
     // echo $CI->table->generate($query);
     if ($query->result()) {
     ?>
          <table id="users-list" style="width: 100%;" class="display w3-theme-l4 w3-centered">
               <thead>
                    <?php 
                         if (get_user_meta('user_role', get_current_user_id()) == 'admin') {
                         ?> <th>ID</th> <?php
                         }
                    ?>
                    <th>Name</th>
                    <th>Role</th>
                    <?php
                         if (get_user_meta('user_role', get_current_user_id()) == 'admin') {
                         ?> <th>Manager</th> <?php
                         }
                    ?>
                    <th>Actions</th>
               </thead>
               <tbody>
               <?php foreach ($query->result() as $key => $value) { 
                    $vid = $value->id;
                    if (get_current_user_id() == $vid)
                         continue;
                         
                    if (get_user_role(get_current_user_id()) != 'admin') {
                         if (! is_user_capable_to_this_user(get_current_user_id(), $vid))
                              continue;
                    }  
               ?>
                    <tr class="">
                         <?php 
                              if (get_user_meta('user_role', get_current_user_id()) == 'admin') {
                              ?> <td><?= $value->id ?></td> <?php 
                              }
                         ?>
                         <td><?= get_user_meta('first_name', $value->id) . ' ' . get_user_meta('last_name', $value->id) ?></td>
                         <td><?= ucfirst(get_user_meta('user_role', $value->id)) ?></td>
                         <?php 
                              if (get_user_meta('user_role', get_current_user_id()) == 'admin') {
                              ?> <td>
                              <?php 
                                   if (user_meta_exists('manager', $vid))
                                        $mid = get_user_meta('manager', $vid);

                                   if (isset($mid) && ! empty($mid)) {
                                        ?>
                                        <input type="hidden"
                                        <?php
                                        $name = get_user_meta('first_name', $mid) . ' ' . get_user_meta('last_name', $mid);
                                        echo $name;
                                   }
                              ?>
                                   </td> <?php
                              }
                         ?>
                         <td>
                              <button href="#" class="w3-button w3-small w3-ripple w3-blue edit_profile" onclick="window.location = '<?= base_url('_users/edit_profile/'. $vid) ?>'" data-user-id="<?= $vid ?>"><i class="fa fa-edit"></i> Edit Profile</button>
                              <button href="#" class="w3-button w3-small w3-ripple w3-blue edit_account" onclick="window.location = '<?= base_url('_users/edit_account/'. $vid) ?>'" data-user-id="<?= $vid ?>"><i class="fa fa-edit"></i> Edit Account</button>
                              <button href="#" disabled="true" class="w3-button w3-small w3-ripple w3-red delete_user" onclick="window.location = '<?= base_url('_users/edit_account/'. $vid) ?>'" data-user-id="<?= $vid ?>"><i class="fa fa-trash"></i> Delete</button>
                         </td>
                    </tr>
               <?php } ?>
               </tbody>
          </table>

     <?php
     }
}

if (is_logged_in()) {
     if (get_user_role(get_current_user_id()) == 'admin' || get_user_role(get_current_user_id()) == 'manager')
          add_action('users.index.do_content', 'list_users');
}