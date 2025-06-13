<!DOCTYPE html>
<html>
<head>
  <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-auth.js"></script>
</head>
<body>
  <button id="google-login">Login / Register dengan Google</button>

  <script>
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js";
    import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/9.22.0/firebase-auth.js";

    const firebaseConfig = {
        apiKey: "{{ env('FIREBASE_API_KEY') }}",
        authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
    };

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const provider = new GoogleAuthProvider();

    document.getElementById('google-login').onclick = async () => {
        try {
            const result = await signInWithPopup(auth, provider);
            const idToken = await result.user.getIdToken();

            // Kirim token ke backend Laravel
            fetch("{{ route('user.login.google.callback') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ idToken })
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    window.location.href = "{{ route('user.dashboard') }}";
                } else {
                    alert(data.message || 'Login gagal');
                }
            });
        } catch (error) {
            console.error(error);
        }
    };
  </script>
</body>
</html>
