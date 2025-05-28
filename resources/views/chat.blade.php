<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wywiad z Asystentem AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: url("{{ asset('images/chat-bg.jpg') }}") no-repeat center center fixed;
            background-size: cover;
        }

        #header-bar {
            background-color: white;
            width: 100%;
            padding: 0px 0;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }

        #hello-container, #survey-container, #chat-container, #end-survey-container, #thank-you-container {
            display: none;
            background: rgba(255, 255, 255, 0.91);
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 6px;
        }

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

        #char-count {
            text-align: right;
            font-size: 0.85rem;
            color: gray;
        }

        #message-input {
            resize: none;
            overflow-y: hidden;
            min-height: 40px;
        }

        footer {
            margin-top: 20px;
            background-color: #ffffff;
            box-shadow: 0px -2px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
  </head>
  <body class="min-h-screen flex flex-col">

    <!-- Pasek nagłówka -->
    <div id="header-bar" class="flex justify-center items-center py-2 px-4">
      <img
        src="{{ asset('images/university-logo.jpg') }}"
        alt="Logo Uczelni"
        class="h-14 object-contain mr-4"
      />
      <h1 class="text-lg font-semibold text-gray-800">
        Wywiad z asystentem AI
      </h1>
    </div>

    <!-- Sekcja z ANKIETĄ -->
    <div class="flex-1 content-wrapper flex items-center justify-center w-full relative">

      <!-- Ekran z powitaniem -->
      <div id="hello-container" class="w-full max-w-3xl flex flex-col space-y-4 mt-4" style="display: none;">
      <h2 class="text-s mb-4 text-center">
          INSTRUKCJA
          <br />
          <br />
          <p>
            Za chwilę wezmą Państwo udział w wywiadzie przeprowadzonym przez
            asystenta sztucznej inteligencji. Asystent zada kilka pytań –
            dokładnie tak, jak przeprowadzający wywiad. Wywiad będzie dotyczył
            sukcesu w pracy akademickiej i rezygnacji z pracy na uczelni.
            Orientacyjny czas to około 20 minut.
          </p>
          <br />
          <p>Wywiad podzielony jest na dwie części:</p>
          <ul>
            <li>
              <span class="highlight">1. Krótki formularz</span> – cztery
              pytania zamknięte (płeć, wiek, dyscyplina i stopień naukowy).
            </li>
            <li>
              <span class="highlight">2. Główna rozmowa</span> – Rozmowa
              przypominająca wymianę wiadomości SMS na telefonie. Najpierw
              pojawi się pytanie, a następnie możliwość wprowadzenia odpowiedzi
              na dole ekranu. Przy żadnym pytaniu nie ma ograniczenia czasowego.
              Historia pytań i odpowiedzi jest zapisywana automatycznie.
            </li>
          </ul>
          <br />
          <p>
            Prosimy o wyczerpujące odpowiedzi. Zależy nam bardzo na szczegółach.
            Interesuje nas indywidualna perspektywa, wychodząca poza ogólne
            stwierdzenia. Poprosilibyśmy o co najmniej 2-3 zdania przy każdym
            pytaniu.
          </p>
          <br />
          <p>
          Prosimy o rozpoczęcie wywiadu klikając przycisk DALEJ.
          </p>
          <br />
          <button
            type="button"
            id="start-survey-button"
            class="bg-blue-500 text-white w-full py-2 rounded hover:bg-blue-600"
          >
            Dalej
          </button>
        </h2>
        </div>

      <div id="survey-container" class="w-full max-w-3xl flex flex-col space-y-4 mt-4">

        <form id="survey-form" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Płeć:</label>
            <div class="space-y-2">
              <label class="inline-flex items-center">
                <input
                  type="radio"
                  id="gender"
                  name="gender"
                  value="Male"
                  class="form-radio text-blue-500"
                />
                <span class="ml-2">Mężczyzna</span>
              </label>
              <label class="inline-flex items-center">
                <input
                  type="radio"
                  id="gender"
                  name="gender"
                  value="Female"
                  class="form-radio text-blue-500"
                />
                <span class="ml-2">Kobieta</span>
              </label>
              <label class="inline-flex items-center">
                <input
                  type="radio"
                  id="gender"
                  name="gender"
                  value="NoComment"
                  class="form-radio text-blue-500"
                />
                <span class="ml-2">Wolę nie odpowiadać</span>
              </label>
            </div>
          </div>
          <div>
            <label for="age" class="block text-sm font-medium text-gray-700"
              >Wiek:</label
            >
            <input
              type="number"
              id="age"
              name="age"
              class="w-full p-2 border border-gray-300 rounded"
              min="20"
              max="100"
            />
          </div>

          <div>
            <label
              for="discipline"
              class="block text-sm font-medium text-gray-700"
              >Dyscyplina naukowa:</label
            >
            <select
              id="discipline"
              name="discipline"
              class="w-full p-2 border border-gray-300 rounded"
            >
              <option value="" disabled selected>
                -- Wybierz dyscyplinę --
              </option>

              <!-- Dziedzina nauk humanistycznych -->
              <optgroup label="1. Dziedzina nauk humanistycznych">
                <option value="Archeologia">Archeologia</option>
                <option value="Etnologia i antropologia kulturowa">
                  Etnologia i antropologia kulturowa
                </option>
                <option value="Filozofia">Filozofia</option>
                <option value="Historia">Historia</option>
                <option value="Językoznawstwo">Językoznawstwo</option>
                <option value="Literaturoznawstwo">Literaturoznawstwo</option>
                <option value="Nauki o kulturze i religii">
                  Nauki o kulturze i religii
                </option>
                <option value="Nauki o sztuce">Nauki o sztuce</option>
                <option value="Polonistyka">Polonistyka</option>
              </optgroup>

              <!-- Dziedzina nauk inżynieryjno-technicznych -->
              <optgroup label="2. Dziedzina nauk inżynieryjno-technicznych">
                <option value="Architektura i urbanistyka">
                  Architektura i urbanistyka
                </option>
                <option
                  value="Automatyka, elektronika, elektrotechnika i technologiekosmiczne"
                >
                  Automatyka, elektronika, elektrotechnika i technologie
                  kosmiczne
                </option>
                <option value="Informatyka techniczna i telekomunikacja">
                  Informatyka techniczna i telekomunikacja
                </option>
                <option value="Inżynieria bezpieczeństwa">
                  Inżynieria bezpieczeństwa
                </option>
                <option value="Inżynieria biomedyczna">
                  Inżynieria biomedyczna
                </option>
                <option value="Inżynieria chemiczna">
                  Inżynieria chemiczna
                </option>
                <option value="Inżynieria lądowa, geodezja i transport">
                  Inżynieria lądowa, geodezja i transport
                </option>
                <option value="Inżynieria materiałowa">
                  Inżynieria materiałowa
                </option>
                <option value="Inżynieria mechaniczna">
                  Inżynieria mechaniczna
                </option>
                <option value="Inżynieria środowiska, górnictwo i energetyka">
                  Inżynieria środowiska, górnictwo i energetyka
                </option>
                <option value="Ochrona dziedzictwa i konserwacja zabytków">
                  Ochrona dziedzictwa i konserwacja zabytków
                </option>
              </optgroup>

              <!-- Dziedzina nauk medycznych i nauk o zdrowiu -->
              <optgroup label="3. Dziedzina nauk medycznych i nauk o zdrowiu">
                <option value="Biologia medyczna">Biologia medyczna</option>
                <option value="Nauki farmaceutyczne">
                  Nauki farmaceutyczne
                </option>
                <option value="Nauki medyczne">Nauki medyczne</option>
                <option value="Nauki o kulturze fizycznej">
                  Nauki o kulturze fizycznej
                </option>
                <option value="Nauki o zdrowiu">Nauki o zdrowiu</option>
              </optgroup>

              <!-- Dziedzina nauk o rodzinie -->
              <optgroup label="4. Dziedzina nauk o rodzinie">
                <option value="Nauki o rodzinie">Nauki o rodzinie</option>
              </optgroup>

              <!-- Dziedzina nauk rolniczych -->
              <optgroup label="5. Dziedzina nauk rolniczych">
                <option value="Nauki leśne">Nauki leśne</option>
                <option value="Rolnictwo i ogrodnictwo">
                  Rolnictwo i ogrodnictwo
                </option>
                <option value="Technologia żywności i żywienia">
                  Technologia żywności i żywienia
                </option>
                <option value="Zootechnika i rybactwo">
                  Zootechnika i rybactwo
                </option>
              </optgroup>

              <!-- Dziedzina nauk społecznych -->
              <optgroup label="6. Dziedzina nauk społecznych">
                <option value="Ekonomia i finanse">Ekonomia i finanse</option>
                <option
                  value="Geografia społeczno-ekonomiczna i gospodarka przestrzenna"
                >
                  Geografia społeczno-ekonomiczna i gospodarka przestrzenna
                </option>
                <option value="Nauki o bezpieczeństwie">
                  Nauki o bezpieczeństwie
                </option>
                <option value="Nauki o komunikacji społecznej i mediach">
                  Nauki o komunikacji społecznej i mediach
                </option>
                <option value="Nauki o zarządzaniu i jakości">
                  Nauki o zarządzaniu i jakości
                </option>
                <option value="Nauki prawne">Nauki prawne</option>
                <option value="Nauki socjologiczne">Nauki socjologiczne</option>
                <option value="Pedagogika">Pedagogika</option>
                <option value="Psychologia">Psychologia</option>
              </optgroup>

              <!-- Dziedzina nauk ścisłych i przyrodniczych -->
              <optgroup label="7. Dziedzina nauk ścisłych i przyrodniczych">
                <option value="Astronomia">Astronomia</option>
                <option value="Biotechnologia">Biotechnologia</option>
                <option value="Informatyka">Informatyka</option>
                <option value="Matematyka">Matematyka</option>
                <option value="Nauki biologiczne">Nauki biologiczne</option>
                <option value="Nauki fizyczne">Nauki fizyczne</option>
              </optgroup>

              <!-- Dziedzina nauk teologicznych -->
              <optgroup label="8. Dziedzina nauk teologicznych">
                <option value="Nauki biblijne">Nauki biblijne</option>
                <option value="Nauki teologiczne">Nauki teologiczne</option>
              </optgroup>

              <!-- Dziedzina nauk weterynaryjnych -->
              <optgroup label="9. Dziedzina nauk weterynaryjnych">
                <option value="Weterynaria">Weterynaria</option>
              </optgroup>

              <!-- Dziedzina sztuki -->
              <optgroup label="10. Dziedzina sztuki">
                <option value="Sztuki filmowe i teatralne">
                  Sztuki filmowe i teatralne
                </option>
                <option value="Sztuki muzyczne">Sztuki muzyczne</option>
                <option value="Sztuki plastyczne i konserwacja dzieł sztuki">
                  Sztuki plastyczne i konserwacja dzieł sztuki
                </option>
              </optgroup>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700"
              >Najwyższy stopień lub tytuł naukowy:</label
            >
            <div class="space-y-2">
              <label class="inline-flex items-center">
                <input
                  type="radio"
                  id="title"
                  name="title"
                  value="Magisterium"
                  class="form-radio text-blue-500"
                />
                <span class="ml-2">Magisterium</span>
              </label>
              <label class="inline-flex items-center">
                <input
                  type="radio"
                  id="title"
                  name="title"
                  value="Doktorat"
                  class="form-radio text-blue-500"
                />
                <span class="ml-2">Doktorat</span>
              </label>
              <label class="inline-flex items-center">
                <input
                  type="radio"
                  id="title"
                  name="title"
                  value="Habilitacja"
                  class="form-radio text-blue-500"
                />
                <span class="ml-2">Habilitacja</span>
              </label>
              <label class="inline-flex items-center">
                <input
                  type="radio"
                  id="title"
                  name="title"
                  value="Profesura tytularna"
                  class="form-radio text-blue-500"
                />
                <span class="ml-2">Profesura tytularna</span>
              </label>
            </div>
          </div>
          <button
            type="button"
            id="start-chat-button"
            class="bg-blue-500 text-white w-full py-2 rounded hover:bg-blue-600"
          >
            Dalej
          </button>
        </form>
      </div>

      <!-- Kontener czatu -->
      <div id="chat-container" class="w-full max-w-3xl flex flex-col space-y-4 mt-4">
        <h2 class="text-xl font-bold mb-4 text-center"></h2>
        <div id="chat-history"></div>
        <div class="flex mt-4 space-x-2">
          <textarea
            id="message-input"
            class="flex-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300 text-sm"
            placeholder="Napisz wiadomość..."
            maxlength="1000"
            rows="1"
            autocomplete="off"
          ></textarea>
          <button
            id="send-button"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
          >
            Wyślij
          </button>
        </div>
        <p id="char-count" class="text-right text-sm text-gray-500 mt-1">
          Pozostało: 1000 znaków
        </p>

        <button
          id="end-chat-button"
          class="bg-red-500 text-white w-full py-2 rounded hover:bg-red-600 mt-4"
        >
          Zakończ czat
        </button>
      </div>

      <!-- Ankieta na zakończenie -->
      <div id="end-survey-container" class="w-full max-w-3xl flex flex-col space-y-4 mt-4" style="display: none;">
        <h2 class="text-xl font-bold mb-4 text-center">
          Wrażenia po wywiadzie
        </h2>

        <form id="end-survey-form" class="space-y-4">
          <p class="text-center mb-4">
            Jak Państwo oceniacie swoje wrażenia z wywiadu przeprowadzonego przez
            asystenta sztucznej inteligencji:
          </p>
          <div class="flex justify-center space-x-4">
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q1"
                value="Bardzo dobre"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Bardzo dobre</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q1"
                value="Dobre"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Dobre</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q1"
                value="Ani dobre, ani złe (neutralne)"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Ani dobre, ani złe (neutralne)</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q1"
                value="Złe"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Złe</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q1"
                value="Bardzo złe"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Bardzo złe</span>
            </label>
          </div>

          <br />

          <p class="text-center mb-4">
            Jak oceniacie Państwo naturalność rozmowy z asystentem?
          </p>
          <div class="flex justify-center space-x-4">
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q2"
                value="Bardzo naturalna"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Bardzo naturalna</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q2"
                value="Raczej naturalna"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Raczej naturalna</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q2"
                value="Ani naturalna, ani sztuczna"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Ani naturalna, ani sztuczna</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q2"
                value="Raczej sztuczna"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Raczej sztuczna</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q2"
                value="Bardzo sztuczna"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Bardzo sztuczna</span>
            </label>
          </div>

          <br />

          <p class="text-center mb-4">
            Czy w porównaniu z wywiadem przeprowadzonym przez człowieka bardziej
            odpowiada Państwu wywiad przeprowadzony przez asystenta sztucznej
            inteligencji?
          </p>
          <div class="flex justify-center space-x-4">
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q3"
                value="Zdecydowanie wolę asystenta"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Zdecydowanie wolę asystenta</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q3"
                value="Raczej wolę asystenta"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Raczej wolę asystenta</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q3"
                value="Nie widzę różnicy"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Nie widzę różnicy</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q3"
                value="Raczej wolę człowieka"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Raczej wolę człowieka</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                name="q3"
                value="Zdecydowanie wolę człowieka"
                class="form-radio text-blue-500"
              />
              <span class="ml-2">Zdecydowanie wolę człowieka</span>
            </label>
          </div>

          <br />

          <p class="text-center mb-4">
            Co najbardziej spodobało się Państwu w formule wywiadu z asystentem?
            Wybierz trzy odpowiedzi.
          </p>
          <div id="q4" class="grid grid-cols-2 gap-2">
            <label class="inline-flex items-center">
              <input
                type="checkbox"
                name="feedback[]"
                value="Łatwość obsługi"
                class="form-checkbox text-blue-500"
              />
              <span class="ml-2">Łatwość obsługi</span>
            </label>

            <label class="inline-flex items-center">
              <input
                type="checkbox"
                name="feedback[]"
                value="Szybkie odpowiedzi"
                class="form-checkbox text-blue-500"
              />
              <span class="ml-2">Szybkie odpowiedzi</span>
            </label>

            <label class="inline-flex items-center">
              <input
                type="checkbox"
                name="feedback[]"
                value="Brak presji"
                class="form-checkbox text-blue-500"
              />
              <span class="ml-2">Brak presji</span>
            </label>

            <label class="inline-flex items-center">
              <input
                type="checkbox"
                name="feedback[]"
                value="Naturalny język"
                class="form-checkbox text-blue-500"
              />
              <span class="ml-2">Naturalny język</span>
            </label>

            <label class="inline-flex items-center">
              <input
                type="checkbox"
                name="feedback[]"
                value="Uprzejmy ton"
                class="form-checkbox text-blue-500"
              />
              <span class="ml-2">Uprzejmy ton</span>
            </label>

            <label class="inline-flex items-center">
              <input
                type="checkbox"
                name="feedback[]"
                value="Jasne pytania"
                class="form-checkbox text-blue-500"
              />
              <span class="ml-2">Jasne pytania</span>
            </label>

            <label class="inline-flex items-center">
              <input
                type="checkbox"
                name="feedback[]"
                value="Swoboda odpowiedzi"
                class="form-checkbox text-blue-500"
              />
              <span class="ml-2">Swoboda odpowiedzi</span>
            </label>

            <label class="inline-flex items-center">
              <input
                type="checkbox"
                name="feedback[]"
                value="Elastyczność rozmowy"
                class="form-checkbox text-blue-500"
              />
              <span class="ml-2">Elastyczność rozmowy</span>
            </label>

            <label class="inline-flex items-center">
              <input
                type="checkbox"
                name="feedback[]"
                value="Prywatność rozmowy"
                class="form-checkbox text-blue-500"
              />
              <span class="ml-2">Prywatność rozmowy</span>
            </label>

            <label class="inline-flex items-center">
              <input
                type="checkbox"
                name="feedback[]"
                value="Spokojne tempo"
                class="form-checkbox text-blue-500"
              />
              <span class="ml-2">Spokojne tempo</span>
            </label>
          </div>

          <br />
          <p class="text-center mb-4">
            Dziękujemy za udział w wywiadzie. Gdyby chcieli Państwo jeszcze coś
            dodać, to prosimy o skorzystanie z pola udostępnionego poniżej.
          </p>
          <div class="flex justify-center space-x-4">
            <textarea
              id="q5"
              class="flex-1 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300 text-sm"
              placeholder="Napisz wiadomość..."
              maxlength="1000"
              rows="5"
              autocomplete="off"
            ></textarea>
          </div>
          <p id="char-count-q" class="text-right text-sm text-gray-500 mt-1">
            Pozostało: 1000 znaków
          </p>

          <br />
          <button
            type="button"
            id="submit-end-survey"
            class="bg-blue-500 text-white w-full py-2 rounded hover:bg-blue-600"
          >
            Prześlij odpowiedź
          </button>
        </form>
      </div>

      <!-- Ekran z podziękowaniem -->
      <div id="thank-you-container" class="w-full max-w-3xl flex flex-col space-y-4 mt-4" style="display: none;">
      <br/>
        <h2 class="text-xl font-bold mb-4 text-center">
          Dziękujemy za udział w wywiadzie.
        </h2>
        <br/>
        <br/>
      </div>
    </div>

    <!-- Stopka -->
    <footer id="footer" class="bg-white text-gray-500 text-center py-4 shadow-md transition-all duration-300">
      © 2025 Uniwersytet im. Adama Mickiewicza w Poznaniu. Wszelkie prawa zastrzeżone.
    </footer>

    <script>
      document.addEventListener("DOMContentLoaded", async function() {
          let noMessagesByUser = 0;

          const helloContainer = document.getElementById('hello-container');
          const surveyContainer = document.getElementById('survey-container');
          const chatContainer = document.getElementById('chat-container');
          const endSurveyContainer = document.getElementById('end-survey-container');
          const thankYouContainer = document.getElementById('thank-you-container');
          const chatHistory = document.getElementById('chat-history');
          const messageInput = document.getElementById("message-input");
          const qualityInput = document.getElementById("q5");
          const sendButton = document.getElementById("send-button");
          const charCount = document.getElementById("char-count");
          const charCountQ = document.getElementById("char-count-q");

          const baseUrl = "{{ url('/') }}";
          const chatId = window.location.pathname.split('/').pop();

          const q4 = document.querySelectorAll('#q4 input[type="checkbox"]');


          const observer = new MutationObserver(() => {
              chatHistory.scrollTop = chatHistory.scrollHeight;
          });

          // Konfiguracja observera - śledzi nowe elementy w chatHistory
          observer.observe(chatHistory, {
              childList: true, // Śledzi dodanie nowych elementów
              subtree: true    // Śledzi zmiany w zagnieżdżonych elementach
          });

          // Ładowanie historii czatu
          function loadChatHistory() {
              fetch(`/chat/${chatId}/get-history`)
              .then(response => response.json())
              .then(data => {
                  chatHistory.innerHTML = '';
                  data.messages.forEach(message => {
                      appendMessage(message.content, message.is_bot);
                  });

                  sendButton.disabled = false;
                  sendButton.classList.remove('opacity-50');
              })
              .catch(error => console.error("Błąd przy ładowaniu historii czatu:", error));

              scrollToBottom();
          }

          // Wybór ekranu
          fetch(`/chat/${chatId}/check-survey-status`)
          .then(response => response.json())
          .then(data => {
              if (data.hasCompletedSurvey && !data.hasCompletedChat && !data.hasCompletedPostSurvey) {
                helloContainer.style.display = 'none';
                surveyContainer.style.display = 'none';
                chatContainer.style.display = 'block';
                endSurveyContainer.style.display = 'none';
                thankYouContainer.style.display = 'none';
                loadChatHistory();
                scrollToBottom();
              }
              else if (data.hasCompletedSurvey && data.hasCompletedChat && !data.hasCompletedPostSurvey) {
                helloContainer.style.display = 'none';
                surveyContainer.style.display = 'none';
                chatContainer.style.display = 'none';
                endSurveyContainer.style.display = 'block';
                thankYouContainer.style.display = 'none';
              }
              else if (data.hasCompletedSurvey && data.hasCompletedChat && data.hasCompletedPostSurvey) {
                helloContainer.style.display = 'none';
                surveyContainer.style.display = 'none';
                chatContainer.style.display = 'none';
                endSurveyContainer.style.display = 'none';
                thankYouContainer.style.display = 'block';
              }
              else {
                helloContainer.style.display = 'block';
                surveyContainer.style.display = 'none';
                chatContainer.style.display = 'none';
                endSurveyContainer.style.display = 'none';
                thankYouContainer.style.display = 'none';
              }
          })
          .catch(error => {
            console.error("Błąd przy sprawdzaniu statusu ankiety:", error);
            surveyContainer.style.display = 'block';
          });

          document.getElementById('start-survey-button').addEventListener('click', async function(event) {
            const button = document.getElementById('start-survey-button');
            button.disabled = true;
            button.classList.add('opacity-50');
            await new Promise(resolve => setTimeout(resolve, 500));

            helloContainer.style.display = 'none';
            surveyContainer.style.display = 'block';
            chatContainer.style.display = 'none';
            endSurveyContainer.style.display = 'none';
            thankYouContainer.style.display = 'none';
          });

          // Zapis ankiety i rozpoczęcie czatu
          document.getElementById('start-chat-button').addEventListener('click', async function(event) {
            
            const genderElement = document.getElementById('gender');
            const ageElement = document.getElementById('age');
            const disciplineElement = document.getElementById('discipline');
            const titleElement = document.getElementById('title');

            const gender = document.querySelector('input[name="gender"]:checked')?.value || 'NoInfo';
            const age = ageElement.value || 0;
            const discipline = document.querySelector('select[name="discipline"]')?.value || 'NoInfo';
            const title = document.querySelector('input[name="title"]:checked')?.value || 'NoInfo';

            if (gender == "NoInfo" || age < 20 || age > 100 || discipline == "NoInfo" || title == "NoInfo") {
            alert("Proszę odpowiedzieć poprawnie na wszystkie pytania.");
          }
          else{
            const button = document.getElementById('start-chat-button');
            button.disabled = true;
            button.classList.add('opacity-50');
            await new Promise(resolve => setTimeout(resolve, 500));

            sendButton.disabled = true;
            sendButton.classList.add('opacity-50');

            surveyContainer.style.display = 'none';
            chatContainer.style.display = 'block';
            endSurveyContainer.style.display = 'none';
            thankYouContainer.style.display = 'none';

            fetch(`/chat/${chatId}/store-survey`, {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
              },
              body: JSON.stringify({ gender, age, discipline, title })
            })
            .then(() => {
              loadChatHistory();
              scrollToBottom()
            })
            .catch(error => console.error("Błąd przy zapisie ankiety:", error));
          }
          });

          // Automatyczne przewijanie czatu na start
          scrollToBottom();

          // Czatowanie
          sendButton.addEventListener("click", function(event) {
            event.preventDefault();
            sendMessage();
          }
          );
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

              sendButton.disabled = true;
              sendButton.classList.add('opacity-50');

              appendMessage(message, false);

              fetch(`/chat/${chatId}/send-message`, {
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
                  scrollToBottom();

                  sendButton.disabled = false;
                  sendButton.classList.remove('opacity-50');

                  if (data.checkEnd == "End" || noMessagesByUser >= 25 ) {
                      appendMessage("Dziękujemy za udział w wywiadzie. Musimy w tym momencie zakończyć. Za chwile zostaniesz przekierowany.", true);

                      // Blokowanie przycisku
                      const endChatButton = document.getElementById('end-chat-button');
                      endChatButton.disabled = true;
                      endChatButton.classList.add('opacity-50');

                      sendButton.disabled = true;
                      sendButton.classList.add('opacity-50');

                      // Oczekiwanie 3 sekundy przed fetch'em
                      setTimeout(() => {
                          fetch(`/chat/${chatId}/end-chat`, {
                              method: "POST",
                              headers: {
                                  "Content-Type": "application/json",
                                  "X-CSRF-TOKEN": "{{ csrf_token() }}"
                              }
                          })
                          .then(response => response.json())
                          .then(() => {
                              surveyContainer.style.display = 'none';
                              chatContainer.style.display = 'none';
                              endSurveyContainer.style.display = 'block';
                              thankYouContainer.style.display = 'none';
                          })
                          .catch(error => console.error("Błąd:", error));
                      }, 5000); // Oczekiwanie XXX sekund
                  }
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

            if (!isBot) {
                noMessagesByUser++;
            }
          }

          function updateCharCount() {
            const remaining = 1000 - messageInput.value.length;
            charCount.textContent = `Pozostało: ${remaining} znaków`;
          }

          function adjustTextareaHeight() {
            messageInput.style.height = "auto";
            messageInput.style.height = messageInput.scrollHeight + "px";
          }

          function scrollToBottom() {
              requestAnimationFrame(() => {
                  chatHistory.scrollTop = chatHistory.scrollHeight;
              });
          }


        // Kończenie czatu
        document.getElementById('end-chat-button').addEventListener('click', async function (event) {
            const button = document.getElementById('end-chat-button');
            button.disabled = true;
            button.classList.add('opacity-50');

            sendButton.disabled = true;
            sendButton.classList.add('opacity-50');

            await new Promise(resolve => setTimeout(resolve, 500));
          
          fetch(`/chat/${chatId}/end-chat`, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
          })
          .then(response => response.json())
          .then(() => {
            surveyContainer.style.display = 'none';
             chatContainer.style.display = 'none';
             endSurveyContainer.style.display = 'block';
             thankYouContainer.style.display = 'none';
          })
          .catch(error => console.error("Błąd:", error));
        });

        // Obsługa ankiety końcowej
        document.getElementById('submit-end-survey').addEventListener('click', async function (event) {
            const button = document.getElementById('submit-end-survey');
            button.disabled = true;
            button.classList.add('opacity-50');
            await new Promise(resolve => setTimeout(resolve, 500));

          const q1 = document.querySelector('input[name="q1"]:checked')?.value || 'NoInfo';
          const q2 = document.querySelector('input[name="q2"]:checked')?.value || 'NoInfo';
          const q3 = document.querySelector('input[name="q3"]:checked')?.value || 'NoInfo';
          const q5 = qualityInput.value.trim() || 'NoInfo';
          const checkedCount = document.querySelectorAll('#q4 input[type="checkbox"]:checked').length;

          if (checkedCount > 3) {
            alert("Proszę wybrać maksymalnie 3 odpowiedzi w sekcji 'Co najbardziej się spodobało'.");
            button.disabled = false;
            button.classList.remove('opacity-50');
          }
          else {
            const q4 = Array.from(document.querySelectorAll('#q4 input[type="checkbox"]:checked')).map(checkbox => checkbox.value).join(' | ') || 'NoInfo';
            
            fetch(`/chat/${chatId}/end-survey`, {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
              },
              body: JSON.stringify({ q1, q2, q3, q4, q5 })
            })
            .then(response => {
              if (!response.ok) {
                throw new Error('Błąd przy zapisie ankiety końcowej!');
              }
              return response.json();
            })
            .then(() => {
                      surveyContainer.style.display = 'none';
                      chatContainer.style.display = 'none';
                      endSurveyContainer.style.display = 'none';
                      thankYouContainer.style.display = 'block';
            })
            .catch(error => console.error("Błąd przy zapisie ankiety końcowej:", error));
          }
        });

        function updateCharCountQ() {
          const remaining = 1000 - qualityInput.value.length;
          charCountQ.textContent = `Pozostało: ${remaining} znaków`;
        }

        qualityInput.addEventListener("input", function() {
          updateCharCountQ();
          adjustTextareaHeight();
        });


        let buttonTimeouts = {};

        function disableButtonForSeconds(button, seconds) {
          if (buttonTimeouts[button.id]) {
            clearTimeout(buttonTimeouts[button.id]);  // Anuluje poprzedni timer
          }
          
          button.disabled = true;
          button.classList.add('opacity-50'); // Wizualne oznaczenie
          
          buttonTimeouts[button.id] = setTimeout(() => {
            button.disabled = false;
            button.classList.remove('opacity-50');
            delete buttonTimeouts[button.id]; // Usuwa timer po zakończeniu
          }, seconds * 1000);
        }

      });
    </script>
  </body>
</html>
