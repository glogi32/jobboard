<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\TechnologyRequest;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TechnologyController extends Controller
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

        $query = Technology::query();

        if (!empty($keyword)) {
            $query = $query->where("name", "like", "%" . $keyword . "%");
        }
        $query = $query->orderBy("created_at", "DESC");
        try {
            $skip = $perPage * ($page - 1);
            $response["totalTechs"] = $query->count();
            $response["totalPages"] = ceil($response["totalTechs"] / $perPage);
            $response["curentPage"] = (int)$page;
            $response["nextPage"] = $response["totalPages"] - $page <= 0 ? false : true;
            $response["prevPage"] = $page <= 1 ? false : true;
            $response["skip"] = $skip + 1;


            $response["techs"] = $query->skip($skip)->take($perPage)->get();

            if ($pageType == "adminTechs") {
                $this->formatAdminTechs($response["techs"], $response["skip"]);
            }

            return response(["data" => $response], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response(["message" => "Server error, try again later."], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TechnologyRequest $request)
    {
        $tech = new Technology();
        $tech->name = $request->input('name');

        try {
            $tech->save();
            return redirect()->back()->with("success", ["title" => "Success: ", "message" => "Technology successfully added."]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with("error", ["title" => "Error: ", "message" => "Server error, try again later"]);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tech = Technology::find($id);
        try {
            if (!$tech) {
                return response(["message" => "Technology not found"], 404);
            }
            $tech->delete();
            return response(["message" => "Technology successfully deleted"], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response(["message" => "Server error on deleteing technology"], 500);
        }
    }

    function formatAdminTechs($techs, $skip = 1)
    {
        foreach ($techs as $t) {
            $t->listNumber = $skip;
            $skip++;

            $t->created_at_formated = date("d.m.Y H:i", $t->created_at->timestamp);

            if ($t->created_at->timestamp == $t->updated_at->timestamp) {
                $t->updated_at_formated = null;
            } else {
                $t->updated_at_formated = date("d.m.Y H:i", $t->updated_at->timestamp);
            }
        }
    }
}
