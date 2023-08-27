<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->input("keyword");

        $perPage = $request->input("perPage", 5);
        $page = $request->input("page", 1);

        $response = [];
        $pageType = $request->input("pageType");

        $query = City::query();

        if (!empty($keyword)) {
            $query = $query->where("name", "like", "%" . $keyword . "%");
        }
        try {
            $skip = $perPage * ($page - 1);
            $response["totalCities"] = $query->count();
            $response["totalPages"] = ceil($response["totalCities"] / $perPage);
            $response["curentPage"] = (int)$page;
            $response["nextPage"] = $response["totalPages"] - $page <= 0 ? false : true;
            $response["prevPage"] = $page <= 1 ? false : true;
            $response["skip"] = $skip + 1;


            $response["cities"] = $query->skip($skip)->take($perPage)->get();

            if ($pageType == "adminCities") {
                $this->formatAdminCities($response["cities"], $response["skip"]);
            }

            return response(["data" => $response], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response(["message" => "Server error, try again later."], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(CityRequest $request)
    {
        $city = new City();
        $city->name = $request->input('cityName');

        try {
            $city->save();
            return redirect()->back()->with("success", ["title" => "Success: ", "message" => "City successfully added."]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with("error", ["title" => "Error: ", "message" => "Server error, try again later"]);
        }
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::find($id);
        try {
            if (!$city) {
                return response(["message" => "City not found"], 404);
            }
            $city->delete();
            return response(["message" => "City successfully deleted"], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response(["message" => "Server error on deleteing company"], 500);
        }
    }

    function formatAdminCities($cities, $skip = 1)
    {
        foreach ($cities as $c) {
            $c->listNumber = $skip;
            $skip++;

            $c->created_at_formated = date("d.m.Y H:i", $c->created_at->timestamp);

            if ($c->created_at->timestamp == $c->updated_at->timestamp) {
                $c->updated_at_formated = null;
            } else {
                $c->updated_at_formated = date("d.m.Y H:i", $c->updated_at->timestamp);
            }
        }
    }
}
