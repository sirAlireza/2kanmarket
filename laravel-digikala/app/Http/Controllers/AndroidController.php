<?php
namespace App\Http\Controllers;

use App\Address;
use App\Amazing;
use App\Category;
use App\CatProduct;
use App\Filter;
use App\Product;
use App\Search;
use App\Slider;
use App\User;
use DB;
use Illuminate\Http\Request;
use Validator;
use Auth;
class  AndroidController extends Controller
{
    public function get_android_slider()
    {
        $slider=Slider::select('id','img')->orderBy('id','DESC')->get()->toJson();
        return $slider;
    }
    public function get_android_cat_index()
    {
        $cat_list=Category::select('id','cat_name')->where("parent_id",0)->get()->toJson();
        return  $cat_list;
    }
    public function get_android_order_product()
    {
        $product_list=array();
        $product=Product::with('get_img')->select('id','title','price','discounts')->where(['show_product'=>1,'product_status'=>1])->orderBy('order_product','DESC')->limit(10)->get();
        foreach ($product as $key=>$value)
        {
            $product_list[$key]['id']=$value->id;
            $product_list[$key]['title']=$value->title;
            $product_list[$key]['price']=$value->price-$value->discounts;
            $product_list[$key]['img']=$value->get_img->url;
        }

        return json_encode($product_list);
    }
    public function get_android_new_product()
    {
        $product_list=array();
        $product=Product::with('get_img')
            ->select('id','title','price','discounts')
            ->where(['show_product'=>1,'product_status'=>1])
            ->orderBy('id','DESC')->limit(10)->get();
        foreach ($product as $key=>$value)
        {
            $product_list[$key]['id']=$value->id;
            $product_list[$key]['title']=$value->title;
            $product_list[$key]['price']=$value->price-$value->discounts;
            $product_list[$key]['img']=$value->get_img->url;
        }

        return json_encode($product_list);
    }
    public function get_android_view_product()
    {
        $product_list=array();
        $product=Product::with('get_img')
            ->select('id','title','price','discounts')
            ->where(['show_product'=>1,'product_status'=>1])
            ->orderBy('view','DESC')->limit(10)->get();
        foreach ($product as $key=>$value)
        {
            $product_list[$key]['id']=$value->id;
            $product_list[$key]['title']=$value->title;
            $product_list[$key]['price']=$value->price-$value->discounts;
            $product_list[$key]['img']=$value->get_img->url;
        }

        return json_encode($product_list);
    }
    public function get_android_amazing_product()
    {
        $time=time();
        $product_list=array();
        $last=Amazing::orderBy('timestamp','DESC')->first();
        if($last)
        {

            if($last->timestamp>$time)
            {
                $product=Amazing::with('get_img')->orderBy('id','DESC')->get();
                foreach ($product as $key=>$value)
                {
                    $time=$value->timestamp-time();
                    $product_list[$key]['id']=$value->product_id;
                    $product_list[$key]['title']=$value->m_title;
                    $product_list[$key]['title2']=$value->title;
                    $product_list[$key]['price1']=$value->price1;
                    $product_list[$key]['price2']=$value->price1-$value->price2;
                    $product_list[$key]['img']=$value->get_img->url;
                    $product_list[$key]['time']=$time;
                }
            }

        }

        
        return json_encode($product_list);
    }
    public function get_android_product_data($id)
    {
        $color_id=0;
        $product_data=array();
        $product=Product::with(['get_images','get_colors','get_service_name'])->where(['show_product'=>1,'id'=>$id])->first();
        if($product)
        {
            $product_data['data']['title']=$product['title'];
            $product_data['data']['code']=$product['code'];
            $product_data['data']['tozihat']=$product['text'];
            $product_data['data']['price']=$product['price']-$product['discounts'];
            $product_data['data']['discounts']=$product['discounts'];
            foreach ($product->get_images as $key=>$value)
            {
                $product_data['img'][$key]['url']=$value->url;
            }

            foreach ($product->get_colors as $key=>$value)
            {
                if($key==0)
                {
                    $color_id=$value->id;
                }
                $product_data['colors'][$key]['id']=$value->id;
                $product_data['colors'][$key]['color_name']=$value->color_name;
                $product_data['colors'][$key]['color_code']=$value->color_code;
            }
            if(sizeof($product->get_colors)==0)
            {
                $product_data['colors']=array();
            }
            $i=1;
            $product_data['service']=array();
            foreach ($product->get_service_name as $key=>$value)
            {
                if($color_id!=0)
                {
                    $check=DB::table('service')
                        ->where(['parent_id'=>$value->id,'color_id'=>$color_id])
                        ->first();
                    if($check && !array_key_exists(0,$product_data['service']))
                    {
                        $product_data['service'][0]['service_id']=$value->id;
                        $product_data['service'][0]['service_name']=$value->service_name;
                    }
                    else
                    {
                        $product_data['service'][$i]['service_id']=$value->id;
                        $product_data['service'][$i]['service_name']=$value->service_name;
                    }
                }
                else
                {
                    $product_data['service'][$key]['service_id']=$value->id;
                    $product_data['service'][$key]['service_name']=$value->service_name;
                }
            }
            if(array_key_exists('service',$product_data))
            {
                sort($product_data['service']);
            }

            return json_encode($product_data);
        }
        else
        {
            return json_encode($product);
        }
    }
    public function get_android_product_score($id)
    {
        $product_score=Product::with('get_score')->select(['id'])->where('id',$id)->first();
        $array=array();
        $array[1]=0;
        $array[2]=0;
        $array[3]=0;
        $array[4]=0;
        $array[5]=0;
        $array[6]=0;
        foreach ($product_score->get_score as $key=>$value)
        {
            $e=explode('@#',$value->value);
            foreach ($e as $key2=>$value2)
            {
                $e2=explode('_',$value2);
                if(sizeof($e2)==2)
                {
                    $k=$e2[0];
                    if(array_key_exists($k,$array))
                    {
                        $array[$k]=$array[$k]+$e2[1];
                    }
                }
            }
        }

        $size=sizeof($product_score->get_score);
        $sum=0;
        $avg=0;
        if($size>0)
        {
            foreach ($array as $key=>$value)
            {
                $value=$value/$size;
                $sum+=$value;
                $array[$key]=substr($value,0,3);
            }
            $avg=$sum/6;
        }
        $array["number"]=3;
        $array["avg"]=substr($avg,0,3);

        return json_encode($array);
    }
    public function get_like_product($id)
    {
        $product_list=array();
        $cat=DB::table('cat_product')->where('product_id',$id)->orderBy('id','DESC')->first();
        if($cat)
        {
            $cat_list=DB::table('cat_product')->where('cat_id',$cat->cat_id)->where('product_id','!=',$id)->pluck('product_id','product_id');
            $product=Product::with('get_img')
                ->whereIn('id',$cat_list)
                ->select("id",'title','price','discounts')
                ->where(['show_product'=>1,'product_status'=>1])
                ->orderBy('id','DESC')->limit(10)->get();
            foreach ($product as $key=>$value)
            {
                $product_list[$key]['id']=$value->id;
                $product_list[$key]['title']=$value->title;
                $product_list[$key]['price']=$value->price-$value->discounts;
                $product_list[$key]['img']=$value->get_img->url;
            }

        }

        return json_encode($product_list);

    }
    public function get_android_child_cat1($cat_id)
    {
        $cat_list=Category::select('id','cat_name','img')->where("parent_id",$cat_id)->get()->toJson();
        return  $cat_list;
    }
    public function get_android_child_cat2($id)
    {
        $cat_list=array();
        $category=Category::find($id);
        if($category)
        {
            $cat=Category::get_show_child_cat($category->id);
            $i=0;
            foreach ($cat as $key=>$value)
            {
                $cat_list[$i]=$value;
                $i++;
            }
        }
        return json_encode($cat_list);
    }
    public function  get_android_offer_product($id)
    {
        $product_id=DB::table('cat_product')->where(['cat_id'=>$id])->pluck('product_id','product_id');
        $product_list=array();
        $product=Product::with('get_img')
            ->select('id','title','price','discounts')
            ->where(['show_product'=>1,'product_status'=>1])
            ->whereIn('id',$product_id)
            ->orderBy('order_product','DESC')
            ->limit(10)->get();
        foreach ($product as $key=>$value)
        {
            $product_list[$key]['id']=$value->id;
            $product_list[$key]['title']=$value->title;
            $product_list[$key]['price']=$value->price-$value->discounts;
            $product_list[$key]['img']=$value->get_img->url;
        }

        return json_encode($product_list);
    }
    public function get_android_product_filter($cat1,$cat2,$cat3)
    {
        $array=array();
        $filter=Filter::get_search_filter($cat1,$cat2,$cat3);
        $price=CatProduct::get_search_price($cat3);
        $i=0;
        $array['filter'][$i]="بر اساس قیمت";
        $id="0_0";

        $price_list=array();
        if (sizeof($price)==2)
        {
            $price1=$price["price1"];
            $price2=$price["price2"];
            if($price1>0 && $price2>0)
            {
                $n=$price2/$price1;
                $n=ceil($n);
                $j=0;
                $price_list[$j]["name"]=$price1;
                $price_list[$j]["filed"]=3;
                $p=$price1;
                for ($x=0;$x<$n;$x++)
                {
                    $j++;
                    $p=$p+$price1;
                    $price_list[$j]["name"]=$p;
                    $price_list[$j]["filed"]=3;
                }
            }
        }
        $n='child_filter_0';
        $array[$n]=$price_list;

        foreach ($filter as $key=>$value)
        {
            $i++;
            $array['filter'][$i]=$value->name;

            foreach ($value->get_child as $key2=>$value2)
            {
                $id=$value->ename.'_'.$value2->id;
                $n='child_filter_'.$i;
                $array[$n][$key2]['name']=$value2->name;
                $array[$n][$key2]['id']=$id;
                $array[$n][$key2]['filed']=$value2->filed;
            }
        }

        return json_encode($array);
    }
    public function get_android_product_cat($cat_id)
    {
        $product_id=DB::table('cat_product')->where(['cat_id'=>$cat_id])->pluck('product_id','product_id');
        $product_list=array();
        $product=Product::with('get_img')
            ->select('id','title','price','discounts','code')
            ->where(['show_product'=>1,'product_status'=>1])
            ->whereIn('id',$product_id)
            ->orderBy('id','DESC')
            ->limit(10)->get();
        foreach ($product as $key=>$value)
        {
            $product_list[$key]['id']=$value->id;
            $product_list[$key]['title']=$value->title;
            $product_list[$key]['code']=$value->code;
            $product_list[$key]['price']=$value->price-$value->discounts;
            $product_list[$key]['img']=$value->get_img->url;
        }

        return json_encode($product_list);
    }
    public function get_android_filter_product(Request $request)
    {
       $filter_product=$request->get('filter_product');
        //$filter_product="brand_0";

        $array=array();
        $filter_ename=array();
        $e=explode(',',$filter_product);
        foreach ($e as $key=>$value)
        {
            $e2=explode('_',$value);
            if(sizeof($e2)==2)
            {
                if(array_key_exists($e2[0],$filter_ename))
                {
                    $k=$filter_ename[$e2[0]];
                    $s=sizeof($array[$k]);
                    $array[$k][$s]=$e2[1];
                }
                else
                {
                    $array[$e2[0]][0]=$e2[1];
                    $filter_ename[$e2[0]]=$e2[0];

                }
            }
        }
        $search=new Search($array);
        $search->android=1;
        $data=$search->get_product();

        echo json_encode($data['product']);
    }
    public function android_user_register(Request $request)
    {
        $username=$request->get('username');
        $password=$request->get('password');
        $data=['username'=>'09141592083','password'=>'123456'];
        $Validator=Validator::make($request->all(), [
            'username' => 'required|string|check_username|max:255|unique_username',
            'password' => 'required|string|min:6',
        ],[],[
            'username'=>'شماره همراه یا پست الکترونیک',
            'password'=>'کلمه عبور',
        ]);

        if($Validator->fails())
        {
            $error=$Validator->errors();
            foreach ($error->all() as $key=>$value)
            {
               if($key==0)
               {
                   echo  $value;
               }
            }
        }
        else
        {
            $user=User::create([
                'username' => $username,
                'password' => bcrypt($password),
                'role'=>'user'
            ]);
            if($user)
            {
                echo 'ok';
            }
            else
            {
                echo 'error';
            }
        }
    }


    public function get_android_user_address(Request $request)
    {
        $array=array();
        $user=$request->user();
        if($user)
        {
            $user_id=$user->id;
            $address=Address::find(['user_id'=>$user_id]);
            foreach ($address as $key=>$value)
            {
                $array[$key]['name']=$value->name;
                $array[$key]['tell']=$value->tell;
                $array[$key]['tell_code']=$value->tell_code;
                $array[$key]['mobile']=$value->mobile;
                $array[$key]['zip_code']=$value->mobile;
                $array[$key]['address']=$value->address;
                $array[$key]['ostan_name']=$value->get_ostan->ostan_name;
                $array[$key]['shahr_name']=$value->get_shahr->shahr_name;
            }

        }

       echo json_encode($array);
    }
}