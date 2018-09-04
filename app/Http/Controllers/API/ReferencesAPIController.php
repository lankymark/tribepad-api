<?php

namespace App\Http\Controllers\API;

use App\APIReferences;
use App\APIReferencesProvider;
use App\APIReferencesProviderHistory;
use App\Http\Requests\ReferencesAPIRequest;
use App\Http\Resources\ReferencesAPIProvidersResource;
use App\Http\Resources\ReferencesAPIResource;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ReferencesAPIController extends Controller
{
    private function _APIReferenceProviders($reference, $providers) {
        foreach ($providers as $key => $row) {
            $provider = APIReferencesProvider::where(['reference' => $reference, 'provider' => $key])->first();
            if (empty($provider)) {
                $save = new APIReferencesProvider;

                $save->reference = $reference;
                $save->provider = $key;
            } else {
                if ($provider->status == $row['status']
                    && $provider->score == $row['score']
                    && $provider->failed == $row['failed']) {
                    continue;
                }

                $save = APIReferencesProvider::find($provider->id);
            }

            $history = new APIReferencesProviderHistory;

            $save->status = $history->status = $row['status'];
            $save->score = $history->score = $row['score'];
            $save->failed = $history->failed = $row['failed'];

            $save->save();

            $history->provider_id = $save->id;
            $history->save();
        }
    }

    private function _InsertAPIReference($request)
    {
        $reference = new APIReferences;

        $reference->reference = $request->request->get('reference');
        $reference->email = $request->request->get('email');

        $reference->save();
    }

    private function _rules($request)
    {
        $rules = [
            // Check that the reference exists
            'reference'     => 'required|max:255',
            // Check that email is valid
            'email'         => 'required|email',
            // Check that providers is an array
            'providers'     => 'required|array'
        ];

        $providers = $request->get('providers');
        if (!empty($providers)) {
            foreach ($providers as $key => $row) {
                // Check that the provider isn't too long
                $rules['providers.'.$key] = 'required|max:255';
                $rules['providers.'.$key.'.status'] = [
                    'required',
                    Rule::in('passed', 'failed', 'pending')
                ];
                $rules['providers.'.$key.'.score'] = 'required|numeric|between:0,50';
                $rules['providers.'.$key.'.failed'] = 'required';
            }
        }

        return $rules;
    }

    private function _UpdateAPIReference($update, $request) {
        $update->email = $request->request->get('email');
        $update->save();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($email=false)
    {
        // Get all references
        if ($email) {
            $references = APIReferences::where('email', 'like', '%'.$email.'%')->orderBy('updated_at','DESC')->paginate(5);
        } else {
            $references = APIReferences::orderBy('updated_at','DESC')->paginate(5);
        }

        return ReferencesAPIResource::collection($references);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function providers($id)
    {
        // Get all references
        $providers = APIReferencesProvider::where('reference', $id)->orderBy('updated_at','DESC')->get();

        return ReferencesAPIProvidersResource::collection($providers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReferencesAPIRequest $request)
    {
        $request->authorize($request);
        $validator = Validator::make($request->all(), $this->_Rules($request));
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $reference = $request->request->get('reference');
        $providers = $request->request->get('providers');
        $update = APIReferences::find($reference);
        if (empty($update)) {
            $this->_InsertAPIReference($request);
        } else {
            $this->_UpdateAPIReference($update, $request);
        }

        if (!empty($providers)) {
            $this->_APIReferenceProviders($reference, $providers);
        }

        return response()->json(['Success' => 1, 'Message' => 'Reference Stored: '.$reference]);
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
        $reference = APIReferences::findOrFail($id);

        return response()->json(new ReferencesAPIResource($reference));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $providers = APIReferencesProvider::where('reference', $id)->get();
        if (!empty($providers)) {
            foreach ($providers as $row) {
                APIReferencesProviderHistory::where('provider_id', $row['id'])->delete();
                APIReferencesProvider::destroy($row['id']);
            }
        }

        APIReferences::destroy($id);

        return response()->json(['Success' => 1]);
    }
}
