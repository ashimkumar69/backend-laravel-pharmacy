<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFeedbackValidation;
use App\UserFeedback;
use Illuminate\Http\Request;
use App\Http\Resources\UserFeedback as UserFeedbackResource;
use Illuminate\Support\Facades\Auth;

class UserFeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = UserFeedbackResource::collection(UserFeedback::where('user_id', Auth::id())->get());
        if ($data) {
            return $data;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFeedbackValidation $request)
    {
        $count =  UserFeedback::where('user_id', Auth::id())->count();
        if ($count === 0) {
            UserFeedback::create([
                'user_id' => Auth::id(),
                'stars' => $request->stars,
                'comment' => $request->comment,
            ]);
            $data = UserFeedbackResource::collection(UserFeedback::where('user_id', Auth::id())->get());
            if ($data) {
                return $data;
            }
            // return  UserFeedbackResource::collection(UserFeedback::all());
        } else {
            return response()->json(['error' => 'Already You Give Feedback']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserFeedback  $userFeedback
     * @return \Illuminate\Http\Response
     */
    public function show(UserFeedback $userFeedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserFeedback  $userFeedback
     * @return \Illuminate\Http\Response
     */
    public function update(UserFeedbackValidation $request, UserFeedback $userFeedback)
    {

        $userFeedback = UserFeedback::whereId($request->id)->first();
        $userFeedback->update([
            'stars' => $request->stars,
            'comment' => $request->comment,
        ]);

        $data = UserFeedbackResource::collection(UserFeedback::where('user_id', Auth::id())->get());
        if ($data) {
            return $data;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserFeedback  $userFeedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserFeedback $userFeedback)
    {
        $userFeedback = UserFeedback::where('user_id', Auth::id())->first();
        $userFeedback->delete();
        return response()->json(null, 200);
    }

    public function allFeedbackIndex()
    {

        return UserFeedbackResource::collection(UserFeedback::all());
    }

    public function approveOrNot(Request $request)
    {

        $userFeedback = UserFeedback::whereId($request->id)->first();
        if ($userFeedback->published === 0) {
            $userFeedback->update([
                'published' => true,
            ]);
        } else {
            $userFeedback->update([
                'published' => false,
            ]);
        }


        return UserFeedbackResource::collection(UserFeedback::all());
    }

    public function delete(Request $request)
    {
        UserFeedback::whereId($request->id)->first()->delete();

        return UserFeedbackResource::collection(UserFeedback::all());
    }
}
