<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Events\MessageSent;

class ChatController extends Controller
{
    /**
     * Cria ou obtém o chat aberto para um usuário (client_id).
     * Se não existir chat com status 'open', cria um novo.
     */
    public function createOrGetOpenChat(Request $request)
    {
        $clientId = $request->input('client_id');

        // Tenta achar um chat 'open' para esse client_id
        $chat = Chat::where('client_id', $clientId)
                    ->where('status', 'open')
                    ->first();

        // Se não existir, cria um novo
        if (!$chat) {
            $chat = Chat::create([
                'client_id' => $clientId,
                'admin_id'  => null,
                'status'    => 'open'
            ]);
        }

        return response()->json($chat);
    }

    /**
     * Envia uma mensagem (com ou sem anexo).
     */
    public function sendMessage(Request $request)
    {
        $chatId  = $request->input('chat_id');
        $userId  = $request->input('user_id');
        $content = $request->input('content', '');
        $attachmentPath = null;

        // Se houver arquivo, salva em storage/app/public/attachments
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $attachmentPath = $path;
        }

        $message = Message::create([
            'chat_id'   => $chatId,
            'user_id'   => $userId,
            'content'   => $content,
            'attachment'=> $attachmentPath
        ]);

        // Dispara o evento para broadcast (tempo real)
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message, 201);
    }

    /**
     * Retorna o histórico de mensagens de um chat.
     */
    public function getMessages($chatId)
    {
        $messages = Message::where('chat_id', $chatId)
                    ->orderBy('created_at', 'asc')
                    ->get();
        return response()->json($messages);
    }

    /**
     * Lista todos os chats (para o admin).
     */
    public function getAllChats()
    {
        $chats = Chat::with('messages')->get();
        return response()->json($chats);
    }

    /**
     * Fecha (encerra) um chat, alterando o status para 'closed'.
     */
    public function closeChat($chatId)
    {
        $chat = Chat::findOrFail($chatId);
        $chat->status = 'closed';
        $chat->save();

        return response()->json(['message' => 'Chat encerrado com sucesso!']);
    }

    /**
     * Lista os chats do usuário logado (para exibir histórico).
     */
    public function meusChats()
    {
        $userId = auth()->id(); // se o usuário estiver logado
        $chats = Chat::where('client_id', $userId)
                     ->orderBy('created_at', 'desc')
                     ->get();

        // Se quiser retornar JSON, descomente:
        // return response()->json($chats);

        // Ou retornar uma view Blade:
        return view('cliente.meus-chats', compact('chats'));
    }

    /**
     * Exibe as mensagens de um chat específico (histórico).
     */
    public function show($chatId)
    {
        $chat = Chat::with('messages')->findOrFail($chatId);
        // Se quiser restringir o acesso ao dono do chat:
        // if ($chat->client_id != auth()->id()) { abort(403); }

        // Retorna JSON ou view
        return view('cliente.show-chat', compact('chat'));
    }

    /**
     * (Opcional) Lista todos os chats para o admin, caso queira uma view em vez de JSON.
     */
    public function listAllChats()
    {
        $chats = Chat::with('messages')->orderBy('created_at','desc')->get();
        return view('admin.chats.index', compact('chats'));
    }
}
