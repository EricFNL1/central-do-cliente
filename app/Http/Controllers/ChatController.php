<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function createChat(Request $request)
    {
        $clientId = $request->input('client_id');
        // Se já existir um chat com esse client_id, retorna ele; caso contrário, cria
        $chat = Chat::firstOrCreate(
            ['client_id' => $clientId],
            ['admin_id' => null]
        );
    
        return response()->json($chat, 201);
    }
    

    // Envia uma mensagem, salva no DB e dispara o evento de broadcast
    public function sendMessage(Request $request)
    {
        $chatId  = $request->input('chat_id');
        $userId  = $request->input('user_id');
        $content = $request->input('content');

        $message = Message::create([
            'chat_id' => $chatId,
            'user_id' => $userId,
            'content' => $content
        ]);

        // Dispara o evento para outros clientes conectados
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message, 201);
    }

    // Retorna o histórico de mensagens de um chat
    public function getMessages($chatId)
    {
        $messages = Message::where('chat_id', $chatId)
                    ->orderBy('created_at', 'asc')
                    ->get();
        return response()->json($messages);
    }

    // Lista todos os chats (para um painel admin, por exemplo)
    public function getAllChats()
    {
        $chats = Chat::with('messages')->get();
        return response()->json($chats);
    }
}
