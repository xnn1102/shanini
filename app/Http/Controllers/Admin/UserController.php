<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\User;
 
use Hash;

use DB;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //获取表单传过来的数据
        //
       /* $res = User::
        where('username','like','%'.$request->username.'%')->
        paginate($request->input('nums',10));*/

        //多条件查询
       $res =  User::orderBy('id','asc')
	        ->where(function($query) use($request){
	        //检测关键字
	        $username = $request->input('username');
	        $email = $request->input('email');
	        //如果用户名不为空
	        if(!empty($username)) {
	            $query->where('username','like','%'.$username.'%');
	        }
	        //如果邮箱不为空
	        if(!empty($email)) {
	            $query->where('email','like','%'.$email.'%');
	        }
	    })
		    ->paginate($request->input('nums', 10));
        
        return view('admin.user.index',[
            'title'=>'用户的列表页面',
            'res'=> $res,
            'request'=>$request

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.user.add',['title'=>'用户的添加页面']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //表单验证
        $this->validate($request, [
            'username' => 'required|unique:user|regex:/\w{5,16}/',
            'password' => 'required|regex:/\w{6,12}/',
            'repass' => 'same:password',
            'email' =>'email',
            'phone' => 'regex:/1[3456789]\d{9}/'
        ],[
            'username.required' => '用户名不能为空',
            'username.regex' => '用户名格式不正确',
            'password.required'  => '密码不能为空',
            'password.regex'  => '密码格式不正确',
            'repass.same' =>'两次密码不一致',
            'email.email'=>'邮箱格式不正确',
            'phone.regex'=>'手机号码格式不正确'
        ]);
        //获取数据
        $res = $request->except(['repass','profile','_token']);

        //头像处理
        if(!$request->hasFile('profile')){

            echo '没有选择文件上传';die;
        } else {

            $file = $request->file('profile');

            //设置名字
            $name = rand(1111,9999).time();

            //获取后缀
            $suffix = $file->getClientOriginalExtension();

            //移动文件
            $file->move('./uploads', $name.'.'.$suffix);

            //存到数据库
            $res['profile'] = '/uploads/'.$name.'.'.$suffix;
        }

        //密码  加密
        //hash  加密解密
        $res['password'] = Hash::make($request->password);

        //添加数据
        try{

            //添加
             $data = User::create($res);

            
            if($data){
                return redirect('/admin/user')->with('success','添加成功');
            }

        }catch(\Exception $e){

            return back()->with('error','添加失败');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $res = User::find($id);
        return view('admin.user.edit',[
        	'title'=>'用户的修改页面',
        	'res'=>$res

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	//表单验证
    	
    	//删除之前的头像
    	
    	  $this->validate($request, [
            'username' => 'required|regex:/\w{6,16}/',
           
            'email' =>'email',
            'phone' => 'regex:/1[3456789]\d{9}/'
        ],[
            'username.required' => '用户名不能为空',
            'username.regex' => '用户名格式不正确',
           
            'email.email'=>'邮箱格式不正确',
            'phone.regex'=>'手机号码格式不正确'
        ]);
    	

        $res = $request->except('_token','_method','profile');
 
         if(!$request->hasFile('profile')){

            echo '没有选择文件上传';
        } else {

            $file = $request->file('profile');

            //设置名字
            $name = rand(1111,9999).time();

            //获取后缀
            $suffix = $file->getClientOriginalExtension();

            //移动文件
            $file->move('./uploads', $name.'.'.$suffix);

            //存到数据库
            $res['profile'] = '/uploads/'.$name.'.'.$suffix;
        }

        //密码  加密
        //hash  加密解密
        $res['password'] = Hash::make($request->password);
       
        //添加数据
        try{

            //添加
             $data = User::where('id',$id)->update($res);

            
            if($data){
                return redirect('/admin/user')->with('success','修改成功');
            }

        }catch(\Exception $e){

            return back()->with('error','修改失败');
        }
        
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      	//如果用户没有了  存在磁盘中的头像要不要删除
     	
       	  try{

         	$data= User::destroy($id);
          	
            
            if($data){
                return redirect('/admin/user')->with('success','删除成功');
            }

        }catch(\Exception $e){

            return back()->with('error','删除失败');
        }

    }
    //ajax修改用户名
    public function userajax(Request $request)
    {
        //获取id
        $id = $request->id;

        $rs = $request->only('username');

        $res = DB::table('user')->where('id', $id)->update($rs);

        if($res){

            echo 1;
        } else {

            echo 0;
        }
    }  

    public function changepass($id)
    {
    	return view('admin.user.changepass',[
            'title'=>'修改账号密码',
            'id'=>$id
        ]);
    }
     public function rechangepass(Request $request ,$id)
    { 
    	echo $id;
    	//获取旧密码
    	$pass = $request->password;
    	
    	$rs = DB::table('user')->where('id',$id)->first();
    	
    	if (!Hash::check($pass, $rs->password)) {
        
            return back()->with('errors','输入旧密码不正确');
        }
        //获取输入的新密码
        $newpass = $request->newpass; 
         //获取确认密码
        $repass = $request->renewpass;

        if($newpass != $repass){

            return back()->with('errors','两次密码不一致');

        }
        $arr = [];

        // 加密
        $arr['password'] = Hash::make($newpass);

        $data = User::where('id', $id)->update($arr);

        if($data){

            session(['uid'=>'']);

            return redirect('/admin/login');
        }
    }

    public function profile()
    {
    	$rs = User::where('id', session('uid'))->first();
    	//dump($rs);
        return view('admin.user.profile',[
            'title'=>'修改用户头像',

            'profile'=>$rs->profile

        ]);
    }

    public function doprofile(Request $request)
    {
        //获取上传的文件对象
        // $file = Input::file('file_upload');

        $file = $request->file('profile');

        //判断文件是否有效
        if($file->isValid()){
            //上传文件的后缀名
            $entension = $file->getClientOriginalExtension();
            //新的 文件名+后缀名   
            $newName = date('YmdHis').mt_rand(1000,9999).'.'.$entension;

            $path = $file->move('./uploads',$newName);

            //uploads/238409385454.jpg
            $filepath = '/uploads/'.$newName;

            //返回文件的路径
            echo $filepath;
        }

        $rs['profile'] = $filepath;

        DB::table('user')->where('id', session('uid'))->update($rs);


    }

}
 