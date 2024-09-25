# User Management System (Roles & Permissions) API

## Overview

This Laravel project implements a User Management System with support for Roles and Permissions. It allows for fine-grained control over user roles, permissions, categories and books ensuring that only authorized users can perform specific actions.
## Features

- **User Management**: Create, read, update, and delete users with assigned roles and permissions.
- **Role Management**: Define roles and assign multiple permissions to each role.
- **Permission Management**: Control what actions users can perform by assigning them specific permissions.
- **Authentication**: Secured with JWT authentication.
- **JWT Authentication**: Secured API access using JWT tokens.


## Project Setup

### Requirements

- PHP >= 8.0
- Composer
- Laravel >= 9.x
- MySQL or another database
- JWT Authentication (via tymon/jwt-auth)


### Installation

1. **Clone the Repository**

    ```bash
    git clone https://github.com/Dralve/user-management-system.git
    ```

2. **Navigate to the Project Directory**

    ```bash
    cd team-management-api
    ```

3. **Install Dependencies**

    ```bash
    composer install
    ```

4. **Set Up Environment Variables**

   Copy the `.env.example` file to `.env` and configure your database and other environment settings.

    ```bash
    cp .env.example .env
    ```

   Update the `.env` file with your database credentials and other configuration details.

5. **Generate JWT secret key**

    ```bash
    php artisan jwt:secret
    ```

6. **Run Migrations**

    ```bash
    php artisan migrate
    ```

7. **Seed the Database (Seed Admin And Permissions)**

    ```bash
    php artisan db:seed
    ```

8. **Start the Development Server**

    ```bash
    php artisan serve
    ```
   
### Database Structure
    
- The following tables are created to manage users, roles, and permissions:
- users: Stores user information.
- roles: Stores role names and descriptions.
- permissions: Stores permission names and descriptions.
- role_user: Pivot table linking users to roles (Many-to-Many relationship).
- permission_role: Pivot table linking permissions to roles (Many-to-Many relationship).
- categories: Stores category names and descriptions.
- books: Stores book titles, authors, published date.

## API Endpoints

### Authentication

- **Register**: `POST /api/auth/v1/register`
- **Login**: `POST /api/auth/v1/login`
- **Logout**: `POST api/auth/v1/logout`
- **Refresh**: `POST api/auth/v1/refresh`
- **current**: `GET api/auth/v1/current`

### Roles

- **Create Roles**: `POST /api/v1/roles`
- **View Roles**: `GET /api/v1/roles`
- **show Roles**: `GET /api/v1/roles/{id}`
- **Update Roles**: `PUT /api/v1/roles/{id}`
- **Delete Roles**: `DELETE /api/v1/roles/{id}`


### Permissions

- **Create Permissions**: `POST /api/v1/permissions`
- **View Permissions**: `GET /api/v1/permissions`
- **show Permissions**: `GET /api/v1/permissions/{id}`
- **Update Permissions**: `PUT /api/v1/permissions/{id}`
- **Delete Permissions**: `DELETE /api/v1/permissions/{id}`
- **Restore Permissions**: `POST /api/v1/permission/{id}/restore`
- **Show Deleted Permissions**: `Get /api/v1/deleted/permissions`
- **Permanently Delete Permissions**: `DELETE /api/v1/permission/{id}/permanently/delete`


### Users

- **Create User**: `POST /api/v1/users`
- **View Users**: `GET /api/v1/users`
- **Update User**: `PUT /api/v1/users/{id}`
- **Delete User**: `DELETE /api/v1/users/{id}`
- **Restore User**: `POST /api/v1/user/{id}/restore`
- **Get User By Id**: `POST /api/v1/users/{id}`
- **Show deleted Users**: `POST /api/v1/get/deleted/users`
- **Permanently deleted Users**: `DELETE /api/v1/users/{id}/permanently/delete`


### Categories

- **Create Categories**: `POST /api/v1/categories`
- **View Categories**: `GET /api/v1/categories`
- **Update Categories**: `PUT /api/v1/categories/{id}`
- **Delete Categories**: `DELETE /api/v1/categories/{id}`
- **Restore Categories**: `POST /api/v1/category/{id}/restore`
- **Get Categories By Id**: `POST /api/v1/categories/{id}`
- **Show deleted Categories**: `POST /api/v1/get/deleted/categories`
- **Permanently deleted Categories**: `DELETE /api/v1/category/{id}/permanently/delete`

### Books

- **Create Books**: `POST /api/v1/books`
- **View Books**: `GET /api/v1/books`
- **Update Books**: `PUT /api/v1/books/{id}`
- **Delete Books**: `DELETE /api/v1/books/{id}`
- **Restore Books**: `POST /api/v1/book/{id}/restore`
- **Get Books By Id**: `POST /api/v1/books/{id}`
- **Show deleted Books**: `POST /api/v1/get/deleted/books`
- **Permanently deleted Books**: `DELETE /api/v1/book/{id}/permanently/delete`



## Error Handling

Customized error messages and responses are provided to ensure clarity and user-friendly feedback.

## Documentation

All code is documented with appropriate comments and DocBlocks. For more details on the codebase, refer to the inline comments.

## Contributing

Contributions are welcome! Please follow the standard pull request process and adhere to the project's coding standards.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contact

For any questions or issues, please contact [your email] or open an issue on GitHub.

