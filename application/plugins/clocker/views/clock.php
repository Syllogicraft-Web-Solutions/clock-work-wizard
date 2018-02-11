<?php
?>
<!-- <div class="se-pre-con"></div> -->
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
<style>
     /* Paste this css to your style sheet file or under head tag */
/* This only works with JavaScript, 
if it's not present, don't show loader */
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('../public/assets/medias/svg/disk-94.svg') center no-repeat #fff;
}
</style>
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