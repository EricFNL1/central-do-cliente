<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Painel Admin</title>
    <!-- Meta CSRF para as requisições -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
      /* Estilos simples para melhor visualização */
      #admin-dashboard, #admin-chat-div {
          margin: 20px;
          padding: 10px;
          border: 1px solid #ccc;
      }
      #chat-list li {
          margin-bottom: 10px;
      }
      #admin-chat-body {
          background: #f9f9f9;
          padding: 10px;
          height: 200px;
          overflow-y: auto;
      }
    </style>
</head>
<body>
    <header>
        <h1>Painel Admin</h1>
    </header>

    <main>
        <p>Bem-vindo, {{ Auth::user()->name }}!</p>

        @if (session('status'))
            <p style="color: green;">{{ session('status') }}</p>
        @endif

        <ul>
            <li><a href="{{ route('admin.administradoras.create') }}">Adicionar Administradora</a></li>
            <li><a href="{{ route('admin.usuarios.create') }}">Cadastrar Usuário</a></li>
            <li><a href="{{ route('admin.logs.index') }}">Logs de Usuários</a></li>
            <li><a href="{{ route('admin.solicitacoes.index') }}">Gerenciar Solicitações</a></li>
            <li><a href="{{ route('admin.journeys.index') }}">Gerenciar Jornada</a></li>
            <li><a href="{{ route('admin.faqs.index') }}">Gerenciar FAQs</a></li>
            <li><a href="{{ route('admin.financeiro.index') }}">Financeiro (Admin)</a></li>
            <li><a href="{{ route('index') }}">Voltar</a></li>
        </ul>

        <!-- Dashboard Admin: lista de chats abertos -->
        <div id="admin-dashboard">
          <h2>Chats Abertos</h2>
          <ul id="chat-list"></ul>
        </div>

        <!-- Área onde o chat selecionado pelo admin será carregado -->
        <div id="admin-chat-div"></div>

        <!-- Exemplo de logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Sair</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 - Todos os direitos reservados.</p>
    </footer>

    <!-- Script para o painel admin -->
    <script>
    (function() {
      // Verifica se estamos no painel admin pelo elemento chat-list
      const chatList = document.getElementById('chat-list');
      if (!chatList) return;

      // Obtém o token CSRF do meta
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

      // Função para carregar a lista de chats abertos
      function loadOpenChats() {
        fetch('/chats')
          .then(response => response.json())
          .then(chats => {
            chatList.innerHTML = '';
            chats.forEach(chat => {
              const li = document.createElement('li');
              li.innerHTML = `Chat ID: ${chat.id} - Cliente: ${chat.client_id}`;
              
              // Botão para abrir o chat
              const openBtn = document.createElement('button');
              openBtn.textContent = 'Abrir Chat';
              openBtn.style.marginLeft = '10px';
              openBtn.addEventListener('click', function() {
                openAdminChat(chat.id);
              });
              li.appendChild(openBtn);
              chatList.appendChild(li);
            });
          })
          .catch(err => console.error('Erro ao carregar chats:', err));
      }

      // Função para carregar o histórico de mensagens do chat aberto (admin)
      function loadAdminChatMessages(chatId) {
        fetch(`/chat/${chatId}/messages`)
          .then(response => response.json())
          .then(messages => {
            const adminChatBody = document.getElementById('admin-chat-body');
            if (adminChatBody) {
              adminChatBody.innerHTML = '';
              messages.forEach(msg => {
                const p = document.createElement('p');
                // Exibe "Você (Admin)" se a mensagem veio do admin (exemplo: admin ID 999) e "Cliente" caso contrário
                if (msg.user_id == 999) {
                  p.innerHTML = `<strong>Você (Admin):</strong> ${msg.content}`;
                } else {
                  p.innerHTML = `<strong>Cliente:</strong> ${msg.content}`;
                }
                adminChatBody.appendChild(p);
              });
            }
          })
          .catch(err => console.error('Erro ao carregar mensagens do chat:', err));
      }

      // Função para abrir a interface do chat para o admin e configurar o envio de mensagens
      function openAdminChat(chatId) {
        // Seleciona o container onde o chat será inserido
        const adminChatDiv = document.getElementById('admin-chat-div');
        // Cria (ou substitui) a interface do chat
        adminChatDiv.innerHTML = `
          <h2>Chat ID: ${chatId}</h2>
          <div id="admin-chat-body" style="border: 1px solid #ccc; width: 300px; height: 200px; overflow:auto; margin-bottom:10px;"></div>
          <input type="text" id="admin-chat-input" placeholder="Digite sua resposta..." />
          <button id="admin-send-message" type="button">Enviar</button>
        `;

        // Carrega o histórico de mensagens para esse chat
        loadAdminChatMessages(chatId);

        // Configura o envio de mensagem pelo admin
        const adminSendBtn = document.getElementById('admin-send-message');
        const adminChatInput = document.getElementById('admin-chat-input');
        const adminChatBody = document.getElementById('admin-chat-body');
        // Exemplo: ID do admin (substitua pelo ID real do usuário logado)
        const adminUserId = 999;

        adminSendBtn.addEventListener('click', function() {
          const content = adminChatInput.value.trim();
          if (!content) return;

          fetch('/chat/send', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ chat_id: chatId, user_id: adminUserId, content: content })
          })
          .then(response => response.json())
          .then(data => {
            const p = document.createElement('p');
            p.innerHTML = `<strong>Você (Admin):</strong> ${data.content}`;
            adminChatBody.appendChild(p);
          })
          .catch(err => console.error('Erro ao enviar mensagem (Admin):', err));

          adminChatInput.value = '';
        });

        // Inscreve o admin no canal para receber mensagens em tempo real para este chat
        if (window.Echo) {
          window.Echo.channel(`chat.${chatId}`)
            .listen('MessageSent', (e) => {
              // Exibe a mensagem se ela não foi enviada pelo admin
              if (e.message.user_id != adminUserId) {
                const p = document.createElement('p');
                p.innerHTML = `<strong>Cliente:</strong> ${e.message.content}`;
                adminChatBody.appendChild(p);
              }
            });
        }
      }

      // Carrega a lista de chats abertos assim que a página do painel for carregada
      loadOpenChats();

      // Opcional: você pode configurar um botão ou ação para recarregar a lista periodicamente
      // setInterval(loadOpenChats, 30000);
    })();
    </script>
</body>
</html>
