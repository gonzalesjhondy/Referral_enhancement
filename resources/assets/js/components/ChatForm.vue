<template>
    <div>
        <div class="composer" v-if="selected != null">
            <textarea
                    name="message"
                    class="form-control input-sm"
                    placeholder="Type your message here..."
                    v-model="newMessage"
                    @keyup.enter="sendMessage"
                    @keyup="sendTypingEvent">
            </textarea>
        </div>
        <!--<span class="input-group-btn">
            <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
                Send
            </button>
        </span>-->
    </div>
</template>

<script>
    export default {
        name : "ChatForm",
        props: ['user','selected'],

        data() {
            return {
                newMessage: '',
                messages: [],
                users: [],
            }
        },
        methods: {
            sendTypingEvent() {
                Echo.join('chat')
                    .whisper('typing', this.user);
            },

            sendMessage() {
                this.$emit('messagesent', {
                    from: this.user.id,
                    to: this.selected,
                    text: this.newMessage
                });

                this.newMessage = ''
            },

        }
    }
</script>

<style lang="scss" scoped>
    .composer textarea {
        width: 96%;
        margin: 10px;
        resize: none;
        border-radius: 3px;
        border: 1px solid lightgray;
        padding: 6px;
    }
</style>