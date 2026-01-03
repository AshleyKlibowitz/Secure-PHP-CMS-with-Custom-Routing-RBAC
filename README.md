# Secure PHP CMS with Custom Routing & Role-Based Access Control (RBAC)

## 📖 Project Overview
This is a custom-built Content Management System (CMS) engineered from scratch using **PHP** and **MySQL**. The project demonstrates a deep understanding of core web technologies by implementing a **Model-View-Controller (MVC) style architecture** without reliance on external frameworks.

The system features a secure, full-stack environment where administrators can manage content and users via a protected dashboard, while registered members can engage with the community through a moderated comment system.


<img width="826" height="463" alt="Screenshot 2026-01-02 at 9 59 09 PM" src="https://github.com/user-attachments/assets/1187bf7b-a144-4b0a-a6b2-18e4bb4f61ec" />


## ⚙️ Technical Highlights (The "Under the Hood" Features)
This project was built to demonstrate proficiency in backend architecture and security:

* **Custom Routing Engine:** Implemented a `router.php` system combined with Apache `.htaccess` rewriting to handle URI parsing and deliver clean, SEO-friendly URLs (e.g., `/profile` instead of `/profile.php`).
* **Role-Based Access Control (RBAC):** Engineered a permission system that differentiates between **Guests**, **Authenticated Users**, and **Administrators**, strictly enforcing access to specific PHP scripts based on session privileges.
* **Security First Approach:**
    * **Encryption:** User passwords are salted and hashed using MySQL's `SHA2` (256-bit) encryption algorithms.
    * **Session Hijacking Protection:** Customized session management logic prevents unauthorized access to protected views.
    * **SQL Injection Prevention:** Utilizes prepared statements for database interactions.

## ✨ Functional Features

### 1. Administration (CMS)
* **CRUD Operations:** Full Create, Read, Update, and Delete functionality for blog posts.
* **User Management:** Administrative capability to view all registered users and manage account access.
* **Content Moderation:** Ability to edit or remove user comments to maintain community standards.

### 2. User Experience
* **Interactive Dashboard:** Users can register, log in, and manage their personal profiles and bio information.
* **Engagement:** Registered users can post, edit, and delete their own comments on blog posts.
* **Dynamic Sorting:** Content filtering allows visitors to sort posts by date and navigate via custom pagination.

## 🛠️ Technology Stack
* **Language:** PHP 7.4+ (Server-side logic)
* **Database:** MySQL (Relational Data Design)
* **Frontend:** HTML5, CSS3 (Custom Responsive Design)
* **Server:** Apache (Mod_Rewrite enabled)

## 🗄️ Database Architecture
The application relies on a normalized relational database schema:



* **`users` table:** Stores credentials, profile data, and timestamps.
* **`blogposts` table:** Stores article content and links to authors.
* **`comments` table:** Manages many-to-one relationships between users, posts, and comments.

## 🚀 Installation

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/yourusername/secure-php-cms.git](https://github.com/yourusername/secure-php-cms.git)
    ```
2.  **Database:** Import the provided SQL dump into your local MySQL instance.
3.  **Config:** Update `mysqli_connect.php` with your local environment credentials.
4.  **Launch:** Serve the project via Apache (XAMPP/MAMP) to enable the custom routing features.
