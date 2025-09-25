@extends('layouts.app')

@section('title', 'Create Your Business')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Your Business</h2>
            <p class="text-gray-600">Chat with our AI assistant to set up your business in minutes</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-blue-600 text-white p-4">
                <div class="flex items-center">
                    <div class="bg-blue-500 rounded-full p-2 mr-3">
                        <i class="fas fa-robot text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Business Setup Assistant</h3>
                        <p class="text-blue-100 text-sm">Let's create your business together!</p>
                    </div>
                </div>
            </div>

            <div id="chat-container" class="h-96 overflow-y-auto p-4 space-y-3 bg-gray-50">
                <div class="bg-white p-4 rounded-lg border-l-4 border-blue-500 shadow-sm">
                    <div class="flex items-start">
                        <div class="bg-blue-100 rounded-full p-2 mr-3">
                            <i class="fas fa-robot text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800">👋 Hi! I'm your business setup assistant. Type <strong>"start"</strong> to begin creating your business!</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t p-4 bg-white">
                <div class="flex space-x-2">
                    <input 
                        type="text" 
                        id="user-input" 
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                        placeholder="Type your message..."
                        autocomplete="off"
                    >
                    <button 
                        id="send-btn" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center"
                    >
                        <i class="fas fa-paper-plane mr-1"></i>
                        Send
                    </button>
                </div>
                <div class="mt-2 text-xs text-gray-500">
                    Tip: Type "start" to begin the setup process
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="/" class="text-blue-600 hover:text-blue-800">← Back to Home</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatContainer = document.getElementById('chat-container');
        const userInput = document.getElementById('user-input');
        const sendBtn = document.getElementById('send-btn');

        // Set up CSRF token for axios
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function addMessage(message, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = isUser 
                ? 'flex justify-end'
                : 'flex justify-start';

            const messageBubble = document.createElement('div');
            messageBubble.className = isUser
                ? 'bg-blue-600 text-white p-3 rounded-lg max-w-xs shadow-sm'
                : 'bg-white p-4 rounded-lg border-l-4 border-blue-500 shadow-sm max-w-md';

            if (isUser) {
                messageBubble.innerHTML = `<p class="text-sm">${message}</p>`;
            } else {
                messageBubble.innerHTML = `
                    <div class="flex items-start">
                        <div class="bg-blue-100 rounded-full p-2 mr-3 flex-shrink-0">
                            <i class="fas fa-robot text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800">${message}</p>
                        </div>
                    </div>
                `;
            }

            messageDiv.appendChild(messageBubble);
            chatContainer.appendChild(messageDiv);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function sendMessage() {
            const message = userInput.value.trim();
            if (!message) return;

            addMessage(message, true);
            userInput.value = '';
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Sending...';

            axios.post('/botman', {
                driver: 'web',
                message: message,
                userId: 'user-' + Date.now()
            }).then(response => {
                if (response.data && response.data.messages) {
                    response.data.messages.forEach(msg => {
                        setTimeout(() => {
                            addMessage(msg.text || msg);
                        }, 300);
                    });
                } else if (response.data) {
                    setTimeout(() => {
                        addMessage(response.data);
                    }, 300);
                }
            }).catch(error => {
                console.error('Error:', error);
                setTimeout(() => {
                    addMessage('Sorry, something went wrong. Please try again.');
                }, 300);
            }).finally(() => {
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<i class="fas fa-paper-plane mr-1"></i> Send';
            });
        }

        sendBtn.addEventListener('click', sendMessage);
        userInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Auto-focus input
        userInput.focus();
    });
</script>
@endpush
@endsection
