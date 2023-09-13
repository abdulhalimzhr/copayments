## CoPayments

##### Coding Collective's Take Home test

This app is built with Laravel 10 & Livewire 3.

### Prerequisites

Please make sure you have the following tools installed before setup this project:

- Composer
- NPM
- Docker
- [Makefile](https://www.gnu.org/software/make/manual/make.html)

### Setup

1. Open your terminal/command line within the project directory and run `make setup`. This process will take around 5-10 minutes to finish the setup process in the localhost
2. After the setup is done, the apps can now be accessed through `http://localhost`

### Running the Application

1. Open browser and navigate to `http://localhost` and click "Login"
2. Please use the following credentials to login:
   ```
   email: test@test.com
   password: password
   ```

### Running the API

This application uses the following API:

#### Deposit

- URL: http://localhost/api/simulate-deposit
- Authentication: Bearer YWJkdWwgaGFsaW0=
- Request Body (example)
  ```
      {
          "order_id": "1" ,
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

#### Preview
