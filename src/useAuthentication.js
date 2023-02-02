import { onAuthStateChanged } from "firebase/auth"
import { ref } from "vue";
import { auth } from "@/db";

export default function useAuthentication() {
    const isAuthenticated = ref(false);
    const currentUser = ref('')

    onAuthStateChanged(
        auth,
        (user) => {
            if (user) {
                // User is signed in, see docs for a list of available properties
                // https://firebase.google.com/docs/reference/js/firebase.User
                currentUser.value = user.email
                isAuthenticated.value = true
            } else {
                currentUser.value = ''
                isAuthenticated.value = false
            }
        },
        (error) => {
            console.error('authentication error')
            console.error(error)
        }
    )

    return {
        currentUser,
        isAuthenticated,
    }
}
