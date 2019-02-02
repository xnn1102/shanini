@extends('layout.admins')

@section('title', $title)

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

@if (session('errors'))
    <div class="mws-form-message error">
        {{ session('errors') }}
    </div>
@endif


<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span>{{$title}}</span>
    </div>
    <div class="mws-panel-body no-padding">
    	<form id="art_form" action="/admin/doprofile" method='post' class="mws-form" enctype="multipart/form-data">
            <div class="mws-form-inline">
        		<div class="mws-form-row">
                    <label class="mws-form-label">头像</label>
                    <div class="mws-form-item">
                        <img id="img" src="{{$profile}}" alt="" style='height:150px'>
                        <input type="file" id="file_upload" name='profile' style="position: absolute; top: 0px; right: 0px; margin: 0px; cursor: pointer; font-size: 999px; opacity: 0; z-index: 999;">

                    </div>
                </div>
            </div>
    		<div class="mws-button-row">
    			{{csrf_field()}}
    			<input type="submit" class="btn btn-danger" value="修改头像">
    		</div>
    	</form>
    </div>    	
</div>


@stop

@section('js')
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(function () {

        $("#file_upload").change(function () {

            // alert(2143);
                   
            //判断是否有选择上传文件
            var imgPath = $("#file_upload").val();

            // console.log(imgPath);

            if (imgPath == "") {
                alert("请选择上传图片！");
                return;
            }

            //判断上传文件的后缀名
            var strExtension = imgPath.substr(imgPath.lastIndexOf('.') + 1);
            if (strExtension != 'jpg' && strExtension != 'gif'
                && strExtension != 'png' && strExtension != 'bmp') {
                alert("请选择图片文件");
                return;
            }

            var formData = new FormData($('#art_form')[0]);

            $.ajax({
                type: "POST",
                url: "/admin/doprofile",
                data: formData,
                contentType: false,
                processData: false,

                success: function(data) {
                    //把服务器返回的结果传过来 在页面中显示
                   // data = 'uploads/238409385454.jpg'

                   // /uploads/238409385454.jpg
                    $('#img').attr('src',data);

                    alert('修改成功');
                    location.reload(true);
                },

                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("上传失败，请检查网络后重试");
                }
            });
        })
    })

</script>

@stop