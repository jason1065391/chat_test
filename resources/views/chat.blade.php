<!DOCTYPE html>
<html>
<head>
    <title>Chat Room</title>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Add some basic styling */
        #chat {
            width: 400px;
            margin: 0 auto;
        }
        .message {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div id="chat">
        <div v-for="message in messages" :key="message.id" class="message">
            <strong>@{{ message.user_name }}:</strong> @{{ message.message }}
        </div>
        <input v-model="userName" placeholder="Your name">
        <textarea v-model="newMessage" placeholder="Type a message..."></textarea>
        <button @click="sendMessage">Send</button>
    </div>

    <script>
        var pusher = new Pusher('a401a4d25e156a3b09fc', {
            cluster: 'ap3'
        });

        var channel = pusher.subscribe('chat');
        channel.bind('message-sent', function(data) {
            app.addMessage(data.message);
        });

        var app = new Vue({
            el: '#chat',
            data: {
                userName: '',
                newMessage: '',
                messages: []
            },
            created() {
                this.fetchMessages();
            },
            methods: {
                sendMessage() {
                    if (this.userName && this.newMessage) {
                        fetch('/chat_test_v0/public/send-message', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                user_name: this.userName,
                                message: this.newMessage
                            })
                        }).then(response => response.json())
                          .then(data => {
                              this.newMessage = '';
                          })
                          .catch(error => {
                              console.error('Error sending message:', error);
                          });
                    }
                },
                fetchMessages() {
                    fetch('/chat_test_v0/public/messages')
                        .then(response => response.json())
                        .then(data => {
                            this.messages = data;
                        })
                        .catch(error => {
                            console.error('Error fetching messages:', error);
                        });
                },
                addMessage(message) {
                    this.messages.push(message);
                }
            }
        });
    </script>
</body>
</html>