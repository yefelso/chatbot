<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ChatBot</title>
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">ChatBot</div>
        <div class="chat-box" id="chat-box"></div>
        <div class="chat-input">
            <input type="text" id="question" placeholder="Escribe tu mensaje..." autocomplete="off">
            <button onclick="sendMessage()">Enviar</button>
        </div>
    </div>

    <script src="{{ asset('js/chat.js') }}"></script>
</body>
</html>
