<form action="" method="POST">
     <div class="w3-container w3-margin">
          <label>Choose timezone</label>
          <?php echo timezone_menu($time_zone, 'w3-border-theme', 'clocker_timezone') ?><br><br>
          <div>
          <button name="save_settings" class="w3-button w3-theme-d4 w3-hover-theme">Save</button>
          </div>
     </div>
</form>