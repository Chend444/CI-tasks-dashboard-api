<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = DB::table('tasks')->get();
        return response()->json(['message' => $tasks]);
    }

    public function show($id)
    {
        $task = DB::table('tasks')->find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        return response()->json(['message' => $task]);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|max:32',
                'text' => 'required|max:255',
                'status' => 'required|max:16',
                'due_date' => 'required|date', // Assuming due_date is a date field
                // Add other validation rules as needed
            ]);

            $taskId = DB::table('tasks')->insertGetId([
                'name' => $request->input('name'),
                'text' => $request->input('text'),
                'status' => $request->input('status'),
                'due_date' => $request->input('due_date'),
                // Add other fields as needed
            ]);

            $task = DB::table('tasks')->find($taskId);
            return response()->json(['message' => 'Task created', 'task' => $task], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create task', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'name' => 'required|max:32',
                'text' => 'required|max:255',
                'status' => 'required|max:16',
                'due_date' => 'required|date', // Assuming due_date is a date field
                // Add other validation rules as needed
            ]);

            $affected = DB::table('tasks')->where('id', $id)->update([
                'name' => $request->input('name'),
                'text' => $request->input('text'),
                'status' => $request->input('status'),
                'due_date' => $request->input('due_date'),
                // Add other fields as needed
            ]);

            if ($affected) {
                $task = DB::table('tasks')->find($id);
                return response()->json(['message' => 'Task updated', 'task' => $task]);
            }

            return response()->json(['message' => 'Task not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update task', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $affected = DB::table('tasks')->where('id', $id)->delete();
        if ($affected) {
            return response()->json(['message' => 'Task deleted']);
        }
        return response()->json(['message' => 'Task not found'], 404);
    }
}

?>
