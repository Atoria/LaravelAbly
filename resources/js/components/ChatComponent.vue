<template>
    <div class="chat-container p-3">
        <div class="messages d-flex flex-column-reverse overflow-auto" style="height: 300px;">
            <div v-for="message in messages" :key="message.id" class="p-2 mb-2 bg-light border rounded">
                <strong>{{ message.username }}:</strong> {{ message.content }}
            </div>

            <div class="typing-indicator" v-if="typingUser">{{ typingUser.name }} is typing</div>
        </div>
        <div class="input-group mt-3">
            <input type="text" v-model="newMessage" class="form-control" placeholder="Type a message..."
                   @input="onInput"
                   @keyup.enter="sendMessage">
            <div class="input-group-append">
                <button class="btn btn-primary" @click="sendMessage">Send</button>
            </div>
        </div>
    </div>
</template>

<script>

import * as Ably from 'ably'

export default {
    data() {
        return {
            messages: [],
            newMessage: '',
            ably: null,
            channel: null,
            user: null,
            typingTimeout: null,
            typingUser: null,
            typeIndicatorTimeout: null
        };
    },
    mounted() {
        this.getUser();
        this.initAbly();
    },
    methods: {
        getUser() {
            axios.get('/api/user').then((response) => {
                this.user = response.data;
            }).catch(error => {
                console.error('Error fetching Ably token:', error);
            });
        },
        initAbly() {
            axios.get('/api/message/getToken').then((response) => {
                this.initializeAbly(response.data);
            }).catch(error => {
                console.error('Error fetching Ably token:', error);
            });
        },
        initializeAbly(tokenDetails) {
            this.ably = new Ably.Realtime({tokenDetails: tokenDetails});
            this.channel = this.ably.channels.get('chat');
            this.channel.subscribe('message', (message) => {
                this.messages.unshift(message.data);
            });
            this.channel.subscribe('typing', (message) => {
                if (this.user.id !== message.data.id) {
                    this.handleTypingIndicator(message.data)
                }
            })

        },

        onInput() {
            if (this.typingTimeout) clearTimeout(this.typingTimeout);
            const vm = this;
            this.typingTimeout = setTimeout(() => {
                vm.channel.publish('typing', this.user, err => {
                    console.log(3);
                    if (err) console.log(`Error sending typing event`, err);
                })
            })
        },
        handleTypingIndicator(clientId) {
            this.typingUser = clientId;
            if (this.typeIndicatorTimeout) clearTimeout(this.typeIndicatorTimeout);
            this.typeIndicatorTimeout = setTimeout(() => {
                this.typingUser = null
            }, 2000)
        },
        sendMessage() {
            const messageData = {
                content: this.newMessage
            };

            axios.post('/api/message/send', messageData)
                .then(() => {
                    this.newMessage = '';
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                });
        }
    },
};
</script>
