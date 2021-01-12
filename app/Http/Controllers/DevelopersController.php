<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Tasks;
use App\Developers;
use App\TasksCategories;
use App\TaskSubCategories;
use Illuminate\Support\Facades\Mail;

class DevelopersController extends Controller
{
    public function index(Request $request){

        if (!session()->get('company_id')) {
            session()->put('company_id', 1);
        }

        if($request->ajax()){

            $tasks = Tasks::where('company_id', '=', session()->get('company_id'))->orderBy('created_at',  'DESC');
            return datatables()->of($tasks)
                ->addColumn('developer', 'pages.developers.info')
                ->addColumn('btnaction', 'pages.developers.actions')
                ->addColumn('btnstatus', 'pages.developers.status')
                ->rawColumns(['btnstatus', 'btnaction'])
                ->make();

        }else{

            return view('pages.developers.index');
        }

    }

    public function show($id){

        $task = Tasks::where('id', '=', $id)->first();
        $categories = DB::table('tasks_categories')->where('company_id', '=', session()->get('company_id'));
        $sub_categories = DB::table('tasks_sub_categories');
        return view('pages.developers.show-task', compact('task', 'categories', 'sub_categories'));
    }

    public function create(){

        $categories = DB::table('tasks_categories')->where('company_id', '=', session()->get('company_id'))->get();
        $sub_categories = DB::table('tasks_sub_categories')->where('company_id', '=', session()->get('company_id'))->get();
        $developers = DB::table('developers')->where('company_id', '=', session()->get('company_id'))->get();
        return view('pages.developers.create-task', compact('categories', 'sub_categories', 'developers'));
    }

    public function store(Request $request){

        $task = Tasks::create([
            'company_id' => session()->get('company_id'), 'status_id' => 3, 'user_id' => auth()->user()->id
        ] + $request->task);
        if ($task->save()) {
            return redirect(route('developers.index'))->with('message_success', 'Task created successfully');
        }else{
            return redirect(route('developers.index'))->with('message_warning', 'An error has occurred');
        }
    }

    public function editTask($id){

        $task = Tasks::where('id', '=', $id)->first();
        $categories = DB::table('tasks_categories')->where('company_id', '=', session()->get('company_id'))->get();
        $sub_categories = DB::table('tasks_sub_categories')->where('company_id', '=', session()->get('company_id'))->get();
        $developers = DB::table('developers')->where('company_id', '=', session()->get('company_id'))->get();
        return view('pages.developers.update-task', compact('task', 'categories', 'sub_categories', 'developers'));
    }

    public function updateTask(Request $request, Tasks $task){

        $developer = $task->get_developer($request->task['developer_id'], false);
        $status = $task->get_status($request->task['status_id']);
        $this->sendEmailNotification($request->task, $developer, $status, $task->user_id);

        $task->update($request->task);
        if ($task->save()) {
            return redirect(route('developers.index'))->with('message_success', 'Task updated successfully');
        }else{
            return redirect(route('developers.index'))->with('message_warning', 'An error has occurred');
        }
    }

    function sendEmailNotification($task, $developer, $status, $user_id){

        $task['developer'] = $developer->firstname . " " . $developer->lastname;
        $task['developer_email'] = $developer->email;
        $task['status'] = $status;
        $task['user'] = DB::table('users')->where('id', '=', $user_id)->first();
        Mail::send('pages.developers.email-notification', $task, function($message) use ($task){
            $message->from('email@gmail.com', 'Hoteratus')
            ->to([$task['user']->email, $task['developer_email']])
            ->subject("Hoteratus Task Notification");
        });
    }

    public function createCategory(){

        return view('pages.developers.create-category');
    }

    public function storeCategory(Request $request){

        $category = TasksCategories::create( ["company_id" =>session()->get('company_id') ] + $request->category);

        if ($category->save()) {
            return redirect(route('developers.index'))->with('message_success', 'Category created successfully');
        }else{
            return redirect(route('developers.index'))->with('message_warning', 'An error has occurred');
        }
    }

    public function createSubcategory(){

        return view('pages.developers.create-subcategory');
    }

    public function storeSubcategory(Request $request){

        $subcategory = TaskSubCategories::create($request->subcategory);
        $subcategory->company_id = session()->get('company_id');
        if ($subcategory->save()) {
            return redirect(route('developers.index'))->with('message_success', 'Sub Category created successfully');
        }else{
            return redirect(route('developers.index'))->with('message_warning', 'An error has occurred');
        }
    }


    public function createDeveloper(){

        return view('pages.developers.create-developer');
    }

    public function storeDeveloper(Request $request){

        $developer = Developers::create($request->developer); // Inserta
        $developer->company_id = session()->get('company_id'); // Este campo debe estar Nullable en la migracion
         // Actualiza
        if ($developer->save()) {
            return redirect(route('developers.index'))->with('message_success', 'Developer created successfully');
        }else{
            return redirect(route('developers.index'))->with('message_warning', 'An error has occurred');
        }
    }



}
