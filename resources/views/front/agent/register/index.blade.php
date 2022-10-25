@extends('layouts.front',['select2'=>true,'req'=>true,'file_upload'=>true])
@section('styles')

@endsection
@section('body')

  <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1>{{$title}}</h1>
  </div>

  <div class="container mb-4 agent-register">
    <div class="row justify-center card-deck mb-3 text-center">
      @guest()
        <p class="text-justify alert alert-info">
          اگر اطلاعات کاربری دارید
          <a href="javascript:void(0);" data-bs-toggle="modal"
             data-bs-target="#login_modal">از این قسمت وارد شوید</a>
          در غیر اینصورت اطلاعات کاربری فرم را هم دقیق کامل کنید
        </p>
      @endguest
    </div>
    {{--    form--}}
    {{ Form::open(array('route' => 'front.agent.register.store', 'method' => 'POST','id'=>'form_req','files'=>true)) }}
    <div class="row">
      <div class="col-12">
        <h5 class="title_form">اطلاعات شخصی</h5>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('name', 'نام و نام خانوادگی *')}}
          @guest()
            {{Form::text('name', null, array('class' => 'form-control','required'))}}
          @else
            {{Form::text('name', Auth::user()->name, array('class' => 'form-control','readonly'))}}
          @endguest
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('username', 'نام کاربری *')}}
          @guest()
            {{Form::text('username', null, array('class' => 'form-control d-ltr text-start','required'))}}
          @else
            {{Form::text('username', Auth::user()->username, array('class' => 'form-control d-ltr text-start','readonly'))}}
          @endguest
        </div>
      </div>
      @guest()
        <div class="col-md-6">
          <div class="form-group">
            {{Form::label('password', 'رمز عبور *')}}
            {{Form::password('password', array('class' => 'form-control d-ltr text-start','autocomplete'=>'current-password','required'))}}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            {{Form::label('password_confirmation', 'تکرار رمز عبور *')}}
            {{Form::password('password_confirmation', array('class' => 'form-control d-ltr text-start','autocomplete'=>'current-password','required'))}}
          </div>
        </div>
      @endguest
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('sex', 'جنسیت *')}}
          {{ Form::select('sex', ['man'=>'آقا','woman'=>'خانم'], null, array('class' => 'form-control','required')) }}
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('age', 'سن *')}}
          {{Form::number('age', null, array('class' => 'form-control d-ltr text-start','min'=>10,'max'=>100,'required'))}}
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('marital_id', 'وضعیت تاهل *')}}
          {{ Form::select('marital_id', array_pluck($maritals, 'title', 'id'), null, array('class' => 'form-control select2-show-search custom-select','required')) }}
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('n_code', 'کد ملی *')}}
          {{Form::number('n_code', null, array('class' => 'form-control d-ltr text-start','required'))}}
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('education_id', 'میزان تحصیلات *')}}
          {{ Form::select('education_id', array_pluck($educations, 'title', 'id'), null, array('class' => 'form-control select2-show-search custom-select','required')) }}
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('job_status_id', 'شغل فعلی *')}}
          <select name="job_status_id" id="job_status_id" class="form-control select2-show-search">
            @foreach($status_jobs as $status_job)
              <option value="{{$status_job->id}}" data-text="{{$status_job->text_other}}">{{$status_job->title}}</option>
            @endforeach
          </select>
        </div>
      </div>
      @php
      $text_other=false;
        if(old('job_status_id'))
        {
            $status_job_set=App\Models\StatusJob::find(old('job_status_id'));
            if($status_job_set && $status_job_set->text_other=='yes')
                {
                     $text_other=true;
                }
        }
        if(count($status_jobs) && $status_jobs[0]->text_other=='yes')
            {
                 $text_other=true;
            }
      @endphp
      <div class="col-lg-4 col-md-6 job_status_text {{$text_other?'':'d-none'}}">
        <div class="form-group">
          {{Form::label('job_other', 'توضیح *')}}
          {{ Form::text('job_other', null, array('class' => 'form-control job_status_text_input',$text_other?'required':'')) }}
        </div>
      </div>
      <div class="col-12">
        <h5 class="title_form">اطلاعات ارتباطی</h5>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('country_code', 'کد کشور *')}}
          {{ Form::select('country_code', array_pluck_2($country_codes, 'title','phone_code', 'phone_code'), null, array('class' => 'form-control select2-show-search custom-select','required')) }}
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('mobile', 'موبایل(دارای واتساپ) *')}}
          {{Form::number('mobile', null, array('class' => 'form-control d-ltr text-start','placeholder'=>'شماره موبایل را بدون صفر ابتدایی وارد کنید','required'))}}
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('phone', 'شماره تلفن ثابت *')}}
          {{Form::number('phone', null, array('class' => 'form-control d-ltr text-start','placeholder'=>'شماره تلفن را بدون صفر ابتدایی و با کد شهر وارد کنید','required'))}}
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('email', 'ایمیل *')}}
          @guest()
            {{Form::text('email', null, array('class' => 'form-control d-ltr text-start','required'))}}
          @else
            {{Form::email('email', Auth::user()->email, array('class' => 'form-control d-ltr text-start','readonly'))}}
          @endguest
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('website', 'آدرس وبسایت')}}
          {{Form::url('website', null, array('class' => 'form-control d-ltr text-start'))}}
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          {{Form::label('address', 'آدرس *')}}
          {{Form::text('address', null, array('class' => 'form-control','placeholder'=>'لطفا آدرس را کامل وارد کنید','required'))}}
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('postcode', 'کد پستی')}}
          {{Form::number('postcode', null, array('class' => 'form-control d-ltr text-start'))}}
        </div>
      </div>
      <div class="col-12 d-ltr text-start">
        <div class="form-group">
          {{Form::label('social', 'لینک شبکه های اجتماعی(حداقل 1 مورد) *')}}
          {{Form::text('social', null, array('class' => 'form-control','data-choices','data-choices-limit'=>'5','data-choices-removeItem','required'))}}
        </div>
      </div>
      <div class="col-12">
        <h5 class="title_form">مهارت ها/افتخارات</h5>
      </div>
      <div class="col-12">
        <div class="form-group">
          {{Form::label('skill', 'مهارت ها(حداکثر 12 مورد)')}}
          {{Form::text('skill', null, array('class' => 'form-control','data-choices','data-choices-limit'=>'12','data-choices-removeItem'))}}
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          {{Form::label('award', 'افتخارات و جوایز')}}
          {{ Form::textarea('award', null, array('class' => 'form-control','rows'=>2)) }}
        </div>
      </div>
      <div class="col-12">
        <div class="container-fluid add_lang_list">
          <div class="row position-relative">
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('lang_id', 'زبان *')}}
                {{ Form::select('lang_id[]', array_pluck($list_langs, 'title', 'id'), null, array('class' => 'form-control select2-show-search custom-select','required')) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{Form::label('dominance', 'میزان تسلط *')}}
                {{ Form::select('dominance[]', ['low'=>'مبتدی','medium'=>'متوسط','top'=>'عالی'], null, array('class' => 'form-control','required')) }}
              </div>
            </div>
          </div>
        </div>
        <button type="button" class="btn-default add_row_lang" data-bs-toggle="tooltip"
                data-bs-placement="top" title="افزودن زبان">
          <i class="fas fa-plus"></i>
        </button>
      </div>
      <div class="col-12">
        <h5 class="title_form">سوالات</h5>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          {{Form::label('Income_before', 'میزان درآمد سالانه شما در حال حاضر چقدر است؟')}}
          {{Form::text('Income_before', null, array('class' => 'form-control'))}}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          {{Form::label('Income_after', 'میزان درآمد سالانه مد نظر شما از همکاری با ما چقدر است؟')}}
          {{Form::text('Income_after', null, array('class' => 'form-control'))}}
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          {{Form::label('sale_experience', 'آیا تجربه فروش و فروشندگی داشته اید ؟')}}
          {{ Form::select('sale_experience', ['no'=>'خیر','yes'=>'بلی'], null, array('class' => 'form-control')) }}
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          {{Form::label('property', 'آیا دارای ویژگی خاصی برای تصدی این سمت هستید؟')}}
          {{ Form::textarea('property', null, array('class' => 'form-control','rows'=>2)) }}
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          {{Form::label('strength_big', 'بزرگترین نقطه قوت شما چیست؟ *')}}
          {{ Form::textarea('strength_big', null, array('class' => 'form-control','rows'=>2,'required')) }}
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          {{Form::label('weakness_big', 'بزرگترین نقطه ضعف شما چیست؟ *')}}
          {{ Form::textarea('weakness_big', null, array('class' => 'form-control','rows'=>2,'required')) }}
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          {{Form::label('reasons', 'دلایل تمایل شما به همکاری با ما چیست؟ *')}}
          {{ Form::textarea('reasons', null, array('class' => 'form-control','rows'=>4,'required')) }}
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          {{Form::label('year_5_after', 'در 5 سال آینده خود را در چه جایگاهی تصور میکنید؟')}}
          {{ Form::textarea('year_5_after', null, array('class' => 'form-control','rows'=>4)) }}
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="form-group">
          {{Form::label('introduction_id', 'از چه طریقی با شرکت ما آشنا شدید؟')}}
          {{ Form::select('introduction_id', array_pluck($introductions, 'title', 'id'), null, array('class' => 'form-control select2-show-search custom-select')) }}
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
          {{Form::label('text', 'توضیحات')}}
          {{ Form::textarea('text', null, array('class' => 'form-control','rows'=>4)) }}
        </div>
      </div>
      <div class="col-12">
        <h5 class="title_form">فایل ها</h5>
      </div>

      <div class="col-12">
        <div class="form-group">
          {{Form::label('video', 'لینک ویدئو در مورد خودتان')}}
          {{Form::url('video', null, array('class' => 'form-control d-ltr text-start'))}}
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          @if(auth()->check())
            {{Form::label('photo_profile', auth()->user()->photo_profile?'تصویر پروفایل':'تصویر پروفایل *')}}
          @else
            {{Form::label('photo_profile', 'تصویر پروفایل *')}}
          @endif
          @if(auth()->check())
          {{Form::file('photo_profile', array('class' => 'dropify','data-height'=>'180','accept' => '.jpg,.jpeg,.png','data-default-file'=>auth()->user()->photo_profile && is_file(auth()->user()->photo_profile->path)?url(auth()->user()->photo_profile->path):null,auth()->user()->photo_profile?'':'required'))}}
          @else
          {{Form::file('photo_profile', array('class' => 'dropify','data-height'=>'180','accept' => '.jpg,.jpeg,.png','required'))}}
          @endif
        </div>
        <p class="text-danger">_<small>حداکثر حجم تصویر 5Mb می باشد</small></p>
        <p class="text-danger">_<small>بهترین سایز تصویر معادل عرض 300 پیکسل در ارتفاع 280 پیکسل می باشد</small></p>
        <p class="text-danger">_<small>فرمت تصویر فقط باید JPG,JPEG,PNG باشد</small></p>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          {{Form::label('cv_file', 'فایل رزومه ')}}
          {{Form::file('cv_file', array('class' => 'dropify','data-height'=>'180','accept' => '.zip,.rar,.pdf'))}}
        </div>
        <p class="text-danger">_<small>حداکثر حجم فایل 30Mb می باشد</small></p>
        <p class="text-danger">_<small>فرمت فقط باید ZIP,RAR,PDF باشد</small></p>
      </div>
      <div class="col-md-12 text-start">
        <hr/>
        {{Form::submit('ثبت اطلاعات',array('class'=>'btn btn-primary float-start','onclick'=>"return confirm('برای ارسال فرم مطمئن هستید؟')"))}}
      </div>
    </div>
    {{ Form::close() }}
  </div>


@endsection
@section('scripts_one')
  <script type="text/javascript" src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
@endsection
@section('scripts')
  <script>
      let i=1;
      let count= {{count($list_langs)}};
      $('.add_row_lang').click(function (){
          i++;
          $('.add_lang_list').append('<div class="row position-relative row_lang_'+i+'">\n' +
              '<button type="button" class="btn btn-danger remove_row_lang" onclick="remove_row_lang('+i+')"><i class="fas fa-close"></i> </button>' +
              '            <div class="col-md-6">\n' +
              '              <div class="form-group">\n' +
              '                {{Form::label("lang_id", "زبان *")}}\n' +
              '                {{ Form::select("lang_id[]", array_pluck($list_langs, "title", "id"), null, array("class" => "form-control select2-show-search custom-select","required")) }}\n' +
              '              </div>\n' +
              '            </div>\n' +
              '            <div class="col-md-6">\n' +
              '              <div class="form-group">\n' +
              '                {{Form::label("dominance", "میزان تسلط *")}}\n' +
              '                {{ Form::select("dominance[]", ["low"=>"مبتدی","medium"=>"متوسط","top"=>"عالی"], null, array("class" => "form-control","required")) }}\n' +
              '              </div>\n' +
              '            </div>\n' +
              '          </div>')

          if(count<=i)
          {
              $('.add_row_lang').addClass('d-none')
          }
      })
      function remove_row_lang(remove_id)
      {
          i--;
          $('.row_lang_'+remove_id).remove()
          if(count>i)
          {
              $('.add_row_lang').removeClass('d-none')
          }
      }
  </script>
@endsection


