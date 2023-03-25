<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    // direct userlist
    public function userList(){
        if(Session::has('SEARCH')){
            Session::forget('SEARCH');
        }
        $userData = User::where('role','user')->paginate(7);
        return view('admin.user.userList')->with(['user'=>$userData]);
    }

    // direct adminlist
    public function adminList(){
        $userData = User::where('role','admin')->paginate(7);
        return view('admin.user.adminList')->with(['admin'=>$userData]);
    }

    // user search
    public function userSearch(Request $request){
        $response = $this->search('user',$request);
        return view('admin.user.userList')->with(['user'=>$response]);
    }

    // admin search
    public function adminSearch(Request $request){
        $response = $this->search('admin',$request);
        return view('admin.user.adminList')->with(['admin'=>$response]);
    }



    public function userDelete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'User Deleted...']);
    }

    public function downloadUserList(){
        if(Session::has('SEARCH')){
            $user = User::where('role','user')
                         ->where(function ($query){
                            $query->orWhere('name','like','%'.Session::get('SEARCH').'%')
                            ->orWhere('email','like','%'.Session::get('SEARCH').'%')
                            ->orWhere('phone','like','%'.Session::get('SEARCH').'%')
                            ->orWhere('address','like','%'.Session::get('SEARCH').'%');
                         })
                            ->get();
        }else{
            $user = User::where('role','user')->get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->build($user, [
            'contact_id' => 'No',
            'name' => 'Name',
            'email' => 'Email',
            'message' => 'Message',
            'created_at'  => 'Created Date',
            'updated_at'  => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'UserList.csv';

        return response((string) $csvReader)
            ->header('Content-Type','text/csv; charset-UTF-8')
            ->header('Content-Disposition','attachment; filename="'.$filename.'"');

    }

    public function downloadAdminList(){
        if(Session::has('SEARCH')){
            $admin = User::where('role','admin')
                         ->where(function ($query){
                            $query->orWhere('name','like','%'.Session::get('SEARCH').'%')
                            ->orWhere('email','like','%'.Session::get('SEARCH').'%')
                            ->orWhere('phone','like','%'.Session::get('SEARCH').'%')
                            ->orWhere('address','like','%'.Session::get('SEARCH').'%');
                         })
                            ->get();
        }else{
            $admin = User::where('role','admin')->get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->build($admin, [
            'contact_id' => 'No',
            'name' => 'Name',
            'email' => 'Email',
            'message' => 'Message',
            'created_at'  => 'Created Date',
            'updated_at'  => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'AdminList.csv';

        return response((string) $csvReader)
            ->header('Content-Type','text/csv; charset-UTF-8')
            ->header('Content-Disposition','attachment; filename="'.$filename.'"');

    }

    private function search($role,$request){
        $searchData = User::where('role',$role)
                        ->where(function ($query) use($request) {
                            $query->orWhere('name','like','%'.$request->searchData.'%')
                            ->orWhere('email','like','%'.$request->searchData.'%')
                            ->orWhere('phone','like','%'.$request->searchData.'%')
                            ->orWhere('address','like','%'.$request->searchData.'%');
                        })
                        ->paginate(7);
                        Session::put('SEARCH',$request->searchData);
        $searchData->appends($request->all());
        return $searchData;
    }

}
