<?php

use Orlyapps\LaravelGithubChangelog\Http\Controllers\ChangelogController;

Route::group(['middleware' => config('github-changelog.middleware', ['web'])], function () {
    Route::get(config('github-changelog.route_path', 'changelog'), ChangelogController::class)->name('changelog');
});
