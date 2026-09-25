<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter tanggal
        if ($request->filled('date-filter')) {
            $date = \Carbon\Carbon::parse($request->input('date-filter'))->format('Y-m-d');
            $query->whereDate('applied_at', $date);
        }

        // Sorting
        $allowedSorts = ['company', 'position', 'status', 'applied_at', 'created_at'];
        $sort = $request->get('sort', 'created_at');
        if (!in_array($sort, $allowedSorts)) $sort = 'created_at';

        $order = $request->get('order', 'desc');
        if (!in_array($order, ['asc', 'desc'])) $order = 'desc';

        // Ganti ->get() jadi ->paginate(5)
        $applications = $query
            ->orderBy($sort, $order)
            ->paginate(5)
            ->withQueryString();   // ⬅️ supaya filter tetap kebawa saat pindah page

        // Statistics
        $total = JobApplication::count();
        $applied = JobApplication::where('status', 'Applied')->count();
        $interview = JobApplication::where('status', 'Interview')->count();
        $accepted = JobApplication::where('status', 'Accepted')->count();
        $rejected = JobApplication::where('status', 'Rejected')->count();

        if ($request->ajax() || $request->input('ajax') === '1') {
            return view('job-applications._ajax', compact(
                'applications',
                'sort',
                'order',
                'total',
                'applied',
                'interview',
                'accepted',
                'rejected'
            ));
        }
        return view('job-applications.index', compact(
            'applications',
            'sort',
            'order',
            'total',
            'applied',
            'interview',
            'accepted',
            'rejected'
        ));
    }

    public function create()
    {
        return view('job-applications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'status' => 'required|string',
            'applied_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        JobApplication::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect('/')
            ->with('success', 'The application has been successfully added.');
    }

    public function edit(JobApplication $jobApplication)
    {
        return view('job-applications.edit', compact('jobApplication'));
    }

    public function update(Request $request, JobApplication $jobApplication)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'status' => 'required|string',
            'applied_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $jobApplication->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect('/')
            ->with('success', 'The application has been successfully updated.');
    }

    public function destroy(Request $request, JobApplication $jobApplication)
    {
        $jobApplication->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect('/')
            ->with('success', 'The application was successfully deleted.');
    }

    public function show(JobApplication $jobApplication)
    {
        return response()->json($jobApplication);
    }
}
