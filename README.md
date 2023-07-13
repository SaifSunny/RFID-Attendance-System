# UniTrack-RFID-Attendance-System

UniTrack is a comprehensive attendance management system designed specifically for universities. It has been developed using Bootstrap, PHP, MySQL, and RFID modules to provide a user-friendly interface and efficient administration. The system enables universities to seamlessly manage semesters, departments, RFID devices, courses, programs, teachers, and students. With UniTrack, administrators can easily create classes and assign teachers and students to those classes. Teachers, upon receiving their account credentials, can effortlessly add students to the classes assigned to them by the admin. The attendance tracking process is simplified as teachers can activate the RFID device in their class, and as students swipe their cards, attendance is automatically recorded. UniTrack simplifies attendance management for universities, providing accurate and convenient tracking while reducing administrative burdens.

# Features

  **1. User-Friendly Interface:** UniTrack offers a user-friendly interface, making it easy for administrators, teachers, and students to navigate and perform their respective tasks.
  
  **2. Semester and Department Management:** The system allows administrators to manage semesters and departments efficiently, facilitating organized attendance tracking for different academic units.
  
  **3. RFID Device Integration:** UniTrack seamlessly integrates with RFID devices, enabling teachers to record attendance simply by activating the device and having students swipe their RFID cards.
  
  **4. Course and Program Management:** Administrators can easily create and manage courses and programs within the system, providing a structured framework for attendance management.
  
  **5. Teacher and Student Assignment:** Administrators have the privilege of assigning teachers and students to specific classes, ensuring accurate tracking of attendance for each course.
  
  **6. Effortless Student Enrollment:** Teachers can effortlessly add students to the classes assigned to them, streamlining the enrollment process and reducing administrative efforts.

# Technologies Used

UniTrack has been developed using the following technologies:

  **Bootstrap:** A popular front-end framework that provides a responsive and modern user interface design.
  
 **PHP:** A server-side scripting language used for implementing the logic and functionality of the attendance system.
  
  **MySQL:** A relational database management system used for storing and managing the attendance data and system configurations.
  
  **RFID Modules:** RFID (Radio Frequency Identification) modules are utilized to integrate the attendance system with RFID card-swiping devices for automatic attendance tracking.

# Setup Instructions
To set up UniTrack locally, please follow these steps:

  1. Clone the GitHub repository to your local machine:
  ```
  git clone https://github.com/your-username/untrack.git
  ```
  Ensure you have a compatible web server environment (such as Apache or Nginx) installed on your machine.
  
  2. Install PHP and MySQL on your local machine if they are not already installed.
  
  3. Create a new MySQL database and import the provided SQL file (database.sql) to set up the necessary database structure.
  
  4. Update the database connection details in the configuration file (config.php) located in the root directory of the project. Modify the DB_HOST, DB_USERNAME, DB_PASSWORD, and DB_NAME constants with your own MySQL database credentials.
  
  5. Deploy the UniTrack system to your web server.
  
  6. Access UniTrack by navigating to the appropriate URL in your web browser.

# Contributions
Contributions to UniTrack are welcome! If you would like to contribute, please fork the repository, make your changes, and submit a pull request.

# Contact
If you have any questions or suggestions regarding UniTrack, feel free to reach out to us at saifsunny56@gmail.com.
