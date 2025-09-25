<!DOCTYPE html>
<html>
<head>
    <title>Business Setup Assistant</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-blue-600 text-white p-4">
            <h2 class="text-xl font-semibold flex items-center">
                <i class="fas fa-robot mr-2"></i>
                Business Setup Assistant
            </h2>
            <p class="text-sm opacity-90">Let's create your business in minutes!</p>
        </div>

        <div id="chat-container" class="h-96 overflow-y-auto p-4 space-y-3">
            <div class="bg-blue-50 p-3 rounded-lg">
                <p class="text-sm">👋 Hi! I'm your business setup assistant. Type "start" to begin creating your business!</p>
            </div>
        </div>

        <div class="border-t p-4">
            <div class="flex space-x-2">
                <input type="text" id="user-input" class="flex-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message...">
                <button id="send-btn" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Send</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const chatContainer = document.getElementById('chat-container');
        const userInput = document.getElementById('user-input');
        const sendBtn = document.getElementById('send-btn');

        // Set up CSRF token
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function addMessage(message, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = isUser 
                ? 'bg-blue-600 text-white p-3 rounded-lg ml-auto max-w-xs'
                : 'bg-gray-100 p-3 rounded-lg max-w-xs';
            messageDiv.innerHTML = `<p class="text-sm">${message}</p>`;
            chatContainer.appendChild(messageDiv);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function sendMessage() {
            const message = userInput.value.trim();
            if (!message) return;

            addMessage(message, true);
            userInput.value = '';

            axios.post('/botman', {
                driver: 'web',
                message: message,
                userId: 'user-' + Date.now()
            }).then(response => {
                if (response.data.messages) {
                    response.data.messages.forEach(msg => {
                        addMessage(msg.text);
                    });
                }
            }).catch(error => {
                console.error('Error:', error);
                addMessage('Sorry, something went wrong. Please try again.');
            });
        }

        sendBtn.addEventListener('click', sendMessage);
        userInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        userInput.focus();
    </script>
</body>
</html>
