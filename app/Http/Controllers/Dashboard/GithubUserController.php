<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\GithubUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class GithubUserController extends Controller
{
    /**
     * Display a listing of the imported GitHub users.
     */
    public function index() : Response
    {
        return Inertia::render('dashboard/github-users/Index', [
            'githubUsers' => GithubUser::query()
                ->withCount('repositories')
                ->latest()
                ->get(),
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GithubUser $githubUser) : Response
    {
        return Inertia::render('dashboard/github-users/Show', [
            'githubUser' => $githubUser->load('repositories'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : RedirectResponse
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
    public function destroy(GithubUser $githubUser) : RedirectResponse
    {
        $githubUser->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => __('GitHub user removed.')]);

        return to_route('dashboard.github-users.index');
    }
}
