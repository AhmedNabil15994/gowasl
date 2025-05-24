@extends('apps::Frontend.layouts.app')
@section('title', __('authentication::frontend.login.index.title') )
@section('content')
    <div class="container-fluid">
        <section class="page-head align-items-center text-center d-flex">
            <div class="container">
                <ul>
                    <li><a href="{{URL::to('/')}}"> {{__("apps::frontend.home")}} </a></li>/
                    <li class="active">{{__("apps::frontend.sign_up")}}</li>
                </ul>
            </div>
        </section>

        <div class="box-form">
            <div class="container">
                <div class="row">
                    <h2 class="h3">
                        <i class="bi bi-person-bounding-box"></i> {{__("apps::frontend.sign_up")}}
                    </h2>
                    <div class="col-12">
                        <form method="post" action="{{route('frontend.auth.register.post')}}">
                            @csrf
                            <div class="row filter-option">
                                <div class="col-12">
                                    <div class="form-label-group">
                                        <label>{{__("apps::frontend.full_name")}}</label>
                                        <input type="text" name="name" class="form-control rounded-pill" placeholder="{{__("apps::frontend.full_name")}}" required="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-label-group">
                                        <label>{{__("apps::frontend.your_email")}}</label>
                                        <input type="email" name="email" class="form-control rounded-pill" placeholder="{{__("apps::frontend.your_email")}}" required="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-label-group">
                                        <label>{{__("apps::frontend.mobile")}}</label>
                                        <input type="text" name="mobile" class="form-control rounded-pill" placeholder="{{__("apps::frontend.mobile")}}" required="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-label-group">
                                        <label>{{__("apps::frontend.birthday_optional")}}</label>
                                        <input type="date" name="birthday" class="form-control rounded-pill" required="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-label-group">
                                        <label for="exampleFormControlSelect1">{{__("apps::frontend.gender_p2")}}</label>
                                        <select class="form-control rounded-pill" id="exampleFormControlSelect1">
                                            <option value="1">{{__("apps::frontend.male")}}</option>
                                            <option value="2">{{__("apps::frontend.female")}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-label-group">
                                        <label>{{__("apps::frontend.password")}}</label>
                                        <input type="password" name="password" class="form-control rounded-pill" placeholder="{{__("apps::frontend.password")}}" required="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-label-group">
                                        <label>{{__("apps::frontend.confirm_password")}}</label>
                                        <input type="password" name="password_confirmation" class="form-control rounded-pill" placeholder="{{__("apps::frontend.confirm_password")}}" required="" autofocus="">
                                    </div>
                                </div>
                                <hr>
                                <h2 class="password-note mb-20">
                                    <span>*</span> {{__("apps::frontend.register_p")}}
                                </h2>
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" checked id="defaultCheck1" name="defaultCheck1">
                                        <label class="custom-control-label" for="defaultCheck1">{{__("apps::frontend.i_agree")}} <span class="btn-link-company text-dark">{{__("apps::frontend.i_agree_p")}}</span></label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox terms ">
                                        <input type="checkbox" class="custom-control-input" checked id="defaultCheck2" name="defaultCheck2">
                                        <label class="custom-control-label" for="defaultCheck2">{{__("apps::frontend.i_accept")}} <a target="_blank" href="{{route('frontend.terms')}}" class="btn-link-company text-dark">{{__("apps::frontend.i_accept_p")}}</a></label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn  btn-primary rounded-pill btn-w100 mt-20">{{__("apps::frontend.sign_up")}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
