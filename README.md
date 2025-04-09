
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
9. `GET /api/wallpaper` - All wallpaper.
10. `POST /api/wallpaper/store` - Upload wallpaper
11. `POST /api/wallpaper/update/{id}` - Update wallpaper
12. `POST /api/logout` — Logout (Requires Auth Token)

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

It will be updated the user profile. **The avatar must be under 8MB.**

---
### Wallpaper (`/api/wallpaper`)
In this link all the wallpapers will be showed. With its name, price and image.

---
### Store Wallpaper (`/api/wallpaper/store`)
**Parameters**
- `name`(string)
- `price`(decimal) Total 10 numbers with 2 place after the dot(.). Like `1500.00`.
- `image`(file) Image must be under **15MB**.

It will store the wallpaper in the database.

---
### Update Wallpaper (`/api/wallpaper/update/{id}`)
**Parameters**
- `name`(string)
- `price`(decimal) Total 10 numbers with 2 place after the dot(.). Like `1500.00`.
- `image`(file) Image must be under **15MB**.

It will update the wallpaper information in ID-wise. For id 1 it will just the data for id 1.

---
### Logout (`/api/logout`)

Requires the auth token in the request header (`Authorization: Bearer {token}`)  
Logs the user out by deleting their token.

---
