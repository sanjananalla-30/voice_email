<?php
include 'imap_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inbox</title>
    <link rel="stylesheet" type="text/css" href="inbox.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f8fb;
            text-align: center;
        }
        h2 {
            margin-top: 30px;
        }
        #searchBox {
            width: 50%;
            padding: 12px;
            margin: 20px auto;
            display: block;
            border-radius: 20px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .inbox-container {
            width: 80%;
            margin: auto;
        }
        .email-item {
            background: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            text-align: left;
        }
        .btn-read, .btn-delete, .btn-speak {
            margin-right: 10px;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-read { background: #4caf50; color: white; }
        .btn-delete { background: #f44336; color: white; }
        .btn-speak { background: #2196f3; color: white; }
    </style>
</head>
<body>

<h2>Inbox</h2>

<input type="text" id="searchBox" placeholder="Search by subject or sender..." onkeyup="filterEmails()">

<div class="inbox-container">
<?php
$emails = imap_search($inbox, 'ALL');
$emailMap = []; // store id => actual message ID

if ($emails) {
    rsort($emails); // Newest first
    $count = 1;
    foreach ($emails as $mail) {
        $overview = imap_fetch_overview($inbox, $mail, 0)[0];

        $from = isset($overview->from) ? htmlspecialchars($overview->from) : 'Unknown';
        $subject = isset($overview->subject) ? htmlspecialchars($overview->subject) : 'No Subject';
        $emailMap[$count] = $mail; // map spoken index to real message ID

        echo "<div class='email-item' data-id='$count'>";
        echo "<b>Email $count:</b><br>";
        echo "<b>From:</b> $from<br>";
        echo "<b>Subject:</b> $subject<br>";
        echo "<a href='read_email.php?id=$mail' class='btn-read'>Read</a>";
        echo "<a href='delete_email.php?id=$mail' class='btn-delete'>Delete</a>";
        echo "<button class='btn-speak' onclick='speakEmail(\"From: $from. Subject: $subject\")'>🔊 Speak</button>";
        echo "</div>";

        $count++;
    }
} else {
    echo "<p>No emails found.</p>";
}

imap_close($inbox);
?>
</div>

<script>
function filterEmails() {
    const input = document.getElementById("searchBox").value.toLowerCase();
    const items = document.getElementsByClassName("email-item");

    for (let i = 0; i < items.length; i++) {
        const content = items[i].textContent.toLowerCase();
        items[i].style.display = content.includes(input) ? "" : "none";
    }
}

function speakEmail(text) {
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'en-US';
    window.speechSynthesis.speak(utterance);
}

function speak(text, callback) {
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'en-US';
    utterance.onend = () => { if (callback) callback(); };
    window.speechSynthesis.speak(utterance);
}

function listen() {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (!SpeechRecognition) {
        speak("Sorry, your browser does not support voice recognition.");
        return;
    }

    const recognition = new SpeechRecognition();
    recognition.lang = 'en-US';
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;

    recognition.onresult = function(event) {
        const command = event.results[0][0].transcript.toLowerCase();
        console.log("Command:", command);

        if (command.includes("read email")) {
            const number = command.match(/\d+/);
            if (number && document.querySelector(`.email-item[data-id="${number[0]}"]`)) {
                speak("Reading email " + number[0], () => {
                    window.location.href = document.querySelector(`.email-item[data-id="${number[0]}"] .btn-read`).href;
                });
            } else {
                speak("Email number not found.");
            }
        } else if (command.includes("delete email")) {
            const number = command.match(/\d+/);
            if (number && document.querySelector(`.email-item[data-id="${number[0]}"]`)) {
                speak("Deleting email " + number[0], () => {
                    window.location.href = document.querySelector(`.email-item[data-id="${number[0]}"] .btn-delete`).href;
                });
            } else {
                speak("Email number not found.");
            }
        } else if (command.includes("speak email")) {
            const number = command.match(/\d+/);
            const item = document.querySelector(`.email-item[data-id="${number[0]}"]`);
            if (number && item) {
                const text = item.textContent.trim();
                speak(text, () => setTimeout(listen, 1000));
            } else {
                speak("Email number not found.", () => setTimeout(listen, 1000));
            }
        } else if (command.includes("search for")) {
            const term = command.replace("search for", "").trim();
            document.getElementById("searchBox").value = term;
            filterEmails();
            speak("Searching for " + term, () => setTimeout(listen, 1000));
        } else if (command.includes("stop speaking")) {
            window.speechSynthesis.cancel();
            speak("Speech stopped.", () => setTimeout(listen, 1000));
        } else if (command.includes("go back") || command.includes("menu")) {
            speak("Returning to menu.", () => {
                window.location.href = "home.html";
            });
        } else {
            speak("Sorry, I didn't understand that. Please try again.", () => setTimeout(listen, 1000));
        }
    };

    recognition.onerror = function(event) {
        console.error("Recognition error:", event.error);
        speak("There was an error. Please try again.", () => setTimeout(listen, 1000));
    };

    recognition.start();
}


window.onload = function() {
    speak("Welcome to your inbox. You can say, read email 1, delete email 2, or go back to menu.", listen);
};
</script>

</body>
</html>
