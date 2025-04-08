
---

## API List

1. `POST /api/register` — User Registration
2. `POST /api/login` — User Login
3. `POST /api/verify-otp` — Verify Email OTP
4. `POST /api/reset-password` — Send OTP for Password Reset
5. `POST /api/confirm-password` — Confirm New Password Using OTP
6. `GET /api/user/{id}` - Show the user information after authenticate
7. `POST /api/user/update/{id}` - Update the user profile.
8. `GET /api/user` - All user list
8. `POST /api/logout` — Logout (Requires Auth Token)

---

### Registration (`/api/register`)

**Parameters:**

- `name` (string) — Username
- `email` (string) — Must be a valid and unique email
- `password` (string) — Minimum 6 characters
- `confirm_password` (string) — Must match `password`

On success: Sends a 4-digit OTP to the user's email.  
OTP is valid for 2 minutes.

---

### Login (`/api/login`)

**Parameters:**

- `email` (string)
- `password` (string)

Returns an auth token upon successful login.
Login is only allowed if the email is verified.

---

### Verify OTP (`/api/verify-otp`)

**Parameters:**

- `email` (string)
- `otp` (string)

Verifies the OTP sent to the email.  
OTP is valid for 2 minutes.

---

###  Reset Password Request (`/api/reset-password`)

**Parameters:**

- `email` (string)

Sends a reset OTP to the user's email.   
OTP is valid for 10 minutes.

---

### Confirm New Password (`/api/confirm-password`)

**Parameters:**

- `email` (string)
- `otp` (string)
- `password` (string) — Minimum 6 characters
- `confirm_password` (string) — Must match `password`

Updates the user's password if OTP is correct and not expired.

---

### All User Information (`/api/user`)
It will show the all user information. This link is not authenticate. 

---
### Individual User Information (`/api/user/{id}`)

It will show the individual and authenticate user information. This link will be showed the username, email, bio and avatar(profile picture).

---
### Update User Profile (`/api/user/update/{id}`)

**Parameters**

- `user_id` (unsignedbiginteger)
- `username` (string)
- `email` (string)
- `bio` (long text)
- `avatar` (file)

It will be updated the user profile.

---

### Logout (`/api/logout`)

Requires the auth token in the request header (`Authorization: Bearer {token}`)  
Logs the user out by deleting their token.

---
