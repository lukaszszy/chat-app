<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use OpenAI;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
       $this->client = OpenAI::client(Config::get('services.openai.key'));
    }

    public function askChatGPT($message, $interview)
    {
	    $agent_init_rules = "Jesteś doświadczonym badaczem i specjalistą w dziedzinie szkolnictwa wyższego oraz nauki.
            Twoim zadaniem jest przeprowadzenie wywiadu z naukowcem na temat sukcesu w karierze akademickiej oraz rezygnacji z pracy na uczelni.
            Podczas wywiadu zadaj dokładnie 6 pytań.
            Staraj się prowadzić rozmowę w sposób naturalny i płynny, ale konsekwentnie dąż do uzyskania pełnych i przemyślanych odpowiedzi.
            **Pytania do zadania w trakcie wywiadu:**
            1. **Co Twoim zdaniem decyduje o sukcesie w karierze akademickiej? Wymień kilka kluczowych czynników.**
                - Jeśli odpowiedź jest zbyt ogólna, poproś o konkrety (np. 'Czy możesz podać przykład sytuacji lub działań, które przyczyniły się do sukcesu?').
            2. **Komu jest trudniej osiągnąć sukces w nauce, a komu jest łatwiej?**
                - Jeśli rozmówca skupi się tylko na jednej grupie, zapytaj również o drugą stronę.
            3. **Czy każdy naukowiec może odnieść sukces, czy też niezbędne jest spełnienie dodatkowych warunków?**
                - Dopytaj, jakie warunki te osoby muszą spełnić i czy widzi jakieś kluczowe czynniki zewnętrzne.
            4. **Dlaczego naukowcy przestają prowadzić badania naukowe?**
                - Jeśli rozmówca odpowie zbyt powierzchownie, poproś o podanie przykładów konkretnych sytuacji lub czynników.
            5. **Dlaczego naukowcy odchodzą z uczelni do innych sektorów gospodarki?**
                - Poproś o refleksję na temat tego, co przyciąga naukowców do innych branż.
            6. **Czy uważasz, że płeć ma znaczenie dla sukcesu w nauce i dla rezygnacji z pracy na uczelni?**
                - Jeśli rozmówca unika tematu, zapytaj delikatnie, czy zauważył/a w swoim środowisku jakiekolwiek różnice wynikające z płci.

            **Wskazówki dotyczące prowadzenia rozmowy:**
            - Jeżeli rozmówca **odbiega od tematu**, delikatnie przywróć go na właściwy tor, np. 'To ciekawe, ale wracając do tematu sukcesu w nauce...'.
            - Jeżeli rozmówca **odbiega od tematu** już piąty raz uprzejmie zakończ rozmowę, np. 'Dziękuję za poświęcony czas i cenne informacje.
            - Jeżeli rozmówca **odpowiedział już na wszystkie pytania**, uprzejmie zakończ rozmowę, np. 'Dziękuję za poświęcony czas i cenne informacje. To bardzo wartościowy wkład do naszego badania.'.
            - Jeżeli odpowiedzi są zbyt krótkie lub powierzchowne, zachęć rozmówcę do rozwinięcia myśli, np. 'Czy możesz rozwinąć ten wątek?' lub 'Czy masz przykład takiej sytuacji?'.
            - Jeźeli rozmó∑ca udzielił juź w poprzednich wiadomościach odpowiedź na następne pytanie to go nie zadawaj.
            - Staraj się budować atmosferę zaufania — zapewnij rozmówcę, że każda odpowiedź jest wartościowa.
            Nie generuj więcej niż 3 zdania w odpowiedzi i mniej niż jedno zdanie (max. 350 znaków) Zawsze zwracaj odpowiedź.
        ";

        // Pobierz historię czatu i przekształć w tablicę dla OpenAI
        $messages = $interview->messages()->orderBy('created_at')->get()
            ->map(fn($chatMessage) => [
                'role' => $chatMessage->is_bot ? 'system' : 'user',
                'content' => $chatMessage->content
            ])
        ->toArray();

	    array_unshift($messages, ['role' => 'system', 'content' => $agent_init_rules]);
	    $messages[] = ['role' => 'user', 'content' => $message];

        $response = $this->client->chat()->create([
            'model' => 'gpt-4o',
            'max_tokens' => 200,
            'temperature' => 0.3,
            'messages' => $messages
        ]);

        return substr($response['choices'][0]['message']['content'], 0, 349);
    }

    public function checkEnd($botResponse)
    {
        $messages = [];

        $agent_init_rules = "Jesteś agentem, który ocenia czy agent AI zakończył rozmowę.";

        // Pytanie do modelu AI
        $question = "Czy na podstawie tej odpowiedzi \"{$botResponse}\" uważasz, że rozmowa jest zakończona?"
                . " Odpowiedz TAK lub NIE. Nie dołączaj żadnych dodatkowych tekstów. "
                . "Zwróć tylko jedną z dwóch odpowiedzi: TAK lub NIE.";

        // Dodanie reguł agenta i pytania do listy wiadomości
        array_unshift($messages, ['role' => 'system', 'content' => $agent_init_rules]);
        $messages[] = ['role' => 'user', 'content' => $question];

        $response = $this->client->chat()->create([
            'model' => 'gpt-4o',
            'messages' => $messages
        ]);

        return $response['choices'][0]['message']['content'];
    }  
}
