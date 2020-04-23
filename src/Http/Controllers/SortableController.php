<?php

namespace Nh\Sortable\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SortableController extends Controller
{
    /**
     * Invoke the sortable controller.
     * @param  Request $request
     * @return json
     */
    public function __invoke(Request $request)
    {

        // Get parameters
        $model  = $request['model'];
        $ids    = $request['ids'];

        // Abort if no model
        if(empty($model) || !class_exists($model))
        {
            return response()->json(['message' => __('sortable::sortable.errors.model')], 500);
        }

        // Abort if no ids
        if(empty($ids))
        {
            return response()->json(['message' => __('sortable::sortable.errors.id')], 500);
        }

        // Abort if model not sortable
        if(!in_array('Nh\Sortable\Traits\Sortable', class_uses($model)))
        {
            return response()->json(['message' => __('sortable::sortable.errors.not-sortable')], 500);
        }

        // Create a new model
        $model = new $model;

        // Update the positions
        $startOrder = 1;
        foreach ($ids as $id)
        {
            $model->where('id', $id)->update(['position' => $startOrder++]);
        }

        // Response
        $response = array('message' => __('sortable::sortable.success'));

        // Return
        return response()->json($response);
    }
}
