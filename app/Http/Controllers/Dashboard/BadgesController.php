<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Badge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BadgesController extends Controller
{
    private $resources = 'badges';
    private $resource = [
        'route' => 'admin.badges',
        'view' => "badges",
        'icon' => "id-badge",
        'title' => "BADGES",
        'action' => "",
        'model' => "Badges",
        'header' => "Badges"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Badge::where('hidden',1)->paginate(6);
        $resource = $this->resource;
        return view('dashboard.views.'.$this->resources.'.index',compact('data', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resource = $this->resource;
        $resource['action'] = 'Create';
        return view('dashboard.views.'.$this->resources.'.create',compact( 'resource'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $lang)
    {
        $rules =  [
            'name' => 'required',
            'img_link' => 'required|mimes:jpeg,jpg,png,gif',
            'amount' => 'required',
            'description' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $inputs = $request->except('image');
        if ($request->image)
        {
            $inputs['img_link'] =$this->uploadFile($request->img_link, 'badges');
        }
        $inputs['category_id'] = 2;
        $inputs['badgeCategory_id'] =3;
        $inputs['charge_badge'] =0;
        $inputs['hidden'] =1;


        Badge::create($inputs);

        App::setLocale($lang);
        flashy(__('dashboard.created'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id)
    {
        $resource = $this->resource;
        $resource['action'] = 'Edit';
        $item = Badge::findOrFail($id);
        return view('dashboard.views.' .$this->resources. '.edit', compact('item', 'resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $id)
    {
        $rules =  [
            'name' => 'required',
            'img_link' => 'nullable',
            'amount' => 'required',
            'description' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $item = Badge::find($id);
        $inputs = $request->except('img_link');
        if ($request->img_link)
        {

            if (strpos($item->img_link, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $item->img_link);
                Storage::disk('public')->delete($image);
            }
            $inputs['img_link'] = $this->uploadFile($request->img_link, 'badge'.$id);
        }

        $item->update($inputs);

        App::setLocale($lang);
        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {
        $item = Badge::findOrFail($id);
        if (strpos($item->img_link, '/uploads/') !== false) {
            $image = str_replace( asset('').'storage/', '', $item->img_link);
            Storage::disk('public')->delete($image);
        }
        $item->delete();

        App::setLocale($lang);
        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function multiDelete($lang)
    {
        App::setLocale($lang);
        foreach (\request('checked') as $id)
        {
            $item = Badge::findOrFail($id);
            if (strpos($item->img_link, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $item->img_link);
                Storage::disk('public')->delete($image);
            }
            $item->delete();
        }

        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function search(Request $request,$lang)
    {
        App::setLocale($lang);
        $resource = $this->resource;
        $data = Badge::where('hidden',1)->where('name', 'LIKE', '%'.$request->text.'%')->paginate(10);
        return view('dashboard.views.' .$this->resources. '.index', compact('data', 'resource'));
    }

}
