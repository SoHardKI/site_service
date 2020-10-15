<?php

namespace App\Http\Controllers;

use App\Http\Services\DataApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    /**
     * @var DataApiService
     */
    private $service;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->service = new DataApiService();
    }

    /**
     * @param string $method
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $method = $request->get('method');
        if(!$method) {
            $method = 'getData';
        }

        return view('main.index', compact('method'));
    }

    /**
     * @param Request $request
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function showData(Request $request)
    {
        if($request->has('search')) {
            $page_uid = $request->get('search')['value'] ? $request->get('search')['value'] : '';

            return $this->service->getData($page_uid, $request->get('draw'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createUser(Request $request)
    {
        $validator = Validator::make(
            $request->input(),
            [
                'first_name' => 'required|string|min:1',
                'second_name' => 'required|string|min:1',
                'email' => 'required|email',
                'page_uid' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator->getMessageBag()->getMessages());
        }

        $this->service->createUser($request->input());

        return redirect()->route('main.index');
    }
}
