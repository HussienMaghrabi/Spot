<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\BadgesCategory;
use App\Models\Block_relation;
use App\Models\Follow_relation;
use App\Models\Friend_relation;
use App\Models\Item;
use App\Models\Level;
use App\Models\User;
use App\Models\User_gifts;
use App\Models\User_Item;
use App\Models\UserBadge;
use App\Models\userChargingLevel;
use App\Models\country;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Count;

class UpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = $this->auth();
        $data['user'] = User::where('id', $auth)->select(
            'id',
            'name',
            'email',
            'profile_pic as image',
            'curr_exp',
            'coins',
            'gems',
            'birth_date',
            'desc',
            'user_level',
            'gender',
            'country_id',
            'karizma_exp',
            'karizma_level',
            'created_at',
        )->first();
        $data['user']->date_joined = date('Y-m-d',strtotime($data['user']->created_at));
        $data['user']->country_name = $data['user']->country['name'];
//        $data['user']->required_exp =  Level::where('name',$data['user']->user_level)->pluck('points');
        $data['user']->required_exp = $data['user']->level['points'];
        $data['user']->images = UserImage::where('user_id',$auth)->pluck('image');
        $data['user']->Charge_Level = (!empty(userChargingLevel::where('user_id',$data['user']->id)->first()->user_level)) ? userChargingLevel::where('user_id',$data['user']->id)->first()->user_level : 0;
        unset($data['user']->created_at);
        unset($data['user']->level);
        unset($data['user']->country);

        return $this->successResponse($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProfile(Request $request)
    {
        $auth = $this->auth();
        $id = request('id');
        $data['user'] = User::where('id',$id)->select(
            'id',
            'name',
            'email',
            'gender',
            'desc',
            'profile_pic as image',
            'user_level',
            'karizma_level',
            'created_at',
            'country_id',
            'vip_role',
        )->first();
        $array = Follow_relation::where('user_1', $id)->pluck('user_2')->toArray();
        $count = count($array);
        $data['user']['following_count'] = $count;
        $array2 = Follow_relation::where('user_2', $id)->pluck('user_1')->toArray();
        $count2 = count($array2);
        $data['user']['followers_count'] = $count2;
        $array3 = Friend_relation::where('user_1', $auth)->where('user_2', $id)->where('is_added', 1)->pluck('id')->toArray();
        $array4 = Friend_relation::where('user_1', $id)->where('user_2', $auth)->where('is_added', 1)->pluck('id')->toArray();
        $check = count($array3) + count($array4);
        if($check != 0){
            $data['user']['isFriend'] = 1;
        }
        else{
            $data['user']['isFriend'] = 0;
        }

        $array5 = Block_relation::where('user_1', $auth)->where('user_2', $id)->pluck('id')->toArray();
        $block = count($array5);
        if($block == 0){
            $data['user']['isBlock'] = 0;
        }else{
            $data['user']['isBlock'] = 1;
        }

        $array6 = Follow_relation::where('user_1', $auth)->where('user_2', $id)->pluck('id')->toArray();
        $follow = count($array6);
        if($follow){
            $data['user']['isFollowed'] = 1;
        }else{
            $data['user']['isFollowed'] = 0;
        }


        return $this->successResponse(self::collectionUser($data['user']));
    }

    protected function collectionUser($collection)
    {
        return [
            'id' => $collection['id'],
            'name' => $collection['name'],
            'email' => $collection['email'],
            'gender' => $collection['gender'],
            'desc' => $collection['desc'],
            'image' => $collection['image'],
            'user_level' => $collection['user_level'],
            'karizma_level' => $collection['karizma_level'],
            'country_id' => (user::where('id',$collection['id'])->first()->vip->privileges['hide_country']) ? 'hide_country_name' : country::find($collection['country_id'])->name,
            'vip_role' => $collection['vip_role'],
            'following_count' => $collection['following_count'],
            'followers_count' => $collection['followers_count'],
            'isBlock' => $collection['isBlock'],
            'isFriend' => $collection['isFriend'],
            'isFollowed' => $collection['isFollowed'],
            'date_joined' => date('Y-m-d',strtotime($collection['created_at'])),
            'images' => UserImage::take(5)->where('user_id',$collection['id'])->pluck('image'),
            'Charge_Level' => (!empty(userChargingLevel::where('user_id',$collection['id'])->first()->user_level)) ? userChargingLevel::where('user_id',$collection['id'])->first()->user_level : 0,
        ];
    }

    public function updateProfileImage(Request $request)
    {
        $auth = $this->auth();
        $item = User::find($auth);
        if ($request->profile_pic)
        {

            if (strpos($item->profile_pic, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $item->profile_pic);
                Storage::disk('public')->delete($image);
            }
            $input['profile_pic'] = $this->uploadFile($request->profile_pic, 'users'.$auth);
        }
        $item->update($input);
        return $this->responseUser($request);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->lang();
        $auth = $this->auth();
        $rules =  [
            'name'    => 'required',
            'gender'  => 'required',
            'country_id' => 'required',
            'desc'    => 'required',
            'profile_pic'  => 'nullable',
            'images.*'    => 'nullable|image',
            'images' => 'max:5',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) return $this->errorResponse($errors);

        $input = request()->except('profile_pic','images','completed','remove_images');

        $item = User::find($auth);




        if (request('profile_pic'))
        {

            if (strpos($item->profile_pic, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $item->profile_pic);
                Storage::disk('public')->delete($image);
            }
            $input['profile_pic'] = $this->uploadFile(request('profile_pic'), 'users'.$auth);
        }

        if(request('remove_images') == 1){
            $images = UserImage::where('user_id',$auth)->orderBy('id')->get();
            foreach ($images as $img){
                if (strpos($img->image, '/uploads/') !== false) {
                    $image = str_replace( asset('').'storage/', '', $img->image);
                    Storage::disk('public')->delete($img);
                }
                UserImage::where('id',$img->id)->delete();
            }
            if ($request->hasFile('images')) {
                $userImgCount = UserImage::where('user_id', $auth)->count();
                $requestImgCount = count(request('images'));
                $count = $userImgCount + $requestImgCount;

                if ($count <= 5) {

                    $images = $request->file('images');
                    foreach ($images as $image) {
                        UserImage::create([
                            'image' => $this->uploadFile($image, 'users' . $auth),
                            'user_id' => $item->id
                        ]);
                    }
                } else {

                    $images = UserImage::where('user_id',$auth)->orderBy('id')->get();
                    foreach ($images as $img){
                        if (strpos($img->image, '/uploads/') !== false) {
                            $image = str_replace( asset('').'storage/', '', $img->image);
                            Storage::disk('public')->delete($img);
                        }
                        UserImage::where('id',$img->id)->delete();
                    }
                    $data = $request->file('images');
                    foreach ($data as $im) {
                        UserImage::create([
                            'image' => $this->uploadFile($im, 'users' . $auth),
                            'user_id' => $item->id
                        ]);
                    }
                }
            }
        }else{
            if ($request->hasFile('images')) {
                $userImgCount = UserImage::where('user_id', $auth)->count();
                $requestImgCount = count(request('images'));
                $count = $userImgCount + $requestImgCount;

                if ($count <= 5) {

                    $images = $request->file('images');
                    foreach ($images as $image) {
                        UserImage::create([
                            'image' => $this->uploadFile($image, 'users' . $auth),
                            'user_id' => $item->id
                        ]);
                    }
                } else {

                    $images = UserImage::where('user_id',$auth)->orderBy('id')->get();
                    foreach ($images as $img){
                        if (strpos($img->image, '/uploads/') !== false) {
                            $image = str_replace( asset('').'storage/', '', $img->image);
                            Storage::disk('public')->delete($img);
                        }
                        UserImage::where('id',$img->id)->delete();
                    }
                    $data = $request->file('images');
                    foreach ($data as $im) {
                        UserImage::create([
                            'image' => $this->uploadFile($im, 'users' . $auth),
                            'user_id' => $item->id
                        ]);
                    }
                }
            }
        }


        $item->update($input);

        $this->CompletedCheck();

        return $this->responseUser($request);
    }

    public function responseUser(Request $request)
    {
        $auth = $this->auth();
        $user = User::where('id', $auth)->first();
        $item = new UserResource($user);
        return $this->successResponse($item, __('api.ProfileUpdated'));
    }

    public function CompletedCheck()
    {
        $auth = $this->auth();
        $user = User::where('id', $auth)
            ->where('name',"!=",null)
            ->where('birth_date',"!=",null)
            ->where('desc',"!=",null)
            ->where('gender',"!=",null)
            ->where('country_id',"!=",null)
            ->where('profile_pic',"!=",null)
            ->first();

        if ($user){
            $user->update(['completed'=>1]);
        }
    }


    public function userBadge()
    {
        $lang = $this->lang();
        $auth = $this->auth();
        if($auth){
            $data['user'] = UserBadge::where('user_id',$auth)->select('id','badge_id')->get();
            $data['user']->map(function ($item)  use ($lang)  {
                $item->badge_name = $item->badge->name;
                $item->image = $item->badge->img_link;
                $item->description = $item->badge->description;
                $item->Category_id = $item->badge->badgeCategory_id;
                $item->Category_name = $item->badge->category["name_$lang"];

                unset($item->badge);
                unset($item->badge_id);

            });

            $array[] = null;
            $it = 0;
            $sql = BadgesCategory::all();
            foreach ($sql as $cat){
                $array[$it] = $cat["name_$lang"];  // based on lang Done
                $it++;
            }
            $finalData = [];
            foreach ($array as $cat){
                $list = [];
                $it = 0;
                foreach ($data['user'] as $user_badge){
                    if($user_badge->Category_name === $cat){
                        array_push($list,$user_badge);
                    }
                    $it++;
                }
                $finalData[$cat] = $list;
            }

            return $this->successResponse($finalData);
        }else{
            return $this->errorResponse(__('api.Authorization'));
        }


    }

    public function wearBadge(Request $request){
        $auth = $this->auth();
        if($request->has('old_badge')){
            $oldBadgeId = $request->input('old_badge');
            $oldBadge = UserBadge::where('id',$oldBadgeId)->where('user_id',$auth)->first();
            if($oldBadge != null){
                UserBadge::where('id',$oldBadgeId)->where('user_id',$auth)->update(['active'=>0]);
            }
        }
        if($request->has('badge_id')){
            $userBadge_id = $request->input('badge_id');
            $mainBadge = UserBadge::where('id', $userBadge_id)->where('user_id', $auth)->first();
            if($mainBadge === null){
                $message = __('api.notUserBadge');
                return $this->errorResponse($message, []);
            }
            $mainBadgeCat = $mainBadge->badge->category_id;
            $query = UserBadge::where('user_id', $auth)->get();
            $check = 0;
            foreach ($query as $record){
                if($record->id == $userBadge_id){
                    $check = 1;
                    break;
                }
            }
            if($check === null){
                $message = __('api.notUserBadge');
                return $this->errorResponse($message, []);
            }
            else{
                $activeCount = 0;
                foreach ($query as $record){
                    if($record->active == 1){
                        $activeCount++;
                    }
                }
                if($activeCount >= 3){
                    $message = __('api.userBadgeLimit');
                    return $this->errorResponse($message, []);
                }
                else{
                    $catCheck = 0;
                    foreach ($query as $record){

                        if(($record->badge->category_id == $mainBadgeCat) && ($record->active == 1)){
                            $catCheck = 1;
                            break;
                        }
                    }
                    if($catCheck == 1){
                        $message = __('api.userBadgeCatLimit');
                        return $this->errorResponse($message, []);
                    }
                    else{
                        $sql = UserBadge::where('id', $userBadge_id)->update(['active'=>1]);
                        $message = __('api.success');
                        $query = UserBadge::where('user_id', $auth)->where('active', 1)->get();
                        $query->map(function($item){
                            $item->badge_name = $item->badge->name;
                            $item->image = $item->badge->img_link;

                            unset($item->badge);
                            unset($item->badge_id);
                            unset($item->created_at);
                            unset($item->updated_at);
                            unset($item->active);
                        });
                        return $this->successResponse($query, $message);
                    }
                }
            }
        }
        else{
            $message = __('api.noBadge');
            return $this->errorResponse($message, []);
        }
    }
    public function deactivateBadge(Request $request){
        $auth = $this->auth();
        if($request->has('badge_id')){
            $userBadge_id = $request->input('badge_id');
            $mainBadge = UserBadge::where('id', $userBadge_id)->where('user_id', $auth)->first();
            if($mainBadge === null){
                $message = __('api.notUserBadge');
                return $this->errorResponse($message, []);
            }
            else{
                UserBadge::where('id', $userBadge_id)->where('user_id', $auth)->update(['active'=>0]);
                $query = UserBadge::where('user_id', $auth)->where('active', 1)->get();
                $query->map(function($item){
                    $item->badge_name = $item->badge->name;
                    $item->image = $item->badge->img_link;

                    unset($item->badge);
                    unset($item->badge_id);
                    unset($item->created_at);
                    unset($item->updated_at);
                    unset($item->active);
                });
                $message = __('api.success');
                return $this->successResponse($query, $message);
            }
        }
        else{
        $message = __('api.noBadge');
        return $this->errorResponse($message, []);
}

    }
    public function getWearedBadges(){
        $auth = $this->auth();
        $query = UserBadge::where('user_id', $auth)->where('active', 1)->first();
        if($query === null){
            $message = __('api.noBadges');
            return $this->errorResponse($message, []);
        }
        else{
            $query = UserBadge::where('user_id', $auth)->where('active', 1)->get();
            $query->map(function($item){
                $item->badge_name = $item->badge->name;
                $item->image = $item->badge->img_link;

                unset($item->badge);
                unset($item->badge_id);
                unset($item->created_at);
                unset($item->updated_at);
                unset($item->active);
            });
            $message = __('api.success');
            return $this->successResponse($query, $message);
        }
    }

    public function changePassword()
    {
        $auth = $this->auth();
        $rules = [
            'password' => 'required',
            'new_password' => 'required'
        ];



        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        if($auth){
            $pass = User::where('id', $auth)->first();

            if (Hash::check(request('password'), $pass->password)) {

                $pass->update(['password' => request('new_password')]);
                return $this->successResponse(null, __('api.PasswordReset'));
            }
            return $this->errorResponse(__('api.PasswordInvalid'));
        }else{
            return $this->errorResponse(__('api.Unauthorized'));
        }
    }

    public function getProfileItemsGifts(Request $request){
        if($request->has('user_id')){
            $target_id = $request->input('user_id');
            $user = User::where('id', $target_id)->get();
            if($user === null){
                $message = __('api.userNotFound');
                return $this->errorResponse($message, []);
            }else{
                $data['gifts'] = User_gifts::where('receiver_id', $target_id)->select('id','gift_id', 'amount', 'receiver_id')->groupBy('gift_id')->get();
                if (count($data) != 0){
                    $data['gifts']->map(function ($item) use($target_id) {
                        $item->gift_id = $item->gifts->id;
                        $item->total_habd =  $item->where('receiver_id', $target_id)->select(DB::raw('sum(amount) as total'))->where('gift_id', $item->gift_id)->groupBy('gift_id')->get();
                        $item->total = $item->total_habd[0]['total'];
                        $item->name = $item->gifts->name;
                        $item->image = $item->gifts->img_link;

                        unset($item->gifts);
                        unset($item->amount);
                        unset($item->total_habd);
                    });
                }

                $items = Item::where('cat_id',2)->orWhere('cat_id',3)->pluck('id')->toArray();
                $data['items'] =  User_Item::where('user_id',$target_id)->whereIn('item_id',$items)->select('id','item_id','is_activated','time_of_exp')->get();
                $data['items']->map(function ($user){
                    $user->item_name = $user->item->name;
                    $user->image = $user->item->img_link;
                    $user->price = $user->item->price;
                    unset($user->item);
                    unset($user->item_id);
                });

                $data['active_bades'] = UserBadge::where('user_id', $target_id)->where('active', 1)->get();
                $data['active_bades']->map(function($item){
                    $item->badge_name = $item->badge->name;
                    $item->image = $item->badge->img_link;

                    unset($item->badge);
                    unset($item->badge_id);
                    unset($item->created_at);
                    unset($item->updated_at);
                    unset($item->active);
                });

                $data['badges'] = UserBadge::where('user_id',$target_id)->select('id','badge_id')->get();
                $data['badges']->map(function ($item)  {
                    $item->badge_name = $item->badge->name;
                    $item->image = $item->badge->img_link;
                    $item->description = $item->badge->description;
                    $item->Category_id = $item->badge->badgeCategory_id;

                    unset($item->badge);
                    unset($item->badge_id);

                });

                $message = __('api.success');
                return $this->successResponse($data,$message);
            }
        }
        else{
            $message = __('api.noUser');
            return $this->errorResponse($message, []);
        }
    }
}
