<div align="center">
  <div style="background: linear-gradient(to right, #4a7a8a, #7da8b6); padding: 2px; border-radius: 20px; display: inline-block; margin-bottom: 20px;">
    <div style="background: #edf3f6; padding: 20px 40px; border-radius: 18px; text-align: center;">
      <h1 style="margin: 0; color: transparent; background: linear-gradient(to right, #1a365d, #4a7a8a); -webkit-background-clip: text; background-clip: text; font-size: 32px; font-weight: 800;">HealthyWay</h1>
      <p style="margin: 5px 0 0 0; color: #1e3a5f; font-size: 14px; text-transform: uppercase; letter-spacing: 2px;">Premium Self-Tracking App</p>
    </div>
  </div>

  <p>
    <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
    <img src="https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
    <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine">
    <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  </p>
</div>

<br>

## 🌟 Project Context & Overview

**HealthyWay** is a premium, beautifully designed health and travel logging application built to help users seamlessly track their daily physical mobility and body temperature. 

Born out of the necessity to monitor health metrics during travel, the platform resolves the pain point of scattered health data by providing a centralized, secure, and visually stunning (Luxury Light Medical) dashboard. It allows individuals to log data effortlessly and enables administrators to monitor global health trends for early anomaly detection.

---

## 📖 Core Feature Manual: Masyarakat (User)

As a registered user, you have access to a private, secure vault for your health logs.

### 1. Dashboard Overview & Analytics
- **Greeting Card:** Displays your current health status based on your latest log.
- **Weekly Trend Chart:** A visual bar chart mapping your average temperature over the last 7 days.
- **Quick Metrics:** Instantly view your total logs and overall average temperature.

### 2. Logging a Travel Record (Catat Perjalanan)
- Navigate to **"Catat Perjalanan"** via the top navigation bar.
- The form auto-fills the current Date and Time for convenience.
- Input your **Destination/Location**, **Body Temperature (°C)**, and any **Additional Notes** (e.g., "Feeling dizzy", "Routine check").
- Click **"Simpan Catatan Baru"**. The system instantly evaluates your temperature.

### 3. Understanding Dynamic Temperature Indicators
The application uses visual cues to alert you of potential health risks:
- 🟢 **Normal (< 37.5°C):** Displayed in Emerald Green. No immediate action required.
- 🔴 **Demam / Alert (≥ 37.5°C):** Displayed in Rose Red with a pulsing animation. Indicates a fever.

### 4. Managing & Exporting Logs (Riwayat Log)
- Go to **"Riwayat Log"** to view a complete, paginated table of your history.
- Use the **Filter Panel** to search by location, specific dates, or filter out only anomalous (high temp) logs.
- Need to share data with a doctor? Click **"Cetak Riwayat PDF / Print"** to generate a clean, printer-friendly medical report.

---

## 🛡️ Core Feature Manual: Admin (Administrator)

Administrators act as the global overseers, ensuring data integrity and monitoring macro health trends.

### 1. Global Monitoring Panel
- **Analytics Grid:** View real-time statistics of total registered users, total global travel logs, and the critical **High Temperature Alert Count**.
- **Global Logs Table:** A comprehensive view of all travel logs submitted by all users.

### 2. Auditing & Filtering
- Use the advanced search filters to query specific users by name/email, track specific dates, or isolate all logs with temperatures ≥ 37.5°C across the entire platform.

### 3. Data Governance
- If an anomalous or spam log is detected, admins have the authority to permanently delete the specific log directly from the monitoring table via a secure confirmation modal.

### 4. Global User Lifecycle Management
- Navigate to **"Kelola Pengguna"** to view all registered accounts.
- Admins can revoke access by deleting user accounts that violate terms of service or are no longer active.

---

## 🔒 Security Architecture Notes

HealthyWay implements a robust, enterprise-grade 2-layer defense mechanism to guarantee data privacy and system integrity.

### Layer 1: Route & Role Middleware (`RoleMiddleware`)
All routes are protected by Laravel's core authentication and custom Role-Based Access Control (RBAC). 
- If a `masyarakat` user attempts to access `/admin/dashboard`, the middleware intercepts the request and throws a `403 Forbidden` response.
- Custom Glassmorphic Error Pages (`403`, `404`, `500`) ensure that even during unauthorized access attempts, the application doesn't leak stack traces and maintains its premium aesthetic.

### Layer 2: Controller-Level Ownership Authorization (IDOR Prevention)
To prevent Insecure Direct Object Reference (IDOR) attacks (e.g., a user manually changing the URL to `/perjalanan/edit/99` to view someone else's log), the `MasyarakatController` implements an explicit ownership guard:
```php
private function authorizeOwnership(Perjalanan $perjalanan): void
{
    if ($perjalanan->user_id !== Auth::id()) {
        abort(403, 'Anda tidak memiliki hak akses untuk mengelola data ini.');
    }
}
```
Furthermore, all data queries on the history and print pages are strictly scoped to `$user->perjalanans()`, making cross-account data leakage impossible.

---

## 🚀 Quick Installation & Deployment Guide

Follow these steps to get HealthyWay running on your local machine.

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & npm
- MySQL / MariaDB

### Installation Steps

1. **Clone & Install PHP Dependencies**
   ```bash
   git clone <repository-url>
   cd healthyway
   composer install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Make sure to configure your `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in the `.env` file.*

3. **Database Migration & Seeding**
   This command creates the tables and populates the database with the default Admin and test Masyarakat users.
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Install & Compile Frontend Assets**
   ```bash
   npm install
   npm run build
   ```
   *(For active development, you can use `npm run dev` instead of build).*

5. **Serve the Application**
   ```bash
   php artisan serve
   ```
   *Visit `http://localhost:8000` in your browser.*

### Default Test Credentials (from Seeder)
- **Admin:** `admin@healthyway.com` / `password`
- **User 1:** `budi@healthyway.com` / `password`
- **User 2:** `siti@healthyway.com` / `password`

---
<p align="center" style="color: #64748b; font-size: 12px;">
  &copy; 2026 HealthyWay. Designed with precision and care.
</p>
