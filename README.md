# StretchTec Integrated Production & Efficiency Management System (IPEMS)

Welcome to the official repository for **IPEMS** — a modern, efficient, and scalable solution developed for StretchTec to revolutionize production and operations management.

## 🚀 What is IPEMS?

IPEMS (Integrated Production & Efficiency Management System) is a centralized platform built with **Laravel** and **Blade** that replaces scattered Excel files, notebooks, and manual tracking with a **smart, real-time digital workflow**.

From the spark of a customer inquiry to the shipment of the final product, IPEMS brings structure, speed, and visibility to the entire process.

---

## 🧠 Key Features

- 🔍 **Customer Inquiry Management**  
  Track and respond to customer inquiries in an organized, efficient manner.

- 🧪 **Sample Development Tracking**  
  Manage sample requests and approvals with clear timelines.

- 📦 **Order Management**  
  Seamlessly manage small or bulk orders with real-time status updates.

- 🏭 **Production Planning**  
  Schedule and monitor production processes with built-in intelligence.

- 📊 **Inventory & Material Tracking**  
  Maintain real-time oversight on raw materials and finished goods.

- 📈 **Reports & Dashboards**  
  Instantly generate insights and analytics to support better decisions.

- 🤝 **Collaboration-Friendly**  
  Designed for team usage, promoting better communication and task ownership.

---

## ⚙️ Built With

- **Laravel** – Robust PHP framework for backend logic & APIs  
- **Blade** – Laravel’s lightweight templating engine for the frontend  
- **MySQL** – For structured and reliable data storage  
- **Tailwind CSS** (optional) – For clean, responsive UI styling

---

<h1>Installation Steps</h1>

<ol>
  <li>Clone the repository:
    <pre><code>git clone git@github.com:DulanaNuwanjith/Stretchtec-app.git</code></pre>
  </li>
  
  <li>Direct to Stretchtec folder:
    <pre><code>cd Stretchtec</code></pre>
  </li>

  <li>Install PHP dependencies:
    <pre><code>composer install</code></pre>
  </li>

  <li>Install JavaScript dependencies:
    <pre><code>npm install</code></pre>
  </li>

  <li>Create a `.env` file and copy contents from `.env.example`:</li>

  <li>Generate the application key:
    <pre><code>php artisan key:generate</code></pre>
  </li>

  <li>Run database migrations:
    <pre><code>php artisan migrate</code></pre>
  </li>

  <li>Start the Laravel development server:
    <pre><code>php artisan serve</code></pre>
  </li>

  <li>In a new terminal, run the frontend build:
    <pre><code>npm run dev</code></pre>
  </li>

  <li>Create a symbolic link from `public/storage` to `storage/app/public`:
    <pre><code>php artisan storage:link</code></pre>
  </li>

  <li>Ensure the <code>DISPATCH NOTICES.xlsx</code> template is available:
    <pre><code>storage/app/public/templates/DISPATCH NOTICES.xlsx</code></pre>
    <p>If missing, create the <code>templates</code> folder and place the Excel file inside it manually or pull it from version control.</p>
  </li>

</ol>

---

## 🛡️ License

This project is proprietary to StretchTec. Do not distribute or use without permission.

---

## 👤 Developed By

**Rangiri Holdings IT Team**  
With ❤️ using Laravel & modern web technologies.
