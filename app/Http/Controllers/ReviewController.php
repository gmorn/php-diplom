<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'seller_id' => 'required',
            'rating' => 'required',
            'review_text' => 'required',
        ]);

        // Создаем отзыв
        Review::create([
            'reviewer_id' => auth()->id(),
            'seller_id' => $request->seller_id,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
        ]);

        // Обновляем средний рейтинг пользователя
        $this->updateUserAverageRating($request->seller_id);

        return redirect()->route('user_page_reviews', $request->seller_id);
    }

    protected function updateUserAverageRating($userId)
    {
        $user = User::findOrFail($userId);
        $averageRating = Review::where('seller_id', $userId)->avg('rating');
        $user->rating = $averageRating;
        $user->save();
    }
}
