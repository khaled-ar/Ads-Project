<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Admin;
use App\Http\Requests\Dashboard\StoreStoryRequest;
use App\Models\Story;
use App\Models\Winner;
use Illuminate\Http\Request;

class StoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware(Admin::class)->only('store');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stories = Story::latest()->get();
        return view('stories', compact('stories'));
    }

    public function prize_form(Story $story) {
        return view('prize-form', [
            'story' => $story
        ]);
    }

    public function form_submit(Request $request, Story $story) {
        $data = $request->only(['full_name', 'phone']);
        $data['story_id'] = $story->id;
        $data['value'] = $story->prize_value;
        try {
            Winner::create($data);
            return back()
            ->with('success', 'لقد تم استلام بياناتك بنجاح، سوف يتم التواصل معك لاستلام الجائزة في اقرب وقت ممكن.');
        }catch(\Illuminate\Database\UniqueConstraintViolationException $e) {
            return back()
            ->with('errors', 'لقد قمت بتسجيل المعلومات من اجل هذه القصة مسبقاً.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStoryRequest $request)
    {
        Story::create($request->validated());
        return $this->generalResponse(null, 'Story Added Successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
