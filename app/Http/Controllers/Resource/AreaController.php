<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AreaController extends Controller
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

        $query = Area::query();

        if (!empty($keyword)) {
            $query = $query->where("name", "like", "%" . $keyword . "%");
        }
        $query = $query->orderBy("created_at", "DESC");
        try {
            $skip = $perPage * ($page - 1);
            $response["totalAreas"] = $query->count();
            $response["totalPages"] = ceil($response["totalAreas"] / $perPage);
            $response["curentPage"] = (int)$page;
            $response["nextPage"] = $response["totalPages"] - $page <= 0 ? false : true;
            $response["prevPage"] = $page <= 1 ? false : true;
            $response["skip"] = $skip + 1;


            $response["areas"] = $query->skip($skip)->take($perPage)->get();

            if ($pageType == "adminAreas") {
                $this->formatAdminAreas($response["areas"], $response["skip"]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
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
        //
    }

    function formatAdminAreas($areas, $skip = 1)
    {
        foreach ($areas as $a) {
            $a->listNumber = $skip;
            $skip++;

            $a->created_at_formated = date("d.m.Y H:i", $a->created_at->timestamp);

            if ($a->created_at->timestamp == $a->updated_at->timestamp) {
                $a->updated_at_formated = null;
            } else {
                $a->updated_at_formated = date("d.m.Y H:i", $a->updated_at->timestamp);
            }
        }
    }
}
