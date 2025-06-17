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
        background: rgba(255, 255, 255, 1);
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
      <div id="hello-container" class="w-[95%] md:w-[60%] flex flex-col space-y-3 mt-4" style="display: block;">
        <h2 class="text-xl mb-0 text-center">Privacy Policy</h2>
        <p class="text-sm text-center text-gray-500">Last updated: June 16, 2025</p>
        <div class="text-justify">
          <p>1. Data Controller<br>
          The data controller is Adam Mickiewicz University in Poznań, located at Wieniawskiego 1, 61-712 Poznań, Poland. For matters related to personal data protection, please contact at: cpps@amu.edu.pl.</p>
          <br>
          <p>2. Scope of Collected Data<br>
          As part of participating in the interview conducted by the AI assistant, the following data is collected: demographic information (gender, age, academic discipline, academic rank), selected language, the content of your responses during the interview, post-interview feedback, an anonymous session ID (without identifying information), and technical data such as IP address, browser type, and session duration.</p>
          <br>
          <p>3. Purpose of Data Processing<br>
          The data is processed for the purpose of conducting academic research on AI-supported interviews, analyzing user responses and feedback, and ensuring system security and legal compliance.</p>
          <br>
          <p>4. Use of AI Technology<br>
          The conversation is carried out using an AI assistant that automatically generates responses. The assistant does not possess consciousness or make personal decisions. You may end the interview at any time by typing “END”.</p>
          <br>
          <p>5. Legal Basis for Processing<br>
          Personal data is processed on the basis of Article 6(1)(a) of the GDPR (user consent) and Article 6(1)(f) (legitimate interests of the controller – conducting research and improving services).</p>
          <br>
          <p>6. Data Recipients<br>
          The data is not shared with third parties, except as required by law or when accessed by the research team in anonymized form only.</p>
          <br>
          <p>7. Data Retention Period<br>
          Data will be stored for a maximum of 3 years after the end of data collection or until the consent is withdrawn.</p>
          <br>
          <p>8. User Rights<br>
          You have the right to access your data, request correction or deletion, restrict processing, withdraw consent at any time, and file a complaint with the data protection authority.</p>
          <br>
          <p>9. Voluntary Participation<br>
          Participation in the interview is entirely voluntary and may be withdrawn at any time without providing a reason.</p>
          <br>
          <p>10. Cookies and Server Logs<br>
          The website may use cookies and collect technical data (such as IP address and browser type) to ensure proper functionality and for anonymous statistical analysis.</p>
        </div>
      </div>
    </div>

    <!--- Footer --->
    <footer id="footer" class="bg-white text-gray-500 text-center py-4 shadow-md transition-all duration-300">
      © 2025 Adam Mickiewicz University. All rights reserved. 
      <a href="/privacy" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:underline">
        Privacy Policy
      </a>
    </footer>
  </body>
</html>