<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Models\QualitySurvey;
use App\Services\OpenAIService;

class ChatController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function showChat($id)
    {
        $chat = Chat::where('unique_id', $id)->firstOrFail();
        return view('chat', ['chat' => $chat]);
    }

    public function storeSurvey(Request $request, $id)
    {
        $chat = Chat::where('unique_id', $id)->firstOrFail();

        $request->validate([
            'gender' => 'required|string',
            'age' => 'required|integer|min:1|max:120',
            'discipline' => 'required|string',
            'title' => 'nullable|string',
        ]);

        $chat->update([
            'gender' => $request->gender,
            'age' => $request->age,
            'discipline' => $request->discipline,
            'title' => $request->title,
            'survFinished' => true,
        ]);

        $chat = Chat::where('unique_id', $id)->firstOrFail();
        $botResponse = $this->openAIService->askChatGPT("Zacznij rozmowę", $chat);
        $message = $chat->messages()->create(['content' => "Zacznij rozmowę", 'is_bot' => false]);
        $chat->messages()->create(['content' => $botResponse, 'is_bot' => true, 'finished_by_boot' => "Continue"]);
        
        return response()->json(['message' => 'Ankieta zapisana i zakończona.']);
    }

    public function checkSurveyStatus($id)
    {
        $chat = Chat::where('unique_id', $id)->firstOrFail();
    
        $hasCompletedSurvey = $chat && $chat->survFinished == "1";
        $hasCompletedChat = $chat && $chat->chatFinished == "1";
        $hasCompletedPostSurvey = $chat && $chat->postsurFinished == "1";
    
        return response()->json([
            'hasCompletedSurvey' => $hasCompletedSurvey,
            'hasCompletedChat' => $hasCompletedChat,
            'hasCompletedPostSurvey' => $hasCompletedPostSurvey
        ], 200)->header('Content-Type', 'application/json');
    }

    public function getHistory($id)
    {
        $chat = Chat::where('unique_id', $id)->firstOrFail();
        $messages = $chat->messages()->orderBy('id')->skip(1)->take(PHP_INT_MAX)->get();

        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(Request $request, $id)
    {
        $chat = Chat::where('unique_id', $id)->firstOrFail();
        $userMessage = $request->input('message');

        // Zapis wiadomości użytkownika
        $message = $chat->messages()->create(['content' => $userMessage, 'is_bot' => false]);

        // Odpowiedź bota (przykład z ChatGPT)
        $botResponse = $this->openAIService->askChatGPT($userMessage, $chat);

        //checkEnd
        $checkEnd = $this->openAIService->checkEnd($botResponse);

        if($checkEnd == "TAK") {
            $checkEnd = "End";
        }
        else {
            $checkEnd = "Continue";
        }

        // Zapis odpowiedzi bota
        $chat->messages()->create(['content' => $botResponse, 'is_bot' => true, 'finished_by_boot' => $checkEnd]);

        return response()->json(['userMessage' => $message, 'botResponse' => $botResponse, 'checkEnd' => $checkEnd]);
    }

    public function endChat($id)
    {
        $chat = Chat::where('unique_id', $id)->firstOrFail();

        $chat->update([
            'chatFinished' => true
         ]);

        return response()->json(['message' => 'Czat zakończony.']);
    }

    public function storeEndSurvey(Request $request, $id)
    {
        $chat = Chat::where('unique_id', $id)->firstOrFail();

        QualitySurvey::create([
            'chat_id' => $chat->id,
            'q1' => $request->input('q1'),
            'q2' => $request->input('q2'),
            'q3' => $request->input('q3'),
            'q4' => $request->input('q4'),
            'q5' => $request->input('q5')
        ]);

        $chat->update([
            'postsurFinished' => true
         ]);
    
        return response()->json(['message' => 'Ankieta końcowa zapisana i zakończona.']);
    }

}
