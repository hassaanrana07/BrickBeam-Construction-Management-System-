# BrickBeam — Construction Management System

<div align="center">

![BrickBeam Platform](https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=1200)

**Construction Operations, Project Tracking & Architectural Management Platform**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vuedotjs&logoColor=white)](https://vuejs.org)
[![Inertia.js](https://img.shields.io/badge/Inertia.js-Modern%20Monolith-9553E9?style=for-the-badge&logo=inertia&logoColor=white)](https://inertiajs.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

</div>

---

## 🏗️ Overview

**BrickBeam** is a construction management web application engineered for construction firms, general contractors, civil engineers, and architectural project management offices (PMOs).

The platform bridges public client engagement with internal project tracking, combining an editorial public showcase with an administrative workspace for milestone tracking, lead dispatch, project estimation, and financial command.

---

## ⚡ Core Features

### 🌐 1. Public Experience & Client Portal
- **Industrial Architectural Interface**: Architectural theme styled in Deep Charcoal (`#0D0D0D`), Dark Concrete (`#171717`, `#242424`), Construction Amber (`#E05A1B`), and Off-White (`#F3F1EC`) with CAD grid overlays.
- **Executive Home Portal**: Highlights core pillars of construction excellence, interactive execution roadmap, and project metrics.
- **Editorial About Narrative**: Deep-dive into engineering methodologies, institutional mission/vision, and certified structural governance.
- **Service Capabilities Matrix (`/services`)**: Interactive catalog of core construction capabilities with dynamic cost estimation calculators.
- **Service Dossiers (`/services/{slug}`)**: In-depth breakdowns covering technical specifications, tool ecosystems (Revit BIM, Primavera P6, ETABS), and deliverables matrices.
- **Project Case Studies & Archive (`/projects`)**: Categorized project repository (Residential, Commercial, Industrial, Infrastructure) featuring milestone progress telemetry, budgets, and 4-photo jobsite photo galleries.
- **Case Study Deep-Dive (`/projects/{slug}`)**: 5-phase construction timeline, engineering achievements, and technical specifications.
- **Inquiry & Dispatch Hub (`/contact`)**: Multi-category project inception form wired directly to the engineering command desk, featuring verified headquarters in **Lahore**, **Islamabad**, and **Rajiv**.
- **Legal Compliance Suite**: Dedicated institutional `/privacy-policy` and `/terms-and-conditions` documentation.

---

### 🛡️ 2. Administrative Operations & Command Dashboard
- **Role-Based Access Control (RBAC)**: Powered by Spatie Laravel Permission (`Super Admin`, `Manager`, `Staff`, `Finance Manager`, `Accountant`).
- **Project Lifecycle Management**: Full CRUD operations for projects, milestones, budgets, and gallery media.
- **Service & Page Builder**: Dynamic section management and CMS content editing.
- **Lead & Inquiry Dispatch Desk**: Real-time review, status tracking (`new`, `contacted`, `closed`), and response dispatching.
- **Cost Estimator Rules Engine**: Configurable pricing rules for instant client square-footage feasibility calculations.
- **Finance & Revenue Intelligence**: Contract accounting, revenue analytics, and exportable financial audit reporting.
- **Media Library**: Centralized digital asset management with direct file upload pipelines.

---

## 🛠️ Technology Stack

| Layer | Technology |
| :--- | :--- |
| **Backend Framework** | Laravel 12.x (PHP 8.4+) |
| **Frontend Framework** | Vue 3 (Composition API / `<script setup>`) |
| **Routing / Bridge** | Inertia.js (Single Page Application UX without API boilerplate) |
| **Styling & Design** | Tailwind CSS with custom architectural color palette and shadow tokens |
| **Build Tooling** | Vite 6 |
| **Database** | MySQL / SQLite (configurable via `.env`) |
| **Access Control** | Spatie Laravel Permission |

---

## 🚀 Getting Started

### Prerequisites
- PHP `>= 8.4`
- Composer `>= 2.0`
- Node.js `>= 18.0` & npm
- SQLite or MySQL

---

### Installation & Setup

1. **Clone the Repository**
   ```bash
   git clone https://github.com/hassaanrana07/BrickBeam-Construction-Management-System-.git
   cd BrickBeam-Construction-Management-System-
   ```

2. **Install Backend Dependencies**
   ```bash
   composer install
   ```

3. **Install Frontend Dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Build Frontend Assets**
   ```bash
   npm run build
   ```

7. **Start the Development Servers**
   - In terminal 1 (Laravel backend):
     ```bash
     php artisan serve
     ```
   - In terminal 2 (Vite HMR dev server):
     ```bash
     npm run dev
     ```

8. **Access the Application**
   - Public Website: `http://localhost:8000`
   - Admin Portal: `http://localhost:8000/admin`

---

## 📂 Project Structure

```text
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/              # Administrative Controllers (Projects, Services, Leads, Finance)
│   │   ├── Auth/               # Authentication & Session Controllers
│   │   └── Public/             # Public Facing Page & Inquiry Controllers
│   └── Models/                 # Eloquent Models (Portfolio, Service, Inquiry, User, etc.)
├── database/
│   ├── migrations/             # Database Schema Migrations
│   └── seeders/                # Demonstration and Configuration Seeders
├── resources/
│   ├── css/                    # Global Stylesheets & Tailwind Custom Directives
│   └── js/
│       ├── Components/         # Reusable Vue Components & Section Renderers
│       ├── Layouts/            # PublicLayout, AdminLayout, GuestLayout
│       └── Pages/              # Inertia Vue Pages (Home, About, Services, Projects, Contact, Admin)
├── routes/
│   ├── admin.php               # Protected Administrative Routes
│   ├── auth.php                # Authentication Endpoints
│   └── web.php                 # Public Web Routes
└── tailwind.config.js          # Extended Architectural Theme Tokens
```

---

## 🔄 CI/CD, Monitoring & Production Operations

BrickBeam is configured and documented for Railway deployment with automated continuous integration, application health monitoring, and container logging:

### 1. Continuous Integration (CI Pipeline)
* **Workflow Automation**: Automated GitHub Actions workflow (`.github/workflows/ci.yml`) executes on every `push` to `main` and all `pull_request` events targeting `main`.
* **Frontend Build Job**: Sets up Node.js 20 and PHP 8.4 (for Ziggy routing), executes `npm ci` and `npm run build`, and uploads compiled Vite assets as artifacts.
* **Backend Test Job**: Executes on PHP 8.4, downloads compiled frontend assets, configures in-memory SQLite (`:memory:`), and runs the full PHPUnit test suite (28 tests, 65 assertions).
* **CI Verification Status**: The CI pipeline is fully operational and passing for the latest production commits on `main`.

### 2. Health Monitoring
* **Liveness & Health Probe (`GET /up`)**: Built on Laravel 12's native `/up` endpoint.
* **Database Connectivity Diagnosis**: Integrates with Laravel's `DiagnosingHealth` event via `AppServiceProvider` to actively verify database responsiveness (`DB::connection()->getPdo()`).
* **Probe Status Responses**: Returns HTTP `200 OK` when the application runtime and database connection are healthy; returns HTTP `500 Server Error` if database connectivity fails.

### 3. Containerized Logging
* **Standard Error Log Stream**: Configured for container deployment via `LOG_CHANNEL=stderr`.
* **Platform Ingestion**: Laravel and Monolog route error events and application exceptions directly to `php://stderr`, enabling cloud hosting platforms (such as Railway) to ingest, timestamp, and stream application logs directly in the platform dashboard without ephemeral disk dependencies.

### 4. Production Workflow & Deployment Readiness
* **Buildpack Compilation**: `nixpacks.toml` manages production PHP 8.4 extensions, Composer optimization (`composer install --no-dev --optimize-autoloader`), Node 20 asset bundling, and `storage:link`.
* **Runtime Caching**: Application start routine executes `php artisan config:cache`, `route:cache`, and `view:cache` before starting the HTTP server.
* **Migration Strategy**: Database migrations are decoupled from container startup and designed to execute during the release phase (`php artisan migrate --force` as a pre-deploy command).
* **Target Hosting**: BrickBeam is configured and documented for Railway deployment. For complete provisioning steps, environment variable checklists, rollback strategies, and backup policies, refer to [DEPLOYMENT.md](DEPLOYMENT.md).

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

