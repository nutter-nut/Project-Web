<template>
  <div class="container">
    <button id="myBtn" class="chatbox_open notification">
      <i class="fab fa-rocketchat"></i>
      <span class="badge">{{ this.badge }}</span>
    </button>
    <div class="row no-gutters">
      <!-- class="chatbox chatbox22 chatbox--tray chatbox--closed col-sm-10 col-md-6 col-lg-4" -->
      <div
        class="chatbox chatbox22 chatbox--tray chatbox--closed col-11"
        style="background-color: transparent; position: fixed; width: 600px"
      >
        <div class="chatbox__title">
          <h5>
            <a href="javascript:void()">Private Chat App</a>
          </h5>
          <button class="chatbox__title__close">
            <span>
              <svg viewBox="0 0 12 12" width="12px" height="12px">
                <line
                  stroke="#FFFFFF"
                  x1="11.75"
                  y1="0.25"
                  x2="0.25"
                  y2="11.75"
                />
                <line
                  stroke="#FFFFFF"
                  x1="11.75"
                  y1="11.75"
                  x2="0.25"
                  y2="0.25"
                />
              </svg>
            </span>
          </button>
        </div>
        <friends-component
          v-on:messagesent="sendMessage"
          v-on:session="sessionShow"
          v-on:delete_message="delMessage"
          v-on:load_readed="loadReaded"
          :messages="messages"
          :user="user"
        ></friends-component>
      </div>
    </div>
  </div>
</template>

<script>
import FriendsComponent from "./FriendsComponent";
export default {
  data() {
    return {
      socket: io.connect(config.serverUrl(), {
        secure: true,
        query: {
            userID: "miuserID"
        }
      }),
    };
  },
  props: ["messages", "user","badge"],
  components: { FriendsComponent },
  async mounted() {},
  methods: {
    sendMessage(r) {
      this.$emit("messagesent", {
        id: r.id,
        name: r.name,
        message: r.message,
        session: r.session,
        created_at: r.created_at,
      });
    },
    sessionShow(r) {
      this.$emit("session", {
        session: r.session,
        user: r.user,
      });
    },
    delMessage(r) {
      this.$emit("delete_message", {
        message: r.message,
      });
    },
    loadReaded(r){
      this.$emit("load_readed", {
        load: r.load,
      });
    },
  },
};
</script>