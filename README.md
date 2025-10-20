
# 🧑‍💼 Candidate Management System

The **Candidate Management System (CMS)** is a web-based platform built with **PHP**, **MySQL**, and **TailwindCSS**.  
It streamlines the process of managing candidate information for recruitment or training programs by providing CRUD operations, document uploads, and a visual dashboard.

This system is designed for single-user administration, making it simple and lightweight for organizations that handle digital candidate data internally.

---

## ✨ Main Features

### 👤 Candidate Data Management
- Add, edit, delete, and view candidate profiles.
- Store essential details such as name, gender, education, and recruitment category.
- Track application progress or candidate status.

### 🗂️ Advanced Search & Filter
- Search by name, education, or category.
- Filter candidates by status or gender.
- Instant results displayed dynamically.

### 🧾 Document Uploads
- Upload candidate documents such as CVs, photos, or certificates.
- Validate file type and size to ensure data security.

### 📊 Dashboard Overview
- Visual summary of total candidates, education background, and category statistics.
- Highlighted metrics to support quick decisions.

### 📜 Activity Logs
- Automatically record every CRUD operation (create, update, delete, view).
- Show user actions with timestamps for traceability.

### 📱 Responsive Design
- Built with **TailwindCSS** for clean and modern UI.
- Fully optimized for both desktop and mobile devices.

---

## 🧱 Technology Stack

| Layer | Technology |
|--------|-------------|
| **Frontend** | HTML5, TailwindCSS, JavaScript |
| **Backend** | PHP Native |
| **Database** | MySQL |
| **Server** | Apache (XAMPP / Laragon) |
| **Security** | PHP Session, Input Validation, File Sanitization |

---

## 📂 Folder Structure

```
candidate-management/
├── config/
│   └── koneksi.php
│
├── includes/
│   ├── auth_check.php
│   ├── header.php
│   ├── sidebar.php
│   ├── topbar.php
│   └── footer.php
│
├── modules/
│   ├── dashboard/
│   ├── candidates/
│   ├── uploads/
│   └── logs/
│
├── assets/
│   ├── img/
│   └── css/
│
├── login.php
├── logout.php
├── index.php
└── .htaccess
```

---

## 🧮 Database Structure

### Database: `db_candidate_management`

#### `candidates`
| Field | Type | Description |
|--------|------|-------------|
| id | INT(11) | Primary key |
| name | VARCHAR(100) | Candidate name |
| gender | VARCHAR(10) | Gender |
| education | VARCHAR(100) | Education background |
| category | VARCHAR(100) | Program or recruitment category |
| status | VARCHAR(50) | Application status |
| contact | VARCHAR(50) | Phone or email |
| created_at | DATETIME | Registration timestamp |

#### `documents`
| Field | Type | Description |
|--------|------|-------------|
| id | INT(11) | Primary key |
| candidate_id | INT(11) | Linked candidate |
| file_name | VARCHAR(255) | File name |
| file_path | VARCHAR(255) | File path |
| uploaded_at | DATETIME | Upload timestamp |

#### `logs`
| Field | Type | Description |
|--------|------|-------------|
| id | INT(11) | Primary key |
| action | VARCHAR(100) | Type of activity |
| description | TEXT | Details of action |
| timestamp | DATETIME | Time recorded |

---

## 👨‍💻 Developer Information

| Item | Detail |
|-------|---------|
| **Developer** | Fattah Chaerul Majid |
| **Technology Stack** | PHP Native, MySQL, TailwindCSS |
| **Year** | 2025 |
| **Status** | Company Project |

---

> Built with ❤️ by **Fattah Chaerul Majid**  
> Showcasing full-stack web development and digital recruitment management solutions.
