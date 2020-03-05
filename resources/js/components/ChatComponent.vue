<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ title }}</div>

                    <div v-html="chat" class="card-body">
                    </div>
                    <div class="card-footer">
                      <input v-model="message"></input>
                      <a v-on:click.stop="send">Send</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
  export default {
    data () {
      return {
        title: "Waiting for users...",
        message: "",
        chat: ""
      }
    },
    mounted() {
      axios.post('/groups').then(response => {
        this.listen(response.data)
      }).catch(error => {
        console.log(error.response)
    });
    },
    methods: {
      listen(user) {
        Echo.channel(`user.`).listen('NewMessage', (e) => {
          this.chat += '<p>' + e.message + '</p>';
        });
      },
      send() {
        axios.post('/message', {message: this.message}).then(response => {
          this.message = "";
        }).catch(error => {
          console.log(error.response)
        });
      }
    }
  }
</script>
