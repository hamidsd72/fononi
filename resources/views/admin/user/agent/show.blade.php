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
          {{$title.' '.$item->id}}
        @endslot
    @endcomponent
    <style>
      #lorem h5.title_form {
        background: #0647bf;
        padding: 7px 12px;
        color: #fff;
      }
    </style>
    
    <div id="lorem" class="row pb-5">
      <div class="col-12 p-0 my-2">
        <h5 class="title_form">اطلاعات شخصی</h5>
      </div>
      {{-- اطلاعات شخصی --}}
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>نام و نام خانوادگی</h6>
          <h6>{{$item->sex=='man'?' آقای ':' خانم '}}{{auth()->user()->name}}</h6>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>نام کاربری</h6>
          <h6>{{auth()->user()->username}}</h6>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>سن</h6>
          <h6>{{$item->age.' ساله '}}</h6>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>وضعیت تاهل</h6>
          <h6>{{$item->marital->title}}</h6>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>کد ملی</h6>
          <h6>{{$item->n_code}}</h6>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>میزان تحصیلات</h6>
          <h6>{{$item->education->title}}</h6>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>شغل فعلی</h6>
          <h6>{{$item->status_job->title}}</h6>
        </div>
      </div>
      <div class="col-lg-8 col-md">
        <div class="form-group">
          <h6>توضیحات</h6>
          <h6>{{$item->job_other}}</h6>
        </div>
      </div>
      <div class="col-12 p-0 my-2">
        <h5 class="title_form">اطلاعات ارتباطی</h5>
      </div>
      {{-- اطلاعات ارتباطی --}}
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>کشور</h6>
          <h6>{{$item->country_code}}</h6>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>موبایل</h6>
          <h6>{{$item->mobile}}</h6>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>شماره تلفن ثابت</h6>
          <h6>{{$item->phone}}</h6>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>ایمیل</h6>
          <h6>{{$item->email?$item->email:'___'}}</h6>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>آدرس وبسایت</h6>
          <h6>{{$item->website?$item->website:'___'}}</h6>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>کد پستی</h6>
          <h6>{{$item->postcode}}</h6>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <h6>آدرس </h6>
          <h6>{{$item->address}}</h6>
        </div>
      </div>
      <div class="col-12 d-ltr text-start">
        <div class="form-group">
          <h6>لینک شبکه های اجتماعی</h6>
          <h6>{{$item->social}}</h6>
        </div>
      </div>
      <div class="col-12 p-0 my-2">
        <h5 class="title_form">مهارت ها/افتخارات</h5>
      </div>
      {{-- مهارت ها/افتخارات --}}
      <div class="col-12">
        <div class="form-group">
          <h6>مهارت ها</h6>
          <h6>{{$item->skill}}</h6>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <h6>افتخارات و جوایز</h6>
          <h6>{{$item->award?$item->award:'___'}}</h6>
        </div>
      </div>
      <div class="col-12 p-0">
        <div class="container-fluid add_lang_list">
          <div class="row position-relative">
            <div class="col-md-6">
              <div class="form-group">
                <h6>زبان</h6>
                @foreach ($item->agent_langs()->get() as $my)
                  <h6>{{$my->list_lang->title}}</h6>
                @endforeach
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <h6>میزان تسلط</h6>
                @foreach ($item->agent_langs()->get() as $my)
                  <h6>@if($my->dominance=='low') مبتدی @elseif($my->dominance=='medium') متوسط @elseif($my->dominance=='top') عالی @else {{$my->dominance}} @endif</h6>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 p-0 my-2">
        <h5 class="title_form">سوالات</h5>
      </div>
      {{-- سوالات --}}
      <div class="col-md-6">
        <div class="form-group">
          <h6>میزان درآمد سالانه شما در حال حاضر</h6>
          <h6>{{$item->Income_before}}</h6>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <h6>میزان درآمد سالانه مد نظر شما از همکاری با ما</h6>
          <h6>{{$item->Income_after}}</h6>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <h6>تجربه فروش و فروشندگی</h6>
          <h6>{{$item->sale_experience=='yes'?'بلی':'خیر'}}</h6>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <h6>ویژگی خاصی برای تصدی این سمت</h6>
          <h6>{{$item->property}}</h6>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <h6>بزرگترین نقطه قوت</h6>
          <h6>{{$item->strength_big}}</h6>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <h6>بزرگترین نقطه ضعف</h6>
          <h6>{{$item->weakness_big}}</h6>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <h6>دلایل تمایل به همکاری</h6>
          <h6>{{$item->reasons}}</h6>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <h6>در 5 سال آینده خود را در چه جایگاهی تصور میکنید؟</h6>
          <h6>{{$item->year_5_after}}</h6>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          <h6>از چه طریقی با شرکت ما آشنا شدید؟</h6>
          <h6>{{$item->introduction?$item->introduction->title:'___'}}</h6>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          <h6>توضیحات</h6>
          <h6>{{$item->text}}</h6>
        </div>
      </div>
      <div class="col-12 p-0 my-2">
        <h5 class="title_form">فایل ها</h5>
      </div>
      {{-- فایل ها --}}
      
      <div class="col-lg-4">
        <div class="form-group">
          <h6>لینک ویدئو</h6>
          <h6><a href="{{url('/').'/'.$item->video}}" target="_blank" >{{$item->video?'نمایش فایل':'موجود نیست'}}</a></h6>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group">
          <h6>تصویر پروفایل</h6>
          <h6><a href="{{url('/'.\App\Models\User::find($item->user_id)->photo_profile()->first()->path?\App\Models\User::find($item->user_id)->photo_profile()->first()->path:'')}}" target="_blank" >{{\App\Models\User::find($item->user_id)->photo_profile()->first()->path?'نمایش فایل':'موجود نیست'}}</a></h6>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group">
          <h6>فایل رزومه</h6>
          <h6><a href="{{url('/'.$item->cv_file()->first()->path?$item->cv_file()->first()->path:'')}}" target="_blank" >{{$item->cv_file()->first()->path?'نمایش فایل':'موجود نیست'}}</a></h6>
        </div>
      </div>
    </div>
  </div>

  @endsection
  @section('script')
@endsection
  