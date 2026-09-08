import { initializeApp, getApps, getApp } from "firebase/app";
import {
  getMessaging,
  getToken,
  onMessage,
  isSupported,
} from "firebase/messaging";
import { getAuth } from "firebase/auth";
const firebaseConfig = {
  apiKey: "AIzaSyBjETs35FP0uq7Q6AaCYie3hlKsIJNOas8",
  authDomain: "foodcollwe.firebaseapp.com",
  projectId: "foodcollwe",
  storageBucket: "foodcollwe.firebasestorage.app",
  messagingSenderId: "1059548760564",
  appId: "1:1059548760564:web:f2d3813db1e3076d8f91a1",
  measurementId: "G-VCDEKG4CZM"
};
const firebaseApp = !getApps().length
  ? initializeApp(firebaseConfig)
  : getApp();
const messaging = (async () => {
  try {
    const isSupportedBrowser = await isSupported();
    if (isSupportedBrowser) {
      return getMessaging(firebaseApp);
    }
    return null;
  } catch (err) {
    return null;
  }
})();

export const fetchToken = async (setTokenFound, setFcmToken) => {
  return getToken(await messaging, {
    vapidKey:
      "BDkuBQ3ZBKe4Wx7qbGxug-d0z0SbhGCjYHn-MuNry3eQOO6aXh9Ctqzav87LgPncmgqIwNTbDjJbUzIbnpJ2Xk8",
  })
    .then((currentToken) => {
      if (currentToken) {
        setTokenFound(true);
        setFcmToken(currentToken);

        // Track the token -> client mapping, by sending to backend server
        // show on the UI that permission is secured
      } else {
        setTokenFound(false);
        setFcmToken();
        // shows on the UI that permission is required
      }
    })
    .catch((err) => {
      console.error(err);
      // catch error while creating client token
    });
};

export const onMessageListener = async () =>
  new Promise((resolve) =>
    (async () => {
      const messagingResolve = await messaging;
      onMessage(messagingResolve, (payload) => {
        resolve(payload);
      });
    })()
  );
export const auth = getAuth(firebaseApp);
