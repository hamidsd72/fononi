@extends('layouts.master',['tbl'=>true])
@section('title')
    {{$title}}
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            کاربران/ارزیابی
        @endslot
        @slot('title')
            {{$title}}
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{$title}}</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap table-bordered border-bottom tbl_1" data-url="{{route('admin.activity.index')}}">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">ردیف</th>
                                <th class="border-bottom-0">کاربر</th>
                                <th class="border-bottom-0">شغل</th>
                                <th class="border-bottom-0">وضعیت</th>
                                <th class="border-bottom-0">cv</th>
                                <th class="border-bottom-0"> گواهینامه رانندگی</th>
                                <th class="border-bottom-0">گواهینامه رانندگی بین المللی</th>
                                <th class="border-bottom-0">اطلاعات کافی درمورد شرایط کار در اروپا</th>
                                <th class="border-bottom-0">مهارت های زبان</th>
                                <th class="border-bottom-0">مشاوره شخصی</th>
                                <th class="border-bottom-0">زمان ثبت</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $key=>$item)
                                <tr class="{{$item->seen=='no'?'new_tr':''}}">
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->user?$item->user->name:'__'}}</td>
                                    <td>{{$item->job?$item->job->title:'__'}}</td>
                                    <td>{!! $item->status=='pending'?'<span class="badge bg-danger">تکمیل نشده</span>':'<span class="badge bg-success">تکمیل</span>' !!}</td>
                                    <td class="text-center">
                                        {{$item->level_1_cv=='no'?'خیر':'بلی'}}
                                        @if($item->f1)
                                        <p class="text-center mt-3 mb-0">
                                            <a href="{{url($item->f1->path)}}" download="">
                                                دانلود پیوست
                                            </a>
                                        </p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{$item->level_2_certificate=='no'?'خیر':'بلی'}}
                                        @if($item->f2)
                                            <p class="text-center mt-3 mb-0">
                                                <a href="{{url($item->f2->path)}}" download="">
                                                    دانلود پیوست
                                                </a>
                                            </p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{$item->level_3_certificate=='no'?'خیر':'بلی'}}
                                        @if($item->f3)
                                            <p class="text-center mt-3 mb-0">
                                                <a href="{{url($item->f3->path)}}" download="">
                                                    دانلود پیوست
                                                </a>
                                            </p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{$item->level_4_info=='no'?'خیر':'بلی'}}
                                        @if($item->f4)
                                            <p class="text-center mt-3 mb-0">
                                                <a href="{{url($item->f4->path)}}" download="">
                                                    دانلود پیوست
                                                </a>
                                            </p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{$item->level_5_lang=='no'?'خیر':'بلی'}}
                                        @if($item->f5)
                                            <p class="text-center mt-3 mb-0">
                                                <a href="{{url($item->f5->path)}}" download="">
                                                    دانلود پیوست
                                                </a>
                                            </p>
                                        @endif
                                    </td>
                                    <td class="text-center">{{$item->level_6_counseling=='no'?'خیر':'بلی'}} </td>
                                    <td>{{g2j($item->created_at,'Y/m/d H:i:s')}} </td>
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
