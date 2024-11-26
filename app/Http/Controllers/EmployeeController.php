<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        // Fetch all employees from the database who are not excluded
        $employees = Employee::where('exclude', 0)->get();

        // Pass the employees data to the view
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create-employee');
    }

    public function store(Request $request)
    {
        // Validate incoming request data with additional rules, including photo
        $validatedData = $request->validate([
            'employee_no' => 'required|unique:employees,employee_no',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'gender' => 'required|string',
            'marital_status' => 'required|string',
            'address' => 'required|string|max:255',
            'department' => 'required|string',
            'payroll_position' => 'required|string',
            'designation' => 'required|string|max:255',
            'place_of_assignment' => 'required|string',
            'office_mail' => ['nullable', 'email', 'max:255', 'regex:/^[\w\-.]+@ched\.gov\.ph$/'],
            'personal_mail' => 'required|email|max:255',
            'mobile_number' => 'nullable|string|max:15',
            'tin' => 'nullable|string|max:100',
            'gsis' => 'nullable|string|max:100',
            'crn' => 'nullable|string|max:100',
            'sss' => 'nullable|string|max:100',
            'philhealth' => 'nullable|string|max:100',
            'date_employed' => 'required|date|before_or_equal:today',
            'employment_status' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Validate photo (10MB max size)
        ]);

        // Check for an excluded employee to reuse
        $employee = Employee::where('exclude', 1)->first();

        // Handle file upload if a photo is provided
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('profile_photos', 'public');
        }

        if ($employee) {
            // Reuse the excluded employee record
            $employee->update([
                'employee_no' => $validatedData['employee_no'],
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'birthdate' => $validatedData['birthdate'],
                'gender' => $validatedData['gender'],
                'marital_status' => $validatedData['marital_status'],
                'address' => $validatedData['address'],
                'department' => $validatedData['department'],
                'payroll_position' => $validatedData['payroll_position'],
                'designation' => $validatedData['designation'],
                'place_of_assignment' => $validatedData['place_of_assignment'],
                'office_mail' => $validatedData['office_mail'],
                'personal_mail' => $validatedData['personal_mail'],
                'mobile_number' => $validatedData['mobile_number'],
                'tin' => $validatedData['tin'],
                'gsis' => $validatedData['gsis'],
                'crn' => $validatedData['crn'],
                'sss' => $validatedData['sss'],
                'philhealth' => $validatedData['philhealth'],
                'date_employed' => $validatedData['date_employed'],
                'employment_status' => $validatedData['employment_status'],
                'photo' => $photoPath ?? null,  // Reset the photo to null if no new photo is uploaded
                'exclude' => 0, // Reactivate employee
                'active' => 1,  // Mark as active
            ]);

        } else {
            // Create a new employee if no excluded employee is found
            Employee::create([
                'employee_no' => $validatedData['employee_no'],
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'birthdate' => $validatedData['birthdate'],
                'gender' => $validatedData['gender'],
                'marital_status' => $validatedData['marital_status'],
                'address' => $validatedData['address'],
                'department' => $validatedData['department'],
                'payroll_position' => $validatedData['payroll_position'],
                'designation' => $validatedData['designation'],
                'place_of_assignment' => $validatedData['place_of_assignment'],
                'office_mail' => $validatedData['office_mail'],
                'personal_mail' => $validatedData['personal_mail'],
                'mobile_number' => $validatedData['mobile_number'],
                'tin' => $validatedData['tin'],
                'gsis' => $validatedData['gsis'],
                'crn' => $validatedData['crn'],
                'sss' => $validatedData['sss'],
                'philhealth' => $validatedData['philhealth'],
                'date_employed' => $validatedData['date_employed'],
                'employment_status' => $validatedData['employment_status'],
                'photo' => $photoPath, // Store the new photo path if uploaded, or null
                'active' => 1,  // Mark as active by default
                'exclude' => 0, // Not excluded
            ]);
        }

        return redirect()->route('employees')->with('success', 'Employee created successfully.');
    }


    public function edit($id)
    {
        // Find the employee by ID
        $employee = Employee::findOrFail($id);

        // Return the edit view with the employee data
        return view('admin.employees.edit-employee', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        // Validate incoming request data with additional rules, including photo
        $validatedData = $request->validate([
            'employee_no' => 'required|unique:employees,employee_no,' . $employee->id, // Ensure unique employee number except for this employee
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'gender' => 'required|string',
            'marital_status' => 'required|string',
            'address' => 'required|string|max:255',
            'department' => 'required|string',
            'payroll_position' => 'required|string',
            'designation' => 'required|string|max:255',
            'place_of_assignment' => 'required|string',
            'office_mail' => ['nullable', 'email', 'max:255', 'regex:/^[\w\-.]+@ched\.gov\.ph$/'],
            'personal_mail' => 'required|email|max:255',
            'mobile_number' => 'nullable|string|max:15',
            'tin' => 'nullable|string|max:100',
            'gsis' => 'nullable|string|max:100',
            'crn' => 'nullable|string|max:100',
            'sss' => 'nullable|string|max:100',
            'philhealth' => 'nullable|string|max:100',
            'date_employed' => 'required|date|before_or_equal:today',
            'employment_status' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Validate photo (10MB max size)
        ]);

        // Check if a new photo is uploaded
        if ($request->hasFile('photo')) {
            // Handle file upload and store the new photo
            $photo = $request->file('photo');
            $photoPath = $photo->store('profile_photos', 'public');

            // Delete the old photo if exists
            if ($employee->photo && \Storage::exists('public/' . $employee->photo)) {
                \Storage::delete('public/' . $employee->photo);
            }

            // Update the photo path in the validated data
            $validatedData['photo'] = $photoPath;
        } else {
            // If no new photo is uploaded, retain the old photo path
            $validatedData['photo'] = $employee->photo;
        }

        // Update the employee record with the validated data
        $employee->update($validatedData);

        // Redirect back with success message
        return redirect()->route('employees')->with('success', 'Employee updated successfully.');
    }


    public function destroy(Employee $employee)
    {
        // Soft delete: mark the employee as excluded and inactive
        $employee->update([
            'exclude' => 1, // Mark as excluded
            'active' => 0,  // Set as inactive
        ]);

        return redirect()->route('employees')->with('success', 'Employee soft deleted successfully.');
    }
}
