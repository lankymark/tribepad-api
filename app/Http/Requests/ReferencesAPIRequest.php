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
        return [];
    }
}
