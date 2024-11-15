<template>
    <div class="box direct-chat direct-chat-primary">
        <div class="box-header with-border">
            <h1 class="box-title" v-if="select_rec.code"><a :href="track_url" target="_blank">{{ select_rec.code }}</a></h1>
            <h1 class="box-title" v-else>Direct Chat</h1>
        </div>
        <div class="box-body">
            <div class="direct-chat-messages" style="height: 520px;" :id="'vuefeedback'+select_rec.code">
                <div v-if="loadingFlag" class="text-center">
                    <img :src="loadingPath" alt="">
                </div>
                <div v-for="message in messages" :key="message.id" class="direct-chat-msg" v-bind:class="message.position" v-else>
                    <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name text-primary" v-bind:class="{ 'pull-right' : message.position == 'right','pull-left' : message.position == 'left' }">{{ message.facility_name }}</span><br>
                        <span class="direct-chat-name" v-bind:class="{ 'pull-right' : message.position == 'right','pull-left' : message.position == 'left' }">{{ message.sender_name }}</span>
                        <span class="direct-chat-timestamp" v-bind:class="{ 'pull-left' : message.position == 'right','pull-right' : message.position == 'left' }">{{ message.send_date }}</span>
                    </div>
                    <img class="direct-chat-img" :src="message.chat_image" alt="message user image">
                    <div class="direct-chat-text" v-html="message.message"></div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="input-group">
                <textarea placeholder="Type your message" id="mytextarea"></textarea>
                <span class="input-group-btn">
                    <a class="btn btn-app" @click="sendFeedback">
                        <i class="fa fa-save"></i> Send
                    </a>
                </span>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name : "RecoMessages",
        data() {
            return {
                logo : String,
                sender_name : "",
                socket_message: "",
                new_message : Object,
                loadingPath: $("#broadcasting_url").val()+'/resources/img/loading.gif',
                loadingFlag: false
            }
        },
        props : ["messages","select_rec","track_url","user"],
        methods: {
            sendFeedback() {
                if(this.select_rec.code) {
                    tinyMCE.triggerSave();
                    let str = $("#mytextarea").val();
                    str = str.replace(/^\<p\>/,"").replace(/\<\/p\>$/,"");
                    if(str) {
                        tinyMCE.activeEditor.setContent('');

                        this.sender_name = ""
                        if (this.user.level === "doctor")
                            this.sender_name += "Dr. "

                        this.sender_name += this.user.fname + " " + this.user.mname + " " + this.user.lname
                        this.new_message = {
                            code: this.select_rec.code,
                            message: str,
                            sender: this.user.id,
                            sender_name: this.sender_name,
                            send_date: moment().format('D MMM h:m a'),
                            position: "right",
                            chat_image: $("#receiver_pic").val(),
                            facility_name: $("#facility_name").val()
                        }
                        this.messages.push(this.new_message)
                        this.scrolldownFeedback(this.select_rec.code)
                        this.socket_message = {
                            code: this.select_rec.code,
                            message: str
                        }
                        axios.post('doctor/feedback', this.socket_message).then(response => {});
                    }
                    else {
                        Lobibox.alert("error",
                            {
                                msg: "ReCo message was empty!"
                            });
                    }
                }
                else {
                    Lobibox.alert("error",
                    {
                        msg: "You must select a ReCo"
                    });
                }
            },
            scrolldownFeedback(code) {
                this.loadingFlag = false
                let objDiv = document.getElementById("vuefeedback"+code);
                setTimeout(function () {
                    objDiv.scrollTop = objDiv.scrollHeight
                },500);
            }
        },
        watch: {
            messages: function() {
                this.loadingFlag = false
                this.scrolldownFeedback(this.select_rec.code)
            },
            select_rec: function (new_val, old_val) {
                this.loadingFlag = true
            }
        },
        created() {
            //console.log(this.loadingPath)
            this.logo = $("#doh_logo").val()
            Echo.join('reco')
                .listen('SocketReco', (event) => {
                    if(event.payload.code === this.select_rec.code && event.payload.userid_sender !== this.user.id) {
                        this.new_message = {
                            code: this.select_rec.code,
                            message: event.payload.message,
                            sender: event.payload.userid_sender,
                            sender_name :  event.payload.name_sender,
                            send_date : moment().format('D MMM h:m a'),
                            position: event.payload.userid_sender === this.user.id ? 'right' : 'left',
                            chat_image: event.payload.userid_sender === this.user.id ? $("#receiver_pic").val() : $("#sender_pic").val(),
                            facility_name: event.payload.facility_sender
                        }
                        this.messages.push(this.new_message)
                        this.scrolldownFeedback(this.select_rec.code)
                        console.log("listen1")
                        Lobibox.notify('success', {
                            delay: false,
                            closeOnClick: false,
                            title: 'New Reco',
                            msg: "<small>"+event.payload.message+"</small>",
                            img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                        });
                    }

                    event.payload.alreadyNotifyReco = true
                    this.$emit('listenreco', event.payload);
                });
        }
    }
</script>
<style lang="scss" scoped>
    @import './css/main.scss';
</style>

