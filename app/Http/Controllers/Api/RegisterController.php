<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\PushNotification;
use App\User;
use Validator;
use DB;
use JWTAuth;

class RegisterController extends Controller {
    public $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function checkCustomer(Request $request){
        $validation = Validator::make($request->all(),[
            'email'=>'required|max:191|unique:users',
            'phone'=>'required|unique:users'
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }

        return successMsgResponse('Success');
    }
    
    public function customerStore(Request $request){
        $validation = Validator::make($request->all(),[
            'first_name'=>'required|max:191',
            'last_name'=>'required|max:191',
            'email'=>'required|max:191|unique:users',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',
            'phone'=>'required|unique:users',
            'dob'=>'required',
            'state'=>'required',
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }
        
        DB::beginTransaction();
        try {
            $user = new $this->user;
            $user->name = $request->first_name.' '.$request->last_name;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->phone = $request->phone;
            $user->state = $request->state ?? null;
            $user->dob = dbDateFormat($request->dob);
            $user->status = config('constant.status.active');
            $user->first_step = '1';
            $user->save();
            $customerRole = Role::where('name', 'CUSTOMER')->first();
            $user->roles()->attach($customerRole);
            $token = JWTAuth::fromUser($user);
            DB::commit();
            
            return dataResponse(['user' => $user->id,'access_token'=>$token]);
        } catch (\Exception $e) {
            DB::rollback();
            return errorMsgResponse($e->getMessage());
        }
    }

    public function secondStepStore(Request $request){
        $validation = Validator::make($request->all(),[
            'user_id'=>'required',
            'gender'=>'required|max:10',
            'height_feet'=>'required',
            'height_inch'=>'required',
            'current_weight'=>'required',
            'goal_weight'=>'required',
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }
        
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            if (empty($user)) {
                return errorMsgResponse('User Not Found.');
            }
            $user->gender = $request->gender;
            $user->height_feet = $request->height_feet ?? 5;
            $user->height_inch = $request->height_inch ?? 0;            
            $user->current_weight = $request->current_weight ?? 65;
            $user->today_current_weight = $request->current_weight ?? 65;            
            $user->goal_weight = $request->goal_weight ?? 60;
            $user->second_step = '1';
            $user->save();
        
            DB::commit();
            
            return dataResponse(['user' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return errorMsgResponse($e->getMessage());
        }
    }

    public function thirdStepStore(Request $request){
        $validation = Validator::make($request->all(),[
            'user_id'=>'required',
            'waist_measurement'=>'required',
            'goal_waist_measurement'=>'required',
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }
        
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            if (empty($user)) {
                return errorMsgResponse('User Not Found.');
            }

            $user->waist_measurement = $request->waist_measurement ?? 32;
            $user->goal_waist_measurement = $request->goal_waist_measurement ?? 30;
            $user->today_waist_measurement = $request->waist_measurement ?? 32;
            $user->third_step = '1';            
            $user->save();
        
            DB::commit();
            
            return dataResponse(['user' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return errorMsgResponse($e->getMessage());
        }
    }

    public function fourStepStore(Request $request){
        $validation = Validator::make($request->all(),[
            'user_id'=>'required',
            // 'current_status'=>'required'
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }
        
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            if (empty($user)) {
                return errorMsgResponse('User Not Found.');
            }
            if (isset($request->current_status) && count($request->current_status) > 0) {
                $user->current_status = implode(',', $request->current_status);
            }
            // $user->current_status = $request->current_status ?? null;
            $user->four_step = '1';
            $user->save();
        
            DB::commit();
            
            return dataResponse(['user' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return errorMsgResponse($e->getMessage());
        }
    }

    public function fiveStepStore(Request $request){
        $validation = Validator::make($request->all(),[
            'user_id'=>'required',
            // 'health_concerns' => 'required|array',
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }
        
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            if (empty($user)) {
                return errorMsgResponse('User Not Found.');
            }
            
            if (isset($request->health_concerns) && count($request->health_concerns) > 0) {
                $user->health_concerns = implode(',', $request->health_concerns);
            }

            $user->five_step = '1';
            $user->save();
        
            DB::commit();
            
            return dataResponse(['user' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return errorMsgResponse($e->getMessage());
        }
    }

    public function sixStepStore(Request $request){
        $validation = Validator::make($request->all(),[
            'user_id'=>'required',
            'current_motivation' => 'required',
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }
        
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            if (empty($user)) {
                return errorMsgResponse('User Not Found.');
            }
            
            $user->current_motivation = $request->current_motivation ?? null;
            $user->six_step = '1';
            $user->save();
        
            DB::commit();
            
            return dataResponse(['user' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return errorMsgResponse($e->getMessage());
        }
    }

    public function sevenStepStore(Request $request){
        $validation = Validator::make($request->all(),[
            'user_id'=>'required',
            // 'past_diet' => 'required|array',
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }
        
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            if (empty($user)) {
                return errorMsgResponse('User Not Found.');
            }
            
            if (isset($request->past_diet) && count($request->past_diet) > 0) {
                $user->past_diet = implode(',', $request->past_diet);
            }
            $user->seven_step = '1';
            $user->save();
        
            DB::commit();
            
            return dataResponse(['user' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return errorMsgResponse($e->getMessage());
        }
    }

    public function eightStepStore(Request $request){
        $validation = Validator::make($request->all(),[
            'user_id'=>'required',
            // 'past_program' => 'required|array',
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }
        
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            if (empty($user)) {
                return errorMsgResponse('User Not Found.');
            }
            
            if (isset($request->past_program) && count($request->past_program) > 0) {
                $user->past_program = implode(',', $request->past_program);
            }
            $user->eight_step = '1';
            $user->save();
        
            DB::commit();
            
            return dataResponse(['user' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return errorMsgResponse($e->getMessage());
        }
    }

    public function nineStepStore(Request $request){
        $validation = Validator::make($request->all(),[
            'user_id'=>'required',
            // 'personal_need' => 'required|array',
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }
        
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            if (empty($user)) {
                return errorMsgResponse('User Not Found.');
            }
            
            // if (isset($request->personal_need) && count($request->personal_need) > 0) {
            //     $user->personal_need = implode(',', $request->personal_need);
            // }
            $user->personal_need = $request->personal_need;
            $user->nine_step = '1';
            $user->save();
        
            DB::commit();
            
            return dataResponse(['user' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return errorMsgResponse($e->getMessage());
        }
    }

    public function tenStepStore(Request $request){
        $validation = Validator::make($request->all(),[
            'user_id'=>'required',
            // 'metabolism' => 'required',
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }
        
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            if (empty($user)) {
                return errorMsgResponse('User Not Found.');
            }
            
            $user->metabolism = $request->metabolism ?? null;
            $user->ten_step = '1';
            $user->save();
        
            DB::commit();
            
            return dataResponse(['user' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return errorMsgResponse($e->getMessage());
        }
    }

    public function elevenStepStore(Request $request){
        $validation = Validator::make($request->all(),[
            'user_id'=>'required',
            // 'important' => 'required|array',
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }
        
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            if (empty($user)) {
                return errorMsgResponse('User Not Found.');
            }
            
            $i = 0;
            if (isset($request->important) && count($request->important) > 0) {
                $user->important = implode(',', $request->important);
                $i = count($request->important);
            }
            $user->eleven_step = '1';
            $user->save();
        
            DB::commit();

            $rk = false;
            $needs = explode(',', $user->personal_need);
            if (!empty($user->current_status) && $user->current_motivation <= 7 && (in_array('Not important', $needs) || in_array('Not Important', $needs)) && $i == 0) {
                $rk = true;
            } /*else {
                $ids = [];
                $fcm_tokens = User::select('fcm_token')->where('status',config('constant.status.active'))->whereNotNull('fcm_token')->whereHas('roles',function($q){
                            $q->where('name',config('constant.role.admin'));
                        })->get();
                if($fcm_tokens->count() > 0){
                    foreach($fcm_tokens as $t){
                        array_push($ids,$t->fcm_token);
                    }
                }

                if(count($ids)>0){
                    $data = [
                        'registration_ids'=>$ids,
                        'notification'=>[
                            'title'=>"User Qualifying",
                            'body'=> $user->name.' is Qualifying the step.',
                            'mutable_content'=>false,
                            'sound'=>'Tri-tone',
                            'badge'=> 1
                        ],                    
                        
                    ];
                    $res_notify = pushNotification($data);
                }
            }*/
            
            return dataResponse(['user' => $user->id , 'retake' => $rk]);
        } catch (\Exception $e) {
            DB::rollback();
            return errorMsgResponse($e->getMessage());
        }
    }

    public function store(Request $request){
        $validation = Validator::make($request->all(),[
            'first_name'=>'required|max:191',
            'last_name'=>'required|max:191',
            'email'=>'required|max:191|unique:users',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',
            'phone'=>'required',
            'gender'=>'required|max:10',
            'dob'=>'required',
            'height_feet'=>'required',
            'waist_measurement'=>'required',
            'goal_waist_measurement'=>'required',
            'current_weight'=>'required',
            'goal_weight'=>'required',
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }

        if($request->current_weight == $request->goal_weight){
            return errorMsgResponse('Current weight and Goal weight not be same.');
        }

        DB::beginTransaction();
        try {
            $user = new $this->user;
            $user->name = $request->first_name.' '.$request->last_name;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->dob = dbDateFormat($request->dob);
            $user->height_feet = $request->height_feet ?? 5;
            $user->height_inch = $request->height_inch ?? 0;
            $user->waist_measurement = $request->waist_measurement ?? 32;
            $user->goal_waist_measurement = $request->goal_waist_measurement ?? 30;
            $user->today_waist_measurement = $request->waist_measurement ?? 32;
            $user->current_weight = $request->current_weight ?? 65;
            $user->today_current_weight = $request->current_weight ?? 65;
            $user->goal_weight = $request->goal_weight ?? 60;
            $user->current_status = $request->current_status ?? null;
            $user->current_motivation = $request->current_motivation ?? null;
            $user->current_motivation = $request->current_motivation ?? null;
            $user->metabolism = $request->metabolism ?? null;
            $user->status = config('constant.status.active');
            if($request->hasFile('profile_image')){
                $path = 'uploads/profile';
                $user->profile_image = uploadImage($request,'profile_image',$path);
            }

            if($request->has('health_concerns') && $request->filled('health_concerns')){
                $user->health_concerns = implode(',', $request->health_concerns);
            }

            if($request->has('past_diet') && $request->filled('past_diet')){
                $user->past_diet = implode(',', $request->past_diet);    
            }

            if($request->has('past_program') && $request->filled('past_program')){
                $user->past_program = implode(',', $request->past_program);
            }

            if($request->has('personal_need') && $request->filled('personal_need')){
                $user->personal_need = implode(',', $request->personal_need);
            }

            if($request->has('important') && $request->filled('important')){
                $user->important = implode(',', $request->important);
            }

            $user->save();
            $customerRole = Role::where('name', 'CUSTOMER')->first();
            $user->roles()->attach($customerRole);
        
            DB::commit();
            
            return dataResponse(['user' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return errorMsgResponse($e->getMessage());
        }
    }
    

    /*public function createSquareCustomerCard(){
        $client = new SquareClient([
            'accessToken' => config('constant.squareAccessToken'),
            'environment' => config('constant.squareEnvironment'),
        ]);
        $cardsApi = $client->getCardsApi();
        $body_idempotencyKey = (string) Str::uuid();
        $body_sourceId = 'ccof:iRC9lPpmdkWEELfS4GB';
        $body_card = new \Square\Models\Card;
        $body_card->setId('id0');
        $body_card->setCardBrand(\Square\Models\CardBrand::INTERAC);
        $body_card->setLast4('0004');
        $body_card->setExpMonth(236);
        $body_card->setExpYear(60);
        $body_card->setCardholderName('Amelia Earhart');
        $body_card->setBillingAddress(new Address);
        $body_card->getBillingAddress()->setAddressLine1('500 Electric Ave');
        $body_card->getBillingAddress()->setAddressLine2('Suite 600');
        $body_card->getBillingAddress()->setAddressLine3('address_line_34');
        $body_card->getBillingAddress()->setLocality('New York');
        $body_card->getBillingAddress()->setSublocality('sublocality8');
        $body_card->getBillingAddress()->setAdministrativeDistrictLevel1('NY');
        $body_card->getBillingAddress()->setPostalCode('10003');
        $body_card->getBillingAddress()->setCountry(Country::US);
        $body_card->setCustomerId('Y571GMNBK8T6S8M39R0T85WZC4');
        $body_card->setReferenceId('user-id-1');
        $body = new \Square\Models\CreateCardRequest(
            $body_idempotencyKey,
            $body_sourceId,
            $body_card
        );
        //$body->setVerificationToken('STORE');

        $apiResponse = $cardsApi->createCard($body);

        if ($apiResponse->isSuccess()) {
            $createCardResponse = $apiResponse->getResult();
            dd($createCardResponse);
        } else {
            $errors = $apiResponse->getErrors();
            dd($errors);
        }
    }*/


    public function shippingStore(Request $request){
        $validation = Validator::make($request->all(),[
            'user_id'=>'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address_1' => 'required',
            'address_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
        ]);

        if($validation->fails()){
            return errorMsgResponse($validation->errors()->first());
        }
        
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            if (empty($user)) {
                return errorMsgResponse('User Not Found.');
            }
            
            $user->shipping_address = json_encode($request->all());
            $user->save();
        
            DB::commit();
            
            return dataResponse(['user' => $user->id , 'shipping_address'=>json_decode($user->shipping_address)]);
        } catch (\Exception $e) {
            DB::rollback();
            return errorMsgResponse($e->getMessage());
        }
    }
}
