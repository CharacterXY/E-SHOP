<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\User;
use App\Product;
use App\Photo;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    //
    
    
    public function index(){

        $users = User::paginate(3);

        return view('admin.displayUsers', compact('users'));

    }


    public function editImage($id){

        $user = User::findOrFail($id);

        return view('admin.editUserImage', ['user' => $user]);
    }

    
    public function editUser($id){

        $user = User::findOrFail($id);

        return view('admin.editUsers', ['user' => $user]);
    }


    public function destroy($id){

        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->back();
    }



    public function updateUserImage(Request $request, $id){
 
        Validator::make($request->all(), ['image' => 'required|file|image|mimes:jpg,png,jpeg|max:3000'])->validate(); 

        if($request->hasFile("image")){

            $user = User::findOrFail($id);

            $exists =  Storage::disk('local')->exists("public/users_image/".$user->image);

            if($exists){
                Storage::delete('public/users_image/'.$user->image);
            }

            $filename = $request->file('image')->getClientOriginalExtension();

            $request->image->storeAs("public/users_image/", $user->image);

            $arrayToUpdate = array('image' => $user->image); 
            DB::table('users')->where('id', $id)->update($arrayToUpdate); // change current image with new one

          

            return redirect()->route('adminDisplayUsers')->withsuccess('Image has been successfully changed!'); // back to display admin users

        } else {

            $error = "You should select picture first";

            return $error;

        }


    }

    public function updateUser(Request  $request, $id){

       $user = User::findOrFail($id);

    /* $name = $request->input('name');
       $email = $request->input('email');
       $isActive =  $request->input('is_active');
       $roleId = $request->input('role_id'); */

       if(trim($request->password == '')){                // Ako zelimo editirat usera primjerice bez updatea passworda onda zovemo request all bez passworda

        $input = $request->except('password');

       } else {

        $input = $request->all();                         // Ako zelimo editirat sve zovemo sve, samo sto kod passworda moramo hashirat password tako da nebi bilo vidljivo u bazi podataka

        $input['password'] = bcrypt($request->password);
       }

       $user->update($input);

       return redirect()->route('adminDisplayUsers');
        

      /*   $newUpdatedArray = array("name" => $name, "email" => $email, "is_active" => $isActive, "role_id" => $roleId, 'password' => $input);
        DB::table('users')->where('id', $id)->update($newUpdatedArray);
        
        return redirect()->route('adminDisplayUsers'); */
    }

    
        
        
            
        
    



}
