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
      #hello-container, #survey-container, #chat-container, #end-survey-container, #thank-you-container {
        background: rgba(255, 255, 255, 0.91);
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 10px;
      }
      #survey-container, #chat-container, #end-survey-container, #thank-you-container {
        display: none;
      }
      #chat-history {
        flex-grow: 1;
        min-height: 0;
        overflow-y: auto;
        scroll-behavior: smooth;
        background: rgba(255, 255, 255, 0.5);
        padding: 3px;
        border-radius: 8px;
        box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.05);
        scrollbar-color: rgba(180, 180, 180, 0.4) rgba(255, 255, 255, 0.4);
      }
      #char-count {
        text-align: right;
        font-size: 0.85rem;
        color: gray;
      }
      #message-input {
        resize: none;
        overflow-y: auto;
        min-height: 40px;
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
        <h2 class="text-xl mb-0 text-center">Instructions</h2>
        <h2 class="text-base mb-0 text-justify">
          <p>
            You are about to take part in an interview conducted by an AI assistant.
            The assistant will ask a few questions, just like a human interviewer.
            The questions will focus on academic success and leaving a university position.
            The interview will take about 20 minutes.
          </p>
          <br/>
          <p>The interview has two parts:</p>
          <p>
            1. A short survey with four closed questions (gender, age, discipline, and academic degree).
          </p>
          <p>
            2. The main interview – a chat-style conversation, similar to SMS.
            You will see each question and can type your answer below. 
          </p>
          <br/>
          <p>
            Please answer in detail, at least 2-3 sentences per question.
            <br/>We are interested in your individual perspective, not just general statements.
          </p>
          <br/>
          <p>Click NEXT to begin the interview.</p>
          <br/>
          <button type="button" id="start-survey-button" class="bg-blue-500 text-white w-full py-2 rounded-lg hover:bg-blue-600">
            Next
          </button>
        </h2>
      </div>

      <!--- Survey screen  --->
      <div id="survey-container" class="w-[60%] flex flex-col mt-4">

        <h2 class="text-xl mb-0 text-center">Part 1: Survey</h2>

        <form id="survey-form" class="space-y-5">

          <div class="space-y-1">
            <label class="block text-lg">1. Please select your gender:</label>
            <div class="space-x-3">
              <label class="inline-flex items-center">
                <input type="radio" id="gender" name="gender" value="Male" class="form-radio"/> <span class="ml-2">Male</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" id="gender" name="gender" value="Female" class="form-radio"/> <span class="ml-2">Female</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" id="gender" name="gender" value="PreferNotSay" class="form-radio"/> <span class="ml-2">Prefer not say</span>
              </label>
            </div>
          </div>

          <div class="space-y-1">
            <label for="age" class="block text-lg">2. Please type your age:</label>
            <input type="number" id="age" name="age" class="w-full p-1 border border-gray-300 rounded bg-white" min="20" max="100"/>
          </div>

          <div class="space-y-1">
              <label for="discipline" class="block text-lg">3. Please select your discipline:</label>
              <select id="discipline" name="discipline" class="w-full p-1 border border-gray-300 rounded bg-white">
                <option value="" disabled selected hidden>
                
                <optgroup label="1. Applied Sciences">
                  <option value="Agriculture, Fisheries & Forestry">Agriculture, Fisheries & Forestry</option>
                  <option value="Built Environment & Design">Built Environment & Design</option>
                  <option value="Enabling & Strategic Technologies">Enabling & Strategic Technologies</option>
                  <option value="Engineering">Engineering</option>
                  <option value="Information & Communication Technologies">Information & Communication Technologies</option>
                </optgroup>

                <optgroup label="2. Arts & Humanities">
                  <option value="Communication & Textual Studies">Communication & Textual Studies</option>
                  <option value="Historical Studies">Historical Studies</option>
                  <option value="Philosophy & Theology">Philosophy & Theology</option>
                  <option value="Visual & Performing Arts">Visual & Performing Arts</option>
                </optgroup>

                <optgroup label="3. Economic & Social Sciencess">
                  <option value="Economics & Business ">Economics & Business </option>
                  <option value="Social Sciences">Social Sciences</option>
                </optgroup>

                <optgroup label="4. Health Sciences">
                  <option value="Biomedical Research">Biomedical Research</option>
                  <option value="Clinical Medicine">Clinical Medicine</option>
                  <option value="Psychology & Cognitive Sciences">Psychology & Cognitive Sciencesh</option>
                  <option value="Public Health & Health Services">Public Health & Health Services</option>
                </optgroup>

                <optgroup label="5. Natural Sciences">
                  <option value="Biology">Biology</option>
                  <option value="Chemistry">Chemistry</option>
                  <option value="Earth & Environmental Sciences">Earth & Environmental Sciences</option>
                  <option value="Mathematics & Statistics">Mathematics & Statistics</option>
                  <option value="Physics & Astronomy">Physics & Astronomy</option>
                </optgroup>
              </select>
          </div>

          <div class="space-y-1">
            <label class="block text-lg">4. Please select your exact rank (or equivalent):</label>
            <div class="space-x-3">
              <label class="inline-flex items-center">
                <input type="radio" id="title" name="title" value="Assistant Professor" class="form-radio"/> <span class="ml-2">Assistant Professor</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" id="title" name="title" value="Associate Professor" class="form-radio"/> <span class="ml-2">Associate Professor</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" id="title" name="title" value="Full Professor" class="form-radio"/> <span class="ml-2">Full Professor</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" id="title" name="title" value="Researcher" class="form-radio"/> <span class="ml-2">Researcher</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" id="title" name="title" value="Other" class="form-radio"/> <span class="ml-2">Other</span>
              </label>
            </div>
          </div>

          <div class="space-y-1">
              <label for="language" class="block text-lg">5. Please select your language for interview:</label>
              <select id="language" name="language" class="w-full p-1 border border-gray-300 rounded bg-white">
                  <option value="Arabic">Arabic</option>
                  <option value="Czech">Czech</option>
                  <option value="Danish">Danish</option>
                  <option value="Dutch">Dutch</option>
                  <option value="English" selected>English</option>
                  <option value="Estonian">Estonian</option>
                  <option value="Finnish">Finnish</option>
                  <option value="French">French</option>
                  <option value="German">German</option>
                  <option value="Greek">Greek</option>
                  <option value="Hebrew">Hebrew</option>
                  <option value="Hungarian">Hungarian</option>
                  <option value="Icelandic">Icelandic</option>
                  <option value="Irish">Irish</option>
                  <option value="Italian">Italian</option>
                  <option value="Japanese">Japanese</option>
                  <option value="Latvian">Latvian</option>
                  <option value="Lithuanian">Lithuanian</option>
                  <option value="Luxembourgish">Luxembourgish</option>
                  <option value="Norwegian">Norwegian</option>
                  <option value="Polish">Polish</option>
                  <option value="Portuguese">Portuguese</option>
                  <option value="Slovak">Slovak</option>
                  <option value="Slovene">Slovene</option>
                  <option value="Spanish">Spanish</option>
                  <option value="Swedish">Swedish</option>
                  <option value="Turkish">Turkish</option>
                  <option value="Korean">Korean</option>
              </select>
          </div>
        </form>
        <br/>
        <button type="button" id="start-chat-button" class="bg-blue-500 text-white w-full py-2 rounded-lg hover:bg-blue-600">
            Next
        </button>
      </div>

      <!--- Interview  --->
      <div id="chat-container" class="flex flex-col w-[60%] mt-4 space-y-1" style="height: 70vh;">
        <h2 class="text-xl text-center">Part 2: AI Assisted Interview</h2>

        <div id="chat-history" class="flex-grow overflow-y-auto">
        </div>

        <div class="flex space-x-2 items-end text-base">
          <textarea
            id="message-input"
            class="flex-1 resize-none p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300 text-base"
            placeholder="Type message here... (type END to finish interview)"
            maxlength="1000"
            rows="1"
            autocomplete="off"
          ></textarea>
          <button id="send-button" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            Send
          </button>
        </div>

        <p id="char-count" class="text-right text-base text-gray-500 mt-1 mb-0">
          Characters remaining: 1000
        </p>
      </div>

      <!--- Post int survey  --->
      <div id="end-survey-container" class="w-[60%] flex flex-col space-y-6 mt-4">

        <h3 class="text-xl mb-0 text-center">Post interview impressions</h3>

        <form id="end-survey-form" class="space-y-6">

          <div class="text-left space-y-1">
            <label class="block text-lg">1. How would you rate your experience with the interview?</label>
            <div class="grid grid-cols-5 gap-4 place-items-center text-center max-w-5xl mx-auto">
              <label class="inline-flex items-center">
                <input type="radio" name="q1" value="Very positive" class="form-radio"/> <span class="ml-2">Very<br/>positive</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="q1" value="Somewhat positve" class="form-radio"/> <span class="ml-2">Somewhat<br/>positve</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="q1" value="Niether positive nor negative" class="form-radio"> <span class="ml-2">Niether positive<br/>nor negative</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="q1" value="Somewhat negative" class="form-radio"/> <span class="ml-2">Somewhat<br/>negative</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="q1" value="Very negative" class="form-radio"/> <span class="ml-2">Very<br/>negative</span>
              </label>
            </div>
          </div>

          <div class="text-left space-y-1">
            <label class="block text-lg">2. How natural was the interview?</label>
            <div class="grid grid-cols-5 gap-4 place-items-center text-center max-w-5xl mx-auto">
              <label class="inline-flex items-center">
                <input type="radio" name="q2" value="Very natural" class="form-radio"/> <span class="ml-2">Very<br/>natural</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="q2" value="Somewhat natural" class="form-radio"/> <span class="ml-2">Somewhat<br/>natural</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="q2" value="Neutral" class="form-radio"/> <span class="ml-2">Neutral</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="q2" value="Somewhat artificial" class="form-radio"/> <span class="ml-2">Somewhat<br/>artificial</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="q2" value="Very artificial" class="form-radio"/> <span class="ml-2">Very<br/>artificial</span>
              </label>
            </div>
          </div>

          <div class="text-left space-y-1">
            <label class="block text-lg">3. Compared with an interview conducted by human, would you prefer an AI assisted interview?</label>
            <div class="grid grid-cols-5 gap-4 place-items-center text-center max-w-5xl mx-auto">
              <label class="inline-flex items-center">
                <input type="radio" name="q3" value="Strongly AI" class="form-radio"/> <span class="ml-2">Strongly<br/>AI</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="q3" value="Somewhat AI" class="form-radio"/> <span class="ml-2">Somewhat<br/>AI</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="q3" value="No diffrence" class="form-radio"/> <span class="ml-2">No<br/>diffrence</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="q3" value="Somewhat human" class="form-radio"/> <span class="ml-2">Somewhat<br/>human</span>
              </label>
              <label class="inline-flex items-center">
                <input type="radio" name="q3" value="Strongly human" class="form-radio"/> <span class="ml-2">Strongly<br/>human</span>
              </label>
            </div>
          </div>

          <div class="text-left space-y-1">
            <label class="block text-lg">4. What did you like the most in AI assited interview? Select 3 responses.</label>
            <div id="q4" class="grid grid-cols-2 gap-2 justify-center w-fit mx-auto">
              <label class="inline-flex items-center">
                <input type="checkbox" name="feedback[]" value="Łatwość obsługi" class="form-checkbox"/> <span class="ml-2">Simplicity</span>
              </label>
              <label class="inline-flex items-center">
                <input type="checkbox" name="feedback[]" value="Szybkie odpowiedzi" class="form-checkbox"/> <span class="ml-2">Speed</span>
              </label>
              <label class="inline-flex items-center">
                <input type="checkbox" name="feedback[]" value="Brak presji" class="form-checkbox"/> <span class="ml-2">No rush</span>
              </label>
              <label class="inline-flex items-center">
                <input type="checkbox" name="feedback[]" value="Naturalny język" class="form-checkbox"/> <span class="ml-2">Natural language</span>
              </label>
              <label class="inline-flex items-center">
                <input type="checkbox" name="feedback[]" value="Jasne pytania" class="form-checkbox"/> <span class="ml-2">Clear questions</span>
              </label>
              <label class="inline-flex items-center">
                <input type="checkbox" name="feedback[]" value="Swoboda odpowiedzi" class="form-checkbox"/> <span class="ml-2">Native languages</span>
              </label>
              <label class="inline-flex items-center">
                <input type="checkbox" name="feedback[]" value="Elastyczność rozmowy" class="form-checkbox"/> <span class="ml-2">Flexibility</span>
              </label>
              <label class="inline-flex items-center">
                <input type="checkbox" name="feedback[]" value="Prywatność rozmowy" class="form-checkbox"/> <span class="ml-2">Privacy</span>
              </label>
            </div>
          </div>

          <div class="text-left space-y-1">
            <label class="block text-lg">5. Thank you for participating in the interview! Please use empty space below for any addiditonal comments.</label>
            <div class="flex justify-center space-x-4">
              <textarea
                id="q5"
                class="flex-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300 text-sm"
                placeholder="Write message..."
                maxlength="1000"
                rows="5"
                autocomplete="off"
              ></textarea>
            </div>
            <p id="char-count-q" class="text-right text-sm text-gray-500 mt-1">Characters remaining: 1000</p>
            <br/>
          <button type="button" id="submit-end-survey" class="bg-blue-500 text-white w-full py-2 rounded hover:bg-blue-600">
            Finish interview
          </button>
          </div>
        </form>
      </div>

      <!--- Thank you screen --->
      <div id="thank-you-container" class="w-full max-w-3xl flex flex-col space-y-4 mt-4">
        <br/>
        <h2 class="text-xl mb-4 text-center">
          Thank you very much for your participation in the interview.
        </h2>
        <br/>
      </div>
      
    </div>

    <!--- Footer --->
    <footer id="footer" class="bg-white text-gray-500 text-center py-4 shadow-md transition-all duration-300">
      © 2025 Adam Mickiewicz University. All rights reserved. 
      <a href="/privacy" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:underline">
        Privacy Policy
      </a>
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