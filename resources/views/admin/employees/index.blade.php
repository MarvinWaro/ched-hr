<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employee') }}
        </h2>
    </x-slot>


    <style>
        /* Custom styles for the table header */
        #search-table thead th {
            padding: 20px 24px; /* Adjust these values for top/bottom and left/right padding */
        }

        .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        padding: 5px;
        border: 1px solid gray;
        border-radius: 5px;
        z-index: 1;
        }

        td {
            max-width: 300px; /* Adjust based on your table design */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

    </style>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-5">

                <div class="mx-5 my-5">
                    <a href="{{ route('employees.create') }}" type="button" class="my-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 me-3">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                        </svg>
                        Add new account
                    </a>

                    <div class="table-wrapper">
                        <table id="search-table">
                            <thead>
                                <tr>
                                    <th class="bg-gray-500 text-gray-100 dark:bg-gray-900 dark:text-gray-100 px-10 py-4">Employee ID#</th>
                                    <th class="bg-gray-500 text-gray-100 dark:bg-gray-900 dark:text-gray-100 px-10 py-4">Photo</th>
                                    <th class="bg-gray-500 text-gray-100 dark:bg-gray-900 dark:text-gray-100 px-10 py-4">Name</th>
                                    <th class="bg-gray-500 text-gray-100 dark:bg-gray-900 dark:text-gray-100 px-10 py-4">Gender</th>
                                    <th class="bg-gray-500 text-gray-100 dark:bg-gray-900 dark:text-gray-100 px-10 py-4">Department</th>
                                    <th class="bg-gray-500 text-gray-100 dark:bg-gray-900 dark:text-gray-100 px-10 py-4">Payroll Position</th>
                                    <th class="bg-gray-500 text-gray-100 dark:bg-gray-900 dark:text-gray-100 px-10 py-4">Date Employed</th>
                                    <th class="bg-gray-500 text-gray-100 dark:bg-gray-900 dark:text-gray-100 px-10 py-4">Employment Status</th>
                                    <th class="bg-gray-500 text-gray-100 dark:bg-gray-900 dark:text-gray-100 px-10 py-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr class="hover:bg-gray-200 dark:hover:bg-gray-700">
                                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $employee->id }}-{{ str_pad($employee->employee_no, 3, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td>
                                            @if ($employee->photo)
                                                <!-- Display the uploaded profile photo -->
                                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="Profile Photo" class="w-16 aspect-square object-cover rounded-full">
                                            @else
                                                <!-- Display default profile photo if none is uploaded -->
                                                <img src="{{ asset('img/default_avatar.png') }}" alt="Default Profile Photo" class="w-16 aspect-square object-cover rounded-full">
                                            @endif
                                        </td>
                                        {{-- <td>{{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}</td> --}}
                                        <td>
                                            <!-- Display Employee Name -->
                                            <div>{{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}</div>

                                            <!-- Display Employee Email in a smaller font size and lighter color -->
                                            <div class="text-sm text-gray-500">{{ $employee->personal_mail }}</div>
                                        </td>
                                        <td>{{ $employee->gender }}</td>
                                        <td>{{ $employee->department }}</td>
                                        <td>{{ $employee->payroll_position }}</td>
                                        <td>{{ $employee->date_employed }}</td>
                                        <!-- Conditional Employment Status -->
                                        <td class="{{ strtoupper(trim($employee->employment_status)) === 'ACTIVE' ? 'text-green-500' : (strtoupper(trim($employee->employment_status)) === 'INACTIVE' ? 'text-red-500' : 'text-gray-900') }}">
                                            {{ $employee->employment_status }}
                                        </td>
                                        <td>
                                            <!-- Set unique IDs for the button and dropdown menu using employee id -->
                                            <button id="dropdownHoverButton{{ $employee->id }}" data-dropdown-toggle="dropdownHover{{ $employee->id }}" data-dropdown-trigger="hover" class="text-gray-800 bg-transparent border border-gray-300 hover:text-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-transparent dark:border-gray-600 dark:text-gray-300 dark:hover:text-gray-400 dark:focus:ring-gray-800" type="button">
                                                Action
                                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                                </svg>
                                            </button>

                                            <!-- Dropdown menu with unique ID -->
                                            <div id="dropdownHover{{ $employee->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton{{ $employee->id }}">
                                                    <li>
                                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            <i class="fa-solid fa-eye me-2"></i>View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('employees.edit', $employee->id) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                            <i class="fa-solid fa-pen-to-square me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <hr class="w-[90%] mx-auto">
                                                    <li>
                                                        <!-- Delete Form -->
                                                        <form action="#!" method="POST" class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="delete-button w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white flex items-center focus:outline-none">
                                                                <i class="fa-solid fa-trash me-2 text-red-500"></i><span class="text-red-500">Delete</span>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>


</x-app-layout>
