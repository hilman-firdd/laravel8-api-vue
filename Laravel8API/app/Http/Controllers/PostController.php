<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        // get sebuah data post
        $posts = Post::latest()->get();

        //make sebuah respond
        return response()->json([
            'success'   => true,
            'message'   => 'List data post',
            'data'      => $posts
        ]);
    }

    public function show($id) 
    {
        //find post by id
        $posts = Post::findOrFail($id);

        //make sebuah respons
        return response()->json([
            'success'   => true,
            'message'   => 'Detail data post',
            'data'      => $posts
        ]);
    }

    public function store(Request $request)
    {
        //set validation
        $validation = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required'
        ]);

        //respond error validation
        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        //succes save in your data
        $post = Post::create([
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        //success save to database
        if ($post) {
            return response()->json([
                'success'   => true,
                'message'   => 'Post created',
                'data'      => $post
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Post failed to save'
        ], 409);
    }

    public function update(Request $request, Post $post)
    {
        //set validation
        $validation = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required'
        ]);

        //respond error validation
        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        //succes save in your data
        $post = Post::findOrFail($post->id);

        //success save to database
        if ($post) {
            $post->update([
                'title'     => $request->title,
                'content'   => $request->content
            ]);

            return response()->json([
                'success'   => true,
                'message'   => 'Post updated',
                'data'      => $post
            ], 201);
        }
        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Post failed to update'
        ], 409);
    }

    public function destroy($id)
    {
        //find post by id
        $post = Post::findOrFail($id);

        if ($post) {
            //delete post
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post Deleted'
            ], 200);
        }

        // data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found'
        ], 404);
    }
}
