<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report an Issue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="s">
</head>
<body class="bg-gray-100  ">

    <div class="container mx-auto p-6 max-w-4xl">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold">Report an Issue</h1>
            <p class="text-sm text-gray-500">Home &gt; Reports</p>
        </div>

        <!-- Search & Filter -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <input type="text" id="searchInput" placeholder="Search matatus or drivers..." class="w-full pl-4 pr-10 py-2 border rounded-md shadow-sm">
            </div>
            <select id="filterSelect" class="w-full md:w-[200px] border rounded-md px-4 py-2">
                <option value="rating">Sort by Rating</option>
                <option value="reports">Most Reported</option>
                <option value="newest">Newest</option>
            </select>
        </div>

        <!-- Tabs -->
        <div class="flex justify-center space-x-4 mb-6">
            <button onclick="showTab('matatus')" class="tab-button active-tab">Matatus</button>
            <button onclick="showTab('drivers')" class="tab-button">Drivers</button>
        </div>

        <!-- Matatu List -->
        <div id="matatus" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-md shadow-md">
                    <h2 class="text-lg font-bold">KCA 123B <span class="text-sm text-gray-500">XYZ SACCO</span></h2>
                    <p>Route: 105</p>
                    <div class="flex justify-between items-center">
                        <span class="text-yellow-500">⭐ 4.5/5 (20)</span>
                        <span class="text-red-500">🚨 12 reports</span>
                    </div>
                    <button class="bg-red-500 text-white px-4 py-2 rounded mt-2">Report Issue</button>
                </div>

                <div class="bg-white p-4 rounded-md shadow-md">
                    <h2 class="text-lg font-bold">KCB 456C <span class="text-sm text-gray-500">ABC SACCO</span></h2>
                    <p>Route: 205</p>
                    <div class="flex justify-between items-center">
                        <span class="text-yellow-500">⭐ 4.2/5 (15)</span>
                        <span class="text-red-500">🚨 8 reports</span>
                    </div>
                    <button class="bg-red-500 text-white px-4 py-2 rounded mt-2">Report Issue</button>
                </div>
            </div>
        </div>

        <!-- Drivers List -->
        <div id="drivers" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-md shadow-md">
                    <h2 class="text-lg font-bold">John Doe</h2>
                    <p>Matatu: KCA 123A (Route 34)</p>
                    <p class="text-sm text-gray-500">+254 712 345 678</p>
                    <div class="flex justify-between items-center">
                        <span class="text-yellow-500">⭐ 3.8/5 (15)</span>
                        <span class="text-red-500">🚨 5 reports</span>
                    </div>
                    <button class="bg-red-500 text-white px-4 py-2 rounded mt-2">Report Issue</button>
                </div>

                <div class="bg-white p-4 rounded-md shadow-md">
                    <h2 class="text-lg font-bold">Jane Smith</h2>
                    <p>Matatu: KCB 456B (Route 42)</p>
                    <p class="text-sm text-gray-500">+254 723 456 789</p>
                    <div class="flex justify-between items-center">
                        <span class="text-yellow-500">⭐ 4.1/5 (12)</span>
                        <span class="text-red-500">🚨 3 reports</span>
                    </div>
                    <button class="bg-red-500 text-white px-4 py-2 rounded mt-2">Report Issue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function showTab(tab) {
            document.getElementById("matatus").classList.add("hidden");
            document.getElementById("drivers").classList.add("hidden");
            document.getElementById(tab).classList.remove("hidden");

            document.querySelectorAll(".tab-button").forEach(button => button.classList.remove("active-tab"));
            document.querySelector(`button[onclick="showTab('${tab}')"]`).classList.add("active-tab");
        }
    </script>

    <!-- Tailwind CSS Styling -->
    <style>
        .tab-button {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: bold;
            transition: 0.3s;
        }
        .active-tab {
            background-color: #facc15;
        }
        .tab-content {
            display: block;
        }
        .hidden {
            display: none;
        }
    </style>

</body>
</html>
