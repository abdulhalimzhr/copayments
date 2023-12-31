## CoPayments

This app is built with Laravel 10, Livewire 3 & TailwindCSS + Flowbite.

*Tested with Windows 11

### Prerequisites

Please make sure you have the following tools installed before setting up this project:

- Composer
- NPM
- Docker
- [Makefile](https://www.gnu.org/software/make/manual/make.html)

### Setup

1. Open your terminal/command line within the project directory and run

   For Windows & other OS:

   ```
   make setup
   ```

   For Mac M1 and above:

   ```
   make setup-m1
   ```

   This process will take around 5-10 minutes to finish the setup process at the localhost

2. After the setup is done, the apps can now be accessed through `http://localhost`

### Running the Application

1. Open the browser and navigate to `http://localhost` and click "Login"
2. Please use the following credentials to login:
   ```
   email: test@test.com
   password: password
   ```

### Running the API

This application uses the following API:

#### Deposit

- URL: http://localhost/api/simulate-deposit
- Authentication: `Bearer YWJkdWwgaGFsaW0=` (base64 encoded)
- Request Body (example)
  ```
      {
          "order_id": "1",
          "amount": 1.1,
          "timestamp": "2023-09-12 22:48:00"
      }
  ```
- Response Body (example)
  ```
  {
      "status": true,
      "message": "Deposit queued successfully",
      "data": {
          "order_id": "1",
          "amount": 1,
          "status": 1
      }
  }
  ```

### Makefile Usages

You can use the following commands to manage this project:

- `make setup`: Sets up the project, including installing dependencies, generating keys, and running migrations.
- `make start`: Starts the project in detached mode.
- `make restart`: Restarts the project.
- `make build`: Builds the project, useful when you need to rebuild containers.
- `make stop`: Stops the project.
- `make down`: Stops and removes containers, networks, images, and volumes.
- `make cache`: Clears various Laravel caches.
- `make logs`: Shows container logs.
- `make reset`: Resets the database and seeds it.
- `make route-list`: Lists the registered routes.
- `make bash`: Accesses the app container's bash shell.
- `make queue-work`: Starts the queue worker.
- `make queue-listen`: Starts the queue listener.
- `make help`: Displays a list of available commands.

### Preview

1. Home
   ![image](https://github.com/abdulhalimzhr/copayments/assets/75671219/759cd7ba-0bf7-4146-a9af-b9b4b5f98c7c)

2. Login
   ![image](https://github.com/abdulhalimzhr/copayments/assets/75671219/0178033e-bc8e-4d5b-94c1-aa2eabcd129d)

3. Dashboard
   ![image](https://github.com/abdulhalimzhr/copayments/assets/75671219/34439436-9dbc-4a91-a9c0-a5c6bb509686)

4. Deposit
   ![image](https://github.com/abdulhalimzhr/copayments/assets/75671219/6ab1d81f-e827-4d06-b3e3-bce2865face9)

5. Withdraw
   ![image](https://github.com/abdulhalimzhr/copayments/assets/75671219/34fd6aea-ef7b-40b0-b5c9-de550ec46e04)
