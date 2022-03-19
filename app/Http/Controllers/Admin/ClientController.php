<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Traits\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    use File;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('clients.index');
        $clients = Client::paginate(6);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('clients.create');
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->authorize('clients.create');
        $validator = Validator::make($request->all(), [
            'photo' => 'required|mimes:jpeg,jpg,png,gif,webp',
        ], [
            'photo.required' => 'الصورة مطلوبة',
            'photo.mimes' => 'يجب على الحقل ان يكون صورة',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all())->with('error', 'يوجد خطأ ما');
        }
        $creation['photo'] = $this->uploadFile($request, $this->clientsPath, 'photo');
        Client::create($creation);
        return redirect()->back()->with('success', 'تم انشاء العميل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $this->authorize('clients.destroy');
        if(file_exists($client->photo)) {
            $img = last(explode('/', $client->photo));
            if(in_array($img, scandir(dirname($client->photo)))) {
                unlink($client->photo);
            }
        }
        Client::destroy($client->id);
        return redirect()->back()->with('success', 'تمت الأزالة بنجاح');
    }
}
