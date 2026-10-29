# UIISP - University of Ibadan Internet Service Provider Portal

Campus Wi-Fi self-service portal, customer authentication, 30-day subscription billing gateway, and account management console built with PHP and MySQL.

---

## Getting Started with XAMPP

### 1. Project Directory & Apache Junction

The project files reside at `C:\Users\PC\projects\ift302`.
In XAMPP, an NTFS Directory Junction connects `C:\xampp\htdocs\ift302` directly to this folder:

```powershell
New-Item -ItemType Junction -Path "C:\xampp\htdocs\ift302" -Target "C:\Users\PC\projects\ift302"
```

---

### 2. Database Setup & Seeding

1. Start **Apache** and **MySQL** in the XAMPP Control Panel.
2. The database schema and realistic mock test accounts are in:
   - [`database/schema.sql`](file:///c:/Users/PC/projects/ift302/database/schema.sql) (Import directly into phpMyAdmin or MySQL CLI)
   - Or run the seeder script via command line:
     ```bash
     php database/seed.php
     ```

#### Database Configuration:
- **Database Name**: `ift302`
- **Tables**: `user`, `subscription_history`
- **Supported Credentials**:
  - `ift302` / `ift302`
  - Automatic fallback to standard XAMPP default: `root` (empty password)

---

### 3. Pre-Loaded Mock Test Accounts

All pre-loaded accounts use the password: **`Password123`**

| Account Role | Matric / Staff ID | Email | Subscription State |
| :--- | :--- | :--- | :--- |
| **Active Student** | `219084` | `b.adeleke@ui.edu.ng` | **Standard Plan** (22 days remaining, ₦10,000) |
| **Faculty / Staff** | `UI/STF/4821` | `f.alabi@ui.edu.ng` | **Premium Plan** (14 days remaining, ₦20,000) |
| **Expired Student** | `224105` | `c.okonkwo@ui.edu.ng` | **Expired Plan** (Prompted to renew) |
| **New Student** | `238912` | `i.danjuma@ui.edu.ng` | **No Subscription** (Zero transactions, first-time checkout) |

---

### 4. Key Endpoints & Features

- **Home Page**: [http://localhost/ift302/](http://localhost/ift302/)
  - Dynamic navbar reflecting logged-in vs guest state
  - 3-tier package cards (Basic ₦5,000, Standard ₦10,000, Premium ₦20,000) with direct one-click plan checkout
- **Login / Register**: [http://localhost/ift302/customer-registration-login.php](http://localhost/ift302/customer-registration-login.php)
  - Single sign-on supporting both **Matric/Staff ID** or **Email**
  - Show/hide password toggles, validation, and auto-redirect handling
- **Subscriber Dashboard**: [http://localhost/ift302/subscriber-dashboard.php](http://localhost/ift302/subscriber-dashboard.php)
  - Live RADIUS connection validation badge (`UI-RADIUS ONLINE` vs `UI-RADIUS SUSPENDED`)
  - Real-time days remaining & expiry calculation
  - 30-Day Fair Usage Quota progress telemetry bar
  - WPA3-Enterprise credentials with one-click copy feedback and fallback
  - Transaction history audit trail with official pop-up printable receipts
  - **Account & Security Console**: View student registry info, update contact phone/email, and change portal password
- **Subscription Checkout**: [http://localhost/ift302/subscription-payment.php](http://localhost/ift302/subscription-payment.php)
  - Interactive tier switcher, duration options, Paystack & Remita (RRR) channels
- **Sign Out**: [http://localhost/ift302/logout.php](http://localhost/ift302/logout.php)
  - Wipes session data cleanly and displays confirmed sign-out flash alert
