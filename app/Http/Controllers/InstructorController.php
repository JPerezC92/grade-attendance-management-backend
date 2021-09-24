<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Throwable;

class InstructorController extends Controller
{
    public function getByToken(Request $request)
    {
        try {
            return response()->json([
                "success" => true,
                "payload" => $request->user()
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function create(Request $request)
    {
        try {
            $instructor =  User::create([
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "email" => $request->email,
                "password" => $request->password,
                "status" => "activo",
            ]);

            $instructor->fresh();

            return response()->json([
                "success" => true,
                "payload" => $instructor
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
