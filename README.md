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

**HealthyWay** is an enterprise-grade, beautifully crafted health and travel logging application engineered to help users seamlessly track physical mobility and body temperature anomalies. 

Built with a state-of-the-art **Premium Luxury Light Medical** UI/UX token grid, the platform eliminates scattered medical records by providing a centralized, secure, fluid, and highly interactive application shell. It enables citizens to track logs intuitively and empowers health administrators with deep analytical governance mechanisms to spot epidemiological anomalies early.

---

## 🎨 Advanced UI/UX & Interaction Design Tokens

The application features a tailored micro-interaction network built for premium sensory responses:
- **Triple-Stage Entrance Animation System:** Integrates a luxurious glassmorphic full-screen pre-loader curtain, fluid container kinetic zoom fades, and staggered text inflows managed via hardware-accelerated Alpine.js triggers.
- **Neon Glass Capsule Chart:** Completely redesigned weekly temperature chart using a strict 7-column vertical grid system. Bars feature smooth anchor locking to baseline boundaries, dynamic gradient glows depending on fever intensity, and high-fidelity hovering tooltips.
- **Differentiated Footers System:** Houses three location-specific footer experiences (SaaS multi-column marketing format on landing page, compact user hub index on dashboards, and an operational server clock grid on admin panels).
- **Global Dual Language Switcher (ID/EN):** Full cross-role localized session binding utilizing custom middleware filters, making 100% of the screen text instantly adaptable.

---

## 📖 Core Feature Manual: Masyarakat (User Hub)

As a registered citizen, you have access to a secure digital health vault.

### 1. Dashboard Overview & Contextual Hub
- **Greeting Card:** Displays real-time calendar parameters and current status badges. The name avatar is transformed into an interactive luxury button acting as the entry point for profile updates.
- **Status Imun Widget:** Dynamically calculates historical averages to score user travel readiness.
- **Recent Medical Notes:** Isolates latest text variables submitted from physician logs.
- **Interactive Chart & Empty States:** Automatically overlays supportive graphics when a new account is registered with zero logs, preventing layout breakages.

### 2. Logging a Travel Record (Catat Perjalanan)
- Form auto-fittings capture system timestamps.
- Inputs evaluate **Destination/Location**, **Body Temperature (°C)**, and **Doctor/Personal Notes**.
- Temperature indicators automatically pulse crimson alerts (`🔴 High >= 37.5°C`) or settle into calming teal gradients (`🟢 Normal < 37.5°C`).

### 3. Account & Profile Customization
- Access the secure double-card Profile View to safely mutate names, emails, and update hashed cryptographic password arrays.
- Includes public file disk image validation layers supporting real-time custom avatar uploads.

---

## 🛡️ Core Feature Manual: Admin Operations

Administrators act as infrastructure overseers ensuring operational integrity.

### 1. Global Monitoring Panel
- **Critical Alert Banner:** Top-level, sticky translucent red warning engine that automatically triggers visibility indicators if any user inputs highly anomalous fever indices anywhere on the system.
- **Global Logs Audit Table:** Comprehensive database tracker mapping inputs across all citizen accounts with active responsive horizontal swipeable limits on mobile screens.

### 2. Premium PDF Logging Engine
- Upgrades the **"Cetak Laporan"** utility into a clean invoice-grade structured data sheet. Generates professional metrics tables complete with metadata signature components for medical clearance documentation.

---

## 🔒 Security & Session Session Architecture

### Layer 1: Route & Role Middleware (`RoleMiddleware`)
All app gates operate behind Laravel's core token authentication and Role-Based Access Control (RBAC). 
- **Stale Session Protection:** Login modules explicitly forget previous cross-role URLs, forcing secure, automated role routing destinations on account login shifts.
- **Logout Cleansing:** The logout hook thoroughly invalidates active sessions, flushes security elements, regenerates CSRF forms, and safely shifts view boundaries straight back to the landing page (`/`).

### Layer 2: IDOR Ownership Prevention
To safeguard critical data privacy, the `MasyarakatController` binds structural model injection layers to strict user identity validation matrices:
```php
private function authorizeOwnership(Perjalanan $perjalanan): void
{
    if ($perjalanan->user_id !== Auth::id()) {
        abort(403, 'Anda tidak memiliki hak akses untuk mengelola data ini.');
    }
}
```

---

## 🚀 Quick Installation & Deployment Guide

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
   Configure your `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` parameters inside the `.env` file.

3. **Database Migration & Seeding**
   Generates production-grade mock data tables loaded with both empty state trackers and historic anomaly records.
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Install & Compile Frontend Assets**
   ```bash
   npm install
   npm run build
   ```

5. **Serve the Application**
   ```bash
   php artisan serve
   ```
   Visit `http://localhost:8000` inside your browser windows.

---

### Default Test Credentials (from Seeder Layouts)

* **Primary Admin Tester (Aranxa Admin):** `aranxa.admin@healthyway.com` / `password`
* **Fresh User Tester (Aranxa - Evaluates Empty Charts):** `aranxa@healthyway.com` / `password`
* **Historic User 1 (Budi Santoso):** `budi@healthyway.com` / `password`
* **Historic User 2 (Siti Aminah):** `siti@healthyway.com` / `password`

*Note: Aranxa begins as a fresh user with 0 logs to test our new premium chart empty state view.*
