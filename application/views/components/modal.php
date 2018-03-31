<div id="modal" class="w3-theme-l3" <?php do_action('modal.display_bool'); ?>>
     <div class="modal-header">
          <button class="w3-button w3-hover-orange w3-red" style="float: right;" onclick="jQuery('#modal, #overlay').fadeOut();">Close</button>
     </div>
     <div class="modal-content" style="padding: 20px;">
          <div class="modal-before-content">
               <?php
                    do_action('modal.before_do_content');
               ?>
          </div>
          <div class="modal-do-content">
               <?php
                    do_action('modal.do_content');
               ?>
          </div>
          <div class="modal-after-content">
               <?php
                    do_action('modal.after_do_content');
               ?>
          </div>
     </div>
</div>