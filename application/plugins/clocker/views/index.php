
<div class="w3-container w3-padding">
     <h2>Clocker</h2>
<?php
     // do_action('clocker.clock');
     // do_action('clocker.display_buttons');
     extract($page['data']);
     $file = __DIR__ . '/components/qr-code.php';
     ob_start();
     include($file);
     $content = ob_get_clean();

     // $CI->load->view('components/clocker-widget');
     render_widget('clocker-widget-qrcode', 'clocker-widget-qrcode-container', "Scan QR Code", $content, '');
?>
</div>
