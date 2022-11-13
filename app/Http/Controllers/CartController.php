<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Cart_course;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Course_user;

class CartController extends Controller
{
    public function index(Request $request){
        $user_id = Auth::id();
        $cart = Cart::where('user_id', $user_id)->first();
        if(!$cart) return response(['error' => 'You have not added anything to your cart']);
        $courses = $cart->courses()->paginate(5);
        return response([
            'courses' => $courses,
            'cart_price' => $cart->price
        ], 201);
    }

    public function update(Request $request, $id){
        $course = Course::findOrFail($id);
        $user_id = Auth::id();
        if($course->user_id == $user_id){
            return response(['error' => 'This is YOUR course.'], 409);
        }
        if(!$user_id) return response(['error' => 'You need to be logged in!'], 409);

        $cart = Cart::where('user_id', $user_id)->first();
        if(!$cart){
            $cart = new Cart();
            $cart->user_id = $user_id;
            $cart->price = $course->price;
            $cart->save();

            $cart_course = Cart_course::create([
                'cart_id' => $cart->id,
                'course_id' => $course->id
            ]);
        }
        else{
            $cart_course = Cart_course::where('cart_id', $cart->id)->where('course_id', '=', $course->id)->first();
            if($cart_course != null){
                return response(['error' => 'You already have this added to your cart!', 'cart_course' => $cart_course], 409);
            }
            else{
                $cart_course = Cart_course::create([
                    'cart_id' => $cart->id,
                    'course_id' => $course->id
                ]);
                $cart->price = $cart->price + $course->price;
                $cart->save();
            }
        }

        return response(['success' => 'You have added this item to the cart!'], 201);
    }

    public function destroy($course_id){
        $user_id = Auth::id();
        $cart = Cart::where('user_id', $user_id)->first();
        $course = Course::findOrFail($course_id)->first();

        $cart_course = Cart_course::where('cart_id', $cart->id)->where('course_id', $course_id)->first();

        $cart_course->delete();
        $cart->price = $cart->price - $course->price;
        $cart->save();
        
        return response(
            ['succes' => 'You have successfully deleted this item!']
        , 201);
    }

    public function buy_course($course_id){
        $course = Course::findOrFail($course_id)->first();
        $cart = Cart::where('user_id', Auth::id())->first();
        $course_user = Course_user::where('course_id', $course->id)->where('user_id', Auth::id())->first();
        $cart_course = Cart_course::where('cart_id', $cart->id)->where('course_id', $course->id)->first();

        if($course_user){
            return response(['error' => 'You have already bought this course!'], 409);
        }

        $course_user = Course_user::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id
        ]);
        $cart_course->delete();
        $cart->price = $cart->price - $course->price;
        $cart->save();
        
        return response(['success' => 'Course bought successfully!'], 201);
    }
}
