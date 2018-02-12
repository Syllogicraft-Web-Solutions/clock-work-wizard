jQuery(document).ready(function() {
     var jimbo_preloader = jQuery('.jimbo-preloader-49, .jimbo-preloader-94');
     // console.log(jimbo_preloader.length)
     jQuery(window).load(function() {
          if (jimbo_preloader.length > 0) {
               setTimeout(function() {
                    jQuery('.jimbo-preloader-49, .jimbo-preloader-94').fadeOut();
               }, 200);
          }
     });
});