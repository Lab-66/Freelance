<div class="panel panel-primary">
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title"><b>{{ $company->name }}</b></label>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>{{trans('company.cash_information')}}</h3>

                <div class="row">
                    <div class="col-sm-2">
                        <div class="number c-primary">${{$total_sales}} </div>
                        <div class="txt">{{trans('company.total_sales')}}</div>
                    </div>
                    <div class="col-sm-2">
                        <div class="number c-green">${{ $open_invoices}} </div>
                        <div class="txt">{{trans('company.open_invoices')}}</div>
                    </div>
                    <div class="col-sm-2">
                        <div class="number c-red">${{ $overdue_invoices}} </div>
                        <div class="txt">{{trans('company.overdue_invoices')}}</div>
                    </div>
                    <div class="col-sm-2">
                        <div class="number c-blue">${{ $paid_invoices}} </div>
                        <div class="txt">{{trans('company.paid_invoices')}}</div>
                    </div>
                    <div class="col-sm-2">
                        <div class="number c-blue">${{ $quotations_total}} </div>
                        <div class="txt">{{trans('company.quotations_total')}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <h3>{{trans('company.customer_activities')}}</h3>

                <div class="widget-infobox row">
                    <div class="infobox col-sm-2">
                        <div class="left">
                            <i class="fa fa-phone bg-red"></i>
                        </div>
                        <div class="right">
                            <div class="clearfix">
                                <div>
                                    <span class="c-red pull-left">{{ $calls}}</span>
                                    <br>
                                </div>
                                <div class="txt">{{trans('company.calls')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="infobox col-sm-2">
                        <div class="left">
                            <i class="icon-user bg-yellow"></i>
                        </div>
                        <div class="right">
                            <div class="clearfix">
                                <div>
                                    <span class="c-yellow pull-left">{{$meeting}}</span>
                                    <br>
                                </div>
                                <div class="txt">{{trans('company.meeting')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="infobox col-sm-2">
                        <div class="left">
                            <i class="fa fa-shopping-cart bg-blue"></i>
                        </div>
                        <div class="right">
                            <div>
                                <span class="c-primary pull-left">{{ $salesorder}}</span>
                                <br>
                            </div>
                            <div class="txt">{{trans('company.salesorder')}}</div>
                        </div>
                    </div>
                    <div class="infobox col-sm-2">
                        <div class="left">
                            <i class="icon-note bg-purple"></i>
                        </div>
                        <div class="right">
                            <div class="clearfix">
                                <div>
                                    <span class="c-purple pull-left">{{ $invoices}}</span>
                                    <br>
                                </div>
                                <div class="txt">{{trans('company.invoices')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="infobox col-sm-2">
                        <div class="left">
                            <i class="icon-tag bg-orange"></i>
                        </div>
                        <div class="right">
                            <div class="clearfix">
                                <div>
                                    <span class="c-orange pull-left">{{ $quotations}}</span>
                                    <br>
                                </div>
                                <div class="txt">{{trans('company.quotations')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-infobox row">
                    <div class="infobox col-sm-2">
                        <div class="left">
                            <i class="icon-envelope bg-pink"></i>
                        </div>
                        <div class="right">
                            <div class="clearfix">
                                <div>
                                    <span class="c-purple pull-left">{{ $emails}}</span>
                                    <br>
                                </div>
                                <div class="txt">{{trans('company.emails')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="infobox col-sm-2">
                        <div class="left">
                            <i class="icon-hourglass bg-dark"></i>
                        </div>
                        <div class="right">
                            <div class="clearfix">
                                <div>
                                    <span class="c-dark pull-left">{{ $contracts}}</span>
                                    <br>
                                </div>
                                <div class="txt">{{trans('company.contracts')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <h3>{{trans('company.customer_details')}}</h3>

                <div class="panel widget-member2">
                    <div class="row">
                        <div class="col-lg-2 col-xs-3">
                            @if($company->company_avatar)
                                <img src="{{ url('uploads/company/'.$company->company_avatar)}}" alt="profil 4"
                                     class="pull-left img-responsive thumbnail" style="height: 81px;width:81px;">
                            @else
                                <img src=" {{url('uploads/avatar/user.png')}}" alt="user image"
                                     class="pull-left img-responsive thumbnail" style="height: 81px;width:81px;">
                            @endif
                        </div>
                        <div class="col-lg-10 col-xs-9">
                            <div class="row">
                                @if($company->address)
                                    <div class="col-sm-12">
                                        <p>
                                            <i class="fa fa-map-marker c-gray-light p-r-10"></i> {{ $company->address}}
                                        </p>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                @if(!empty($company->website))
                                    <div class="col-xlg-4 col-lg-6 col-sm-4">
                                        <p>
                                            <i class="fa fa-globe c-gray-light p-r-10"></i> {{ $company->website}}
                                        </p>
                                    </div>
                                @endif
                                @if(isset($company->email))
                                    <div class="col-xlg-4 col-lg-6 col-sm-4 align-right">
                                        <p>
                                            <i class="fa fa-envelope  c-gray-light"></i> {{ $company->email}}
                                        </p>
                                    </div>
                                @endif
                                @if(isset($company->phone))
                                    <div class="col-xlg-4 col-lg-6 col-sm-4">
                                        <p>
                                            <i class="fa fa-phone c-gray-light"></i> {{  $company->phone}}
                                        </p>
                                    </div>
                                @endif
                                @if(!empty($company->fax))
                                    <div class="col-xlg-4 col-lg-6 col-sm-4 align-right">
                                        <p><i class="fa fa-fax c-gray-light"></i> {{ $company->fax}}
                                        </p>
                                    </div>
                                @endif
                                @if(isset($company->contactPerson))
                                    <div class="col-xlg-4 col-lg-6 col-sm-4 align-right">
                                        <p>
                                            <i class="fa fa-user c-gray-light p-r-10"></i> {{ $company->contactPerson->full_name}}
                                        </p>
                                    </div>
                                @endif
                                @if(isset($company->salesTeam))
                                <div class="col-xlg-4 col-lg-6 col-sm-4">
                                    <p><i class="fa fa-check c-gray-light"></i> {{ $company->salesTeam->salesteam}}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="form-group">
                <div class="controls">
                    @if (@$action == 'show')
                        <a href="{{ url($type) }}" class="btn btn-primary"><i
                                    class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                    @else
                        <a href="{{ url($type) }}" class="btn btn-primary"><i
                                    class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                        <button type="submit" class="btn btn-danger"><i
                                    class="fa fa-trash"></i> {{trans('table.delete')}}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
