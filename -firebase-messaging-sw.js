if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('firebase-messaging-sw.js')
  .then(function(registration) {
    console.log('Registration successful, scope is:', registration.scope);
  }).catch(function(err) {
    console.log('Service worker registration failed, error:', err);
  });
}

importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase-messaging.js');

var config = {
  apiKey: "AIzaSyAnN5kqE2OQlQCRa7ZGdts1RVtRON-6_-Q",
  authDomain: "tdh-chat.firebaseapp.com",
  databaseURL: "https://tdh-chat.firebaseio.com",
  projectId: "tdh-chat",
  storageBucket: "tdh-chat.appspot.com",
  messagingSenderId: "874994982918"
};
firebase.initializeApp(config);

const messaging = firebase.messaging();