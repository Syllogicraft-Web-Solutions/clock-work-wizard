<?php
if ($endpoint == 'clocker' && ($action == 'punch-in' || $action == 'punch-out' || $action == 'break-in' || $action == 'break-out')) {
     if (isset($_GET['clocker_code']) && $_GET['clocker_code'] != '') {
          $user_id = decrypt_data($_GET['clocker_code']);
          if (is_user_exists($user_id)) {
               if ($action == 'punch-in' && (isset($_GET['clocker_code']) && $_GET['clocker_code'] != '')) {
                    echo do_action('clocker.punch-in', [$user_id]);
               } elseif ($action == 'punch-out' && (isset($_GET['clocker_code']) && $_GET['clocker_code'] != '')) {
                    echo do_action('clocker.punch-out', [$user_id]);
               } elseif ($action == 'break-in' && (isset($_GET['clocker_code']) && $_GET['clocker_code'] != '')) {
                    echo do_action('clocker.break-in', [$user_id]);
               } elseif ($action == 'break-out' && (isset($_GET['clocker_code']) && $_GET['clocker_code'] != '')) {
                    echo do_action('clocker.break-out', [$user_id]);
               } else
                    echo json_encode(false);
          } 
     } else {
          echo json_encode(['code' => '300', 'message' => 'Invalid authentication token.']);
     }
}

if ($endpoint == 'clocker' && $action == 'verify-clocker-action' && (isset($_GET['verify']) && $_GET['verify'] != '')) {
     $manager_id = decrypt_data($_GET['verify']);
     log_message('error', 'MANAGER_ID = ' . $manager_id);
     if ($manager_id != 'false') {
          $CI =& get_instance();
          if (isset($_GET['clocker_code']) && $_GET['clocker_code'] != '') {
               $bool = false;
               if (! is_user_exists(decrypt_data($_GET['clocker_code']))) {
                    echo json_encode(['code' => 403, 'message' => 'Invalid Token: Authentication failed. Please try logging in again.']);
                    return;
               } else {
                    if (is_user_exists($manager_id)) {
                         if (get_user_meta('manager', decrypt_data($_GET['clocker_code'])) == $manager_id) {
                              echo json_encode(['code' => 200, 'message' => 'Successful', 'responseText' => true]);
                              return;
                         } else {
                              echo json_encode(['code' => 403, 'message' => 'Unable to complete action. Please make sure you are scanning the code of your manager.']);
                              return;
                         }
                    } else {
                         echo json_encode(['code' => 403, 'message' => 'Code doesn\'t exists. Please try logging in again.']);
                         return;
                    }
               }
          } else
               echo json_encode(['code' => 403, 'message' => 'Auth failed: No token provided. Please try logging in again.']);
     } else
          echo json_encode(['code' => 301, 'message' => 'Unable to complete action.']);
}

if ($endpoint == 'clocker' && $action == 'get_clocker_status' && (isset($_GET['clocker_code']) && $_GET['clocker_code'] != '')) {
     $user_id = decrypt_data($_GET['clocker_code']);
     if (is_user_exists($user_id)) {
          echo json_encode(['code' => 200, 'message' => 'Successful', 'responseText' => do_action('clocker.get_clocker_status', [$user_id])]);
     } else 
          echo json_encode(['code' => 403, 'message' => 'Invalid Auth Token: Authentication failed. Please try logging in again.']);
}
/* 
if ($action == 'punch-in' && (isset($_GET['clocker_code']) && $_GET['clocker_code'] != '')) {
     $user_id = decrypt_data($_GET['clocker_code']);
     if (is_user_exists($user_id))
          echo do_action('clocker.punch-in', [$user_id]);
} elseif ($action == 'punch-out' && (isset($_GET['clocker_code']) && $_GET['clocker_code'] != '')) {
     $user_id = decrypt_data($_GET['clocker_code']);
     if (is_user_exists($user_id))
          echo do_action('clocker.punch-out', [$user_id]);
} elseif ($action == 'break-in' && (isset($_GET['clocker_code']) && $_GET['clocker_code'] != '')) {
     $user_id = decrypt_data($_GET['clocker_code']);
     if (is_user_exists($user_id))
          echo do_action('clocker.break-in', [$user_id]);
} elseif ($action == 'break-out' && (isset($_GET['clocker_code']) && $_GET['clocker_code'] != '')) {
     $user_id = decrypt_data($_GET['clocker_code']);
     if (is_user_exists($user_id))
          echo do_action('clocker.break-out', [$user_id]);
} else
     echo json_encode(false); */