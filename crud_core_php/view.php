<?php
    session_start();
    require_once 'db_connection.php';
    if(!isset($_SESSION['user_data'])){
        header('Location:login.php');
    }
    $sql = "SELECT * FROM users";
    $exec = $conn->query($sql);
    // $users = mysqli_fetch_all($exec, MYSQLI_ASSOC);
    while ($data = $exec->fetch_object()) {
        $users[] = $data;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Card shadow */
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        /* Transition effects */
        .transition-all {
            transition: all 0.3s ease;
        }
        
        /* Button hover effects */
        .btn-hover:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        
        /* Responsive table */
        @media (max-width: 768px) {
            .responsive-table thead {
                display: none;
            }
            .responsive-table tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            }
            .responsive-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem;
                text-align: right !important;
                border-bottom: 1px solid #e2e8f0;
            }
            .responsive-table td::before {
                content: attr(data-label);
                font-weight: bold;
                text-align: left;
                margin-right: auto;
                color: #4a5568;
            }
            .responsive-table td:last-child {
                border-bottom: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header with logout button -->
    <header class="bg-indigo-600 text-white py-4 px-6 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">
                <!-- <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/c9462ab0-a728-41b3-9a31-381e45dac6d4.png" alt="Contact Management System logo with modern minimalist design in white text" /> -->
            </h1>
            <a id="logoutBtn" name="logout-btn" class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-medium hover:bg-indigo-50 transition-all btn-hover" href="logout.php">
                <i class="fas fa-sign-out-alt mr-2"></i>Logout
            </a>
        </div>
    </header>
 
    <main class="container mx-auto py-8 px-4 md:px-6">
        <!-- Page title and actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 md:mb-0">Users List</h2>
            <a class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-all btn-hover" href="registration.php">
                <i class="fas fa-plus mr-2"></i>Add User
            </a>
        </div>

        <!-- Contacts table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full responsive-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sno</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">State</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hobbies</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                            $sno = 1;
                            if(isset($users)){
                            foreach ($users as $user) {
                        ?>
                        <tr class="hover:bg-gray-50 transition-all">
                            <td data-label="id" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $sno ?></td>
                            <td data-label="Name" class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="<?= 'uploads/'.$user->profile_picture ?>" alt="Portrait of John Doe, a professional business man with short hair and smiling face" /> 
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?= $user->first_name .' '. $user->last_name ?></div>
                                        <!-- <div class="text-sm text-gray-500">Director</div> -->
                                    </div>
                                </div>
                            </td>
                            <td data-label="Phone" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?=$user->mobile_number ?></td>
                            <td data-label="Email" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?=$user->email ?></td>
                            <td data-label="Email" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?=$user->gender ?></td>
                            <td data-label="Email" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?=$user->address ?></td>
                            <td data-label="Email" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?=$user->state ?></td>
                            <td data-label="Email" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?=$user->hobbies ?></td>
                            <td data-label="Actions" class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a class="text-indigo-600 hover:text-indigo-900 edit-btn" href="registration.php?id=<?= $user->id ?>">
                                        <!-- onclick="editContact(1)" -->
                                        <i class="fas fa-edit"></i>
                                    </a>
                                     <!-- <a class="text-red-600 hover:text-red-900 delete-btn" href="delete.php?id=<?= $user->id ?>"> -->
                                        <!-- onclick="deleteContact(1)" -->
                                        <!-- <i class="fas fa-trash-alt"></i> -->
                                    <!-- </a> -->
                                     <button class="text-red-600 hover:text-red-900 delete-btn" onclick="deleteContact(<?= $user->id ?>)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php $sno++; }
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination (optional) -->
        <!-- <div class="mt-8 flex justify-between items-center">
            <div class="text-sm text-gray-500">
                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">20</span> entries
            </div>
            <div class="flex space-x-2">
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-all">Previous</button>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-all">Next</button>
            </div>
        </div> -->
    </main>

    <!-- Confirmation Modal (hidden by default) -->
    <div id="deleteModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Delete User</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to delete this user? This action cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmDelete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button type="button" id="cancelDelete" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to handle logout
        document.getElementById('logoutBtn').addEventListener('click', function() {
            // Add your logout logic here
            alert('Are you sure you want to logout.');
        });

        // Initialize variables
        let currentDeleteId = null;

        // Function to handle edit contact
        function editContact(id) {
            // Add your edit logic here
            alert(`Editing contact with ID: ${id}`);
        }

        // Function to handle delete contact
        function deleteContact(id) {
            currentDeleteId = id;
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
        }

        // Confirm delete
        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (currentDeleteId) {
                alert(`Deleting contact with ID: ${currentDeleteId}`);
                // Add your delete logic here (API call, etc.)
                fetch('delete.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: currentDeleteId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('User  deleted successfully.');
                        // Optionally, refresh the page or remove the user from the UI
                        location.reload(); // Refresh the page
                    } else {
                        alert('Error deleting user: ' + data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the user.');
                });
                document.getElementById('deleteModal').classList.add('hidden');
                currentDeleteId = null;
            }
        });

        // Cancel delete
        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.add('hidden');
            currentDeleteId = null;
        });

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                modal.classList.add('hidden');
                currentDeleteId = null;
            }
        });
    </script>
</body>
</html>

