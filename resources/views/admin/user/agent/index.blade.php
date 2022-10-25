@extends('layouts.master',['tbl'=>true])
@section('title')
    {{$title}}
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            کاربران / نمایندگی
        @endslot
        @slot('title')
            {{$title}}
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center">
                    <h4 class="card-title mb-0 flex-grow-1">{{$title}}</h4>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter text-nowrap table-bordered border-bottom tbl_1" data-url="{{route('admin.agent.index')}}">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">ردیف</th>
                                    <th class="border-bottom-0">کاربر</th>
                                    <th class="border-bottom-0">سن</th>
                                    <th class="border-bottom-0">وضعیت تاهل</th>
                                    <th class="border-bottom-0">کد ملی</th>
                                    <th class="border-bottom-0">میزان تحصیلات</th>
                                    <th class="border-bottom-0">شغل فعلی</th>
                                    <th class="border-bottom-0">زمان ثبت</th>
                                    <th class="border-bottom-0">نمایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $key=>$item)
                                        <tr class="{{$item->seen=='no'?'new_tr':''}}">
                                            <td>{{$key+1}}</td>
                                            <td>@if($item->sex=='man') <span>آقای</span> @else <span>خانم</span> @endif {{$item->user?$item->user->name:'__'}}</td>
                                            <td>{{$item->age?$item->age.' ساله ':'__'}}</td>
                                            <td>{{$item->marital?$item->marital->title:'__'}}</td>
                                            <td>{{$item->n_code?$item->n_code:'__'}}</td>
                                            <td>{{$item->education?$item->education->title:'__'}}</td>
                                            <td>{{$item->status_job?$item->status_job->title:'__'}}</td>
                                            <td>{{g2j($item->created_at,'Y/m/d H:i:s')}} </td>
                                            <td><a href="{{route('admin.agent.show',$item->id)}}" class="btn btn-sm btn-primary">اطلاعات درخواست</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>

@endsection
@section('script')

@endsection
