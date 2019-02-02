@extends('layout.admins')

@section('title', $title)
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')


<div class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span>
            <i class="icon-table">
            </i>
           {{$title}}
        </span>
    </div>
    <div class="mws-panel-body no-padding">
         <div role="grid" class="dataTables_wrapper" id="DataTables_Table_1_wrapper">

        	<form action="/admin/user" method='get'>
            <div id="DataTables_Table_1_length" class="dataTables_length">

                <label>
                    显示
                    <select name="nums" size="1" aria-controls="DataTables_Table_1">
                        <option value="10" @if($request->nums == 10) selected="selected" @endif>
                            10 
                        </option>
                        <option value="20"  @if($request->nums == 20) selected="selected" @endif>
                            20
                        </option>
                        <option value="30"  @if($request->nums == 30) selected="selected" @endif>
                            30
                        </option>
                       
                    </select>
                    条数据
                </label>
            </div>
            <div class="dataTables_filter" id="DataTables_Table_1_filter">
                <label>
                    用户名:
                    <input type="text" name='username' aria-controls="DataTables_Table_1" value="{{$request->username}}">

                    邮箱：
                    <input type="text" name='email' aria-controls="DataTables_Table_1" value="{{$request->email}}">

                    <button class='btn btn-info'>搜索</button>
                </label>
            </div>
        </form>
            <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1"
            aria-describedby="DataTables_Table_1_info">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 20px;" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                           ID
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 80px;" aria-label="Browser: activate to sort column ascending">
                          用户名
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 110px;" aria-label="Platform(s): activate to sort column ascending">
                         邮箱
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 80px;" aria-label="Engine version: activate to sort column ascending">
                          手机号
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 97px;" aria-label="CSS grade: activate to sort column ascending">
                         头像
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 30px;" aria-label="CSS grade: activate to sort column ascending">
                         状态
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" style="width: 20px;" aria-label="CSS grade: activate to sort column ascending">
                        操作
                        </th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                @foreach($res as $k=>$v)

                	@if($k % 2 == 0)
                    <tr class="odd">

                   	@else
                   	<tr class="even">

                   	@endif
                        <td class="  "> 
                           {{$v->id}}
                        </td>
                        <td class="uname">
                            {{$v->username}}
                        </td>
                        <td class=" ">
	                       {{$v->email}}
                        </td>
                        <td class=" ">
                            {{$v->phone}}
                        </td>
                        <td class=" ">
                           <img src="{{$v->profile}}" alt="" width="97px" height="80px ">
                        </td>
                        <td class=" ">

                     		@if($v->status == 1)
                     		    开启
                     		@else
                     			禁用
                     		@endif
                        </td>
                         <td class=" ">
                            
                            <a class='btn btn-warning' href="/admin/user/{{$v->id}}/edit">修改</a>


                            <!-- <a class='btn btn-danger' href="">删除</a> -->

                            <form action="/admin/user/{{$v->id}}" method='post' style='display:inline'>
                                {{csrf_field()}}

                                {{method_field('DELETE')}}
                                <button class='btn btn-danger'>删除</button>
                            </form>
                        </td>
                    </tr>
       			     @endforeach
                </tbody>
            </table>
             <div class="dataTables_info" id="DataTables_Table_1_info">
                 显示 {{$res->firstItem()}} 到 {{$res->lastItem()}} 总共 {{$res->total()}} 条数

           	</div>

           			<style>
				ul{
					margin:0px;

				}

				.pagination li{
					    float: left;
					    height: 20px;
					    padding: 0 10px;
					    display: block;
					    font-size: 12px;
					    line-height: 20px;
					    text-align: center;
					    cursor: pointer;
					    outline: none;
					    background-color: #444444;
					    color: #fff;
					    text-decoration: none;
					    border-right: 1px solid #232323;
					    border-left: 1px solid #666666;
					    border-right: 1px solid rgba(0, 0, 0, 0.5);
					    border-left: 1px solid rgba(255, 255, 255, 0.15);
					  
					    box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.5), inset 0px 1px 0px rgba(255, 255, 255, 0.15);

				}

				.pagination .active{
					    background-color: #88a9eb;
					    color: #323232;
					    border: none;
					    background-image: none;
					    box-shadow: inset 0px 0px 4px rgba(0, 0, 0, 0.25);	
				}

				.pagination a{
				 	
					color: #fff;
				}

				.pagination .disabled{

					    color: #666666;
    					cursor: default;
				}

			</style>

			<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_1_paginate">

				{{$res->appends($request->all())->links()}}

               
            </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	//alert($);
	$('.mws-form-message').delay(2000).fadeOut(1500);
	

    $('.uname').dblclick(function(){

        var um = $(this);

        //获取td里面的内容
        var ux = $(this).text().trim();

        //创建input输入框
        var ipu = $('<input type="text" />');

        $(this).empty();

        $(this).append(ipu);

        ipu.val(ux);

        ipu.focus();

        ipu.select();

        ipu.blur(function(){
            //获取输入的新值
            var uv = $(this).val().trim();

            if(uv == ''){

                alert('输入的值不能为空');
                return;
            }

            //获取id
            var ids = $(this).parent().prev().text().trim();


            $.post('/admin/userajax',{username:uv,id:ids},function(data){

                if(data == '1'){

                    um.text(uv);
                } else {

                    um.text(ux);
                }
            })
        })



    })
</script>
	
@stop
