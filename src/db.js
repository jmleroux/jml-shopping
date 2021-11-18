import { initializeApp } from 'firebase/app';
import { getDatabase } from "firebase/database";
// import { initializeAppCheck } from "firebase/app-check";

const firebaseConfig = {
  databaseURL: "https://test4422rh-default-rtdb.europe-west1.firebasedatabase.app",
  projectId: "test4422rh",
};

const app = initializeApp(firebaseConfig);

self.FIREBASE_APPCHECK_DEBUG_TOKEN = true;
// initializeAppCheck(app, {});

// Get a reference to the database service
export default getDatabase(app);
