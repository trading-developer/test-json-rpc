<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @var $page string|null
     *
     */
    public function index(string $category = null)
    {
        $data = $this->client->send('viewPage', [
            'url' => request()->url(),
            'date' => time(),
        ]);

        if (empty($data['result'])) {
            abort(404);
        }

        if (isset($data['error'])) {
            return Redirect::back()->withErrors($data['error']);
        }

        return view($category ? 'category' : 'home', compact('category'));
    }
}
