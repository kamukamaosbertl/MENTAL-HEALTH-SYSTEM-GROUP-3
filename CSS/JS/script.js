// script.js

const text = "Welcome to Our Mental Health Services"; // Text to type
const typingSpeed = 100; // Speed in milliseconds
let index = 0; // Current index of the text
const typingElement = document.getElementById("typing-heading"); // Get the heading element

// Function to simulate typing effect
function type() {
    if (index < text.length) {
        typingElement.innerHTML += text.charAt(index); // Append the next character
        index++; // Move to the next character
        setTimeout(type, typingSpeed); // Call type function again after a delay
    }
}

// Start typing effect
type();

// Add event listener for the "Join Us" button
document.getElementById("join-us-button").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default anchor behavior
    
    // Get the selected role from the dropdown
    var role = document.getElementById("role").value;
    
    // Display an alert with the selected role
    alert("Redirecting to the signup page as a " + role + "...");
    
    // Redirect to community_signup.php page
    window.location.href = "community_signup.php"; 
});
