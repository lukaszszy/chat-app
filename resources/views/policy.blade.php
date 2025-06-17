<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AMU AI Assisted Interview</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      body {
        background: url("{{ asset('images/chat-bg.jpg') }}") no-repeat center center fixed;
        background-size: cover;
        font-family: Helvetica, Arial;
      }
      #header-bar {
        background-color: white;
        width: 100%;
        padding: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      }
      #hello-container {
        background: rgba(255, 255, 255, 0.91);
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 10px;
      }
      footer {
        margin-top: 20px;
        background-color: #ffffff;
        box-shadow: 0 -2px 20px rgba(0, 0, 0, 0.1);
      }
    </style>
  </head>

  <body class="min-h-screen flex flex-col">

    <!--- Header  --->
    <div id="header-bar" class="flex justify-center items-center py-2 px-4">
      <img src="{{ asset('images/university-logo.jpg') }}" alt="Logo Uczelni" class="h-20 object-contain mr-4"/>
      <h1 class="text-lg"> Center for Public Policy Studies<br/>AI Assisted Interview </h1>
    </div>

    <!--- Main DIV --->
    <div class="flex-1 content-wrapper flex items-center justify-center w-full relative">
      
      <!--- Instruction screen  --->
      <div id="hello-container" class="w-[60%] flex flex-col space-y-3 mt-4" style="display: block;">
        <h2 class="text-xl mb-0 text-center">Privacy Policy</h2>
        <h2 class="text-base mb-0 text-justify">
          <p>
           Tekst
          </p>
        </h2>
      </div>

    </div>

    <!--- Footer --->
    <footer id="footer" class="bg-white text-gray-500 text-center py-4 shadow-md transition-all duration-300">
      © 2025 Adam Mickiewicz University. All rights reserved
    </footer>

    <script>
      document.addEventListener("DOMContentLoaded", async function() {
        let userMessagesCount = 0;
        const anonymous_id = crypto.randomUUID().replace(/-/g, '');

        const helloContainer = document.getElementById('hello-container');
        const surveyContainer = document.getElementById('survey-container');
        const chatContainer = document.getElementById('chat-container');
        const endSurveyContainer = document.getElementById('end-survey-container');
        const thankYouContainer = document.getElementById('thank-you-container');

        const chatHistory = document.getElementById('chat-history');
        const messageInput = document.getElementById("message-input");
        const charCount = document.getElementById("char-count");
        const sendButton = document.getElementById("send-button");

        const qualityInput = document.getElementById("q5");
        const charCountQ = document.getElementById("char-count-q");

        const observer = new MutationObserver(() => {
          chatHistory.scrollTop = chatHistory.scrollHeight;
        });

        observer.observe(chatHistory, {
          childList: true,
          subtree: true
        });

        document.getElementById('start-survey-button').addEventListener('click', async function() {
          const button = document.getElementById('start-survey-button');
          button.disabled = true;
          button.classList.add('opacity-50');
          await new Promise(resolve => setTimeout(resolve, 250));
          helloContainer.style.display = 'none';
          surveyContainer.style.display = 'block';
        });
        
        document.getElementById('start-chat-button').addEventListener('click', async function() {
          const gender = document.querySelector('input[name="gender"]:checked')?.value || 'NoInfo';
          const age = document.getElementById('age').value || 0;
          const discipline = document.querySelector('select[name="discipline"]')?.value || 'NoInfo';
          const title = document.querySelector('input[name="title"]:checked')?.value || 'NoInfo';
          const language = document.querySelector('select[name="language"]')?.value || 'NoInfo';
          if (gender == "NoInfo" || age < 20 || age > 100 || discipline == "NoInfo" || title == "NoInfo" || language == "NoInfo") {
            alert("Please answer all questions.");
          }
          else {
            const button = document.getElementById('start-chat-button');
            button.disabled = true;
            button.classList.add('opacity-50');
            await new Promise(resolve => setTimeout(resolve, 250));
            sendButton.disabled = true;
            sendButton.classList.add('opacity-50');
            surveyContainer.style.display = 'none';
            chatContainer.style.display = 'flex';
            fetch(`/store-survey`, {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
              },
              body: JSON.stringify({ anonymous_id, gender, age, discipline, title })
            })
            .then(() => {
              loadChatHistory();
            })
            .catch(error => console.error("Error while saving surway:", error));
          }
        });

        function loadChatHistory() {
          fetch(`/${anonymous_id}/get-history`)
          .then(response => response.json())
          .then(data => {
            chatHistory.innerHTML = '';
            data.messages.forEach(message => {
              appendMessage(message.content, message.is_bot);
            });
            sendButton.disabled = false;
            sendButton.classList.remove('opacity-50');
          })
          .catch(error => console.error("Error while loading messages:", error));
        }

        function scrollToBottom() {
          requestAnimationFrame(() => {
            chatHistory.scrollTop = chatHistory.scrollHeight;
          });
        }

        messageInput.addEventListener("input", function() {
          updateCharCount();
        });

        function updateCharCount() {
          const remaining = 1000 - messageInput.value.length;
          charCount.textContent = `Characters remaining: ${remaining}`;
          messageInput.style.height = "auto";
          messageInput.style.height = Math.min(messageInput.scrollHeight, 160) + "px";
          resizeObserver.observe(messageInput);
        }

        const resizeObserver = new ResizeObserver(entries => {
          for (let entry of entries) {
            scrollToBottom();
          }
        });

        messageInput.addEventListener("keypress", function(event) {
          if (event.key === "Enter" && !event.shiftKey) {
            event.preventDefault();
            sendMessage();
          }
        });

        sendButton.addEventListener("click", function(event) {
          event.preventDefault();
          sendMessage();
        });

        function sendMessage() {
          const message = messageInput.value.trim();
          if (!message) return;
          sendButton.disabled = true;
          sendButton.classList.add('opacity-50');
          appendMessage(message, false);
          messageInput.value = "";
          updateCharCount();

          fetch(`/${anonymous_id}/send-message`, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ message: message })
          })
          .then(response => response.json())
          .then(data => {
            if (data.checkEnd === true || userMessagesCount >= 25 || message.toLowerCase() === "end") {
              appendMessage("Thank you for the interview. We have to finish, you will be redirected.", true);
              setTimeout(() => {
                endSurveyContainer.style.display = 'block';
                chatContainer.style.display = 'none';
              }, 5000);
            }
            else {
              appendMessage(data.botResponse, true);
              sendButton.disabled = false;
              sendButton.classList.remove('opacity-50');
            }
          })
          .catch(error => console.error("Error while sending message:", error));
        }

        function appendMessage(text, isBot) {
          const messageDiv = document.createElement("div");
          messageDiv.classList.add("flex", isBot ? "justify-start" : "justify-end", "mb-2");
          const bubble = document.createElement("div");
          bubble.classList.add("max-w-[60%]", "px-3", "py-2", "rounded-lg", "text-base", "leading-tight");
          if (isBot) {
            bubble.classList.add("bg-gray-300", "text-gray-800", "self-start");
          }
          else {
            bubble.classList.add("bg-blue-500", "text-white", "self-end");
          }
          bubble.textContent = text;
          messageDiv.appendChild(bubble);
          chatHistory.appendChild(messageDiv);
          scrollToBottom();
          userMessagesCount++;
        }

        document.getElementById('submit-end-survey').addEventListener('click', async function() {
          const button = document.getElementById('submit-end-survey');
          button.disabled = true;
          button.classList.add('opacity-50');
          const q1 = document.querySelector('input[name="q1"]:checked')?.value || 'NoInfo';
          const q2 = document.querySelector('input[name="q2"]:checked')?.value || 'NoInfo';
          const q3 = document.querySelector('input[name="q3"]:checked')?.value || 'NoInfo';
          const q5 = qualityInput.value.trim() || 'NoInfo';
          const checkedCount = document.querySelectorAll('#q4 input[type="checkbox"]:checked').length;
          if (checkedCount != 3) {
            alert("Please choose 3 responses in question: What did you like the most in AI assited interview?");
            button.disabled = false;
            button.classList.remove('opacity-50');
          }
          else {
            const q4 = Array.from(document.querySelectorAll('#q4 input[type="checkbox"]:checked')).map(checkbox => checkbox.value).join(' | ') || 'NoInfo';
            await new Promise(resolve => setTimeout(resolve, 250));
            endSurveyContainer.style.display = 'none';
            thankYouContainer.style.display = 'block';
            fetch(`/${anonymous_id}/end-survey`, {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
              },
              body: JSON.stringify({ q1, q2, q3, q4, q5 })
            })
            .catch(error => console.error("Error while saving quality survey.", error));
          }
        });

        qualityInput.addEventListener("input", function() {
          const remaining = 1000 - qualityInput.value.length;
          charCountQ.textContent = `Characters remaining: ${remaining}`;
        });
      });
    </script>

  </body>
</html>