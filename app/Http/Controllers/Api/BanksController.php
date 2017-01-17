<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BanksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$limit = $request->all()['limit'] ?? 15;

		$order = $request->all()['order'] ?? null;

		if (!empty($oder)) {
			$order = explode(',', $order);
		}

		$order[0] = $order[0] ?? 'id';
		$order[1] = $order[1] ?? 'asc';

		$where = $request->all()['where'] ?? [];

		$like = $request->all()['like'] ?? [];

		if ($like) {
			$like = explode(',', $like);
			$like[1] = '%' . $like[1] . '%';
		}

        $result = \App\Bank::orderBy($order[0], $order[1])
		->where(function($query) use ($like) {
			if ($like) {
				return $query->where($like[0], 'like', $like[1]);
			}

			return $query;
		})
		->where($where)
		->paginate($limit);

		return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$result = \App\Bank::create($request->all());
        return response()->json(['status' => $result]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = \App\Bank::findOrFail($id);
		return response()->json($result);
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
        $result = \App\Bank::findOrFail($id);
		$result->update($request->all());
		return response()->json($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$result = \App\Bank::findOrFail($id);
		$result->delete();
		return response()->json($result);
    }
}
