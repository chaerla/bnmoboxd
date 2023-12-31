<?php
use app\core\Application;
include_once Application::$BASE_DIR . '/src/views/components/navbar.php';

function reviewList($reviews){
    $str = "";
    if(!empty($reviews)){
        foreach($reviews as $review) {
            $name = $review['title'];
            $id = $review['id'];
            $filmPosterPath = '/assets/films/' . $review['image_path'];
            $reviewText = $review['review'];
            $rating = $review['rating'];
            $dtCreate = new DateTime($review['updated_at'] ?? $review['created_at']);
            $dateCreate = $dtCreate->format('M d, Y');

            $starsHtml = str_repeat('<img src="/assets/app/star.png" alt="star" class="stars-img">', $rating);
            $html = <<<EOT
                <a href="/my-reviews/$id" class="review-container" id="review-container-flex">                                                                                                                                     
                    <img alt="film poster" src="$filmPosterPath" class="poster-image">
                    <div class="review-details">
                        <h6>
                            $name
                            <span class="review-date">
                                $dateCreate
                            </span>
                        </h6>
                        <div class="review-stars-container">$starsHtml</div>
                        <p>$reviewText</p>
                    </div>
                </a>
            EOT;
            $str = $str . $html;
        }
    }
    if(empty($str)){
        return <<<"EOT"
            <p class="empty-text">No reviews.</p>
        EOT;
    }
    return $str;
}
?>

<div class="base-container" id="reviews-page-container">
    <h5 class="section-title" id="t1">MY REVIEWS</h5>
    <div class="review-list" id="rl1">
        <?php
        include Application::$BASE_DIR . '/src/views/components/review-list.php';
        ?>
    </div>
</div>

<script defer src="/js/reviews.js"></script>