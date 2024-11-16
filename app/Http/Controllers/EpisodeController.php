<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEpisodeRequest;
use App\Http\Requests\UpdateEpisodeRequest;
use Illuminate\Http\Request;
use App\Models\Episode;
use App\Models\Season;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Season $season)
    {
        return view('episodes.index', ['episodes' => $season->episodes]);
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
    public function store(StoreEpisodeRequest $request)
    {
        //
        if (!Auth::attempt($request->all())) {
            return redirect()->back()->withErrors(['Usuáro ou senha inválidos']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Episode $episode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Episode $episode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEpisodeRequest $request, Season $season)
    {
        if (! Auth::check()) {
            throw new AuthenticationException();
        }

        Episode::where('season_id', $season->id)
            ->whereIn('id', $request->episodes)
            ->update(['watched' => true]);

        //$season->episodes->filter(fn($episode) => $episode->watched)->count();
        $season->numberOfWatchedEpisodes();

        return to_route('episodes.index', $season->id)->with('mensagem.sucesso', 'Cri com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Episode $episode)
    {
        //
    }

    public function watched(Request $request, string $id)
    {
        //
    }
}
