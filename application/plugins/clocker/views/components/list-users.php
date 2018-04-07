<?php
     $CI =& get_instance();
     add_action('head.do_content', 'add_datatables_script_css');
     $CI->load->helper('date');
     // users.index.do_content
     // $CI->load->library('table');
     // $sql = "SELECT users.id as ID, user_meta.first_name + ' ' + user_meta.last_name as 'Name', user_meta.user_role as 'Role' 
     //      FROM users join user_meta on users.id = user_meta.user_id
     //      ";
     // if (get_user_meta('user_role', get_current_user_id()) == 'manager')
     //      $sql .= "WHERE user_meta.manager = " . get_current_user_id();
     $sql = "SELECT *, clocker_records.id as rec_id FROM users JOIN clocker_records ON users.id = clocker_records.user_id
          ORDER BY rec_id DESC
     ";
     $query = $CI->db->query($sql);
     // echo $CI->table->generate($query);
     if ($query->result()) {
     ?>
          <table id="users-list" style="width: 100%;" class="display w3-theme-l4 w3-centered w3-hoverable">
               <thead>
                    <?php 
                         if (get_user_meta('user_role', get_current_user_id()) == 'admin') {
                         ?> <th>ID</th> <?php
                         }
                    ?>
                    <th>Name</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Status</th>
                    <th>Actions</th>
               </thead>
               <tbody>
               <?php foreach ($query->result() as $key => $value) { 
                    $vid = $value->id;
                    if (get_current_user_id() == $value->user_id)
                         continue;
                         
                    if (get_user_role(get_current_user_id()) != 'admin') {
                         if (! is_user_capable_to_this_user(get_current_user_id(), $vid))
                              continue;
                    }  
               ?>
                    <tr class="view-attendance-sheet" data-id="<?= $vid ?>" style="cursor: pointer;">
                         <?php 
                              if (get_user_meta('user_role', get_current_user_id()) == 'admin') {
                              ?> <td><?= $value->id ?></td> <?php 
                              }
                         ?>
                         <td><?= get_user_meta('first_name', $value->id) . ' ' . get_user_meta('last_name', $value->id) ?></td>
                         <td><?= nice_date($value->punch_in, 'l, g:i a') ?></td>
                         <td><?= nice_date($value->punch_out, 'l, g:i a') ?></td>
                         <td>
                         <?php
                              if ($value->status)
                                   echo ucfirst($value->status);
                         ?>
                         </td>
                         <td>
                         <?php if ($value->status == 'verified') { ?>
                              <button data-rec-id="<?= $value->rec_id ?>" href="#" class="unverify-button w3-button w3-small w3-ripple w3-red w3-hover-yellow" data-user-id="<?= $vid ?>"><i class="fa fa-times"></i></button>
                         <?php } else { ?>
                              <button data-rec-id="<?= $value->rec_id ?>" href="#" class="verify-button w3-button w3-small w3-ripple w3-green w3-hover-theme" data-user-id="<?= $vid ?>"><i class="fa fa-check"></i></button>
                         <?php } ?>
                         </td>
                    </tr>
               <?php } ?>
               </tbody>
          </table>
          <script>
               jQuery(document).ready(function() {
                    jQuery('button.verify-button').click(function() {
                         var rec_id = jQuery(this).attr('data-rec-id');
                         console.log(rec_id);
                         if (rec_id != '') {
                              jQuery.post('<?= base_url('mdl/clocker/verify') ?>?rec_id=' + rec_id, function(data) {
                                   console.log(data);
                                   window.location = window.location;
                              });
                         }
                    });
                    jQuery('button.unverify-button').click(function() {
                         var rec_id = jQuery(this).attr('data-rec-id');
                         console.log(rec_id);
                         if (rec_id != '') {
                              jQuery.post('<?= base_url('mdl/clocker/unverify') ?>?rec_id=' + rec_id, function(data) {
                                   console.log(data);
                                   window.location = window.location;
                              });
                         }
                    });
                    jQuery('.view-attendance-sheet').click(function() {
                         var id = jQuery(this).attr('data-id');
                         window.location = '<?= base_url('mdl/clocker/att_sheet') ?>?ucid=' + id;
                    });
               });
          </script>
     <?php
     }