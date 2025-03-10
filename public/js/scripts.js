(function() {
  const helpButton = document.getElementById('help-button');
  if (!helpButton) {
    console.error('Elemento help-button não encontrado.');
    return;
  }

  let chatId = null;
  const userId = 123; // Ajuste para pegar do Auth, se disponível
  let chatStatus = 'open';

  const chatContainer = document.getElementById('chat-container');
  const closeChatBtn = document.getElementById('close-chat');
  const sendMessageBtn = document.getElementById('send-message');
  const chatInput = document.getElementById('chat-input');
  const chatBody = document.getElementById('chat-body');
  const fileInput = document.getElementById('file-input');
  const startNewChatBtn = document.getElementById('start-new-chat');

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  console.log('Iniciando script de chat...');

  // Função para criar ou obter o chat aberto do usuário
  function createOrGetOpenChat() {
    console.log('Criando/obtendo chat para client_id:', userId);
    return fetch('/chat', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify({ client_id: userId })
    })
    .then(res => {
      if (!res.ok) {
        console.error('Erro na requisição createOrGetOpenChat:', res.statusText);
      }
      return res.json();
    })
    .then(chat => {
      console.log('Chat obtido:', chat);
      chatId = chat.id;
      chatStatus = chat.status;
      return chat;
    })
    .catch(err => {
      console.error('Erro ao criar/obter chat:', err);
    });
  }

  // Função para carregar o histórico de mensagens do chat atual
  function loadChatMessages() {
    if (!chatId) {
      console.warn('chatId não definido. Não foi possível carregar mensagens.');
      return;
    }
    console.log('Carregando mensagens para chatId:', chatId);
    fetch(`/chat/${chatId}/messages`)
      .then(res => {
        if (!res.ok) console.error('Erro ao carregar mensagens:', res.statusText);
        return res.json();
      })
      .then(messages => {
        chatBody.innerHTML = '';
        messages.forEach(msg => {
          renderMessage(msg);
        });
      })
      .catch(err => console.error('Erro ao carregar mensagens:', err));
  }

  // Função para renderizar uma mensagem no chatBody
  function renderMessage(msg) {
    const p = document.createElement('p');
    if (msg.user_id == userId) {
      p.innerHTML = `<strong>Você:</strong> ${msg.content}`;
    } else {
      p.innerHTML = `<strong>Atendente:</strong> ${msg.content}`;
    }
    if (msg.attachment) {
      const a = document.createElement('a');
      a.href = `/storage/${msg.attachment}`;
      a.target = '_blank';
      a.textContent = 'Ver anexo';
      p.appendChild(document.createElement('br'));
      p.appendChild(a);
    }
    chatBody.appendChild(p);
    chatBody.scrollTop = chatBody.scrollHeight;
  }

  // Função para se inscrever no canal do chat (para receber mensagens em tempo real)
  function subscribeToChannel() {
    if (!window.Echo || !chatId) {
      console.warn('Laravel Echo não disponível ou chatId não definido.');
      return;
    }
    console.log('Inscrevendo no canal chat.' + chatId);
    window.Echo.channel(`chat.${chatId}`)
      .listen('MessageSent', (e) => {
        if (e.message.user_id != userId) {
          console.log('Mensagem recebida via Echo:', e.message);
          renderMessage(e.message);
        }
      });
  }

  // Atualiza a interface do chat conforme o status (open/closed)
  function updateUIBasedOnStatus() {
    if (chatStatus === 'closed') {
      chatInput.disabled = true;
      sendMessageBtn.disabled = true;
      fileInput.disabled = true;
      if (startNewChatBtn) {
        startNewChatBtn.style.display = 'inline-block';
      }
      chatBody.innerHTML += '<p style="color:red;"><em>Chat encerrado pelo admin.</em></p>';
    } else {
      chatInput.disabled = false;
      sendMessageBtn.disabled = false;
      fileInput.disabled = false;
      if (startNewChatBtn) {
        startNewChatBtn.style.display = 'none';
      }
    }
  }

  // Abre o chat e configura o fluxo (cria/obtém chat se necessário)
  async function openUserChat() {
    chatContainer.classList.toggle('d-none');
    if (!chatContainer.classList.contains('d-none')) {
      if (!chatId || chatStatus === 'closed') {
        chatId = null;
        chatBody.innerHTML = '<p><strong>Carregando chat...</strong></p>';
        await createOrGetOpenChat();
      }
      loadChatMessages();
      subscribeToChannel();
      updateUIBasedOnStatus();
    }
  }

  helpButton.addEventListener('click', openUserChat);

  closeChatBtn.addEventListener('click', function() {
    chatContainer.classList.add('d-none');
  });

  // Envia mensagem (com anexo, se houver)
  sendMessageBtn.addEventListener('click', function() {
    if (!chatId || chatStatus === 'closed') {
      console.warn('Chat não está aberto ou já foi encerrado.');
      return;
    }
    const content = chatInput.value.trim();
    const file = fileInput.files[0];
    if (!content && !file) {
      console.warn('Nenhuma mensagem ou arquivo para enviar.');
      return;
    }

    let fetchOptions = {};
    if (file) {
      const formData = new FormData();
      formData.append('chat_id', chatId);
      formData.append('user_id', userId);
      formData.append('content', content);
      formData.append('attachment', file);

      fetchOptions = {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        body: formData
      };
    } else {
      fetchOptions = {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ chat_id: chatId, user_id: userId, content: content })
      };
    }

    fetch('/chat/send', fetchOptions)
      .then(res => {
        if (!res.ok) {
          console.error('Erro ao enviar mensagem. Status:', res.status);
        }
        return res.json();
      })
      .then(data => {
        console.log('Mensagem enviada:', data);
        renderMessage(data);
        chatInput.value = '';
        fileInput.value = '';
      })
      .catch(err => console.error('Erro ao enviar mensagem:', err));
  });

  // Configura o botão "Novo Chat" para reiniciar o chat se estiver encerrado
  if (startNewChatBtn) {
    startNewChatBtn.addEventListener('click', async function() {
      chatId = null;
      chatStatus = 'open';
      chatBody.innerHTML = '<p><strong>Iniciando novo chat...</strong></p>';
      await createOrGetOpenChat();
      loadChatMessages();
      subscribeToChannel();
      updateUIBasedOnStatus();
    });
  }
})();
