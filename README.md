# BrickBeam — Construction Management System

<div align="center">

![BrickBeam Platform](https://images.unsplash.com/photo-1541888946425-d81bb19480c5?q=80&w=1200)

**Enterprise Construction Operations, Project Telemetry & Architectural Management Platform**

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vuedotjs&logoColor=white)](https://vuejs.org)
[![Inertia.js](https://img.shields.io/badge/Inertia.js-Modern%20Monolith-9553E9?style=for-the-badge&logo=inertia&logoColor=white)](https://inertiajs.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

</div>

---

## 🏗️ Overview

**BrickBeam** is an enterprise-grade web application engineered for modern construction firms, general contractors, civil engineers, and architectural project management offices (PMOs).

The platform bridges public client engagement with internal project telemetry, combining an editorial public showcase with an administrative workspace for milestone tracking, lead dispatch, project estimation, and financial command.

---

## ⚡ Core Features

### 🌐 1. Public Experience & Client Portal
- **Cinematic Motion-First Interface**: Architectural theme styled in Deep Black (`#050811`), Deep Purple (`#581c87`), and Safety Orange (`#f97316`) with subtle blueprint grids and glassmorphism.
- **Executive Home Portal**: Highlights 5 core pillars of construction excellence, interactive 4-phase execution roadmap, and real-time project metrics.
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

## 🔄 CI/CD & Deployment

This project includes automated Continuous Integration (CI) and a planned Continuous Deployment (CD) architecture:
- **Automated Validation on Pull Requests**: Every pull request targeting `main` automatically runs parallel backend tests (PHP 8.4, in-memory SQLite) and frontend compilation (Node 20, Vite 6) via GitHub Actions.
- **Automated Validation on Pushes**: Every push or merge to the `main` branch undergoes full automated test suite and build verification.
- **Target Deployment Architecture**: Continuous Deployment is planned via Railway's native GitHub repository integration, utilizing `nixpacks.toml` container builds, release-phase database migrations, and health check monitoring via the `/up` endpoint.
- **Detailed Operations Guide**: Refer to [DEPLOYMENT.md](DEPLOYMENT.md) for full hosting architecture specifications, verified local test results, environment variable checklists, and step-by-step Railway configuration instructions.

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

