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
        $order  = $request['order'];

        // Abort if no model or if model doesn't exist
        if(empty($model) || !class_exists($model))
        {
            return response()->json(['message' => __('sortable::sortable.errors.model')], 500);
        }

        // Abort if no ids
        if(empty($ids))
        {
            return response()->json(['message' => __('sortable::sortable.errors.id')], 500);
        }

        // Abort if model is not sortable
        if(!in_array('Nh\Sortable\Traits\Sortable', class_uses($model)))
        {
            return response()->json(['message' => __('sortable::sortable.errors.not-sortable')], 500);
        }

        // If no order set, default is asc
        if(empty($order) || !in_array($order,['asc','desc']))
        {
            $order = 'asc';
        }

        // Create a new model
        $model = new $model;

        // Update the positions
        if($order == 'asc')
        {
            $startOrder = 1;
            foreach ($ids as $id)
            {
                $model->where('id', $id)->update(['position' => $startOrder++]);
            }
        } else {
            $startOrder = count($ids);
            foreach ($ids as $id)
            {
                $model->where('id', $id)->update(['position' => $startOrder--]);
            }
        }


        // Success response
        $response = array('message' => __('sortable::sortable.success'));

        // Return
        return response()->json($response);
    }
}
