@extends('user.user-page')

@section('data')
    <div class="review-container">
        <div class="title">
            <h1>Отзывы о пользователе {{ $user->name }}</h1>
            <button id="addReviewButton" class="addReviewButton">Добавить отзыв</button>
        </div>
        <form class="add-review-form" id="reviewForm" style="display: none;" method="POST" action="{{ route('reviews.store') }}">
            @csrf
            <input type="hidden" name="seller_id" value="{{ $user->id }}">
            <div id="starRating" class="stars-rating">
                <img src="{{ asset('image/user-account/star-false.svg') }}" data-value="1" class="star">
                <img src="{{ asset('image/user-account/star-false.svg') }}" data-value="2" class="star">
                <img src="{{ asset('image/user-account/star-false.svg') }}" data-value="3" class="star">
                <img src="{{ asset('image/user-account/star-false.svg') }}" data-value="4" class="star">
                <img src="{{ asset('image/user-account/star-false.svg') }}" data-value="5" class="star">
            </div>
            @include('components.main-input', ['placeholder'=>'Введите отзыв', 'name'=>'review_text', 'type'=>'text'])
            <input type="hidden" name="rating" id="rating" value="0">
            <button class="addReviewButton" type="submit">Отправить</button>
        </form>
        @if($reviews->isEmpty())
            <p class="review-message">Нет отзывов о данном пользователе.</p>
        @else
            <div class="review-list">
                @foreach($reviews->reverse() as $review)
                    <div class="review-item">
                        <div class="review-title">
                            @if($review->reviewer->images)
                                <img class="user-data-image" src="{{ asset('storage/' . $review->reviewer->images) }}" alt="User Avatar">
                            @else
                                <img class="user-data-image" src="{{asset('image/header/user-logo.svg')}}" alt=""/>
                            @endif
                            <h2>{{ $review->reviewer->name }}</h2>
                            <div class="review-rating">
                                {!! generateStarRating($review->rating) !!}
                            </div>
                        </div>
                        <p>{{ $review->review_text }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <script>
        document.getElementById('addReviewButton').addEventListener('click', function() {
            var form = document.getElementById('reviewForm');
            if (form.style.display === 'none') {
                form.style.display = 'block';
                this.textContent = 'Отменить';
            } else {
                form.style.display = 'none';
                this.textContent = 'Добавить отзыв';
                resetForm();
            }
        });

        const stars = document.querySelectorAll('.stars-rating .star');
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-value');
                document.getElementById('rating').value = rating;
                updateStars(rating);
            });
        });

        function updateStars(rating) {
            stars.forEach(star => {
                const starValue = star.getAttribute('data-value');
                if (starValue <= rating) {
                    star.src = '{{ asset('image/user-account/star-true.svg') }}';
                } else {
                    star.src = '{{ asset('image/user-account/star-false.svg') }}';
                }
            });
        }

        function resetForm() {
            document.querySelector('[name="review_text"]').value = '';
            document.getElementById('rating').value = '0';
            updateStars(0);
        }
    </script>
@endsection

@php
    function generateStarRating($rating) {
        $fullStar = asset('image/user-account/star-true.svg');
        $emptyStar = asset('image/user-account/star-false.svg');
        $starsHtml = '';

        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $starsHtml .= '<img src="' . $fullStar . '" class="star" alt="Star">';
            } else {
                $starsHtml .= '<img src="' . $emptyStar . '" class="star" alt="Star">';
            }
        }

        return $starsHtml;
    }
@endphp

<style>
    .add-review-form textarea {
        height: 150px;
    }
    .addReviewButton {
        margin-top: 15px;
    }
    .stars-rating img {
        width: 30px;
        height: 30px;
        cursor: pointer;
    }
    .stars-rating {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .review-title h2 {
        font-size: 18px;
    }
    .review-container {
        padding: 15px;
        border-radius: 12px;
        box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
        width: 920px;
    }
    .title {
        display: flex;
        justify-content: space-between;
        align-items: start;
    }
    .title .addReviewButton {
        margin: 0;
    }
    .title h1 {
        font-weight: 700;
        font-size: 40px;
    }
    .addReviewButton {
        height: 36px;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 12px;
        transition: 300ms;
        border: none;
        font-weight: 500;
        font-size: 14px;
    }
    .addReviewButton:hover {
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
        transform: scale(1.02);
    }
    .review-title {
        display: flex;
        align-items: center;
    }
    .user-data-image {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }
    .review-rating {
        display: flex;
        align-items: center;
        margin: 10px 0;
    }
    .review-rating img {
        height: 25px;
        width: 25px;
    }
    .review-item {
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
        margin-top: 15px;
    }
</style>
