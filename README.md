
# Healthtok Documentation

## API Endpoints

### 1. Login

<details>
<summary>Login Endpoint</summary>

**URL**: `/social_auth/login.php`

**Method**: `GET`

**Description**: Initiates the OAuth authentication process with the specified provider.

**Query Parameters**:
- `provider` (string): The name of the OAuth provider (e.g., `Google`).

**Response**:
- Redirects the user to the OAuth provider's authorization page.

**Example Request**:
```sh
GET /social_auth/login.php?provider=Google
```
</details>

### 2. Callback Endpoint

<details>
<summary> Callback Endpoint </summary>

**URL**: `/social_auth/callback.php`

**Method**: `GET`

**Description**: Handles the OAuth callback and retrieves the user's profile information.

**Query Parameters**:
- `code` (string): The authorization code returned by the OAuth provider.
- `provider` (string): The name of the OAuth provider (e.g., `Google`).

**Response**:
- `200 OK`: Returns a JSON object containing the user's profile information.
- `400 Bad Request`: Returns a JSON object with an error message if the required parameters are missing or invalid.
- `500 Internal Server Error`: Returns a JSON object with an error message if something goes wrong during the callback process.

**Response Fields**:
- `firstName` (string): The user's first name.
- `lastName` (string): The user's last name.
- `email` (string): The user's email address.
- `photoURL` (string): The URL of the user's profile photo.

**Example Request**:
```sh
GET /social_auth/callback.php?provider=Google&code=AUTHORIZATION_CODE
```

**Example Response**:
```json
{
    "firstName": "John",
    "lastName": "Doe",
    "email": "john.doe@example.com",
    "photoURL": "http://example.com/photo.jpg"
}
```

**Example Error Response**:
```json
{
    "error": "Oops! Something went wrong during the callback: Error message"
}
```
</details>

### 3. Store User Endpoint

<details>
<summary>Store user</summary>

**URL**: `/fbauth/store-user.php`

**Method**: `POST`

**Description**: Stores user details like email, role, gender, and fbid in the PostgreSQL database.

**Request Body**:
- `email` (string): The user's email address.
- `role` (string): The user's role.
- `gender` (string): The user's gender.
- `fbid` (string): The user's Facebook ID.

**Response**:
- `200 OK`: Returns a JSON object indicating success.
- `400 Bad Request`: Returns a JSON object with an error message if the input data is invalid.
- `500 Internal Server Error`: Returns a JSON object with an error message if something goes wrong during the database operation.

**Example Request**:
```sh
POST /fbauth/store-user.php
Content-Type: application/json

{
    "email": "john.doe@example.com",
    "role": "user",
    "gender": "male",
    "fbid": "1234567890"
}
```

**Example Response**:
```json
{
    "success": "User details stored successfully"
}
```
</details>

### 4. Get User Endpoint
<details>
<summary>Get User</summary>

**URL**: `/fbauth/get-user.php`

**Method**: `GET`

**Description**: Retrieves user details based on the fbid from the PostgreSQL database.

**Query Parameters**:
- `fbid` (string): The user's Facebook ID.

**Response**:
- `200 OK`: Returns a JSON object containing the user's details.
- `400 Bad Request`: Returns a JSON object with an error message if the fbid parameter is missing or invalid.
- `404 Not Found`: Returns a JSON object with an error message if the user is not found.
- `500 Internal Server Error`: Returns a JSON object with an error message if something goes wrong during the database operation.

**Response Fields**:
- `email` (string): The user's email address.
- `role` (string): The user's role.
- `gender` (string): The user's gender.
- `fbid` (string): The user's Facebook ID.

**Example Request**:
```sh
GET /fbauth/get-user.php?fbid=1234567890
```

**Example Response**:
```json
{
    "email": "john.doe@example.com",
    "role": "user",
    "gender": "male",
    "fbid": "1234567890"
}
```
</details>

### 5. Mental Health Tips API

<details>
<summary>Mental Health Tips API</summary>

This API provides endpoints to manage mental health tips, allowing users to retrieve all tips, retrieve a single tip, add new tips (including the `authorID`), and delete tips.


---

## 1. Get All Mental Health Tips

### **Endpoint**
```
GET /tips/all.php
```

### **Description**
Retrieves all mental health tips from the database.

### **Request Method**
`GET`

### **Response Example**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "tip": "Take regular breaks during work to relax your mind.",
      "authorID": 1,
      "created_at": "2024-10-06 12:30:00"
    },
    {
      "id": 2,
      "tip": "Maintain a balanced diet to improve mental clarity.",
      "authorID": 2,
      "created_at": "2024-10-06 12:35:00"
    }
    // More tips...
  ]
}
```

### **Status Codes**
- `200 OK`: Successfully retrieved all tips.
- `500 Internal Server Error`: Failed to retrieve tips due to server issues.

---

## 2. Get a Single Mental Health Tip

### **Endpoint**
```
GET /tips/tip.php?id={id}
```

### **Description**
Retrieves a specific mental health tip by its ID.

### **Request Method**
`GET`

### **Request Parameters**
- `id`: The ID of the tip you want to retrieve.

### **Response Example**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "tip": "Take regular breaks during work to relax your mind.",
    "authorID": 1,
    "created_at": "2024-10-06 12:30:00"
  }
}
```

### **Status Codes**
- `200 OK`: Successfully retrieved the tip.
- `400 Bad Request`: The `id` parameter is missing.
- `404 Not Found`: The tip with the specified ID was not found.
- `500 Internal Server Error`: Failed to retrieve the tip due to server issues.

---

## 3. Add a New Mental Health Tip

### **Endpoint**
```
POST /tips/add.php
```

### **Description**
Adds a new mental health tip to the database. The `authorID` field is required to associate the tip with an author (practitioner).

### **Request Method**
`POST`

### **Request Body Example**
```json
{
  "tip": "Engage in regular physical activity to reduce stress.",
  "authorID": 1
}
```

### **Response Example**
```json
{
  "status": "success",
  "message": "Tip added successfully.",
  "data": {
    "id": 16,
    "tip": "Engage in regular physical activity to reduce stress.",
    "authorID": 1
  }
}
```

### **Status Codes**
- `201 Created`: The tip was successfully added.
- `400 Bad Request`: Missing or invalid data in the request body (e.g., `tip` or `authorID` is missing).
- `500 Internal Server Error`: Failed to add the tip due to server issues.

---

## 4. Delete a Mental Health Tip

### **Endpoint**
```
DELETE /tips/delete?id={id}
```

### **Description**
Deletes a mental health tip by its ID.

### **Request Method**
`DELETE`

### **Request Parameters**
- `id`: The ID of the tip you want to delete.

### **Response Example**
```json
{
  "status": "success",
  "message": "Tip deleted successfully."
}
```

### **Status Codes**
- `200 OK`: Successfully deleted the tip.
- `400 Bad Request`: The `id` parameter is missing.
- `404 Not Found`: The tip with the specified ID was not found.
- `500 Internal Server Error`: Failed to delete the tip due to server issues.

---

## Common Error Responses

### **Response Example (400 Bad Request)**
```json
{
  "status": "error",
  "message": "Missing required fields: tip, authorID."
}
```

### **Response Example (404 Not Found)**
```json
{
  "status": "error",
  "message": "Tip not found."
}
```

### **Response Example (405 Method Not Allowed)**
```json
{
  "status": "error",
  "message": "Method not allowed."
}
```

### **Response Example (500 Internal Server Error)**
```json
{
  "status": "error",
  "message": "Database error: failed to connect to the database."
}
```
</details>

### 6. Gemini Chat API Documentation
<details>
<summary>Ai chat docs</summary>

---

## Endpoints

### 1. Send a Message to Gemini Chat
This endpoint sends a message to the Gemini chat service and returns a response.

- **URL**: `/aichat/chat.php`
- **Method**: `POST`
- **Request Headers**:
  - `Content-Type: application/json`
- **Request Body** (JSON):
  ```json
  {
    "message": "your message here"
  }
  ```
- **Success Response**:
  - **Status**: `200 OK`
  - **Content-Type**: `application/json`
  - **Body**:
    ```json
    {
      "status": "success",
      "response": "Gemini's response here"
    }
    ```

- **Error Responses**:

  - **Invalid Request Method**:
    - **Status**: `405 Method Not Allowed`
    - **Body**:
      ```json
      {
        "status": "error",
        "message": "Invalid request method"
      }
      ```

  - **Missing or Empty Message**:
    - **Status**: `400 Bad Request`
    - **Body**:
      ```json
      {
        "status": "error",
        "message": "Message is required"
      }
      ```

  - **Internal Server Error**:
    - **Status**: `500 Internal Server Error`
    - **Body**:
      ```json
      {
        "status": "error",
        "message": "An error message describing the issue"
      }
      ```

## Example Request

### Request Body:
```json
{
  "message": "Hello Gemini!"
}
```

### Response (Success):
```json
{
  "status": "success",
  "response": "Hello World in PHP"
}
```

### Response (Error - Invalid Method):
```json
{
  "status": "error",
  "message": "Invalid request method"
}
```

### Response (Error - Missing Message):
```json
{
  "status": "error",
  "message": "Message is required"
}
```


</details>

### 7. Note-Taking API Documentation

<details>
<summary>Notes API</summary>

---

### Endpoints

#### 1. Get All Notes

- **Endpoint:** `/notes/all.php`
- **Method:** `GET`
- **Description:** Retrieve a list of all notes.
- **Response:**
  - **200 OK**
    - **Content:**
      ```json
      [
        {
          "noteID": 1,
          "title": "Meeting Notes",
          "content": "Notes from the client meeting on project status and next steps.",
          "authorid": 1,
          "created_at": "2024-10-05T12:00:00Z"
        },
        ...
      ]
      ```

#### 2. Get Note by ID

- **Endpoint:** `/notes/note.php?id={id}`
- **Method:** `GET`
- **Description:** Retrieve a note by its ID.
- **Path Parameters:**
  - `noteID`: ID of the note to retrieve.
- **Response:**
  - **200 OK**
    - **Content:**
      ```json
      {
        "noteID": 1,
        "title": "Meeting Notes",
        "content": "Notes from the client meeting on project status and next steps.",
        "authorid": 1,
        "created_at": "2024-10-05T12:00:00Z"
      }
      ```
  - **404 Not Found**
    - **Content:**
      ```json
      {
        "error": "Note not found"
      }
      ```

#### 3. Add Note

- **Endpoint:** `/notes/add.php`
- **Method:** `POST`
- **Description:** Add a new note.
- **Request Body:**
  ```json
  {
    "title": "New Note Title",
    "content": "Content of the new note.",
    "authorid": 1
  }
  ```
- **Response:**
  - **201 Created**
    - **Content:**
      ```json
      {
        "noteID": 1,
        "title": "New Note Title",
        "content": "Content of the new note.",
        "authorid": 1,
        "created_at": "2024-10-05T12:00:00Z"
      }
      ```
  - **400 Bad Request**
    - **Content:**
      ```json
      {
        "error": "Invalid input"
      }
      ```

#### 4. Delete Note

- **Endpoint:** `/notes/delete.php?id={id}`
- **Method:** `DELETE`
- **Description:** Delete a note by its ID.
- **Path Parameters:**
  - `noteID`: ID of the note to delete.
- **Response:**
  - **204 No Content**
  - **404 Not Found**
    - **Content:**
      ```json
      {
        "error": "Note not found"
      }
      ```

---

### Sample Request and Response

#### Add Note Example

**Request:**
```bash
POST /api/notes/
Content-Type: application/json

{
  "title": "Sample Note",
  "content": "This is a sample note.",
  "authorid": 1
}
```

**Response:**
```json
{
  "noteID": 1,
  "title": "Sample Note",
  "content": "This is a sample note.",
  "authorid": 1,
  "created_at": "2024-10-05T12:00:00Z"
}
```

</details>