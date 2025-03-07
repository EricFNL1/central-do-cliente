/*!
* Start Bootstrap - Landing Page v6.0.6 (https://startbootstrap.com/theme/landing-page)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-landing-page/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project

  // Exibe/oculta o chat ao clicar no botão de ajuda
  document.getElementById('help-button').addEventListener('click', function() {
    var chat = document.getElementById('chat-container');
    chat.classList.toggle('d-none');
  });

  // Fecha o chat ao clicar no botão de fechar
  document.getElementById('close-chat').addEventListener('click', function() {
    document.getElementById('chat-container').classList.add('d-none');
  });
