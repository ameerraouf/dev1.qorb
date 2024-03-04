@extends('frontEnd.layout')

@section('content')

    <section id="inner-headline">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li><a href="{{ route('Home') }}"><i class="fa fa-home"></i></a><i class="icon-angle-right"></i>
                        </li>
                        <li class="active">{{ __('cruds.Society.Title') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section id="content">
        <div class="container">
            <!-- بداية صفحة المجتمع -->
            <section class="content-row-no-bg" style="margin-top:2%; padding: 0 0 0 0">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="home-row-head">
                                <h2 class="heading">{{ __('cruds.Society.Title') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="panel-group mian-accordion" id="accordion">
                                <div class="boxes-faq">
                                    <div class="panel panel-default">
                                        <a class="box-faq" data-toggle="collapse" href="#society">
                                            <div class="content">
                                                <img src="https://placehold.co/400" alt="" class="img">
                                                <h3 class="title">
                                                    @if(app()->getLocale() == 'ar')
                                                        {{ $society->question_ar }}
                                                    @else
                                                        {{ $society->question_en }}
                                                    @endif
                                                </h3>
                                            </div>
                                            <div class="footer-box">
                                                <span class="name">{{ $society->user->name }}</span>
                                                <div class="btns">
                                                    <span class="btn"><i class="fa fa-eye" aria-hidden="true"></i>{{ $society->views }}</span>
                                                    <span class="btn"><i class="fa fa-commenting-o" aria-hidden="true"></i>{{ $society->replies->count() }}</span>
                                                </div>
                                            </div>
                                        </a>
                                        <div id="society" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <h5 class="text-black">{{ __('cruds.Society.Replies') }}:</h5>
                                                <div class="boxes-faq">
                                                 @foreach($society->replies as $reply)
                                                     <div class="box-comment">
                                                         <div class="info-user">
                                                         <img src="https://placehold.co/400" alt="" class="img">
                                                             <span class="name">{{ $reply->user->name }}</span>
                                                         </div>
                                                         <p class="content">{{ $reply->reply }}</p>
                                                     </div>
                                                     @endforeach
                                                </div>
                                                {{Form::open(['route'=>['replySociety',$society->id],'method'=>'POST'])}}
                                                 <div class="box-add-comment">
                                                     <textarea name="reply" class="form-control" placeholder="{{ __('cruds.Society.YourReply') }}"></textarea>
                                                     <button type="submit" class="btn btn-theme">{{ __('cruds.Society.Reply') }}</button>
                                                 </div>
                                                 {{Form::close()}}

                                            </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- نهاية صفحة المجتمع -->
        </div>
    </section>

@endsection
