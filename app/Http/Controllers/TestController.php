<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\User;
use App\Models\Task;
use App\Enum\TaskStatusEnum;
use App\DTO\TaskDto;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $t = Task::find(123);



        dd($t->canDelete());


        echo('it works!');
    }
}
