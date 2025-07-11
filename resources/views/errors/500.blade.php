<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AMU AI-Assisted Interview</title>
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
      #hello-container{
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
      <h1 class="text-lg"> Center for Public Policy Studies<br/>AI-Assisted Interview </h1>
    </div>

    <!--- Main DIV --->
    <div class="flex-1 content-wrapper flex items-center justify-center w-full relative">
      
      <!--- Instruction screen  --->
      <div id="hello-container" class="w-full max-w-3xl flex flex-col space-y-4 mt-4">
        <br/>
        <h2 class="text-xl mb-4 text-center">
          Error 500.
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
  
  </body>
</html>