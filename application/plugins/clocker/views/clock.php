<?php
?>
<div id="clock">
     <div>
          <div id="time"></div>
          <div id="date">
               <span></span>
               <span></span>
               <span></span>
          </div>
     </div>
     <!-- <input type="button" value='Get Server Time' onclick="timer_function();"> -->
</div>
<script>
     timer_function()
     function Ajax() {
          var target = 'time';
          var httpxml;
          try {
               // Firefox, Opera 8.0+, Safari
               httpxml = new XMLHttpRequest();
          } catch (e) {
               // Internet Explorer
               try {
                    httpxml = new ActiveXObject("Msxml2.XMLHTTP");
               } catch (e) {
                    try {
                         httpxml = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (e) {
                         alert("Your browser does not support AJAX!");
                         return false;
                    }
               }
          }

          function stateck() {
               if(httpxml.readyState == 4) {
                    jQuery('#' + target).fadeIn(1000).html(httpxml.responseText);
               }
          }

          var url = "<?= base_url() ?>_public/get_time";
          url = url+"?sid="+Math.random();
          httpxml.onreadystatechange = stateck;
          httpxml.open("GET", url, true);
          httpxml.send(null);
          tt = timer_function();
     }

     function timer_function(id) {
          var refresh = 1000; // Refresh rate in milli seconds
          mytime = setTimeout('Ajax();', refresh);
     }
</script>