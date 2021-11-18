import { initializeApp } from 'firebase/app';
import { getDatabase } from "firebase/database";
import { initializeAppCheck, ReCaptchaV3Provider } from "firebase/app-check";

const firebaseConfig = {
  apiKey: "AIzaSyCPjc8oRmv4Lxe919Rea9QOTpka5Vhu1uw",
  authDomain: "test4422rh.firebaseapp.com",
  databaseURL: "https://test4422rh-default-rtdb.europe-west1.firebasedatabase.app",
  projectId: "test4422rh",
  storageBucket: "test4422rh.appspot.com",
  messagingSenderId: "157938711281",
  appId: "1:157938711281:web:0f1faf0ea3239c56ba8750"
};

const app = initializeApp(firebaseConfig);

self.FIREBASE_APPCHECK_DEBUG_TOKEN = true;

initializeAppCheck(app, {
  provider: new ReCaptchaV3Provider('6LcEVDgdAAAAAH6BKybAmkWJB09gjKvujKOlPkkS'),

  // Optional argument. If true, the SDK automatically refreshes App Check
  // tokens as needed.
  isTokenAutoRefreshEnabled: true
});

// Get a reference to the database service
export default getDatabase(app);
