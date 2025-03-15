document.addEventListener('DOMContentLoaded', function() {
  // Elementos de navegación
  const btnInicio = document.getElementById('btnInicio');
  const btnGaleria = document.getElementById('btnGaleria');
  const btnContacto = document.getElementById('btnContacto');
  const btnServicios = document.getElementById('btnServicios');
  
  // Ventanas
  const ventanaInicio = document.getElementById('ventanaInicio');
  const ventanaGaleria = document.getElementById('ventanaGaleria');
  const ventanaContacto = document.getElementById('ventanaContacto');
  const ventanaServicios = document.getElementById('ventanaServicios');
  
  // Controles del carrusel
  const prevButton = document.querySelector('.prev');
  const nextButton = document.querySelector('.next');
  const carouselItems = document.querySelectorAll('.carousel-item');
  
  // Modal Login y Signup
  const loginModal = document.getElementById('loginModal');
  const signupModal = document.getElementById('signupModal');
  const btnLogin = document.getElementById('btnLogin');
  const btnSignup = document.getElementById('btnSignup');
  const closeModalButtons = document.querySelectorAll('.close-modal');
  const showSignupLink = document.getElementById('showSignup');
  const showLoginLink = document.getElementById('showLogin');
  const loginModal = document.getElementById('loginModal');
  const resetPasswordModal = document.getElementById('resetPasswordModal');
  const showResetPassword = document.getElementById('showResetPassword');
  const showLogin = document.getElementById('showLogin');

  
  // Función para cambiar entre ventanas
  function cambiarVentana(ventanaActiva, botonActivo) {
    // Ocultar todas las ventanas
    document.querySelectorAll('.ventana').forEach(ventana => {
      ventana.classList.remove('active');
    });
    
    // Desactivar todos los botones de navegación
    document.querySelectorAll('.nav-button').forEach(boton => {
      boton.classList.remove('active');
    });
    
    // Activar la ventana y botón correspondientes
    ventanaActiva.classList.add('active');
    botonActivo.classList.add('active');
    
    // Hacer scroll al inicio de la página
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }
  
  // Eventos para los botones de navegación
  btnInicio.addEventListener('click', function() {
    cambiarVentana(ventanaInicio, btnInicio);
  });
  
  btnGaleria.addEventListener('click', function() {
    cambiarVentana(ventanaGaleria, btnGaleria);
  });
  
  btnContacto.addEventListener('click', function() {
    cambiarVentana(ventanaContacto, btnContacto);
  });
  
  btnServicios.addEventListener('click', function() {
    cambiarVentana(ventanaServicios, btnServicios);
  });
  
  // Funcionalidad del carrusel
  let currentIndex = 0;
  
  function showSlide(index) {
    // Ocultar todos los slides
    carouselItems.forEach(item => {
      item.classList.remove('active');
    });
    
    // Si el índice está fuera de rango, ajustarlo
    if (index < 0) {
      currentIndex = carouselItems.length - 1;
    } else if (index >= carouselItems.length) {
      currentIndex = 0;
    } else {
      currentIndex = index;
    }
    
    // Mostrar el slide actual
    carouselItems[currentIndex].classList.add('active');
  }
  
  // Evento para el botón anterior
  prevButton.addEventListener('click', function() {
    showSlide(currentIndex - 1);
  });
  
  // Evento para el botón siguiente
  nextButton.addEventListener('click', function() {
    showSlide(currentIndex + 1);
  });
  
  // Cambiar automáticamente cada 5 segundos
  setInterval(function() {
    showSlide(currentIndex + 1);
  }, 5000);
  
  // Eventos para los botones de la galería
  document.querySelectorAll('.btn-accion').forEach(boton => {
    boton.addEventListener('click', function() {
      alert('Acción: ' + this.textContent);
    });
  });
  
  // Eventos para los botones de servicios
  document.querySelectorAll('.btn-info').forEach(boton => {
    boton.addEventListener('click', function() {
      const servicio = this.parentElement.querySelector('h3').textContent;
      alert('Has solicitado información sobre: ' + servicio);
    });
  });

  
  // Evento para el formulario de contacto
  const contactForm = document.querySelector('.contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Mensaje enviado correctamente. Te contactaremos pronto.');
      this.reset();
    });
  }
  
  // ✅ Delegar eventos en el `document` para que funcione en todas las ventanas
  document.addEventListener('click', function(event) {
    if (event.target.matches('#btnLogin')) {
      loginModal.style.display = 'block';
    }
    if (event.target.matches('#btnSignup')) {
      signupModal.style.display = 'block';
    }
    if (event.target.matches('#showSignup')) {
      loginModal.style.display = 'none';
      signupModal.style.display = 'block';
    }
    if (event.target.matches('#showLogin')) {
      signupModal.style.display = 'none';
      loginModal.style.display = 'block';
    }
  });


  // Cerrar los modales cuando se hace clic en la "X"
  closeModalButtons.forEach(button => {
    button.addEventListener('click', function() {
      this.closest('.modal').style.display = 'none';
    });
  });
  
  
  // Cambiar entre el formulario de Login y Signup
  showSignupLink.addEventListener('click', function() {
    loginModal.style.display = 'none';
    signupModal.style.display = 'block';
  });
  
  showLoginLink.addEventListener('click', function() {
    signupModal.style.display = 'none';
    loginModal.style.display = 'block';
  });
  
  // Cerrar las modales si se hace clic fuera de ellas
  window.addEventListener('click', (event) => {
    if (event.target === loginModal) {
      loginModal.style.display = 'none';
    }
    if (event.target === signupModal) {
      signupModal.style.display = 'none';
    }
  });
  
  // --- Añadido aquí ---
  const signupForm = document.querySelector('form[action="register.php"]');
  if (signupForm) {
    signupForm.addEventListener('submit', function(event) {
      console.log("Formulario enviado con método:", this.method); // Esto debería mostrar "POST"
    });
  }
});


  function togglePassword() {
    var passwordField = document.getElementById("password");
    var toggleIcon = document.querySelector(".toggle-password");

    if (passwordField.type === "password") {
      passwordField.type = "text";
      toggleIcon.innerHTML = "&#128065;"; // Ícono de ojo abierto
    } else {
      passwordField.type = "password";
      toggleIcon.innerHTML = "&#128064;"; // Ícono de ojo cerrado
    }
  }

