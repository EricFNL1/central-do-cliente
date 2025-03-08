(function() {
  const helpButton = document.getElementById('help-button');
  if (!helpButton) return; // Se não existir o botão, sai daqui

  // Exemplos de IDs. Em produção, você pode obter userId do Auth
  let chatId = null;    // Inicialmente, não temos chat
  const userId = 123;   // ID do cliente

  const chatContainer = document.getElementById('chat-container');
  const closeChat = document.getElementById('close-chat');
  const sendMessageBtn = document.getElementById('send-message');
  const chatInput = document.getElementById('chat-input');
  const chatBody = document.getElementById('chat-body');

  let isSubscribed = false; // Para evitar inscrever no canal múltiplas vezes

  // Obtém o token CSRF do meta
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  /**
   * Cria ou obtém o chat do usuário (client_id).
   * O endpoint deve retornar algo como: { id: 7, client_id: 123, admin_id: null, ... }
   */
  function getOrCreateChat() {
    return fetch('/chat', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify({ client_id: userId })
    })
    .then(response => response.json())
    .then(chat => {
      chatId = chat.id;
      return chatId;
    })
    .catch(err => {
      console.error('Erro ao criar/obter chat:', err);
    });
  }

  /**
   * Carrega o histórico de mensagens para o chat atual.
   */
  function loadChatMessages() {
    if (!chatId) return;
    // GET requests geralmente não exigem CSRF, mas se precisar, você pode incluir o token
    fetch(`/chat/${chatId}/messages`)
      .then(response => response.json())
      .then(messages => {
        chatBody.innerHTML = ''; // Limpa o histórico
        messages.forEach(msg => {
          const p = document.createElement('p');
          if (msg.user_id == userId) {
            p.innerHTML = `<strong>Você:</strong> ${msg.content}`;
          } else {
            p.innerHTML = `<strong>Atendente:</strong> ${msg.content}`;
          }
          chatBody.appendChild(p);
        });
      })
      .catch(error => console.error('Erro ao carregar mensagens:', error));
  }

  /**
   * Inscreve-se no canal do chat para receber mensagens em tempo real.
   */
  function subscribeToChannel() {
    if (isSubscribed || !window.Echo || !chatId) return;
    isSubscribed = true;

    window.Echo.channel(`chat.${chatId}`)
      .listen('MessageSent', (e) => {
        // Se a mensagem não foi enviada pelo cliente, exibe como "Atendente"
        if (e.message.user_id != userId) {
          const p = document.createElement('p');
          p.innerHTML = `<strong>Atendente:</strong> ${e.message.content}`;
          chatBody.appendChild(p);
        }
      });
  }

  /**
   * Lida com o clique no botão de ajuda.
   * - Se o chat estava oculto, criamos/pegamos o chat e carregamos as mensagens.
   */
  helpButton.addEventListener('click', async function() {
    // Alterna a exibição do chat
    chatContainer.classList.toggle('d-none');

    // Se o chat foi aberto
    if (!chatContainer.classList.contains('d-none')) {
      // 1) Cria ou obtém o chat se ainda não tivermos um chatId
      if (!chatId) {
        await getOrCreateChat();
      }
      // 2) Carrega as mensagens
      loadChatMessages();
      // 3) Inscreve no canal (caso ainda não esteja inscrito)
      subscribeToChannel();
    }
  });

  /**
   * Fecha o chat ao clicar no botão de fechar (x).
   */
  closeChat.addEventListener('click', function() {
    chatContainer.classList.add('d-none');
  });

  /**
   * Envia mensagem ao clicar no botão "Enviar".
   */
  sendMessageBtn.addEventListener('click', function() {
    const content = chatInput.value.trim();
    if (!content || !chatId) return;

    fetch('/chat/send', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify({ chat_id: chatId, user_id: userId, content: content })
    })
    .then(response => response.json())
    .then(data => {
      // Exibe a mensagem enviada pelo cliente
      const p = document.createElement('p');
      p.innerHTML = `<strong>Você:</strong> ${data.content}`;
      chatBody.appendChild(p);
    })
    .catch(err => console.error('Erro ao enviar mensagem:', err));

    chatInput.value = '';
  });
})();
