<?php

namespace App\Http\Controllers;

use App\Models\Employee; // Import the Employee model
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        // Fetch all employees from the database
        $employees = Employee::all();

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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Validate photo (2MB max size)
        ]);

        // Handle the file upload if a photo is provided
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('profile_photos', 'public'); // Store in storage/app/public/profile_photos
        }

        // Create and store the employee record, including the photo path
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
            'photo' => $photoPath, // Save photo path
        ]);

        // Redirect with success message
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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'employee_no' => 'required|unique:employees,employee_no,' . $employee->id,
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Validate photo
        ]);

        // Handle the file upload if a new photo is provided
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($employee->photo && \Storage::disk('public')->exists($employee->photo)) {
                \Storage::disk('public')->delete($employee->photo);
            }
            // Store the new photo
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
            $employee->photo = $photoPath; // Update photo path
        }

        // Check if the user wants to remove the current profile picture
        if ($request->has('remove_photo')) {
            // Delete the current photo if it exists
            if ($employee->photo && \Storage::disk('public')->exists($employee->photo)) {
                \Storage::disk('public')->delete($employee->photo);
            }
            // Reset the photo field to null (or default it)
            $employee->photo = null;
        }

        // Update the employee record with validated data
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
            'photo' => $employee->photo, // Keep the updated or removed photo path
        ]);

        // Redirect with success message
        return redirect()->route('employees')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        // Check if the employee has a profile picture and delete it from storage
        if ($employee->photo && \Storage::disk('public')->exists($employee->photo)) {
            \Storage::disk('public')->delete($employee->photo);
        }

        // Delete the employee record from the database
        $employee->delete();

        // Redirect back with a success message
        return redirect()->route('employees')->with('success', 'Employee deleted successfully.');
    }







}


