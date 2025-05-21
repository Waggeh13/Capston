# Web Application README

## Overview
This web application is built using PHP, HTML, JavaScript, and CSS. It provides a platform for managing users (e.g., superadmin, doctors, pharmacists, cashiers, admins, lab technicians, and patients) and supports virtual meeting bookings via Zoom integration. The application requires a database setup and configuration of API keys for full functionality, including integration with the ChatGPT API for AI-driven features.

This README provides detailed instructions on how to set up the application, host it locally or on a server, and use its core features.

---

## Prerequisites
Before setting up the application, ensure you have the following:
- A web server environment (e.g., XAMPP for local hosting or a remote server with PHP support).
- PHP (version 7.4 or higher recommended).
- A database management system (e.g., MySQL or MariaDB).
- A text editor to modify configuration files (e.g., VS Code, Notepad++).
- A Zoom account for virtual meeting integration.
- An OpenAI API key for ChatGPT functionality (optional, depending on features used).
- Basic knowledge of database management and server configuration.

---

## Setup Instructions

### 1. Extract Files
1. Download the application source code package.
2. Extract all files and folders into a root directory of your choice (e.g., `my_webapp`).
   - Ensure the directory structure remains intact, including all assets, PHP files, JavaScript, CSS, and the SQL database file.

### 2. Set Up the Database
1. **Import the SQL File**:
   - Locate the SQL file included in the root directory (e.g., `database.sql`).
   - Open your database management tool (e.g., phpMyAdmin, MySQL Workbench, or command-line MySQL).
   - Create a new database (e.g., `my_webapp_db`).
   - Import the SQL file into the newly created database to set up the required tables and schema.
     - In phpMyAdmin: Select the database, go to the "Import" tab, upload the SQL file, and click "Go."
     - In MySQL CLI: Run `mysql -u [username] -p [database_name] < database.sql`.

2. **Configure Database Credentials**:
   - Navigate to the `db_cred` file in the root directory (e.g., `db_cred.php`).
   - Open the file in a text editor and update the database credentials with your own:
     ```php
     <?php
     return [
         'host' => 'localhost', // Replace with your database host
         'database' => 'my_webapp_db', // Replace with your database name
         'username' => 'your_username', // Replace with your database username
         'password' => 'your_password' // Replace with your database password
     ];
     ?>
     ```
   - Save the file after updating the credentials.

### 3. Configure the ChatGPT API Key
1. **Obtain an OpenAI API Key**:
   - Visit the OpenAI API website (https://platform.openai.com/account/api-keys).
   - Sign up or log in to your OpenAI account.
   - Generate a new API key for your application.
   - Copy the API key to your clipboard.

2. **Update the Configuration File**:
   - Locate the configuration file in the root directory (e.g., `config.php`).
   - Open the file in a text editor and replace the placeholder with your OpenAI API key:
     ```php
     <?php
     return [
         'OPENAI_API_KEY' => 'your_openai_api_key_here' // Replace with your actual OpenAI API key
     ];
     ?>
     ```
   - Save the file after updating the key.

### 4. Host the Application
You can host the application locally using XAMPP or on a remote server. Follow the appropriate steps below:

#### Option A: Local Hosting with XAMPP
1. **Install XAMPP**:
   - Download and install XAMPP (https://www.apachefriends.org/index.html) if not already installed.
   - Ensure Apache and MySQL modules are enabled.

2. **Move Files to XAMPP**:
   - Copy the entire root directory (e.g., `my_webapp`) to the `htdocs` folder in your XAMPP installation (e.g., `C:\xampp\htdocs\my_webapp`).
   - Ensure all files and subdirectories are copied correctly.

3. **Access the Application**:
   - Start XAMPP and ensure Apache and MySQL services are running.
   - Open a web browser and navigate to `http://localhost/my_webapp` (replace `my_webapp` with your root directory name).
   - The application should now be accessible locally.

#### Option B: Hosting on a Remote Server
1. **Prepare the Server**:
   - Ensure your server has PHP, a web server (e.g., Apache or Nginx), and MySQL/MariaDB installed.
   - Verify that the server supports the required PHP version and extensions.

2. **Upload Files**:
   - Use an FTP client (e.g., FileZilla) or your hosting provider’s file manager to upload the contents of the root directory to the server’s root directory (e.g., `/var/www/html/` or `public_html`).
   - Ensure all files and folders are uploaded correctly.

3. **Set Up the Database on the Server**:
   - Create a database on the server using your hosting provider’s control panel or MySQL CLI.
   - Import the SQL file into the database as described in Step 2.
   - Update the `db_cred.php` file with the server’s database credentials.

4. **Access the Application**:
   - Navigate to your server’s domain or IP address (e.g., `http://yourdomain.com` or `http://server_ip`).
   - The application should now be live on the server.

---

## Using the Web Application

### 1. Creating the Superadmin Account
- **Note**: Patients cannot create their own accounts. A superadmin account must be created manually to manage other users.
- To create a superadmin account:
  1. Access the database using your database management tool.
  2. Locate the users table (e.g., `users` or similar, depending on your schema).
  3. Insert a new record for the superadmin with the required fields (e.g., username, password, role, etc.).
     - Ensure the password is hashed (use a PHP function like `password_hash()` if required).
     - Set the role to `superadmin` or the equivalent role identifier in your schema.
  4. Save the record.

- Log in to the application using the superadmin credentials.
- The superadmin can now create other user accounts (e.g., doctors, pharmacists, cashiers, admins, lab technicians, patients) through the application’s admin interface.

### 2. Booking Virtual Meetings with Zoom
- The application supports virtual meeting bookings via Zoom integration.
- **Steps**:
  1. When booking a virtual meeting, users will be prompted to log in to their Zoom account.
  2. Authorize the application to access your Zoom account when prompted.
  3. Once authorized, users can schedule virtual appointments through the application’s interface.
- **Note**: Ensure you have a valid Zoom account and that the Zoom API is properly configured in the application (check any Zoom-related configuration files or settings).

### 3. General Usage
- **User Roles**: The superadmin can create accounts for various roles, including:
  - Doctors
  - Pharmacists
  - Cashiers
  - Admins
  - Lab Technicians
  - Patients
- **Features**:
  - Manage user accounts (create, update, delete) via the superadmin interface.
  - Book and manage virtual appointments with Zoom integration.
  - Utilize AI-driven features powered by the ChatGPT API (if configured).
- Navigate the application’s interface to access specific features based on your role.

---

## Troubleshooting
- **Database Connection Issues**:
  - Verify that the database credentials in `db_cred.php` are correct.
  - Ensure the database server is running and accessible.
- **ChatGPT API Errors**:
  - Confirm that the OpenAI API key in `config.php` is valid and has not expired.
  - Check your OpenAI account for API usage limits or restrictions.
- **Zoom Integration Issues**:
  - Ensure you have a valid Zoom account and have authorized the application.
  - Verify that any Zoom API credentials (if applicable) are correctly configured.
- **Application Not Loading**:
  - Check that all files are correctly placed in the `htdocs` folder (for XAMPP) or the server’s root directory.
  - Ensure the web server (Apache/Nginx) and PHP are properly installed and running.

---

## Additional Notes
- **Security**:
  - Keep your database credentials and OpenAI API key secure. Do not share them publicly.
  - Regularly back up your database to prevent data loss.
- **Updates**:
  - Check the application’s repository or documentation for updates or additional features.
- **Support**:
  - For further assistance, consult the application’s documentation or contact the developer.

Thank you for using this web application! If you encounter any issues or have questions, refer to the troubleshooting section or seek additional support.