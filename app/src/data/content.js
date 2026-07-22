export const content = {
  es: {
    nav: { home: 'Inicio', menu: 'Menú', catering: 'Catering', gallery: 'Galería', contact: 'Contacto' },
    hero: {
      kicker: 'Una experiencia culinaria excepcional',
      title: 'Tei Sushi',
      cta: 'Reserva en línea',
    },
    about: {
      subtitle: 'El sushi que tu paladar necesita.',
      title: 'Tei Sushi',
      p1: 'Somos un restaurante de comida asiática que te transportará a Japón a través de sus sabores únicos y auténticos. Ten por seguro que vivirás una experiencia exquisita gracias a la calidad y frescura de cada uno de nuestros ingredientes.',
      p2: 'Rodeados de una atmósfera singular, tendrás una aventura con todos tus sentidos gracias al espacio cuidadosamente decorado y por supuesto, deliciosos platillos de autor.',
      reservar: 'Reservar',
    },
    chef: {
      subtitle: '¿Estás listo para probar algo nuevo y emocionante?',
      title: 'Prueba nuestras delicias de autor',
      p: 'Si buscas un lugar para celebrar una ocasión especial o simplemente disfrutar de una comida inolvidable con amigos, Tei Sushi es el lugar ideal. Ven y descubre el verdadero sabor de Asia, donde la pasión, la creatividad y el buen gusto por la calidad gastronómica se combinan perfectamente para ofrecer lo mejor en un platillo.',
      cta: 'Reservar',
    },
    group: {
      subtitle: 'Perteneciendo ahora al',
      title: 'Grupo ALCARI',
      brands: [
        { name: 'Cocina Mexicana', img: '/img/chef/hamburger.jpg', logo: '/img/jazmin.png' },
        { name: 'Tei Sushi', img: '/img/chef/salad.jpg', logo: '/img/alcari.png' },
        { name: 'Cocina Italiana', img: '/img/chef/wine.jpg', logo: '/img/fiorenza.png' },
      ],
    },
    hours: {
      title: 'Horarios',
      from: 'Lunes',
      to: 'Domingo',
      time: '13:00 – 22:00',
      callAlso: 'También puedes llamar:',
      reservar: 'Reservar',
      address: 'Blvrd Antonio Mijares, No. 10, Col. Centro.',
    },
    testimonials: [
      {
        name: 'Octava',
        text: '¡Un lugar muy agradable y muy rico todo! Los platillos están muy bien preparados, hay rollos, ramen, platillos calientes y varias entradas, el marisco es fresco. Pedí si me podrían preparar un rollo de manera diferente y lo hicieron, muy accesibles. El lugar es bonito, tiene aire acondicionado, sillas cómodas. Buena atención.',
      },
      {
        name: 'Oscar Rodriguez Alvarez',
        text: 'Gran experiencia culinaria, buenas bebidas, buena ambientación y decoración. Un lugar completo para asistir con pareja o en familia.',
      },
      {
        name: 'Abraham Romero',
        text: 'Buen lugar para locales, precios accesibles y comida muy rica. El ambiente muy bueno, agradable.',
      },
    ],
    services: [
      { title: 'Expertos', text: 'Con un servicio excepcional vivirás tu visita con un equipo que siempre estará listo para atenderte.' },
      { title: 'Platillos', text: 'Nuestros chefs tienen la habilidad de siempre superar las expectativas.' },
      { title: 'Bebidas', text: 'Nuestra coctelería siempre te enamorará con cada sorbo lleno de sabor.' },
    ],
    news: {
      subtitle: '¿Se acerca una fecha especial?',
      title: 'Da vida a tus momentos memorables.',
      items: [
        { tag: 'Cumpleaños', text: 'Si celebras tu cumpleaños con nosotros, disfruta tu postre completamente gratis.', img: '/img/news/1.jpg' },
        { tag: 'Aniversarios', text: 'En una atmósfera romántica vive sentimientos emocionantes y llenos de amor. ¡Seremos tus cómplices!', img: '/img/news/2.jpg' },
        { tag: 'Días Especiales', text: '¿Graduaciones, San Valentín, Día de las Madres? Cual sea tu fecha importante, permítenos ser parte.', img: '/img/news/7.jpg' },
      ],
    },
    galleryTitle: { subtitle: 'De la vista nace el amor', title: 'Galería' },
    contact: {
      title: '¡Contáctanos!',
      quote: 'Un lugar donde la elegancia y la sofisticación se unen para ofrecer la mejor experiencia.',
      reservaOnline: 'Reserva en línea',
      fields: { nombre: 'Nombre', tel: 'Teléfono', mail: 'Correo', msj: 'Mensaje', submit: 'Contactar' },
      success: '¡Gracias! Tu mensaje fue enviado, te contactaremos pronto.',
      error: 'Hubo un problema al enviar tu mensaje. Intenta de nuevo o escríbenos por WhatsApp.',
      captchaError: 'Por favor confirma el reCAPTCHA.',
    },
    menu: {
      kicker: 'Disfruta de los mejores platillos',
      title: 'Nuestro Menú',
      tabs: [
        { key: 'aperitivos', label: 'Aperitivos', images: ['/img/menu/01.jpg'] },
        { key: 'sashimis', label: 'Sashimis', images: ['/img/menu/02.jpg'] },
        { key: 'ramen', label: 'Ramen', images: ['/img/menu/05.jpg', '/img/menu/06.jpg', '/img/menu/07.jpg'] },
        { key: 'rollos', label: 'Rollos', images: ['/img/menu/03.jpg', '/img/menu/04.jpg'] },
        { key: 'caliente', label: 'Comida Caliente', images: ['/img/menu/09.jpg'] },
        { key: 'bebidas', label: 'Bebidas', images: ['/img/menu/08.jpg'] },
      ],
    },
    catering: {
      kicker: 'Disfruta de los mejores platillos',
      title: 'Nuestro Catering',
      cta: 'Reserva tu evento',
      introTitle: 'Vive el arte de la cocina japonesa con el toque de la Baja',
      introText:
        'Tei Sushi Catering lleva la maestría de los sabores japoneses, los ingredientes más frescos y nuestra presentación distintiva directamente a tu villa, yate o evento privado. Ya sea una cena íntima para dos o una celebración frente al mar, nuestro equipo crea una experiencia diseñada para impresionar.',
      bullets: [
        'Catering exclusivo para villas, yates y eventos privados.',
        'Sushi recién preparado con ingredientes de la más alta calidad.',
        'Presentación elegante y servicio atento a cargo de personal capacitado.',
        'Menús personalizados para adaptarse a tu celebración.',
      ],
      extrasTitle: 'Servicios opcionales adicionales:',
      extras: ['Bebidas sin alcohol.', 'Sake.', 'Chef preparando sushi en vivo.'],
      menusSubtitle: 'MENÚS DE CATERING EN LOS CABOS',
      menusTitle: 'Descubre tres menús únicos que combinan la autenticidad japonesa con el espíritu de Baja.',
      menus: [
        {
          tag: 'CLÁSICO CON UN TOQUE TEI',
          img: '/img/MENU-1.jpg',
          text: 'Una selección básica pensada para los amantes del sushi clásico, combina camarones tempura crujientes, cangrejo fresco y rollos de atún spicy. Ideal para cenas privadas, reuniones en villas o experiencias relajadas en yate.',
        },
        {
          tag: 'FUSIÓN LIGERA',
          img: '/img/MENU-2.jpg',
          text: 'Un menú refrescante que une la técnica japonesa con los sabores tropicales. Fusión ligera ofrece camarón con yuzu, rollos de mango y tostaditas de atún: una propuesta ideal para elevar cualquier evento privado en Los Cabos.',
        },
        {
          tag: 'DEGUSTACIÓN PREMIUM',
          img: '/img/MENU-3.jpg',
          text: 'Una experiencia elevada para los paladares más exigentes que buscan sorprender a sus invitados en cualquiera de sus eventos privados en Cabo. Incluye dragon roll, rainbow roll, mix de sashimi y yakimeshi de camarón.',
        },
      ],
      formTitle: 'Reserva tu evento',
      formText: 'Envíanos un mensaje y nos pondremos en contacto contigo.',
      fields: { nombre: 'Nombre', tel: 'Teléfono', mail: 'Correo', msj: 'Detalles del evento...', submit: 'Enviar' },
    },
    footer: {
      rights: '© Tei Sushi 2026. Diseñado por',
    },
  },

  en: {
    nav: { home: 'Home', menu: 'Menu', catering: 'Catering', gallery: 'Gallery', contact: 'Contact' },
    hero: {
      kicker: 'An exceptional culinary experience',
      title: 'Tei Sushi',
      cta: 'Book online',
    },
    about: {
      subtitle: 'The sushi your palate needs.',
      title: 'Tei Sushi',
      p1: 'We are an Asian restaurant that will transport you to Japan through its unique, authentic flavors. Rest assured you will live an exquisite experience thanks to the quality and freshness of every one of our ingredients.',
      p2: 'Surrounded by a singular atmosphere, you will have an adventure for all your senses thanks to our carefully decorated space and, of course, delicious signature dishes.',
      reservar: 'Reserve',
    },
    chef: {
      subtitle: 'Ready to try something new and exciting?',
      title: 'Try our signature delicacies',
      p: 'Whether you are looking for a place to celebrate a special occasion or simply enjoy an unforgettable meal with friends, Tei Sushi is the ideal place. Come and discover the true taste of Asia, where passion, creativity and a taste for gastronomic quality combine perfectly to offer the best in every dish.',
      cta: 'Reserve',
    },
    group: {
      subtitle: 'Now part of',
      title: 'Grupo ALCARI',
      brands: [
        { name: 'Mexican Cuisine', img: '/img/chef/hamburger.jpg', logo: '/img/jazmin.png' },
        { name: 'Tei Sushi', img: '/img/chef/salad.jpg', logo: '/img/alcari.png' },
        { name: 'Italian Cuisine', img: '/img/chef/wine.jpg', logo: '/img/fiorenza.png' },
      ],
    },
    hours: {
      title: 'Hours',
      from: 'Monday',
      to: 'Sunday',
      time: '1:00pm – 10:00pm',
      callAlso: 'You can also call:',
      reservar: 'Reserve',
      address: 'Blvrd Antonio Mijares, No. 10, Col. Centro.',
    },
    testimonials: [
      {
        name: 'Octava',
        text: 'A very pleasant place and everything is delicious! The dishes are very well prepared, there are rolls, ramen, hot dishes and several starters, the seafood is fresh. I asked if they could prepare a roll differently and they did, very accommodating. The place is beautiful, has air conditioning, comfortable chairs. Great service.',
      },
      {
        name: 'Oscar Rodriguez Alvarez',
        text: 'Great culinary experience, good drinks, great atmosphere and decor. A complete place to visit as a couple or with family.',
      },
      {
        name: 'Abraham Romero',
        text: 'Good place for locals, affordable prices and delicious food. Very pleasant atmosphere.',
      },
    ],
    services: [
      { title: 'Experts', text: 'With exceptional service you will live your visit with a team always ready to attend to you.' },
      { title: 'Dishes', text: 'Our chefs have the ability to always exceed expectations.' },
      { title: 'Drinks', text: 'Our cocktails will always win you over with every flavor-filled sip.' },
    ],
    news: {
      subtitle: 'Is a special date coming up?',
      title: 'Bring your memorable moments to life.',
      items: [
        { tag: 'Birthdays', text: 'If you celebrate your birthday with us, enjoy your dessert completely free.', img: '/img/news/1.jpg' },
        { tag: 'Anniversaries', text: 'Live exciting, love-filled feelings in a romantic atmosphere. We will be your accomplices!', img: '/img/news/2.jpg' },
        { tag: 'Special Days', text: 'Graduations, Valentine’s Day, Mother’s Day? Whatever your important date, let us be part of it.', img: '/img/news/7.jpg' },
      ],
    },
    galleryTitle: { subtitle: 'Love is born from what you see', title: 'Gallery' },
    contact: {
      title: 'Contact Us!',
      quote: 'A place where elegance and sophistication come together to offer the finest experience.',
      reservaOnline: 'Book online',
      fields: { nombre: 'Name', tel: 'Phone', mail: 'Email', msj: 'Message', submit: 'Contact' },
      success: 'Thank you! Your message was sent, we will contact you soon.',
      error: 'There was a problem sending your message. Try again or message us on WhatsApp.',
      captchaError: 'Please confirm the reCAPTCHA.',
    },
    menu: {
      kicker: 'Enjoy the best dishes',
      title: 'Our Menu',
      tabs: [
        { key: 'aperitivos', label: 'Starters', images: ['/img/menu/eng/01.jpg'] },
        { key: 'sashimis', label: 'Sashimis', images: ['/img/menu/eng/02.jpg'] },
        { key: 'rollos', label: 'Rolls', images: ['/img/menu/eng/04.jpg', '/img/menu/eng/05.jpg'] },
        { key: 'ramen', label: 'Ramen', images: ['/img/menu/eng/06.jpg', '/img/menu/eng/04.jpg', '/img/menu/eng/08.jpg'] },
        { key: 'caliente', label: 'Main Courses', images: ['/img/menu/eng/03.jpg'] },
        { key: 'bebidas', label: 'Drinks', images: ['/img/menu/eng/09.jpg'] },
      ],
    },
    catering: {
      kicker: 'Enjoy the finest dishes',
      title: 'Our Catering',
      cta: 'Book your event',
      introTitle: 'Experience the art of Japanese cuisine with the Baja touch',
      introText:
        'Tei Sushi Catering brings the mastery of Japanese flavors, the freshest ingredients, and our distinctive presentation directly to your villa, yacht, or private event. Whether it’s an intimate dinner for two or a seaside celebration, our team creates an experience designed to impress.',
      bullets: [
        'Exclusive catering for villas, yachts, and private events.',
        'Freshly prepared sushi made with the highest quality ingredients.',
        'Elegant presentation and attentive service by our professional staff.',
        'Personalized menus tailored to your celebration.',
      ],
      extrasTitle: 'Additional optional services:',
      extras: ['Non-alcoholic beverages.', 'Sake.', 'Live sushi chef.'],
      menusSubtitle: 'CATERING MENUS IN LOS CABOS',
      menusTitle: 'Discover three unique menus that combine authentic Japanese flavors with the spirit of Baja.',
      menus: [
        {
          tag: 'CLASSIC WITH A TEI TOUCH',
          img: '/img/MENU-1.jpg',
          text: 'A refined selection created for true sushi lovers. This menu combines crispy tempura shrimp, fresh crab, and spicy tuna rolls — a balance of tradition and flavor. Perfect for private dinners, villa gatherings, or relaxed yacht experiences in Los Cabos.',
        },
        {
          tag: 'LIGHT FUSION',
          img: '/img/MENU-2.jpg',
          text: 'A refreshing menu that blends Japanese technique with tropical flavors. Light Fusion features shrimp with yuzu, mango rolls, and tuna tostaditas — an ideal proposal to elevate any private event in Los Cabos.',
        },
        {
          tag: 'PREMIUM TASTING',
          img: '/img/MENU-3.jpg',
          text: 'An elevated experience for the most discerning palates, designed to impress your guests at any private celebration in Cabo. Includes dragon roll, rainbow roll, sashimi mix, and shrimp yakimeshi.',
        },
      ],
      formTitle: 'Book your event',
      formText: 'Send us a message and we’ll get in touch with you shortly.',
      fields: { nombre: 'Name', tel: 'Phone', mail: 'Email', msj: 'Event details...', submit: 'Send' },
    },
    footer: {
      rights: '© Tei Sushi 2026. Designed by',
    },
  },
}

export const site = {
  phone: '+52 (624) 123 7003',
  phoneHref: 'tel:+526241237003',
  whatsapp: 'https://wa.me/+526241237003?text=Hola%20me%20gustar%C3%ADa%20agendar%20una%20reserva.',
  instagram: 'https://www.instagram.com/teisushicabo/?hl=es-la',
  facebook: 'https://www.facebook.com/TeiSushiCabo',
  mapsShort: 'https://goo.gl/maps/xE6f2qkdNU6APNtm9',
  mapsEmbed:
    'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d692.5074395004276!2d-109.69469669876268!3d23.062474610654604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86af51ac12370483%3A0x3f45f519ada3f0bd!2sTei%20Sushi!5e0!3m2!1ses-419!2smx!4v1680128582329!5m2!1ses-419!2smx',
  openTable:
    'https://www.opentable.com.mx/r/tei-sushi-san-jose-del-cabo?corrid=bf20a876-aa77-4635-a023-85f4c04ac5ae&avt=eyJ2IjoyLCJtIjowLCJwIjowLCJzIjowLCJuIjowfQ&p=2&sd=2023-03-29T19%3A00%3A00',
  recaptchaSiteKey: '6Lf92OAfAAAAAEy9m8sf2kbU0ojkdDs5CNOnaNYS',
  gallery: [
    '/img/daily/1.jpg',
    '/img/daily/2.jpg',
    '/img/daily/3.jpg',
    '/img/daily/4.jpg',
    '/img/daily/5.jpg',
    '/img/daily/6.jpg',
    '/img/daily/7.jpg',
    '/img/daily/8.jpg',
  ],
}
