
<?php
if (defined('DISABLE_PRELOADER') && DISABLE_PRELOADER) {
  // Oculta por completo el preloader en entorno local
  echo '<style>.preloader-bg,#preloader{display:none!important}</style>';
  return;
}
?>
<!-- Preloader -->
<div class="preloader-bg"></div>
<div id="preloader">
    <div id="preloader-status">
        <div class="preloader-position loader"> <span></span> </div>
    </div>
</div>