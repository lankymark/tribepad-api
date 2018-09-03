<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReferencesAPIRequest extends FormRequest
{
    private $_trustedProxies = [
        '127.0.0.1',
        '10.0.2.2'
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        // Check if the
        $clientServer = $request::ip();
        if (!in_array($clientServer, $this->_trustedProxies)) {
            return false;
        }

        $contentType = $request->server->get('CONTENT_TYPE');
        if ($contentType !== "application/json") {
            return false;
        }

        $contentLength = $request->server->get('CONTENT_LENGTH');
        if ($contentLength > 1000) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            // Check that the reference exists
            'reference'     => 'required|max:255',
            // Check that email is valid
            'email'         => 'required|email',
            // Check that providers is an array
            'providers'     => 'required|array'
        ];

        $providers = $this->request->get('providers');
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
}
