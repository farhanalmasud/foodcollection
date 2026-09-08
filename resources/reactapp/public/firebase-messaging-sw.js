importScripts(
  "https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"
);
importScripts(
  "https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js"
);
// // Initialize the Firebase app in the service worker by passing the generated config
const firebaseConfig = {
  apiKey: "AIzaSyBjETs35FP0uq7Q6AaCYie3hlKsIJNOas8",

  authDomain: "foodcollwe.firebaseapp.com",

  projectId: "foodcollwe",

  storageBucket: "foodcollwe.firebasestorage.app",

  messagingSenderId: "1059548760564",

  appId: "1:1059548760564:web:f2d3813db1e3076d8f91a1",

  measurementId: "G-VCDEKG4CZM"

};

firebase?.initializeApp(firebaseConfig);

// Retrieve firebase messaging
const messaging = firebase?.messaging();

messaging.onBackgroundMessage(function (payload) {
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});
