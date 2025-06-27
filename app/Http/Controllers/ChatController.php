<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Interview;
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
        $link = Link::where('url', $id)->firstOrFail();
        if($link->linkClicked == false){
            $link->update(['linkClicked' => true]);
            return view('chat', ['chat' => $link]);
        }
        else{
            return view('invalid', ['chat' => $link]);
        }
    }

    public function storeSurvey(Request $request)
    {
        $request->validate([
            'anonymous_id' => 'required|string',
            'gender' => 'required|string',
            'age' => 'required|integer|min:0|max:100',
            'discipline' => 'required|string',
            'title' => 'required|string',
            'language' => 'required|string'
        ]);

        $interview = Interview::create([
            'url' => $request->anonymous_id,
            'gender' => $request->gender,
            'age' => $request->age,
            'discipline' => $request->discipline,
            'title' => $request->title,
        ]);

        $firstUserMessage = "Zacznij rozmowę. Prowadź rozmowę w języku {$request->language}";
        $botResponse = $this->openAIService->askChatGPT($firstUserMessage, $interview);
        $message = $interview->messages()->create(['content' => $firstUserMessage, 'is_bot' => false]);
        $interview->messages()->create(['content' => $botResponse, 'is_bot' => true, 'finished_by_boot' => false]);
        
        return response()->json(['message' => 'Ankieta zapisana i zakończona.']);
    }

    public function getHistory($id)
    {
        $chat = Interview::where('url', $id)->firstOrFail();
        $messages = $chat->messages()->orderBy('id')->skip(1)->take(PHP_INT_MAX)->get();

        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(Request $request, $id)
    {
        $interview = Interview::where('url', $id)->firstOrFail();
        $userMessage = $request->input('message');

        // Zapis wiadomości użytkownika
        $message = $interview->messages()->create(['content' => $userMessage, 'is_bot' => false]);

        // Odpowiedź bota (przykład z ChatGPT)
        $botResponse = $this->openAIService->askChatGPT($userMessage, $interview);

        //checkEnd
        $checkEnd = $this->openAIService->checkEnd($botResponse);

        if($checkEnd == "TAK") {
            $checkEnd = true;
        }
        else {
            $checkEnd = false;
        }

        // Zapis odpowiedzi bota
        $interview->messages()->create(['content' => $botResponse, 'is_bot' => true, 'finished_by_boot' => $checkEnd]);

        return response()->json(['userMessage' => $message, 'botResponse' => $botResponse, 'checkEnd' => $checkEnd]);
    }

    public function storeEndSurvey(Request $request, $id)
    {
        $interview = Interview::where('url', $id)->firstOrFail();

        $interview->qualitySurveys()->create([
            'q1' => $request->input('q1'),
            'q2' => $request->input('q2'),
            'q3' => $request->input('q3'),
            'q4' => $request->input('q4'),
            'q5' => $request->input('q5')
        ]);
    
        return response()->json(['message' => 'Ankieta końcowa zapisana i zakończona.']);
    }
}
