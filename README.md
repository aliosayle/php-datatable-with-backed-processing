# PHP DataTable with Search Builder

This project is a data table with server-side features like search, sorting, and search builder. These features are implemented on the backend to ensure efficient performance, especially for large datasets.

## Features
- **Server-Side Processing:** Ensures scalability for large datasets.
- **Search Builder:** Advanced search with multiple criteria.
- **Column Reordering:** Reorder columns on the frontend.
- **Pagination and Sorting:** Optimized server-side pagination and sorting.

## Technologies Used
- **Frontend:**
  - DataTables.js (v1.13.1)
  - SearchBuilder (v1.3.0)
  - jQuery (v3.6.0)
- **Backend:**
  - PHP
  - MySQL/MariaDB

## Installation
1. Clone this repository:
    ```bash
    git clone https://github.com/aliosayle/php-datatable-with-backed-processing.git
    ```
2. Import the `search_builder` database or create a `users` table with columns: `id`, `name`, `email`, and `country`.
3. Configure the database connection in the PHP backend (`fetch_data.php`):
    ```php
    $host = 'localhost';
    $db = 'search_builder';
    $user = 'root';
    $pass = '';
    ```
4. Start your local server (e.g., using XAMPP) and place the project files in the `htdocs` folder.
5. Open the project in your browser:
    ```
    http://localhost/your-project-folder
    ```
## License and Contribution
Contributions to this repo are welcome, If you have any ideas or improvements please submit a pull request or open an issue.
You may also use the code in this project freely.