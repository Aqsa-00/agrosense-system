# AgroSense - Smart Farming SaaS Platform

![AgroSense Logo](images/agriculture.avif)

AgroSense is a modern, intelligent farming monitoring system designed to empower farmers with real-time field insights, pest detection alerts, and soil health analytics. By leveraging IoT and data-driven models, AgroSense helps maximize crop yield while minimizing manual intervention and water waste.

## 🚀 Features

- **🌱 Real-time Crop Monitoring**: Track field health remotely via IoT sensors.
- **🐛 AI-Powered Pest Detection**: Early warnings for pest infestations using intelligent data analytics.
- **💧 Soil & Climate Insights**: Precise recommendations for irrigation and fertilization based on soil moisture and local weather.
- **🔐 Secure User Authentication**: Full user management system with login and registration.
- **📝 Dynamic Blog System**: Integrated blog platform for sharing farming insights with full CRUD capabilities.
- **📱 Fully Responsive Design**: Seamless experience across desktop, tablet, and mobile devices.

## 🛠️ Technology Stack

- **Frontend**: 
  - Semantic HTML5
  - Vanilla CSS3 (Custom Design System with Glassmorphism)
  - Vanilla JavaScript (ES6+)
- **Backend**:
  - PHP (RESTful API Architecture)
- **Database**:
  - MySQL (Relational Data Management)
- **Deployment & Server**:
  - XAMPP / Apache Local Server

## 📂 Project Structure

```text
agrosense-system/
├── api/                # PHP Backend RESTful API
│   └── posts/          # API endpoints for posts and users
│       ├── users/      # Authentication (Login/Register)
│       ├── comments/   # Blog comment system
│       ├── db.php      # Database connection & auto-migration
│       └── ...         # CRUD operators (create, read, update, delete)
├── css/                # Custom Stylesheets
│   └── style.css       # Main design system
├── images/             # Project Assets & Hero Images
├── js/                 # Frontend Logic
│   └── script.js       # API integration & UI Interactivity
├── index.html          # Main Landing Page / Entry Point
└── README.md           # Documentation
```

## ⚙️ Installation & Setup

Follow these steps to set up the project locally:

1. **Install XAMPP**: Download and install [XAMPP](https://www.apachefriends.org/) (Apache + MySQL).
2. **Clone the Repository**:
   ```bash
   git clone <repository-url>
   mv agrosense-system C:/xampp/htdocs/agrosense-system
   ```
3. **Configure Database**:
   - Start **Apache** and **MySQL** from the XAMPP Control Panel.
   - Open your browser and go to `http://localhost/phpmyadmin`.
   - Create a new database named `agrosense`. (Note: The `db.php` script is designed to auto-migrate tables upon the first API call).
4. **Access the App**:
   - Open `http://localhost/agrosense-system` in your browser.

## 📡 API Endpoints (Brief)

| Endpoint | Method | Description |
| :--- | :--- | :--- |
| `/api/posts/read.php` | GET | Fetch all blog posts |
| `/api/posts/users/login.php` | POST | User authentication |
| `/api/posts/users/register.php` | POST | New user registration |
| `/api/posts/create.php` | POST | Create a new blog post |

1. Clone the repository:
https://github.com/Aqsa-00/agrosense-system

## 🔗 Live Demo

👉(https://agrosense-system.netlify.app/)

## 📜 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

*Made with ❤️ for sustainable agriculture.*