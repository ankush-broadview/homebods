// Initialize Firebase
/*var config = {
	apiKey: "AIzaSyDQdJLluamjJSzzOqiVm-Bujgd20vPYISk",
	authDomain: "my-test-app-91f99.firebaseapp.com",
	databaseURL: "https://my-test-app-91f99.firebaseio.com",
	projectId: "my-test-app-91f99",
	storageBucket: "my-test-app-91f99.appspot.com",
	messagingSenderId: "279160965485"
};*/

var config = {
    apiKey: "AIzaSyADYoc9k8MQHDMKe2NigeZIUQ47MSIaHpc",
    authDomain: "chat-system-demo-5a5ff.firebaseapp.com",
    databaseURL: "https://chat-system-demo-5a5ff.firebaseio.com",
    projectId: "chat-system-demo-5a5ff",
    storageBucket: "chat-system-demo-5a5ff.appspot.com",
    messagingSenderId: "517896775717",
    appId: "1:517896775717:web:947352e9b1f4119c1037cc",
    measurementId: "G-QL2M9YQ1SH"
  };

firebase.initializeApp(config);

// Initialize Cloud Firestore through Firebase
var db = firebase.firestore();

// Disable deprecated features
db.settings({
	timestampsInSnapshots: true
});