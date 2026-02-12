// Speak text aloud
function speak(text) {
  const utterance = new SpeechSynthesisUtterance(text);
  utterance.lang = "en-US";
  speechSynthesis.speak(utterance);
}

// Example usage
function greetUser() {
  speak("Welcome to the Voice Email System.");
}

window.onload = greetUser;
