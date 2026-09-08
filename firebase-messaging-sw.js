importScripts("https://www.gstatic.com/firebasejs/10.12.0/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/10.12.0/firebase-messaging-compat.js");

firebase.initializeApp({
    apiKey: "AIzaSyBiw5ieTdsrQOMfkZa75MSFEtV0GubGFlk",
    authDomain: "food-collections-6c68b.firebaseapp.com",
    projectId: "food-collections-6c68b",
    storageBucket: "food-collections-6c68b.appspot.com",
    messagingSenderId: "651450827473",
    appId: "1:651450827473:web:4e4abb60d30611f8343bf0",
    measurementId: "G-BJNZR104CZ"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    const data = payload.data || {};
    const title = data.title || (payload.notification && payload.notification.title) || "Notification";
    const body  = data.body  || (payload.notification && payload.notification.body)  || "";
    const image = data.image || (payload.notification && payload.notification.image) || undefined;

    self.registration.showNotification(title, {
        body,
        icon: image,
        data,
    });
});

self.addEventListener("notificationclick", (event) => {
    event.notification.close();
    const data = event.notification.data || {};
    const url = resolveTargetUrl(data);

    event.waitUntil(
        self.clients
            .matchAll({ type: "window", includeUncontrolled: true })
            .then((windowClients) => {
                const existing = windowClients.find((c) => c.url.startsWith(self.location.origin));
                if (existing) {
                    existing.focus();
                    return existing.navigate(url);
                }
                return self.clients.openWindow(url);
            }),
    );
});

function resolveTargetUrl(data) {
    const base = self.location.origin;
    if (data && data.type === "order_status" && data.order_id) {
        return base + "/profile?page=orders&orderId=" + encodeURIComponent(data.order_id);
    }
    if (data && data.type === "message") {
        return base + "/profile?page=inbox";
    }
    return base + "/";
}