# Symfony + React Admin PoC (Docker)

This is a Proof of Concept project for modernizing a legacy Symfony 1.4 interface using:

- 🐘 Symfony 5 (REST API)
- ⚛️ React Admin (frontend)
- 🐳 Docker Compose (development environment)
- 🐬 MariaDB (database)

## 🗂 Project Structure

```
.
├── backend       # Symfony 5 API
├── frontend      # React Admin interface
├── docker        # Docker configuration files
├── docker-compose.yml
└── README.md
```

---

## 🚀 Getting Started

### Start all services

```bash
docker-compose up --build
```

The first time will take a few minutes (Composer install, React dependencies, etc.).

---

## 🧪 Accessing the services

### 🔙 Symfony Backend (`welante-admin-back`)

- URL: [http://localhost:8181](http://localhost:8181)
- Folder: `./backend`
- Symfony console (inside container):

```bash
docker-compose exec welante-admin-back php bin/console
```

### 💾 MariaDB (`welante-admin-db`)

- Host: `localhost`
- Port: `8282`
- User: `symfony`
- Password: `symfony`
- Database: `app`

You can connect using TablePlus, DBeaver, or Symfony's `doctrine:query:sql`:

```bash
docker-compose exec welante-admin-back php bin/console doctrine:query:sql "SHOW TABLES"
```

---

### 🧑‍💻 React Admin Frontend (`welante-admin-front`)

- URL: [http://localhost:3000](http://localhost:3000)
- Folder: `./frontend`
- React runs with hot reload via `npm start`

To install new packages:

```bash
docker-compose exec welante-admin-front npm install <package>
```

---

## 🛠 Common Commands

### Rebuild after Dockerfile or config changes:

```bash
docker-compose build
```

### Remove all services:

```bash
docker-compose down
```

### Run Symfony commands:

```bash
docker-compose exec welante-admin-back php bin/console <command>
```

### Install Composer packages:

```bash
docker-compose exec welante-admin-back composer require <package>
```

---