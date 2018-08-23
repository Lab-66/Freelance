

<div class="steps" >
    <ul class="list-inline">
        <li style="padding: 15px 15px 15px 15px">
            <a class="{{ isset($steps['welcome']) ? $steps['welcome'] : '' }}">
                <div class="stepNumber"><i class="fa fa-home"></i>
                    <span class="stepDesc text-small" style="margin-left: 5px; ">{{trans('install.welcome')}}</span></div>

            </a>
        </li>
        <li style="padding: 15px 15px 15px 15px">
            <a class="{{ isset($steps['requirements']) ? $steps['requirements'] : '' }}">
                <div class="stepNumber"><i class="fa fa-list"></i>
                <span class="stepDesc text-small" style="margin-left: 5px">{{trans('install.system_requirements')}}</span></div>
            </a>
        </li>
        <li style="padding: 15px 15px 15px 15px">
            <a class="{{ isset($steps['permissions']) ? $steps['permissions'] : '' }}">
                <div class="stepNumber"><i class="fa fa-lock"></i>
                <span class="stepDesc text-small" style="margin-left: 5px">{{trans('install.permissions')}}</span></div>
            </a>
        </li>
        <li style="padding: 15px 15px 15px 15px">
            <a class="{{ isset($steps['database']) ? $steps['database'] : '' }}">
                <div class="stepNumber"><i class="fa fa-database"></i>
                <span class="stepDesc text-small" style="margin-left: 5px">{{trans('install.database_info')}}</span></div>
            </a>
        </li>
        <li style="padding: 15px 15px 15px 15px">
            <a class="{{ isset($steps['installation']) ? $steps['installation'] : '' }}">
                <div class="stepNumber"><i class="fa fa-terminal" style="font-size: 20px; font-weight: bold"></i>
                <span class="stepDesc text-small" style="margin-left: 5px">{{trans('install.installation')}}</span></div>
            </a>
        </li>
        <li style="padding: 15px 15px 15px 15px">
            <a class="{{ isset($steps['settings']) ? $steps['settings'] : '' }}">
                <div class="stepNumber" ><i class="fa fa-wrench"></i>
                <span class="stepDesc text-small" style="margin-left: 5px">{{trans('install.settings')}}</span></div>
            </a>
        </li>
        <li style="padding: 15px 15px 15px 15px">
            <a class="{{ isset($steps['mail_settings']) ? $steps['mail_settings'] : '' }}">
                <div class="stepNumber"><i class="fa fa-envelope"></i>
                <span class="stepDesc text-small" style="margin-left: 5px">{{trans('install.mail_settings')}}</span></div>
            </a>
        </li>
        <li style="padding: 15px 15px 15px 15px" >
            <a class="{{ isset($steps['complete']) ? $steps['complete'] : '' }}">
                <div class="stepNumber"><i class="fa fa-flag-checkered"></i>
                <span class="stepDesc text-small" style="margin-left: 5px">{{trans('install.complete')}}</span></div>
            </a>
        </li>
    </ul>
</div>
