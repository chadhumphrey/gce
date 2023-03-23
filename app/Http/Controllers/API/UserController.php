<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\User;
use App\Models\Spammers;
use App\Http\Resources\UserResource;
use DB;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Spammers::all();
        return $this->sendResponse(UserResource::collection($blogs), 'Posts fetched.');//
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $blog = Blog::create($input);
        return $this->sendResponse(new UserResource($blog), 'Post created.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Spammers::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new UserResource($blog), 'Post fetched.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

     $input = $request->all();
     $validator = Validator::make($input, [
         'sent_to' => 'required',
     ]);
     if($validator->fails()){
         return $this->sendError($validator->errors());
     }
     $blog = Spammers::find($id);
     $blog->sent_to = $input['sent_to'];
     $blog->save();

     return $this->sendResponse(new UserResource($blog), 'Post updated.');

     // Error: Attempt to assign property "sent_to" on null in file /var/www/html/codetest/app/Http/Controllers/API/UserController.php on line 82

      //   $input = $request->all();
      // //   $validator = Validator::make($input, [
      // //     'title' => 'required',
      // //     'description' => 'required'
      // // ]);
      //   // if ($validator->fails()) {
      //   //     return $this->sendError($validator->errors());
      //   // }
      //   // use DB;
      //   DB::enableQueryLog();
      //    // $q = DB::getQueryLog();  // print_r($appointment);//  dd(DB::getQueryLog());
      //   $s = new Spammers();
      //   $s->update($request->all());
      //   $q = DB::getQueryLog();
      //   $x="hello"; dd(__LINE__,__METHOD__, $q);
      //        // $blog->sent_to = $input['sent_to'];
      //   // $blog->id = $input['id'];
      //
      //   // $blog->description = $input['description'];
      //   // $blog->save();
      //
      //   return $this->sendResponse(new UserResource($s), 'Post updated.');
                // return response(['project' => new ProjectResource($project), 'message' => 'Update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Spammers::find($id);
        $blog->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}
