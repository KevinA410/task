<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Note;
use App\Models\Task;
use App\Models\Tasklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {           
        $user = User::find(Auth::user()->id);
        $categories = $user->categories()->get();
        $notes = $user->notes()->get();
        $tasklists = $user->tasklists()->get();

        return view('home')->with([
            'user_id' => $user->id,
            'categories' => $categories,
            'notes' => $notes,
            'tasklists' => $tasklists,
        ]);
    }

    public function profile() {
        $user = User::find(Auth::user()->id);
        return view('profile')->with([
            'user' => $user
        ]);
    }

    public function addCategory(Request $r) {
        $category = new Category;
        $category->user_id = $r->user_id;
        $category->name = $r->name;
        $category->save();

        return redirect(route('home'));
    }

    public function deleteCategory(Request $r) {
        $category = Category::find($r->id);

        foreach($category->tasklists()->get() as $list) {
            foreach($list->tasks()->get() as $task) {
                $task->delete();
            }
            $list->delete();
        }

        foreach($category->notes()->get() as $note) {
            $note->delete();
        }

        $category->delete();
        return redirect(route('home'));
    }

    public function addNote(Request $r) {
        $note = new Note;
        $note->user_id = $r->user_id;
        $note->category_id = $r->category;
        $note->title = $r->title;
        $note->description = $r->description;
        $note->save();

        return redirect(route('home'));
    }

    public function deleteNote(Request $r) {
        $note = Note::find($r->id);
        $note->delete();

        return redirect(route('home'));
    }

    public function editNote(Request $r) {
        $note = Note::find($r->id);
        $note->title = $r->title;
        $note->description = $r->description;
        $note->save();

        return redirect(route('home'));        
    }

    public function addTasklist(Request $r) {
        // Create tasklist
        $list = new Tasklist;
        $list->user_id = $r->user_id;
        $list->category_id = $r->category;
        $list->name = $r->name;
        $list->save();

        // Create tasks
        for($i = 1; $i <= $r->counter; $i++) {
            $task = new Task;
            $task->tasklist_id = $list->id;
            $task->name = $r->{'task_txt' . $i};
            $task->save();
        }

        return redirect(route('home'));
    }

    public function deleteTasklist(Request $r) {
        $list = Tasklist::find($r->id);

        foreach($list->tasks()->get() as $task) {
            $task->delete();
        }

        $list->delete();
        return redirect(route('home'));
    }

    public function editTasklist(Request $r) {
        $task = Task::find($r->id);
        $task->checked = true;
        $task->save();
    }

    public function editUser(Request $r) {
        $user = User::find($r->user_id);
        $password = Auth::user()->password;
       
        if(password_verify($r->password, $password)) {
            $user->name = $r->name;
            if($r->new_password) {
                $user->password = password_hash($r->new_password, PASSWORD_DEFAULT);
            }
            $user->save();
        }

        return redirect(route('profile'));
    }
}