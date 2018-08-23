@section('styles')
    <link rel="stylesheet" href="{{ asset('css/icheck.css') }}" type="text/css">
@stop
<div class="panel panel-primary">
    <div class="panel-body">
        <div class="nav-tabs-custom" id="user_tabs">
            <ul class="nav nav-tabs" style="display:list-item;">
                <li class="active">
                    <a href="#general"
                       data-toggle="tab" title="{{ trans('staff.info') }}"><i
                                class="material-icons md-24">info</i></a>
                </li>
                <li>
                    <a href="#logins"
                       data-toggle="tab" title="{{ trans('staff.login') }}"><i
                                class="material-icons md-24">lock</i></a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <div class="form-group">
                        <label class="control-label" for="title">{{trans('staff.full_name')}}</label>
                        <div class="controls">
                            {{ $staff->full_name }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="title">{{trans('staff.email')}}</label>
                        <div class="controls">
                            {{ $staff->email }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="title">{{trans('staff.phone_number')}}</label>
                        <div class="controls">
                            {{ $staff->phone_number }}
                        </div>
                    </div>
                    <div class="form-group">
                        @if(isset($staff->user_avatar))
                            <img src="{{ url('uploads/avatar/thumb_'.$staff->user_avatar) }}" alt="User Image">
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-content">
                                <h5>{{trans('staff.permissions')}}</h5>
                                <div class="row">
                                    <div class="col-md-2">
                                        <p><strong>{{trans('staff.sales_teams')}}</strong></p>
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="sales_team.read"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['sales_team.read'])) checked @endif>
                                                <i class="success"></i> {{trans('staff.read')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="sales_team.write"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['sales_team.write'])) checked @endif>
                                                <i class="warning"></i> {{trans('staff.write')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="sales_team.delete"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['sales_team.delete'])) checked @endif>
                                                <i class="danger"></i> {{trans('staff.delete')}} </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>{{trans('staff.leads')}}</strong></p>
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="leads.read"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['leads.read'])) checked @endif>
                                                <i class="success"></i> {{trans('staff.read')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="leads.write"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['leads.write'])) checked @endif>
                                                <i class="warning"></i> {{trans('staff.write')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="leads.delete"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['leads.delete'])) checked @endif>
                                                <i class="danger"></i> {{trans('staff.delete')}} </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>{{trans('staff.opportunities')}}</strong></p>
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="opportunities.read"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['opportunities.read'])) checked @endif>
                                                <i class="success"></i> {{trans('staff.read')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="opportunities.write"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['opportunities.write'])) checked @endif>
                                                <i class="warning"></i> {{trans('staff.write')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="opportunities.delete"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['opportunities.delete'])) checked @endif>
                                                <i class="danger"></i> {{trans('staff.delete')}} </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>{{trans('staff.logged_calls')}}</strong></p>
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="logged_calls.read"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['logged_calls.read'])) checked @endif>
                                                <i class="success"></i> {{trans('staff.read')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="logged_calls.write"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['logged_calls.write'])) checked @endif>
                                                <i class="warning"></i> {{trans('staff.write')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="logged_calls.delete"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['logged_calls.delete'])) checked @endif>
                                                <i class="danger"></i> {{trans('staff.delete')}} </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>{{trans('staff.meetings')}}</strong></p>
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="meetings.read"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['meetings.read'])) checked @endif>
                                                <i class="success"></i> {{trans('staff.read')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="meetings.write"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['meetings.write'])) checked @endif>
                                                <i class="warning"></i> {{trans('staff.write')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="meetings.delete"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['meetings.delete'])) checked @endif>
                                                <i class="danger"></i> {{trans('staff.delete')}} </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>{{trans('staff.products')}}</strong></p>
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="products.read"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['products.read'])) checked @endif>
                                                <i class="success"></i> {{trans('staff.read')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="products.write"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['products.write'])) checked @endif>
                                                <i class="warning"></i> {{trans('staff.write')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="products.delete"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['products.delete'])) checked @endif>
                                                <i class="danger"></i> {{trans('staff.delete')}} </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">&nbsp;</div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <p><strong>{{trans('staff.quotations')}}</strong></p>
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="quotations.read"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['quotations.read'])) checked @endif>
                                                <i class="success"></i> {{trans('staff.read')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="quotations.write"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['quotations.write'])) checked @endif>
                                                <i class="warning"></i> {{trans('staff.write')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="quotations.delete"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['quotations.delete'])) checked @endif>
                                                <i class="danger"></i> {{trans('staff.delete')}} </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>{{trans('staff.sales_orders')}}</strong></p>
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="sales_orders.read"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['sales_orders.read'])) checked @endif>
                                                <i class="success"></i> {{trans('staff.read')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="sales_orders.write"
                                                       disabled
                                                       class='icheck'
                                                       @if(isset($staff) && $staff->hasAccess(['sales_orders.write'])) checked @endif>
                                                <i class="warning"></i> {{trans('staff.write')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="sales_orders.delete"
                                                       disabled
                                                       class='icheck'
                                                       @if(isset($staff) && $staff->hasAccess(['sales_orders.delete'])) checked @endif>
                                                <i class="danger"></i> {{trans('staff.delete')}} </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>{{trans('staff.invoices')}}</strong></p>
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="invoices.read"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['invoices.read'])) checked @endif>
                                                <i class="success"></i> {{trans('staff.read')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="invoices.write"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['invoices.write'])) checked @endif>
                                                <i class="warning"></i> {{trans('staff.write')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="invoices.delete"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['invoices.delete'])) checked @endif>
                                                <i class="danger"></i> {{trans('staff.delete')}} </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>{{trans('staff.contracts')}}</strong></p>
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="contracts.read"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['contracts.read'])) checked @endif>
                                                <i class="success"></i> {{trans('staff.read')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="contracts.write"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['contracts.write'])) checked @endif>
                                                <i class="warning"></i> {{trans('staff.write')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="contracts.delete"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['contracts.delete'])) checked @endif>
                                                <i class="danger"></i> {{trans('staff.delete')}} </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>{{trans('staff.staff')}}</strong></p>
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="staff.read"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['staff.read'])) checked @endif>
                                                <i class="success"></i> {{trans('staff.read')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="staff.write"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['staff.write'])) checked @endif>
                                                <i class="warning"></i> {{trans('staff.write')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="staff.delete"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['staff.delete'])) checked @endif>
                                                <i class="danger"></i> {{trans('staff.delete')}} </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>{{trans('staff.contacts')}}</strong></p>
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="contacts.read"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['contacts.read'])) checked @endif>
                                                <i class="success"></i> {{trans('staff.read')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="contacts.write"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['contacts.write'])) checked @endif>
                                                <i class="warning"></i> {{trans('staff.write')}} </label>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="contacts.delete"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['contacts.delete'])) checked @endif>
                                                <i class="danger"></i> {{trans('staff.delete')}} </label>
                                        </div>
                                    </div><div class="col-md-2">
                                        <p><strong>{{trans('staff.social')}}</strong></p>
                                        <div class="input-group">
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="social.permission"
                                                       class='icheck' disabled
                                                       @if(isset($staff) && $staff->hasAccess(['social.permission'])) checked @endif>
                                                <i class="success"></i> {{trans('staff.permission')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="logins">
                    <table class="table table-striped table-bordered dataTable no-footer">
                        <thead>
                        <td>{{trans('staff.date_time')}}</td>
                        <td>{{trans('staff.ip_address')}}</td>
                        </thead>
                        <tbody>
                        @foreach($staff->logins as $login )
                            <tr>
                                <td>{{$login->created_at->format(Settings::get('date_format').' '. Settings::get('time_format'))}}</td>
                                <td>{{$login->ip_address}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url($type) }}" class="btn btn-primary"><i
                                class="fa fa-arrow-left"></i> {{trans('table.close')}}</a>
                @else
                    <a href="{{ url($type) }}" class="btn btn-primary"><i
                                class="fa fa-arrow-left"></i> {{trans('table.back')}}</a>
                    <button type="submit" class="btn btn-danger"><i
                                class="fa fa-trash"></i> {{trans('table.delete')}}</button>
                @endif
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        });
    </script>
@stop
