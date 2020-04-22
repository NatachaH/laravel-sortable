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
        $model = new $request['model'];
        $ids = $request['ids'];

        // Return if no model
        if(empty($model))
        {
            return response()->json(array(
                'status' => 'error',
                'message' => __('sortable::sortable.errors.model')
            ));
        }

        // Return if no ids
        if(empty($ids))
        {
            return response()->json(array(
                'status' => 'error',
                'message' => __('sortable::sortable.errors.id')
            ));
        }

        // Update the positions
        $startOrder = 1;
        foreach ($ids as $id)
        {
            $model->where('id', $id)->update(['position' => $startOrder++]);
        }

        // Response
        $response = array(
            'status'  => 'success',
            'message' => __('sortable::sortable.success')
        );

        // Return
        return response()->json($response);
    }
}
