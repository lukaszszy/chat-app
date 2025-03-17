<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wywiad z asystentem AI</title>

    <!-- Importowanie Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Tło czatu */
        body {
            background: url("{{ asset('images/chat-bg.jpg') }}") no-repeat center center fixed;
            background-size: cover;
        }

        /* Pasek nagłówka */
        #header-bar {
            background-color: white;
            width: 100%;
            padding: 0px 0;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }

        /* Kontener czatu */
        #chat-container {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 6px;
        }

        /* Pole z wiadomościami */
        #chat-history {
            height: 430px;
            overflow-y: auto;
            scroll-behavior: smooth;
            background: rgba(255, 255, 255, 0.5);
            padding: 3px;
            border-radius: 8px;
            box-shadow: inset 0px 2px 6px rgba(0, 0, 0, 0.05);
            scrollbar-color: rgba(180, 180, 180, 0.4) rgba(255, 255, 255, 0.4);
        }

        /* Automatyczne dostosowanie textarea */
        textarea {
            resize: none;
            overflow-y: hidden;
            min-height: 40px;
            max-height: 120px;
            ime-mode: disabled;
        }

    </style>
</head>
<body class="bg-gray-100 flex flex-col h-screen justify-start items-center">

    <!-- Pasek nagłówka -->
    <div id="header-bar" class="flex justify-center items-center py-2 px-4">
        <img src="{{ asset('images/university-logo.jpg') }}" alt="Logo Uczelni" class="h-14 object-contain mr-4">
        <h1 class="text-lg font-semibold text-gray-800">Wywiad z asystentem AI</h1>
    </div>

    <!-- Kontener czatu -->
    <div id="chat-container" class="w-full max-w-3xl flex flex-col space-y-4 mt-4 mb-6">

        <!-- Historia wiadomości -->
        <div id="chat-history">
            @foreach($chat->messages as $message)
                <div class="flex @if($message->is_bot) justify-start @else justify-end @endif mb-2">
                    <div class="max-w-[60%] px-3 py-2 rounded-lg text-sm leading-tight
                        @if($message->is_bot) bg-gray-300 text-gray-800 self-start @else bg-blue-500 text-white self-end @endif">
                        {{ $message->content }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Formularz do wpisywania wiadomości -->
        <div class="flex flex-col">
            <div class="flex">
                <textarea id="message-input" class="flex-1 p-2 border rounded-l-lg focus:outline-none focus:ring focus:ring-blue-300 text-sm" 
                    placeholder="Napisz wiadomość..." maxlength="150" rows="1" autocomplete="off"></textarea>
                <button id="send-button" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600 text-sm">Wyślij</button>
            </div>
            <!-- Licznik znaków -->
            <p id="char-count" class="text-xs text-gray-500 mt-1 text-right">Pozostało: 150 znaków</p>
        </div>

    </div>

    <!-- JavaScript obsługujący czat -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chatHistory = document.getElementById("chat-history");
            const messageInput = document.getElementById("message-input");
            const sendButton = document.getElementById("send-button");
            const charCount = document.getElementById("char-count");

            // Automatyczne przewijanie czatu na start
            scrollToBottom();

            sendButton.addEventListener("click", sendMessage);
            messageInput.addEventListener("input", function() {
                updateCharCount();
                adjustTextareaHeight();
            });
            messageInput.addEventListener("keypress", function(event) {
                if (event.key === "Enter" && !event.shiftKey) {
                    event.preventDefault();
                    sendMessage();
                }
            });

            function sendMessage() {
                const message = messageInput.value.trim();
                if (!message) return;

                appendMessage(message, false);

                fetch("{{ route('chat.message', ['id' => $chat->unique_id]) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(response => response.json())
                .then(data => {
                    appendMessage(data.botResponse, true);
                })
                .catch(error => console.error("Błąd:", error));

                messageInput.value = "";
                updateCharCount();
                adjustTextareaHeight();
                scrollToBottom();
            }

            function appendMessage(text, isBot) {
                const messageDiv = document.createElement("div");
                messageDiv.classList.add("flex", isBot ? "justify-start" : "justify-end", "mb-2");

                const bubble = document.createElement("div");
                bubble.classList.add("max-w-[60%]", "px-3", "py-2", "rounded-lg", "text-sm", "leading-tight");

                if (isBot) {
                    bubble.classList.add("bg-gray-300", "text-gray-800", "self-start");
                } else {
                    bubble.classList.add("bg-blue-500", "text-white", "self-end");
                }

                bubble.textContent = text;
                messageDiv.appendChild(bubble);
                chatHistory.appendChild(messageDiv);

                scrollToBottom();
            }

            function updateCharCount() {
                const remaining = 150 - messageInput.value.length;
                charCount.textContent = `Pozostało: ${remaining} znaków`;
            }

            function adjustTextareaHeight() {
                messageInput.style.height = "auto";
                messageInput.style.height = Math.min(messageInput.scrollHeight, 120) + "px";
            }

            function scrollToBottom() {
                chatHistory.scrollTop = chatHistory.scrollHeight;
            }
        });
    </script>

</body>
</html>
