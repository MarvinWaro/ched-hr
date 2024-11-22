<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Employee') }}
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

        .text-danger {
            color: red;
        }


    </style>

    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-5">


                    <div class="py-5 px-4 mx-auto max-w-7xl lg:py-10">
                        {{-- <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add a new employee</h2> --}}
                        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                                {{-- PERSONAL INFORMATION --}}
                                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Personal Information</h2>

                                <!-- Profile Picture Upload Field with Preview -->
                                <div class="sm:col-span-2 flex items-center space-x-6">
                                    <div class="shrink-0">
                                        <!-- Default image or placeholder -->
                                        <img id="preview_img" class="h-16 w-16 object-cover rounded-full" src="{{ asset('img/default_avatar.png') }}" alt="Profile picture preview" />
                                    </div>
                                    <label class="block">
                                        <span class="sr-only">Choose profile photo</span>
                                        <input type="file" name="photo" id="photo" accept="image/*" onchange="loadFile(event)" class="block w-full text-sm text-slate-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-violet-50 file:text-violet-700
                                            hover:file:bg-violet-100"/>
                                    </label>
                                </div>

                                @error('photo')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror

                                <div class="sm:col-span-2 flex gap-4">
                                    <div class="w-full">
                                        <label for="employee_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employee # <span class="text-danger">*</span></label>
                                        <input type="number" name="employee_no" id="employee_no" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter Employee #" >
                                        @error('employee_no')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-full">
                                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" name="last_name" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter Last Name" >
                                        @error('last_name')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-full">
                                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter First Name" >
                                        @error('first_name')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-full">
                                        <label for="middle_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle Name </label>
                                        <input type="text" name="middle_name" id="middle_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter Middle Name">
                                        @error('middle_name')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="sm:col-span-2 flex gap-4">
                                    <div class="w-full">
                                        <label for="birthdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birth Date <span class="text-danger">*</span></label>
                                        <input type="date" name="birthdate" id="birthdate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" >
                                        @error('birthdate')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-full">
                                        <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender <span class="text-danger">*</span></label>
                                        <select id="gender" name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" >
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        @error('gender')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-full">
                                        <label for="marital_status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Marital Status <span class="text-danger">*</span></label>
                                        <select id="marital_status" name="marital_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" >
                                            <option value="" disabled selected>Select Marital Status</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Separated">Separated</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                        </select>
                                        @error('marital_status')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Street, Baranggay, City, Province">
                                    @error('address')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- CREDENTIALS --}}
                                <h2 class="my-4 text-xl font-bold text-gray-900 dark:text-white">Credentials</h2>

                                <!-- Flex container for Department, Payroll Position, and Designation -->
                                <div class="sm:col-span-2 flex gap-4">
                                    <!-- Department Dropdown -->
                                    <div class="w-full">
                                        <label for="department" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department <span class="text-danger">*</span></label>
                                        <select id="department" name="department" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option value="" disabled selected>Select Department</option>
                                            <option value="Director's Office">Director's Office</option>
                                            <option value="Admin Department">Admin Department</option>
                                            <option value="Technical Department">Technical Department</option>
                                        </select>
                                        @error('department')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Payroll Position Dropdown -->
                                    <div class="w-full">
                                        <label for="payroll_position" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Payroll Position <span class="text-danger">*</span></label>
                                        <select id="payroll_position" name="payroll_position" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option value="" disabled selected>Select Payroll Position</option>
                                            <option value="Director IV">Director IV</option>
                                            <option value="Chief Administrative Officer">Chief Administrative Officer</option>
                                            <option value="Supervising Education Program Specialist">Supervising Education Program Specialist</option>
                                            <option value="Education Supervisor II">Education Supervisor II</option>
                                            <option value="Education Program Specialist II">Education Program Specialist II</option>
                                            <option value="Administrative Officer III">Administrative Officer III</option>
                                            <option value="Administrative Assistant III">Administrative Assistant III</option>
                                            <option value="Administrative Aide VI">Administrative Aide VI</option>
                                            <option value="Administrative Aide III">Administrative Aide III</option>
                                            <option value="Project Technical Staff III">Project Technical Staff III</option>
                                            <option value="Project Technical Staff II">Project Technical Staff II</option>
                                            <option value="Project Technical Staff I">Project Technical Staff I</option>
                                            <option value="Project Support Staff IV">Project Support Staff IV</option>
                                            <option value="Job Order">Job Order</option>
                                        </select>
                                        @error('payroll_position')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Designation Input -->
                                    <div class="w-full">
                                        <label for="designation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Designation <span class="text-danger">*</span></label>
                                        <input type="text" name="designation" id="designation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter Designation">
                                        @error('designation')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="sm:col-span-2 flex gap-4">
                                    <div class="w-full">
                                        <label for="place_of_assignment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Place of Assignment <span class="text-danger">*</span></label>
                                        <select id="place_of_assignment" name="place_of_assignment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option value="" disabled selected>Select Place of Assignment</option>
                                            <option value="Zamboanga City, Zamboanga Del Sur">Zamboanga City, Zamboanga Del Sur</option>
                                            <option value="Pagadian City, Zamboanga Sibugay">Pagadian City, Zamboanga Sibugay</option>
                                        </select>
                                        @error('place_of_assignment')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-full">
                                        <label for="office_mail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Office Mail</label>
                                        <input type="email" name="office_mail" id="office_mail" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter Office Mail">
                                        @error('office_mail')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-full">
                                        <label for="personal_mail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Personal Mail <span class="text-danger">*</span></label>
                                        <input type="email" name="personal_mail" id="personal_mail" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter Personal Mail">
                                        @error('personal_mail')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="sm:col-span-2 flex gap-4">
                                    <div class="w-full">
                                        <label for="mobile_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mobile Number</label>
                                        <input type="text" name="mobile_number" id="mobile_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter Mobile Number" >
                                        @error('mobile_number')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-full">
                                        <label for="tin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">TIN</label>
                                        <input type="text" name="tin" id="tin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter TIN" >
                                        @error('tin')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-full">
                                        <label for="gsis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">GSIS</label>
                                        <input type="text" name="gsis" id="gsis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter GSIS Number" >
                                        @error('gsis')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-full">
                                        <label for="crn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CRN</label>
                                        <input type="text" name="crn" id="crn" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter CRN" >
                                        @error('crn')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="sm:col-span-2 flex gap-4">
                                    <div class="w-full">
                                        <label for="sss" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">SSS</label>
                                        <input type="text" name="sss" id="sss" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter SSS Number" >
                                        @error('sss')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-full">
                                        <label for="philhealth" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PhilHealth</label>
                                        <input type="text" name="philhealth" id="philhealth" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter PhilHealth Number" >
                                        @error('philhealth')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-full">
                                        <label for="date_employed" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date Employed <span class="text-danger">*</span></label>
                                        <input type="date" name="date_employed" id="date_employed" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        @error('date_employed')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-full">
                                        <label for="employment_status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employment Status <span class="text-danger">*</span></label>
                                        <select id="employment_status" name="employment_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option value="" disabled selected>Select Employment Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                        @error('employment_status')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <!-- Save Button at Bottom-Right -->
                            <div class="flex justify-end mt-9">
                                <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                    Save Employee
                                </button>
                            </div>
                        </form>

                    </div>


            </div>
        </div>
    </div>

    <!-- Script for previewing the selected image -->
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('preview_img');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src); // Free memory
            }
        };
    </script>

</x-app-layout>
