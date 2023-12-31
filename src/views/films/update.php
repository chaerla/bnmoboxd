<?php

use app\core\Application;

include_once Application::$BASE_DIR . '/src/views/components/navbar.php';

function filmUpdateForm($data){
    $newFilm = !isset($data['film']);

    $title = '';
    $releaseYear = '';
    $director = '';
    $description = '';
    $genre = '';
    $imagePath = '/assets/films/';
    $videoPath = '/assets/videos/';

    if(!$newFilm){
        $film = $data['film'];

        $title = $film['title'];
        $releaseYear = $film['release_year'];
        $director = $film['director'];
        $description = $film['description'];
        $genre = $film['genre'];
        $imagePath = $imagePath . $film['image_path'];
        $videoPath = $videoPath . $film['video_path'];
    }

    $html = $newFilm ? '' : "<div class=\"film-poster-col\"><img src=\"$imagePath\" class=\"poster-image\" alt=\"Current film poster\"></div>";

    $html .= <<<"EOT"
        <div class="film-details-col">
            <form class="form-container" id="film-form">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" formnovalidate value="$title">
                    <label class="form-error" id="title-form-error"></label>
                </div>
                <div class="form-group">
                    <label for="release_year">Release Year</label>
                    <input type="text" id="release_year" name="release_year" formnovalidate value="$releaseYear">
                    <label class="form-error" id="release-year-form-error"></label>
                </div>
                <div class="form-group">
                    <label for="director">Director(s)</label>
                    <input type="text" id="director" name="director" formnovalidate value="$director">
                    <label class="form-error" id="director-form-error"></label>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" formnovalidate>$description</textarea>
                    <label class="form-error" id="description-form-error"></label>
                </div>
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <select type="text" id="genre" name="genre" formnovalidate>
                        {{genre-options}}
                    </select>
                </div>
                <div class="form-group">
                    <label for="film_poster">Poster</label>
                    <input type="file" id="film_poster" name="film_poster" accept="image/*">
                    <label class="form-error" id="film-poster-form-error"></label>
                </div>
                <div class="form-group">
                    <label for="film_trailer">Trailer</label>
                    <input type="file" id="film_trailer" name="film_trailer" accept="video/*">
                </div>
                <div class="btn-group">
                    <button class="btn-primary" type="button" id="save-btn">Save</button>
                    <button class="btn-primary" type="button" id="cancel-btn">Cancel</button>
                    {{button-delete}}
                </div>
                <div class="modal-container" id="confirm-save-modal">
                    <div class="confirmation-modal">
                        <h2>Are you sure you want to save this film?</h2>
                        <div class="btn-group">
                            <button class="btn-primary" type="button" id="confirm-save-btn">Yes</button>
                            <button class="btn-danger" type="button" onclick="handleClose('#confirm-save-modal')">Cancel</button>
                        </div>
                     </div>
                </div>
                <div class="modal-container" id="confirm-cancel-modal">
                    <div class="confirmation-modal">
                        <h2>Are you sure you want to cancel? Any unsaved changes will be lost.</h2>
                        <div class="btn-group">
                            <button class="btn-primary" type="button" id="confirm-cancel-btn">Yes</button>
                            <button class="btn-danger" type="button" onclick="handleClose('#confirm-cancel-modal')">Cancel</button>
                        </div>
                     </div>
                </div>
                <div class="modal-container" id="confirm-delete-modal">
                    <div class="confirmation-modal">
                        <h2>Are you sure you want to delete this film?</h2>
                        <div class="btn-group">
                            <button class="btn-primary" type="button" id="confirm-delete-btn">Yes</button>
                            <button class="btn-danger" type="button" onclick="handleClose('#confirm-delete-modal')">Cancel</button>
                        </div>
                     </div>
                </div>
            </form>
        </div>
    EOT;

    $html = str_replace(
        '{{button-delete}}',
        $newFilm ? '' : '<button class="btn-danger" type="button" id="delete-btn">Delete</button>',
        $html
    );

    $genreOptions = ['Action', 'Comedy', 'Drama', 'Sci-Fi', 'Horror', 'Fantasy', 'Other'];
    $genreOptionsHtml = '';
    foreach($genreOptions as $genreOption){
        $genreOptionHtml = $genreOption == $genre ?
            "<option value=\"$genreOption\" selected>$genreOption</option>" :
            "<option value=\"$genreOption\">$genreOption</option>";
        $genreOptionsHtml = $genreOptionsHtml . $genreOptionHtml;
    }
    $html = str_replace('{{genre-options}}', $genreOptionsHtml, $html);

    return $html;
}
?>
<div class="base-container display-grid no-gap">
    <h5 class="section-title"><?php echo isset($data['film']) ? 'Edit Film' : 'New Film'; ?></h5>
    <div class="film-page-container">
        <?php echo filmUpdateForm($data); ?>
    </div>
</div>
<script defer src="/js/confirmation-modal.js"></script>
<script defer src="/js/form-handler.js"></script>
<script defer src="/js/film-update.js"></script>
