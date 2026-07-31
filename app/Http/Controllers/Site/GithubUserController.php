<?php

namespace App\Http\Controllers\Site;

use App\Models\GithubUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GithubUserController extends Controller
{
    /**
     * Display a listing of the imported GitHub users.
     */
    public function home() : Response
    {
        return Inertia::render('site/Home', [
            'githubUsers' => GithubUser::query()
                ->withCount('repositories')
                ->latest()
                ->get(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
