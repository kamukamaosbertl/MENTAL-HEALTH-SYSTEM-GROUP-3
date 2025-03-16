Here’s a well-organized version of your `README.md` file. I’ve maintained all the existing content while improving the structure, readability, and flow. Key sections are grouped logically, and formatting is enhanced for better clarity:

---

# MHARS (Mental Health Advocacy and Resources Support)

MHARS is a **web-based platform** designed to provide **mental health awareness, resources, and support** to individuals in need. It serves as a digital space for education, self-help tools, and community engagement, making mental health resources easily accessible.

---

## Table of Contents
1. [Getting Started](#getting-started)
2. [Features](#features)
3. [Tech Stack](#tech-stack)
4. [Project Structure](#project-structure)
5. [Setup & Installation](#setup--installation)
6. [Key Implementations](#key-implementations)
   - [Secure User Authentication](#secure-user-authentication)
   - [Report Download System](#report-download-system)
   - [Software Metrics and Logging](#software-metrics-and-logging)
   - [Role-Based Access Control](#role-based-access-control)
   - [Responsive Design](#responsive-design)
7. [Metrics and Logging](#metrics-and-logging)
8. [Goal-Based Measurement (GBM)](#goal-based-measurement-gbm)
9. [Modified & Implemented Files](#modified--implemented-files)
10. [Software Metrics](#software-metrics)
    - [Lines of Code (LOC)](#lines-of-code-loc)
    - [Halstead’s Metrics](#halsteads-metrics)
    - [Cyclomatic Complexity](#cyclomatic-complexity)
    - [Function Points (FP)](#function-points-fp)
11. [Future Plans](#future-plans)
12. [Contributing](#contributing)
13. [License](#license)
14. [Contact](#contact)

---

## **Getting Started**

To get started with MHARS, clone this repository and follow the setup steps below to get the system up and running on your local machine.

---

## **Features**

- **Informational Resources**: Comprehensive articles, guides, and resources on mental health topics.
- **Interactive Self-Help Tools**: Tools and assessments to help users track and improve their mental health.
- **Community Support**: Forums and discussion boards for users to connect and share experiences.
- **Secure User Authentication**: A robust and secure login/signup system with role-based access (user/admin).
- **Report Download System**: Allows authenticated users to securely download reports.
- **Responsive Design**: A user-friendly and responsive design that works seamlessly across devices.

---

## **Tech Stack**

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Recommended Versions**: 
  - PHP 7.4+
  - MySQL 5.7+

---

## **Project Structure**

```
MHARS/
├── assets/            # Images, icons, and static resources
├── css/               # Stylesheets
├── js/                # JavaScript files
├── php/               # Backend PHP scripts
│   ├── includes/      # Reusable PHP components (e.g., header, footer, db_connection)
│   ├── login.php      # Login page backend
│   ├── signup.php     # Signup page backend
│   ├── admin_dashboard.php # Admin dashboard backend
│   └── download_report.php # Report download backend
├── logs/              # Logs for metrics and error tracking
├── index.html         # Main entry point
└── README.md          # Project documentation
```

---

## **Setup & Installation**

### **1. Clone the Repository**
```bash
git clone git@github.com:kamukamaosbertl/MENTAL-HEALTH-SYSTEM-GROUP-3.git
cd mhars
```

### **2. Setup Database**
1. Create a MySQL database named `mhars`.
2. Import the provided `.sql` file (if available) to set up the necessary tables.
3. Update the `db_connection.php` file in the `includes` folder with your database credentials:
   ```php
   $host = "localhost";
   $username = "root";
   $password = "";
   $database = "mhars";
   ```

### **3. Run the Project**
1. Use a local server like XAMPP or WAMP to host the project.
2. Place the project folder in the `htdocs` (XAMPP) or `www` (WAMP) directory.
3. Start the Apache and MySQL services from your local server control panel.
4. Open your browser and navigate to:
   ```bash
   http://localhost/mhars/index.php
   ```

---

## **Key Implementations**

### **1. Secure User Authentication**
- **Login System**: Users can log in securely using their email, password, and role (user/admin).
- **Signup System**: New users can register with their full name, email, password, and role.
- **Password Hashing**: Passwords are securely hashed using `password_hash()` and verified using `password_verify()`.

### **2. Report Download System**
- **Secure Access**: Only authenticated users can download reports.
- **Validation**: Ensures the report ID is valid and belongs to the logged-in user.
- **Logging**: Tracks metrics like unauthorized access attempts, failed downloads, and download time.

### **3. Software Metrics and Logging**
- **Metrics Collection**: Tracks metrics like:
  - `error_count`: Number of errors encountered.
  - `query_count`: Number of database queries executed.
  - `execution_time`: Total time taken for script execution.
  - `failure_type`: Types of failures (e.g., invalid email, weak password).
  - `validation_time`: Time taken for input validation.
  - `db_query_time`: Time taken for database queries.
- **Structured Logging**: Logs metrics in a structured JSON format for easier analysis.

### **4. Role-Based Access Control**
- **User Roles**: Users can log in as either `user` or `admin`.
- **Role-Based Redirection**:
  - Users are redirected to the `services.php` page.
  - Admins are redirected to the `admin_dashboard.php` page.

### **5. Responsive Design**
The platform is designed to be fully responsive, ensuring a seamless experience across devices (desktop, tablet, mobile).

---

## **Metrics and Logging**

The system logs the following metrics for monitoring and improvement:
- **Unauthorized Access Attempts**: Logged when a user tries to access the download page without being logged in.
- **Missing Report IDs**: Logged when the report ID is missing in the URL.
- **Failed Downloads**: Logged when a report is not found or does not belong to the user.
- **Download Time**: Logged for successful downloads to measure performance.
- **Log Location**: Logs are stored in the server's error log file (e.g., `error_log`).

---

## **Goal-Based Measurement (GBM)**

This feature follows the Goal-Based Measurement framework to ensure continuous improvement:

- **Goal**: Enable users to securely and efficiently download their reports.
- **Questions to Address**:
  - Is the user authenticated before accessing the report?
  - Is the report ID valid and does it belong to the logged-in user?
  - Is the download process efficient and error-free?
  - Are errors handled gracefully?
- **Metrics**:
  - Number of unauthorized access attempts.
  - Number of invalid report ID requests.
  - Average download time.
  - Number of failed downloads.

---

## **Modified & Implemented Files**

- `booking.php` - Added cyclomatic complexity calculation and control flow graph representation.
- `admin_dashboard.php` - Implemented structured logging and performance tracking.
- `counseling.php` - Integrated software complexity metrics and logging.
- `download_report.php` - Added secure report download functionality with logging and performance metrics.
- `includes/helpers.php` - Added helper functions for software metrics calculation.

---

## **Software Metrics**

### **1️⃣ Lines of Code (LOC)**
Measures the total number of lines in HTML, CSS, JS, and PHP files. Differentiates between commented lines and effective code lines.

### **2️⃣ Halstead’s Metrics**
Measures operators and operands in the source code. Calculates:
- Program Length (N)
- Program Vocabulary (n)
- Program Volume (V)
- Program Difficulty (D)
- Effort (E)
- Estimated Bugs (B)

### **3️⃣ Cyclomatic Complexity (McCabe's Complexity)**
Determines the complexity of the control flow in the program. Higher values indicate higher complexity and maintenance cost.

### **4️⃣ Function Points (FP)**
Measures software functionality based on:
- External Inputs (EI)
- External Outputs (EO)
- External Inquiries (EQ)
- Internal Logical Files (ILF)
- External Interface Files (EIF)
- Includes Value Adjustment Factor (VAF) for final FP calculation.

---

## **Future Plans**

- **Enhanced Security**:
  - Implement data encryption for sensitive information.
  - Add CAPTCHA or two-factor authentication (2FA) for secure login.
- **Performance Optimization**:
  - Optimize database queries and reduce page load times.
  - Implement caching mechanisms for faster access to static resources.
- **Report Download System Improvements**:
  - Add support for downloading reports in multiple formats (e.g., PDF, CSV).
  - Implement rate limiting to prevent abuse of the download feature.
  - Add user feedback collection for the download experience.
- **Mobile Application**:
  - Develop a mobile app version of MHARS for easier access on the go.
- **Advanced Features**:
  - Add AI-based mental health assessments.
  - Integrate live chat support with mental health professionals.
  - Expand the community forum with more interactive features.

---

## **Contributing**

We welcome contributions to MHARS! If you'd like to contribute, please follow these steps:
1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Commit your changes and push them to your fork.
4. Submit a pull request with a detailed description of your changes.

---

## **License**

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## **Contact**

For any questions or feedback, feel free to reach out:
- **Email**: kamukamaosbert2023@gmail.com
- **GitHub**: [GitHub Repository](https://github.com/kamukamaosbertl/MENTAL-HEALTH-SYSTEM-GROUP-3)

---

Thank you for using MHARS! Together, we can make mental health resources more accessible and supportive for everyone.

--- 

This version is more structured, easier to navigate, and retains all the original content while improving readability. Let me know if you need further adjustments!