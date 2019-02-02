@extends('layout.admins')

@section('title', $title)

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
    	<form action="/admin/rechangepass/{{$id}}" method='post' class="mws-form">
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label class="mws-form-label">旧密码</label>
    				<div class="mws-form-item">
    					<input type="password" class="small" name='password'>
    				</div>
    			</div>

    			<div class="mws-form-row">
    				<label class="mws-form-label">新密码</label>
    				<div class="mws-form-item">
    					<input type="password" class="small" name='newpass'>
    				</div>
    			</div>

    			<div class="mws-form-row">
    				<label class="mws-form-label">确认密码</label>
    				<div class="mws-form-item">
    					<input type="password" class="small" name='renewpass'>
    				</div>
    			</div>
    			
    		</div>
    		<div class="mws-button-row">
    			{{csrf_field()}}
    			<input type="submit" class="btn btn-danger" value="修改">
    			
    		
    		</div>
    	</form>
    </div>    	
</div>


@stop