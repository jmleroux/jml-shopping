import { initializeApp } from 'firebase/app';
import { getDatabase, ref, remove, update } from "firebase/database";
import { initializeAppCheck, ReCaptchaV3Provider } from "firebase/app-check";
import { getAuth } from "firebase/auth";

import firebaseConfig from './firebaseConfig.js'

const app = initializeApp(firebaseConfig);

self.FIREBASE_APPCHECK_DEBUG_TOKEN = JSON.parse(import.meta.env.VITE_FIREBASE_APPCHECK_DEBUG_TOKEN) || false

initializeAppCheck(app, {
  provider: new ReCaptchaV3Provider('6LcEVDgdAAAAAH6BKybAmkWJB09gjKvujKOlPkkS'),

  // Optional argument. If true, the SDK automatically refreshes App Check
  // tokens as needed.
  isTokenAutoRefreshEnabled: true
});

const db = getDatabase(app);

export const removeById = id => {
  const itemRef = ref(db, id);
  remove(itemRef);
}

export const updateData = (payload) => {
  return update(ref(db), payload);
}

export const auth = getAuth();

// Get a reference to the database service
export default db
