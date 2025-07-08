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

  <li>Create .env file and copy paste the code in .env.example file.</li>
  
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
    <pre><code>cd Stretchtec
npm run dev</code></pre>
  </li>

  <li>Laravel to create a symbolic link from the public/storage directory to the storage/app/public directory.:
    <pre><code>php artisan storage:link</code></pre>
  </li>
</ol>
