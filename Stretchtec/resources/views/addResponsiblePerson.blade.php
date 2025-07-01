<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Users Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen overflow-hidden">

  <div class="flex h-full bg-white ">

    <!-- Sidebar -->
    @include('layouts.side-bar') <!-- Make sure sidebar has fixed width like w-64 -->

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto p-5">
      <div class="w-full p-8 ">

        <!-- Page Title -->
        <h2 class="text-3xl font-bold mb-6 ">Add User</h2>

        <!-- Add User Form -->
        <form action="/add-user" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
          @csrf
          <div>
            <label class="block text-sm font-semibold mb-1">User Role</label>
            <select name="role" class="w-full border border-gray-300 p-2 rounded">
              <option value="Operator">Operator</option>
              <option value="Supervisor">Supervisor</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-semibold mb-1">EMP ID</label>
            <input type="text" name="emp_id" placeholder="e.g., EMP001" class="w-full border border-gray-300 p-2 rounded" />
          </div>

          <div>
            <label class="block text-sm font-semibold mb-1">Name</label>
            <input type="text" name="name" class="w-full border border-gray-300 p-2 rounded" />
          </div>

          <div>
            <label class="block text-sm font-semibold mb-1">Telephone No</label>
            <input type="tel" name="telephone" class="w-full border border-gray-300 p-2 rounded" />
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-semibold mb-1">Address</label>
            <textarea name="address" rows="2" class="w-full border border-gray-300 p-2 rounded"></textarea>
          </div>

          <div class="md:col-span-2 text-right">
            <button type="submit"
              class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
              Add User
            </button>
          </div>
        </form>

        <!-- User List with global filter -->
        <!-- User List -->
      <section>
        <h2 class="text-2xl font-bold mb-4 text-gray-900">User List</h2>

        <!-- Search bar -->
        <div class="mb-6 w-full">
          <input
            type="text"
            id="globalSearch"
            onkeyup="filterAllFields()"
            placeholder="Search users..."
            class="w-full rounded-md border border-gray-300 px-4 py-2 text-gray-900 shadow-sm
                   focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 transition"
          />
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
          <table id="userTable" class="min-w-full table-auto divide-y divide-gray-200 text-gray-700">
            <thead class="bg-gray-100 sticky top-0 z-10">
              <tr>
                <th class="px-5 py-3 text-left text-sm font-semibold uppercase">EMP ID</th>
                <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Role</th>
                <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Name</th>
                <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Address</th>
                <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Telephone</th>
                <th class="px-5 py-3 text-center text-sm font-semibold uppercase">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <!-- Example rows -->
              <tr class="hover:bg-blue-50">
                <td class="px-5 py-3 whitespace-nowrap">EMP001</td>
                <td class="px-5 py-3 whitespace-nowrap">Operator</td>
                <td class="px-5 py-3 whitespace-nowrap">Kasun Perera</td>
                <td class="px-5 py-3 whitespace-normal max-w-xs break-words">123 Galle Road, Colombo</td>
                <td class="px-5 py-3 whitespace-nowrap">0771234567</td>
                <td class="px-5 py-3 text-center whitespace-nowrap space-x-2">
                  <button class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</button>
                  <button class="text-red-600 hover:text-red-800 font-medium text-sm">Delete</button>
                </td>
              </tr>
              <tr class="hover:bg-blue-50">
                <td class="px-5 py-3 whitespace-nowrap">EMP002</td>
                <td class="px-5 py-3 whitespace-nowrap">Supervisor</td>
                <td class="px-5 py-3 whitespace-nowrap">Nimal Silva</td>
                <td class="px-5 py-3 whitespace-normal max-w-xs break-words">456 Kandy Road, Gampaha</td>
                <td class="px-5 py-3 whitespace-nowrap">0712345678</td>
                <td class="px-5 py-3 text-center whitespace-nowrap space-x-2">
                  <button class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</button>
                  <button class="text-red-600 hover:text-red-800 font-medium text-sm">Delete</button>
                </td>
              </tr>
              <!-- Add more rows dynamically -->
            </tbody>
          </table>
        </div>
      </section>

    </section>
      </div>
    </div>

  </div>

  <script>
    function filterAllFields() {
      const input = document.getElementById("globalSearch");
      const filter = input.value.toLowerCase();
      const table = document.getElementById("userTable");
      const rows = table.querySelectorAll("tbody tr");

      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
      });
    }
  </script>

</body>
</html>
