<?php
/*
Plugin Name: Google Analytics
Version: 3
*/
// WordPress seems to confuse this plugin with another and notes it needs updated unless my plugin has a higher version number
// *** Find out what WordPress uses to diferentiate plugins as changing Plugin Name doesn't seem to solve this problem ***

// code within function below is from: https://analytics.google.com/analytics/web/#/a171530527w238525439p222918738/admin/tracking/tracking-code/
// IP anonymization modification from: https://developers.google.com/analytics/devguides/collection/gtagjs/ip-anonymization
function psp_add_googleanalytics() { ?>
     
<!-- Global site tag (gtag.js) - Google Analytics - IP Anonymized -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-171530527-1"></script>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){ dataLayer.push(arguments); }
  gtag('js', new Date());

  gtag( 'config', 'UA-171530527-1', { 'anonymize_ip' : true } );
</script>
 
<?php }
add_action('wp_head', 'psp_add_googleanalytics');
?>
