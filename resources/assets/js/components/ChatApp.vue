<template>
    <div class="col-md-8">
        <h3>Inbox</h3>
        <div v-if="messages.length > 0 || selected" class="card card-default">
            <div class="card-body">
                <chat-messages :messages="messages" :user="user_login" :selected="selected"></chat-messages>
            </div>
            <div class="card-footer">
                <chat-form @messagesent="addMessage" :user="user_login" :selected="selected"></chat-form>
            </div>
        </div>
        <div v-else>
            <div class="alert alert-info text-blue">
                <i class="fa fa-warning"></i> Please select contact!
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="contacts-list" v-if="users.length > 0">
            <ul>
                <li v-for="contact in users" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected': contact.id == selected }">
                    <div class="avatar">
                        <img :src="contact.picture" :alt="contact.name">
                    </div>
                    <div class="contact">
                        <p class="name">{{ contact.name }}</p>
                        <p class="email text-yellow">{{ contact.facility }}</p>
                        <p class="email">{{ contact.contact }}</p>
                        <span class="unread" v-if="contact.typing">typing..</span>
                    </div>
                </li>
            </ul>
        </div>
        <div v-else>
            <div class="alert alert-success text-green" id="no_onboard">
                <i class="fa fa-warning"></i> No user's onboard in chat at the moment.
            </div>
        </div>
    </div>
</template>
<script>
    import ChartForm from './ChatForm.vue'
    import ChatMessages from './ChatMessages.vue'
    export default {
        name: 'ChatApp',
        components : {
            'chat-form': ChartForm,
            'chat-messages': ChatMessages
        },
        data() {
            return {
                messages: [],
                users: [],
                user_login: Object,
                selected: null
            }
        },
        created() {
            console.log("WELCOME to VUE JS...")
            this.getUserOnboard()
            Echo.join('chat')
                .here(users => {
                    console.log("Listen here!!!")
                    //this.users = users;
                    this.users = users.filter((user) => user.id !== this.user_login.id)
                })
                .joining(user => {
                    console.log("joining")
                    this.users.push(user);
                })
                .leaving(user => {
                    console.log("leaving")
                    this.users = this.users.filter(u => u.id !== user.id);
                })
                .listenForWhisper('typing', ({id, name}) => {
                    this.users.forEach((user, index) => {
                        if (user.id === id) {
                            user.typing = true;
                        }
                    });
                })
                .listen('MessageSent', (event) => {
                    if(this.messages.length === 0) {
                        console.log("null");
                        this.fetchMessages(event.message.from)
                        this.selected = event.user.id
                    }
                    else if(this.user_login.id === event.message.to){
                        console.log("get event!")
                        this.selected = event.user.id
                        this.messages.push({
                            from: event.message.from,
                            to: event.message.to,
                            text: event.message.text
                        })
                    }

                    this.users.forEach((user, index) => {
                        if (user.id === event.user.id) {
                            user.typing = false;
                        }
                    })
                });
        },
        methods: {
            fetchMessages(id) {
                axios.get('conversation/'+id).then(response => {
                    this.messages = response.data;
                });
            },
            addMessage(message) {
                this.messages.push(message);
                axios.post('conversation/send', message).then(response => {
                    console.log(response.data);
                });
            },
            getUserOnboard() {
                axios.get('chat/user/onboard').then(response => {
                    this.user_login = response.data
                });
            },
            selectContact(contact) {
                this.fetchMessages(contact.id)
                this.selected = contact.id
            }
        }
    }
</script>

<style lang="scss" scoped>
    .chat-app {
        display: flex;
    }
    .contacts-list {
        flex: 2;
        max-height: 100%;
        height: 600px;
        overflow: scroll;
        border-left: 1px solid #a6a6a6;

        ul {
            list-style-type: none;
            padding-left: 0;
            li {
                display: flex;
                padding: 2px;
                border-bottom: 1px solid #aaaaaa;
                height: 80px;
                position: relative;
                cursor: pointer;
                &.selected {
                    background: #dfdfdf;
                }
                span.unread {
                    background: #82e0a8;
                    color: #fff;
                    position: absolute;
                    right: 11px;
                    top: 20px;
                    display: flex;
                    font-weight: 700;
                    min-width: 20px;
                    justify-content: center;
                    align-items: center;
                    line-height: 20px;
                    font-size: 12px;
                    padding: 0 4px;
                    border-radius: 3px;
                }
                .avatar {
                    flex: 1;
                    display: flex;
                    align-items: center;
                    img {
                        width: 35px;
                        border-radius: 50%;
                        margin: 0 auto;
                    }
                }
                .contact {
                    flex: 3;
                    font-size: 10px;
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    p {
                        margin: 0;
                        &.name {
                            font-weight: bold;
                        }
                    }
                }
            }
        }
    }
    #no_onboard{
        margin-top: 55px;
    }
</style>
