<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use App\Models\Supplement;
use App\Models\Exercise;
use App\Models\Recipe;
use App\Models\Post;
use App\User;
use Auth;
use DB;

use Square\SquareClient;
use Square\Exceptions\ApiException;
use Square\Models\ListCatalogRequest;
use Square\Models\SearchCatalogItemsRequest;
use Square\Models\CatalogObject;

class CommonController extends Controller
{ 
    public $supplement;
    public $exercise;
    public function __construct(Supplement $supplement,Exercise $exercise){
        $this->supplement = $supplement;
        $this->exercise = $exercise;
    }
    
    public function getSupplementList(Request $request){
        $supplements = $this->supplement->where('status',config('constant.status.active'))->select('id','name')->get();
        return dataResponse($supplements);
    }

    public function getExerciseList(Request $request){
        $exercises = $this->exercise->where('status',config('constant.status.active'))->select('id','name')->get();
        return dataResponse($exercises);
    }

    public function getSearchMealList(Request $request){
        $recipe = new Recipe;
        $user = Auth::user();
        if(isPremium($user)){
            $list = $recipe->getSearchMealList($request,[config('constant.status.active'),config('constant.status.in_active')]);
            return dataResponse($list);    
        }
        $list = $recipe->getSearchMealList($request);
        return dataResponse($list);
    }

    public function pushNo(){
        $crewNtf = [
                'to'=>"cWEtUBqNT_SzXxRLENvM1y:APA91bG-1GBO_bdU-88qEP-6ppe0nkj1OJePIGvAzy0bjqsY0DFcpPo-X1AIMVxjj3w9h9K5RsTYYMtLKC-TkXe1ZllPqIeya9nj7MRg80CgPd67TRII0RxmaqjPmnpyZE1bB1C54Zb4",
                'notification'=>[
                    'title'=>"Job paused",
                    'body'=>'Job paused date ',
                    'mutable_content'=>false,
                    'sound'=>'Tri-tone'
                ],                    
                
            ];
        
        $result = pushNotification($crewNtf);
        return dataResponse($result);
    }

    public function subscriptionPlans(){
        $plan = new \App\Models\SubscriptionPlan;
        $list = $plan->getPlan();
        $plans = [];
        if($list->count()){
            foreach($list as $row){
                $description = str_replace('</p>', '', $row->description);
                $description = explode('<p>', $description);
                $temp = [];
                if(count($description)){
                    foreach($description as $desc){

                        if(!empty($desc)){
                            array_push($temp,htmlspecialchars_decode(strip_tags($desc)));
                        }
                    }
                }
                $row->description = $temp;
                array_push($plans,$row);
            }
        }
        return dataResponse($plans);
    }

    public function getPaymentUrl(SubscriptionPlan $plan_id){
        return response()->json(['status'=>true,'url'=>route('api-web-view',$plan_id)]);
    }

    public function getStepFormData($id){
        $final = [];
        $user = User::find($id);
        $posts = Post::where('status', 1)->orderBy('title', 'ASC')->get()->toArray();
        if (count($posts) > 0) {
            foreach ($posts as $key => $value) {
                if ($value['post_type'] == 'four_step' && $user->gender == 'Female') {
                    if ($value['gender_type'] == 'F') {
                        $final[$value['post_type']][] = [
                            'title' => $value['title'],
                            'image_src' => asset($value['image_url'])
                        ];
                    }
                } elseif ($value['post_type'] == 'four_step' && $user->gender == 'Male') {
                    if ($value['gender_type'] == 'M') {
                        $final[$value['post_type']][] = [
                            'title' => $value['title'],
                            'image_src' => asset($value['image_url'])
                        ];
                    }
                } elseif ($value['post_type'] != 'four_step') {
                    $final[$value['post_type']][] = [
                        'title' => $value['title'],
                        'image_src' => asset($value['image_url'])
                    ];
                }
            }
        }

        return dataResponse($final);
    }

    public function getSquareItems(){
        $client = new SquareClient([
            'accessToken' => config('constant.squareAccessToken'),
            'environment' => config('constant.squareEnvironment'),
        ]);

        $category_ids = ['GWJVU6QYVCKNMNWKFSUZZJZ6'];
        $body = new SearchCatalogItemsRequest();
        $body->setCategoryIds($category_ids);

        $api_response = $client->getCatalogApi()->searchCatalogItems($body);
        $final = [];
        if ($api_response->isSuccess()) {
            $result = $api_response->getResult()->getItems();
            
            if (!empty($result) && count($result)) {
                foreach ($result as $key => $value) {
                    $arr['image'] = null;
                    $arr['id'] = $value->getId();
                    $image_id = $value->getImageId() ?? '';
                    // dd($value->getItemData());
                    $item = $value->getItemData();
                    $arr['name'] = $item->getName();
                    $arr['description'] = $item->getDescription();
                    $arr['categoryId'] = $item->getCategoryId();
                    $variations = $item->getVariations();
                    $imageUrl = $client->getCatalogApi()->retrieveCatalogObject($image_id);

                    if ($imageUrl->isSuccess()) {
                        $catalogObject = $imageUrl->getResult()->getObject();
                        $imageData = $catalogObject->getImageData();
                        $arr['image'] =  $imageData ? $imageData->getUrl() : null;
                    }

                    foreach ($variations as $variation) {
                        $arr['sku'] = $variation->getItemVariationData()->getSku();
                        $arr['itemId'] = $variation->getItemVariationData()->getItemId();
                        $arr['amount'] = $variation->getItemVariationData()->getPriceMoney()->getAmount();
                        $arr['currency'] = $variation->getItemVariationData()->getPriceMoney()->getCurrency();
                    }
                    array_push($final, $arr);
                }
            }
        }

        return dataResponse($final);
    }

    public function getStateList(){
        $result = DB::table('state_master')->where('country_id', '231')->get()->toArray();
        return dataResponse($result);
    }

    public function getItemUrl($plan_id){
        return response()->json(['status'=>true,'url'=>route('api-item-view',$plan_id)]);
    }
}
