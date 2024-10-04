# Online Video Game Rental System

This is a web application built using MySQL, PHP, HTML, and CSS,Python Streamlit, where users can rent physical copies of video games and admins can manage the available games and perform CRUD operations. Part of the the admin dashboard is built using Streamlit.

## Features

- User login and registration
- Choose games from a list of available games
- Select the rental duration
- Rent games
- Return rented games
- Admin login to access dashboard
- Add, delete, and update games
- Execute SQL queries from the admin dashboard

## Technologies Used

- MySQL
- PHP
- HTML
- CSS
- XAMPP
- Streamlit

## Getting Started

To get started, follow these steps:

1. Install XAMPP on your system
2. Clone this repository into the `htdocs` folder in your XAMPP directory
3. Import the `videogamerental.sql` file into your MySQL server
4. Update the database credentials in `connection.php`
5. Run the XAMPP server
6. Navigate to `http://localhost/videogame-rental` in your web browser

To run the admin dashboard, follow these additional steps:

1. Install Streamlit using `pip install streamlit`
2. Navigate to the project directory in your terminal
3. Run `streamlit run dashboard.py`
4. The Streamlit app should open in your default web browser

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.
