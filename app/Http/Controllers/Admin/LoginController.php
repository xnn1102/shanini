<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder; 

use DB;
use Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin.login.login');
    }
 
    public function dologin(Request $request)
    {
        //1.获取账号
        $uname = $request->username;
       
        //通过账号查找数据库里面有没有
        $rs = DB::table('user')->where('username',$uname)->first();

        if(!$rs){
            return back()->with('errors','用户名或密码不正确');
        }
         

        //2.获取密码
          $pass = $request->password;
          //检测密码，解密
          //1)哈希
          if(!Hash::check($pass,$rs->password)){
            //密码对比。。
            return back()->with('errors','用户名或密码不正确');
          } 
          
          //2)解密
        //   $ps = decrypt($rs->password);
        //   if($pass != $ps){
            
        //     return back()->with('errors','用户名或密码不正确');
        // }
          
        //3.获取验证码
        $vode = $request->vcode;
        $code = session('code');
        if($vode != $code){
            
            return back()->with('errors','验证码不正确');
        }

        //存储session
        session(['uid'=>$rs->id]);
        

        //跳转到后台
        return redirect('admin/index')->with('success','登录成功');

    }
    //退出登录
      public function logout()
    {
        //清空登录session
        session(['uid'=>'']);

        // \Session::forget('uid');

        return redirect('/admin/login');
    }

     public function captch()
    {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(123, 203, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        // 可以设置图片宽高及字体
        $builder->build($width = 110, $height = 35, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
        session(['code'=>$phrase]);
        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }


}