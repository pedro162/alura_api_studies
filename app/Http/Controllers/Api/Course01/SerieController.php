<?php

namespace App\Http\Controllers\Api\Course01;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;

class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): RedirectResponse
    {
        if ($request->user()->cannot('create', Serie::class)) {
            abort(403);
        }

        return redirect('/series');
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
     * Update the specified resource in storage.
     */
    public function updateTest2(Request $request, Serie $serie)
    {
        if ($request->user()->cannot('update', $serie)) {
            abort(403);
        }

        //update the post

        return redirect('/series');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateTest3(Request $request, Serie $serie)
    {
        Gate::authorize('update', $serie);

        //update the post

        return redirect('/series');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateTest(Request $request, Serie $serie, User $user)
    {
        //https://laravel.com/docs/11.x/collections
        #Collections
        //https://laravel.com/docs/11.x/authentication
        #Ecosystem Overview

        $credentials = [];

        if (Auth::guard('admin')->attempt($credentials)) {
            //
        }

        if (!Gate::allows('update-post', $serie)) {
            abort(403);
        }

        if (Gate::forUser($user)->allows('update-post', $serie)) {
            //
        }

        if (Gate::forUser($user)->denies('update', $serie)) {
            //
        }

        if (Gate::any(['update-post', 'delete-post'], $serie)) {
            //Te user can update or delete the post...
        }

        if (Gate::one(['update-post', 'delete-post'], $serie)) {
            //The user can't update or delete the post...
        }

        Gate::authorize('update-post', $serie);

        $response = Gate::inspect('edit-settings');

        if ($response->allowed()) {
            //The action is authorized...
        } else {
            echo $response->message();
        }

        $response = Gate::inspect('updateResponse', $serie);

        if ($response->allowed()) {
            //The action is authorized...
        } else {
            echo $response->message();
        }

        Gate::authorize('update-post', $serie);
    }

    public function collections(Request $request)
    {
        /* $collection = collect(['taylor', 'abigail', null])
            ->map(fn(?string $name) => strtoupper($name))
            ->reject(fn(string $name) => empty($name)); */

        /*Collection::macro('toUpper', function () {
            return $this->map(function (string $value) {
                return Str::upper($value);
            });
        });*/

        Collection::macro('toLocale', function (string $locale) {
            return $this->map(function (string $value) use ($locale) {
                return Lang::get($value, [], $locale);
            });
        });

        $collection = collect([1, 2, 3])->avg();
        $collection = collect([
            ['foo' => 10],
            ['foo' => 10],
            ['oo' => 20],
            ['oo' => 40],
        ])->average('foo');

        $collection = collect(['1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7])->chunk(2)->all();
        $collection = collect(str_split('AABBCCCD'))
            ->chunkWhile(function (string $value, int $key, Collection $chunk) {
                return $value == $chunk->last();
            })->all();

        $collection = collect([
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
        ])->collapse();

        $collection = collect([
            ['first' => collect([1, 2, 3])],
            ['second' => collect([4, 5, 6])],
            ['third' => collect([7, 8, 9])],
        ]);
        $collection = LazyCollection::make(function () {
            yield 1;
            yield 2;
            yield 3;
        })->all();

        $collection = collect(["name", "age"]);
        $collection  = $collection->combine(['George', 29])->all();

        $collection = collect(['John Doe']);
        $collection = $collection->concat(['Jane Doe'])->concat(['name' => 'Johnny Doe']);

        $collection = collect([1, 2, 3, 4, 5])->contains(function ($value, $key) {
            return $value > 5;
        });

        $collection = collect(['name' => 'Desk', 'price' => 100])->contains('Desk');
        $collection = collect([
            ['product' => 'Desk', 'price' => 200],
            ['product' => 'Chair', 'price' => 100],
        ])->contains('price', '>', 100);

        $collection = collect([])->containsOneItem();
        $collection = collect(['1'])->containsOneItem();
        $collection = collect(['1', '2'])->containsOneItem();
        $collection = [
            collect([])->containsOneItem(),
            collect(['1'])->containsOneItem(),
            collect(['1', '2'])->containsOneItem(),
        ];
        $collection = collect([1, 2, 3, 4])->count();
        $collection = collect([1, 2, 2, 2, 3, 3, 4])->countBy()->all();
        $collection = collect(['alice@gmail.com', 'bob@yahoo.com', 'carlos@gmail.com'])->countBy(function ($value, $key) {
            return substr(strrchr($value, '@'), 1);
        });
        $collection = collect([1, 2]);

        $collection = $collection->crossJoin(['a', 'b'], ['I', 'II']);
        //$collection->dump();
        //$collection->dd();
        //Next topic: diff()

        return response()->json(['data' => $collection]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
