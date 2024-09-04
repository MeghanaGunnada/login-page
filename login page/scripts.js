let isSignup = false;

function toggleForm() {
    isSignup = !isSignup;

    document.getElementById("formTitle").textContent = isSignup ? "Sign Up" : "Login";
    document.getElementById("signupFields").style.display = isSignup ? "block" : "none";
    document.querySelector("button").textContent = isSignup ? "Sign Up" : "Login";
    document.getElementById("formType").value = isSignup ? "signup" : "login";
    document.getElementById("toggleText").innerHTML = isSignup ? 
        'Already have an account? <a href="#" id="toggleLink" onclick="toggleForm()">Login</a>' :
        'New user? <a href="#" id="toggleLink" onclick="toggleForm()">Sign Up</a>';
}

function handleSubmit() {
    // Additional client-side validation can be added here
    return true;  // Allow form submission
}

