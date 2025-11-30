# Student Forum

A web-based student forum application built with PHP for the COMP1841 coursework.

## 📋 Features

### User Features
- **Authentication**: Register, login, logout with email verification
- **Password Recovery**: Forgot password with email verification code
- **Profile Management**: Update profile, upload avatar, change password
- **Questions**: Create, edit, delete questions with image attachments
- **Comments**: Add, edit, delete comments on questions
- **Contact Admin**: Send messages to administrators

### Admin Features
- **User Management**: View, delete users
- **Question Management**: Create, edit, delete any question
- **Comment Management**: Moderate comments
- **Module Management**: Create, edit, delete modules
- **Email Management**: View user messages

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL/MariaDB
- **Email**: PHPMailer (via Composer)
- **Frontend**: HTML5, CSS3
- **Server**: Apache (XAMPP)

## 📁 Project Structure

```
cw/
├── admin/                    # Admin panel files
│   ├── addquestion.php
│   ├── comment_post.php
│   ├── create_module.php
│   ├── delete_email.php
│   ├── delete_module.php
│   ├── delete_post.php
│   ├── delete_user.php
│   ├── edit_module.php
│   ├── login.php
│   ├── manage_module.php
│   ├── question.php
│   ├── user_profile.php
│   ├── users.php
│   └── view_emails.php
├── admin_templates/          # Admin HTML templates
├── config/                   # Configuration files
│   └── mail.php
├── db/                       # Database files
│   ├── db.php               # Database connection
│   └── db_function.php      # Database helper functions
├── images/                   # Uploaded images
├── logs/                     # Log files
├── templates/                # User HTML templates
├── vendor/                   # Composer dependencies
├── addquestion.php
├── base.css
├── comment_post.php
├── composer.json
├── delete_post.php
├── edit_question.php
├── forgot.php
├── index.php
├── login.php
├── logout.php
├── profile.php
├── question.php
├── register.php
├── send_code.php
├── send_email.php
├── updatepass.php
├── user_posts.php
├── user_profile.php
└── verify.php
```

## ⚙️ Installation

### Prerequisites
- XAMPP (or similar PHP/MySQL stack)
- PHP 7.4 or higher
- MySQL/MariaDB
- Composer (for PHPMailer)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/DK0310/web_program1_CW.git
   ```

2. **Move to web server directory**
   ```bash
   # For XAMPP on Windows
   move web_program1_CW C:\xampp\htdocs\COMP1841\cw
   ```

3. **Install dependencies**
   ```bash
   cd C:\xampp\htdocs\COMP1841\cw
   composer install
   ```

4. **Configure database**
   - Create a MySQL database
   - Import the database schema (if provided)
   - Update `db/db.php` with your database credentials

5. **Configure email (optional)**
   - Edit `config/mail.php` with your SMTP settings
   ```php
   return [
       'smtp' => true,
       'host' => 'smtp.example.com',
       'port' => 587,
       'username' => 'your-email@example.com',
       'password' => 'your-password',
       'secure' => 'tls',
       'from_address' => 'no-reply@example.com',
       'from_name' => 'Student Forum',
       'admin_address' => 'admin@example.com'
   ];
   ```

6. **Set permissions**
   - Ensure `images/` directory is writable
   - Ensure `logs/` directory is writable

7. **Access the application**
   ```
   http://localhost/COMP1841/cw/
   ```

## 🔐 Default Accounts

| Role  | Username | Password |
|-------|----------|----------|
| Admin | admin    | (set during installation) |

## 📱 Responsive Design

The application features a fully responsive design with:
- Mobile-first approach
- Hamburger menu for mobile devices
- Optimized layouts for tablets and desktops

## 🔒 Security Features

- Password hashing (bcrypt)
- SQL injection prevention (PDO prepared statements)
- XSS protection (htmlspecialchars)
- Session-based authentication
- Email verification for registration
- CSRF protection

## 📝 License

This project is created for educational purposes as part of COMP1841 coursework.

## 👤 Author

- **DK0310** - [GitHub](https://github.com/DK0310)


