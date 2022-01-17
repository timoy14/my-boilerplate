<?php

namespace App\Http\Controllers\Dashboard\Admin\Reviews;

use App\Http\Controllers\Controller;
use App\Model\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user')->with('service')->orderBy('id', 'desc')->get();
        return view('admin.reviews.index', compact('reviews'));
    }
}