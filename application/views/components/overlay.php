<div id="overlay" <?php echo do_action('overlay.display_bool'); ?>>
     <div class="overlay-before-content">
          <?php
               echo do_action('overlay.before_do_content');
          ?>
     </div>
     <div class="overlay-do-content">
          <?php
               echo do_action('overlay.do_content');
          ?>
     </div>
     <div class="overlay-after-content">
          <?php
               echo do_action('overlay.after_do_content');
          ?>
     </div>
</div>