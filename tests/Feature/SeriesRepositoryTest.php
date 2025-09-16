<?php

namespace Tests\Feature;

use App\Http\Requests\StoreSerieRequest;
use App\Models\Serie;
use App\Repositories\SerieRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Tests\TestCase;

class SeriesRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_when_a_series_is_created_its_seasons_and_episodes_must_also_be_created()
    {
        //Arrange
        $repository = $this->app->make(SerieRepository::class);
        $request = new StoreSerieRequest();
        $request->merge(['name' => 'Test0000']);

        //Act
        $repository->store($request->all());

        //Assert
        $this->assertDatabaseHas('series', ['name' => 'Test0000']);
    }
}
