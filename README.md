🎤 Voice Email Website

A web-based email system with voice assistance that allows users to send, receive, read, and manage emails through a simple interface. The system integrates voice feedback using browser speech synthesis and email functionality using PHPMailer and IMAP.

📌 Features
📥 View inbox emails
📤 Send emails
🗑️ Delete emails
📖 Read email content
🎤 Voice greeting and voice feedback
🔐 User authentication support (via database)
📧 Email sending using PHPMailer
📬 Email fetching using IMAP
💻 Simple and responsive web interface
🛠️ Technologies Used

Frontend:
HTML
CSS
JavaScript (Speech Synthesis API)
Backend:PHP
Database:MySQL
Libraries:PHPMailer,IMAP Protocol

voice_email_website/
│
├── index.html            # Home page
├── compose.html          # Compose email page
├── inbox.php             # Inbox page
├── read_email.php        # Read email content
├── send_email.php        # Send email functionality
├── delete_email.php      # Delete email functionality
├── db_config.php         # Database configuration
├── imap_config.php       # IMAP email configuration
├── script.js             # Voice functionality
├── style.css             # Styling
├── inbox.css             # Inbox styling
├── database.sql         # Database schema
├── users.sql            # User table schema
│
└── PHPMailer/           # PHPMailer library
    └── src/
    
⚙️ Requirements
Make sure you have the following installed:
XAMPP / WAMP / LAMP
PHP 7.4 or higher
MySQL
Web browser (Chrome recommended for voice features)
Internet connection

🎤 Voice Functionality
This project uses:
SpeechSynthesisUtterance API
Provides voice greeting
Reads messages aloud
Supported browsers:
✅ Google Chrome (Recommended)
✅ Edge
⚠️ Limited support in other browsers

🚀 Future Improvements
Voice commands for sending emails
User login and authentication
Attachment support
Mobile responsiveness
Accessibility improvements
