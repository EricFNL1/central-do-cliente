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
      /* Estilo para indicar que o chat está encerrado */
      .closed {
          background: #eee;
          color: #777;
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
            <li><a href="{{ route('admin.academia.index') }}">Treinamentos (Admin)</a></li>
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
              li.innerHTML = `Chat ID: ${chat.id} - Cliente: ${chat.client_id} - Status: ${chat.status}`;
              
              // Botão para abrir o chat
              const openBtn = document.createElement('button');
              openBtn.textContent = 'Abrir Chat';
              openBtn.style.marginLeft = '10px';
              openBtn.addEventListener('click', function() {
                openAdminChat(chat.id, chat.status);
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
                // Se houver anexo, exibe um link
                if (msg.attachment) {
                  const a = document.createElement('a');
                  a.href = `/storage/${msg.attachment}`;
                  a.target = "_blank";
                  a.textContent = 'Ver anexo';
                  p.appendChild(document.createElement('br'));
                  p.appendChild(a);
                }
                adminChatBody.appendChild(p);
              });
            }
          })
          .catch(err => console.error('Erro ao carregar mensagens do chat:', err));
      }

      // Função para abrir a interface do chat para o admin e configurar o envio de mensagens e anexos
      function openAdminChat(chatId, chatStatus) {
        const adminChatDiv = document.getElementById('admin-chat-div');
        // Cria (ou substitui) a interface do chat
        adminChatDiv.innerHTML = `
          <h2>Chat ID: ${chatId}</h2>
          <div id="admin-chat-body" style="border: 1px solid #ccc; width: 300px; height: 200px; overflow:auto; margin-bottom:10px;"></div>
          <input type="text" id="admin-chat-input" placeholder="Digite sua resposta..." ${chatStatus === 'closed' ? 'disabled' : ''} />
          <input type="file" id="admin-file-input" ${chatStatus === 'closed' ? 'disabled' : ''} />
          <button id="admin-send-message" type="button" ${chatStatus === 'closed' ? 'disabled' : ''}>Enviar</button>
          <button id="close-chat-admin" type="button" ${chatStatus === 'closed' ? 'disabled' : ''}>Encerrar Chat</button>
          ${chatStatus === 'closed' ? '<p style="color: red;"><em>Chat encerrado.</em></p>' : ''}
        `;

        loadAdminChatMessages(chatId);

        const adminSendBtn = document.getElementById('admin-send-message');
        const adminChatInput = document.getElementById('admin-chat-input');
        const adminFileInput = document.getElementById('admin-file-input');
        const adminChatBody = document.getElementById('admin-chat-body');
        // Exemplo: ID do admin (substitua pelo ID real do usuário logado)
        const adminUserId = 999;

        // Envio de mensagem (com anexos, se houver)
        adminSendBtn.addEventListener('click', function() {
          const content = adminChatInput.value.trim();
          const file = adminFileInput.files[0];
          if (!content && !file) return; // Não envia se não houver texto ou arquivo

          // Cria um FormData para enviar multipart/form-data
          const formData = new FormData();
          formData.append('chat_id', chatId);
          formData.append('user_id', adminUserId);
          formData.append('content', content);
          if (file) {
            formData.append('attachment', file);
          }

          fetch('/chat/send', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken
              // Não defina 'Content-Type', deixe o navegador definir para multipart/form-data
            },
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            const p = document.createElement('p');
            p.innerHTML = `<strong>Você (Admin):</strong> ${data.content}`;
            // Se houver anexo na resposta, exibe um link
            if (data.attachment) {
              const a = document.createElement('a');
              a.href = `/storage/${data.attachment}`;
              a.target = "_blank";
              a.textContent = 'Ver anexo';
              p.appendChild(document.createElement('br'));
              p.appendChild(a);
            }
            adminChatBody.appendChild(p);
          })
          .catch(err => console.error('Erro ao enviar mensagem (Admin):', err));

          adminChatInput.value = '';
          adminFileInput.value = ''; // Limpa o campo de arquivo
        });

        // Encerrar o chat
        document.getElementById('close-chat-admin').addEventListener('click', function() {
          fetch(`/chat/${chatId}/close`, {
            method: 'PATCH',
            headers: {
              'X-CSRF-TOKEN': csrfToken
            }
          })
          .then(res => res.json())
          .then(data => {
            console.log(data.message);
            // Atualiza a interface para indicar que o chat está encerrado
            const adminChatInput = document.getElementById('admin-chat-input');
            const adminFileInput = document.getElementById('admin-file-input');
            const adminSendBtn = document.getElementById('admin-send-message');
            adminChatInput.disabled = true;
            adminFileInput.disabled = true;
            adminSendBtn.disabled = true;
            const adminChatBody = document.getElementById('admin-chat-body');
            adminChatBody.innerHTML += '<p style="color: red;"><em>Chat encerrado.</em></p>';
          })
          .catch(err => console.error('Erro ao encerrar chat:', err));
        });

        // Inscreve o admin no canal para receber mensagens em tempo real para este chat
        if (window.Echo) {
          window.Echo.channel(`chat.${chatId}`)
            .listen('MessageSent', (e) => {
              if (e.message.user_id != adminUserId) {
                const p = document.createElement('p');
                p.innerHTML = `<strong>Cliente:</strong> ${e.message.content}`;
                if (e.message.attachment) {
                  const a = document.createElement('a');
                  a.href = `/storage/${e.message.attachment}`;
                  a.target = "_blank";
                  a.textContent = 'Ver anexo';
                  p.appendChild(document.createElement('br'));
                  p.appendChild(a);
                }
                adminChatBody.appendChild(p);
              }
            });
        }
      }

      // Carrega a lista de chats abertos assim que a página do painel for carregada
      loadOpenChats();

      // Opcional: recarregar a lista periodicamente (ex: a cada 30 segundos)
      // setInterval(loadOpenChats, 30000);
    })();
    </script>
</body>
</html>
