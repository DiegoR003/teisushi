<?php include "includes/head.php"; ?>
<?php include "includes/header.php" ?>
<?php include "includes/redes.php" ?>
<?php include "includes/preloader.php"; ?>
<?php include "includes/scripts.php"; ?>

<link rel="stylesheet" href="css/plugins/owl.carousel.min.css">
<link rel="stylesheet" href="css/plugins/owl.theme.default.min.css">


<style>
   /* =====================
   MODAL DEL MENÚ - AJUSTE DE TAMAÑO
   ===================== */
.menu-modal .modal-dialog {
  max-width: 1100px;              
}

.menu-modal .modal-body {
  display: flex;
  align-items: center;
  justify-content: center;
  background: #111;               /* Fondo uniforme */
  padding: 0;
  overflow: hidden;
}

/* Carrusel ocupa todo el ancho del modal */
.menu-modal .carousel {
  width: 100%;
}

/* Imagen centrada y con proporción natural */
.menu-modal .menu-img {
  display: block;
  margin: 0 auto;
  width: auto;
  max-width: 900px;               /* Ancho máximo en escritorio */
  height: auto;
  max-height: 85vh;               /* Ocupar 85% del alto visible */
  object-fit: contain;            /* Mantiene proporción original */
  border-radius: 6px;
  transition: transform 0.3s ease;
}

/* En pantallas grandes, mejora el aprovechamiento */
@media (min-width: 1400px) {
  .menu-modal .menu-img {
    max-width: 1000px;
    max-height: 88vh;
  }
}

/* En pantallas medianas (tablets, laptops) */
@media (max-width: 991px) {
  .menu-modal .menu-img {
    max-width: 90vw;
    max-height: 80vh;
  }
}

/* En móviles: ocupa casi toda la pantalla */
@media (max-width: 576px) {
  .menu-modal .menu-img {
    max-width: 100vw;
    max-height: 88vh;
    border-radius: 0;
  }
}

/* Quita cualquier padding/margen heredado que cause “hueco blanco” */
#contacto.testimonials { padding: 0; margin: 0; }


/* Fondo tipo banner que ocupa toda la franja visible */
.contact-banner{
  position: relative;
  background-size: cover;
  background-position: center;
  background-attachment: fixed;   /* opcional; quítalo si no quieres efecto parallax */
  min-height: 100vh;               /* ocupa la altura; sube a 85-100vh si quieres más */
  display: flex;
  align-items: center;            /* centra verticalmente el contenido */
  overflow: hidden;
}

/* Overlay oscuro para legibilidad */
.contact-banner__overlay{
  position: absolute; inset: 0;
  background: rgba(0,0,0,.1);    /* equivalente a data-overlay-dark="7" */
  z-index: 0;
}

/* Asegura contenido por encima del overlay */
.contact-banner .container,
.contact-banner .row,
.contact-banner .col-lg-6 { position: relative; z-index: 1; }

/* Card del formulario (contenedor original) */
.contact-card{
  background: rgba(255,255,255,.92);
  border-radius: 1px;
  padding: 28px;
  box-shadow: 0 10px 30px rgba(0,0,0,.25);
  color: #111;
}

/* Inputs del formulario */
.contact-card .form-control{
  border-radius: 6px;
  border: 1px solid #dcdcdc;
}

.contact-banner .col-lg-6:first-child {
  margin-top: -200px; /* súbelo más o menos según necesites */
}


/* Responsivo */
@media (max-width: 991.98px){
  .contact-banner{ background-attachment: scroll; min-height: 70vh; }
  .contact-card{ max-width: 100%; }
}

/* Fondo y títulos (estilo del original) */
.bg-dark-ink { background:#171717; color:#fff; }
.moments .section-subtitle { color:#cfcfcf; letter-spacing:.15em; font-size:.8rem; }
.moments .section-title { color:#fff; }

/* Tarjeta superpuesta tipo “etiqueta + texto” */
.moments .item { position:relative; }
.moments .item img { display:block; width:100%; height:auto; }
.moments-card{
  position:relative;
  max-width: 85%;
  margin: -40px auto 0;        /* flota sobre la imagen */
  background: #efe9e3;         /* tono crema del original */
  color:#1b1b1b;
  border-radius: 4px;
  padding: 18px 22px;
  box-shadow: 0 10px 25px rgba(0,0,0,.35);
}
.moments-tag{
  display:inline-block;
  font-size:.8rem;
  letter-spacing:.2em;
  color:#7a6a58;
  text-transform:uppercase;
  margin-bottom:10px;
}

/* Owl spacing */
.moments-carousel .item { margin: 0 12px; }
.moments.section-padding { padding: 70px 0 40px; }

/* Responsive */
@media (max-width: 991.98px){
  .moments-card{ max-width: 94%; margin-top: -30px; }
}

/* ====== EFECTO ZOOM EN TARJETAS DE MOMENTOS ====== */
.moments .item {
  position: relative;
  overflow: hidden;
  border-radius: 4px;
}

.moments .item img {
  width: 100%;
  height: auto;
  transition: transform 0.8s ease, filter 0.6s ease;
  transform-origin: center;
}

/* Efecto hover: zoom y leve oscurecimiento */
.moments .item:hover img {
  transform: scale(1.08);
  filter: brightness(0.9);
}

/* Opcional: hace que la tarjeta suba un poco */
.moments .moments-card {
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}
.moments .item:hover .moments-card {
  transform: translateY(-8px);
  box-shadow: 0 12px 28px rgba(0, 0, 0, 0.4);
}

</style>

<!-- Header Banner -->
<div class="banner-header valign bg-img bg-fixed" data-overlay-dark="6" data-background="img/catering-1.jpg">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center caption mt-60">
        <h5>ENJOY THE FINEST DISHES</h5>
        <h1>Our Catering</h1>
        <a href="#contacto" class="button-1 mt-15">Book Your Event<span></span></a>
      </div>
    </div>
  </div>
</div>

<!-- BLOCK 1: Image + Text -->
<section class="section-padding">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <img src="img/catering-2.jpg" alt="Tei Sushi Catering" class="img-fluid rounded animate-on-scroll" data-anim="fadeInLeft">
      </div>
      <div class="col-lg-6">
        <h2 class="animate-on-scroll" data-anim="fadeInUp">Experience the art of Japanese cuisine with the Baja touch</h2>
        <p class="mt-3 animate-on-scroll" data-anim="fadeInUp" data-delay="100">
          Tei Sushi Catering brings the mastery of Japanese flavors, the freshest ingredients, and our distinctive presentation 
          directly to your villa, yacht, or private event. Whether it’s an intimate dinner for two or a seaside celebration, 
          our team creates an experience designed to impress.
        </p>
        <ul class="list-unstyled mt-3 animate-on-scroll" data-anim="fadeInUp" data-delay="200">
          <li>• Exclusive catering for villas, yachts, and private events.</li>
          <li>• Freshly prepared sushi made with the highest quality ingredients.</li>
          <li>• Elegant presentation and attentive service by our professional staff.</li>
          <li>• Personalized menus tailored to your celebration.</li>
        </ul>

        <p class="mt-3 animate-on-scroll" data-anim="fadeInUp" data-delay="100">
           <p class="mb-0">Additional optional services:</p>

         <li>• Non-alcoholic beverages.</li>
         <li>• Sake.</li>
         <li>• Live sushi chef.</li>
         </p>
      </div>
    </div>
  </div>
</section>

<!-- MEMORABLE MOMENTS -->
<section class="moments section-padding bg-dark-ink">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center mb-4">
        <div class="section-subtitle text-uppercase tracking-wide"> CATERING MENUS IN LOS CABOS</div>
        <h2 class="section-title display-5"> Discover three unique menus that combine authentic Japanese flavors with the spirit of Baja.</h2>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <!-- Carousel -->
        <div class="owl-carousel owl-theme moments-carousel">
          <!-- Item 1 -->
          <div class="item">
            <div class="position-re o-hidden">
              <img src="img/MENU-1.jpg" class="w-100 d-block" alt="Non-alcoholic Beverages">
            </div>
            <div class="moments-card">
              <span class="moments-tag"> CLASSIC WITH A TEI TOUCH</span>
              <h5 class="mb-0">
                A refined selection created for true sushi lovers. This menu combines crispy tempura shrimp, fresh crab, 
                and spicy tuna rolls — a balance of tradition and flavor. Perfect for private dinners, villa gatherings, or 
                relaxed yacht experiences in Los Cabos.
            </div>
          </div>

          <!-- Item 2 -->
          <div class="item">
            <div class="position-re o-hidden">
              <img src="img/MENU-2.jpg" class="w-100 d-block" alt="Sake">
            </div>
            <div class="moments-card">
              <span class="moments-tag"> LIGHT FUSION</span>
              <h5 class="mb-0">
                      A refreshing menu that blends Japanese technique with tropical flavors. Light Fusion features shrimp 
                      with yuzu, mango rolls, and tuna tostaditas — an ideal proposal to elevate any private event in Los 
                     Cabos.
            </div>
          </div>

          <!-- Item 3 -->
          <div class="item">
            <div class="position-re o-hidden">
              <img src="img/MENU-3.jpg" class="w-100 d-block" alt="Live Sushi Chef">
            </div>
            <div class="moments-card">
              <span class="moments-tag">PREMIUM TASTING</span>
              <h5 class="mb-0">
                  An elevated experience for the most discerning palates, designed to impress your guests at any private 
                  celebration in Cabo. Includes dragon roll, rainbow roll, sashimi mix, and shrimp yakimeshi.
            </div>
          </div>
        </div>
        <!-- /Carousel -->
      </div>
    </div>

    <!-- BUTTON -->
    <div class="text-center mt-4">
      <a class="button-1 mt-15" data-bs-toggle="modal" data-bs-target="#menuPdfModal">
        <i class="bi bi-menu-button-wide me-1"></i> View Full Menu
      </a>
    </div>
  </div>
</section>

<!-- MODAL -->
<div class="modal fade" id="menuPdfModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-fullscreen-md-down">
    <div class="modal-content bg-dark menu-modal">
      <div class="modal-header border-0">
        <h5 class="modal-title text-white">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-0">
        <div id="menuCarousel" class="carousel slide" data-bs-touch="true" data-bs-interval="false" data-bs-wrap="true">
          <!-- Indicators -->
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#menuCarousel" data-bs-slide-to="0" class="active" aria-label="Page 1"></button>
            <button type="button" data-bs-target="#menuCarousel" data-bs-slide-to="1" aria-label="Page 2"></button>
            <button type="button" data-bs-target="#menuCarousel" data-bs-slide-to="2" aria-label="Page 3"></button>
            <button type="button" data-bs-target="#menuCarousel" data-bs-slide-to="3" aria-label="Page 4"></button>
          </div>

          <!-- Slides -->
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="img/docs/Ing/1.jpg" alt="Menu - Page 1" class="menu-img">
            </div>
            <div class="carousel-item">
              <img src="img/docs/Ing/2.jpg" alt="Menu - Page 2" class="menu-img">
            </div>
            <div class="carousel-item">
              <img src="img/docs/Ing/3.jpg" alt="Menu - Page 3" class="menu-img">
            </div>
            <div class="carousel-item">
              <img src="img/docs/Ing/4.jpg" alt="Menu - Page 4" class="menu-img">
            </div>
          </div>

          <!-- Controls -->
          <button class="carousel-control-prev" type="button" data-bs-target="#menuCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#menuCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CONTACT / RESERVATION -->
<section id="contacto" class="testimonials contact-banner bg-img" data-background="img/banner2.jpg" data-overlay-dark="7">
  <div class="contact-banner__overlay"></div>

  <div class="container py-5">
    <div class="row align-items-center g-4">
      <!-- LEFT: Stars + text -->
      <div class="col-lg-6">
        <p class="mb-2 text-warning">
          <i class="star-rating"></i><i class="star-rating"></i>
          <i class="star-rating"></i><i class="star-rating"></i>
          <i class="star-rating"></i>
        </p>
        <h5 class="text-white mb-0" style="max-width:520px;">
          A place where elegance and sophistication come together to offer the finest experience.
        </h5>
      </div>

      <!-- RIGHT: Form inside container -->
      <div class="col-lg-6">
        <div class="contact-card">
          <h3 class="text-center text-dark mb-2">Book Your Event</h3>
          <p class="text-center text-muted mb-4">
            Send us a message and we’ll get in touch with you shortly.
          </p>

          <form class="form1 clearfix" action="/php/contact.php" method="POST">
            <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>
            <input type="text" name="tel" class="form-control mb-3" placeholder="Phone" required>
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
            <textarea name="message" class="form-control mb-3" rows="5" placeholder="Event details..." required></textarea>
            <button class="btn-form1-submit mt-15">Send</button>
          </form>

          <div class="row " style="margin-bottom: 3rem; margin-top:3rem;">
                                        <div class="col-12 col-md-12">
                                            <div class="g-recaptcha" data-sitekey="6Lf92OAfAAAAAEy9m8sf2kbU0ojkdDs5CNOnaNYS" required></div>
                                        </div>
                                    </div>

          <p class="text-center text-dark mt-3 mb-4">
            📞 WhatsApp: <a href="https://wa.me/526241237003" target="_blank">624 123 7003</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- jQuery debe cargarse antes -->
<script src="js/jquery-3.6.0.min.js"></script>

<script src="js/owl.carousel.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS complementario para animaciones / fondos -->
<script>
/* Fondo desde data-background */
document.querySelectorAll('.bg-img').forEach(el=>{
  const bg = el.getAttribute('data-background');
  if(bg) el.style.backgroundImage = 'url('+bg+')';
});
/* Overlay oscuro */
document.querySelectorAll('[data-overlay-dark]').forEach(el=>{
  const v = +el.getAttribute('data-overlay-dark') || 0;
  if(!el.querySelector('.overlay-dark')){
    const o = document.createElement('div');
    o.className='overlay-dark';
    o.style.cssText='position:absolute;inset:0;background:rgba(0,0,0,'+(v/10)+');pointer-events:none;';
    el.style.position='relative';
    el.prepend(o);
  }
});

/* Animaciones al hacer scroll (usa animate.css + waypoints) */
(function(){
  var items = document.querySelectorAll('.animate-on-scroll');
  if (!items.lIngth || typeof jQuery === 'undefined' || typeof jQuery.fn.waypoint === 'undefined') return;
  items.forEach(function(el){
    var anim = el.getAttribute('data-anim') || 'fadeInUp';
    var delay = +(el.getAttribute('data-delay')||0);
    el.style.opacity = 0;
    jQuery(el).waypoint(function(){
      setTimeout(function(){
        el.style.opacity = 1;
        el.classList.add('animated', anim);
      }, delay);
      this.destroy();
    }, { offset: '85%' });
  });
})();
</script>

<script>
// Helper: asigna el src al iframe de un slide si aún no está asignado
function loadPdfIntoSlide(slideEl, pdfUrl){
  var page = slideEl.getAttribute('data-page') || '1';
  var iframe = slideEl.querySelector('iframe.pdf-frame');
  if (iframe && !iframe.src) {
    iframe.src = pdfUrl + '#page=' + page + '&view=FitH';
  }
}

// Cuando se abre el modal, cargamos el slide activo
document.getElementById('menuPdfModal')?.addEventListener('shown.bs.modal', function () {
  var carousel = document.getElementById('menuPdfCarousel');
  if (!carousel) return;
  var pdfUrl = carousel.getAttribute('data-pdf') || 'docs/TeiSushi-MenuCatering-Esp.pdf';
  var activeSlide = carousel.querySelector('.carousel-item.active');
  if (activeSlide) loadPdfIntoSlide(activeSlide, pdfUrl);
});

// Antes/después de cambiar de slide, cargamos el siguiente si hace falta
var carouselEl = document.getElementById('menuPdfCarousel');
if (carouselEl) {
  var pdfUrl = carouselEl.getAttribute('data-pdf') || 'docs/TeiSushi-MenuCatering-Esp.pdf';
  carouselEl.addEventListener('slide.bs.carousel', function (e) {
    // e.relatedTarget = el slide al que vamos
    var nextSlide = e.relatedTarget;
    if (nextSlide) loadPdfIntoSlide(nextSlide, pdfUrl);
  });
}
</script>

<script>
  (function(){
    if (typeof jQuery === 'undefined' || !jQuery.fn.owlCarousel) return;
    jQuery('.moments-carousel').owlCarousel({
      items: 3,
      margin: 30,
      loop: true,
      dots: true,
      nav: false,
      autoplay: true,
      autoplayTimeout: 4500,
      smartSpeed: 600,
      responsive:{
        0:{ items:1, margin:12 },
        768:{ items:2 },
        1200:{ items:3 }
      }
    });
  })();
</script>


<?php include "includes/footer.php"; ?>
