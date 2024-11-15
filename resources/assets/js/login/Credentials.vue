<template>
    <div class="login-block" id="login_form_card">
        <div class="error">
            <input v-model="user.username" id="username" autocomplete="off" type="text" :placeholder="'Username'" class="form-control" name="username" v-on:keyup.enter="login">
            <input v-model="user.password" id="password" type="password" class="form-control" :placeholder="'Password'" name="password" v-on:keyup.enter="login">
            <span class="has-error" >
                <strong class="text-danger">{{ error_message }}</strong>
            </span>
            <button type="submit" class="btn-submit" id="login_btn" :onclick="login">Login</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Credentials",
        data: () => ({
            user: {
                username: "",
                password: ""
            },
            login_type: "",
            login_link: "",
            error_message : ""
        }),
        created() {
            this.setLoginType()
        },
        methods: {
            login() {
                $("#login_btn").html('<i class="fa fa-spinner fa-spin"></i> Validating...');
                axios.post('login', {
                    username: this.user.username,
                    password: this.user.password,
                    login_type: this.login_type,
                    login_link: this.login_link
                })
                    .then(response => {
                        if(response.data['error_notif'] === true) {
                            this.error_message = response.data['error_msg']
                            $("#login_btn").html('Login');
                        } else {
                            this.error_message = ""
                            window.location.href = response.data;
                        }
                    })
            },

            setLoginType() {
                let path = window.location.origin
                if(path === 'https://cvchd7.com') {
                    this.login_type = "cloud"
                } else {
                    this.login_type = "doh"
                }
                this.login_link = path
            }
        }
    }
</script>