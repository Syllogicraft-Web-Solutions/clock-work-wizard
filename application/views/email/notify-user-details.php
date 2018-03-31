<?php

     $this->load->helper('custom_string');
     $article = is_starts_with_vowel($role) ? "an" : 'a';

?>

<div>
     <p>
          Hi <i><?= $nickname ?></i>,
     </p>
     <p>
          <?= $who_added_this ?> added you as <?= $article ?> <?= $role?>.<br>
          Here's your login details, please keep this and don't share it. Feel free to change your password right away.
     </p>
     <p>
          <h5>Login credentials</h5>
          <ul style="list-style: none;">
               <li>Username: <i><?= $user_login ?></i></li>
               <li>Password: <i><?= $user_password ?></i></li>
          </ul>
     </p>
     <p>
          Regards,
          <?= $who_added_this ?>
     </p>
</div>