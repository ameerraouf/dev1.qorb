<?php
// Current Full URL
$fullPagePath = Request::url();
// Char Count of Backend folder Plus 1
$envAdminCharCount = strlen('teacher') + 1;
// URL after Root Path EX: admin/home
$urlAfterRoot = substr($fullPagePath, strpos($fullPagePath, 'teacher') + $envAdminCharCount);
$mnu_title_var = "title_" . @Helper::currentLanguage()->code;
$mnu_title_var2 = "title_" . env('DEFAULT_LANGUAGE');
?> 

<div id="aside" class="app-aside modal fade folded md nav-expand">
    <div class="left navside dark dk" layout="column">
        <div class="navbar navbar-md no-radius">
            <!-- brand -->
            <a class="navbar-brand" href="{{ route('teacher.teacherhome') }}">
                <img src="{{ asset('assets/dashboard/images/logo.png') }}" alt="Control">
                <span class="hidden-folded inline">{{ __('backend.control') }}</span>
            </a>
            <!-- / brand -->
        </div>
        <div flex class="hide-scroll">
            <nav class="scroll nav-active-primary">

                <ul class="nav" ui-nav>
                    <li class="nav-header hidden-folded">
                        <small class="text-muted">{{ __('backend.main') }}</small>
                    </li>
                    <?php
                        $currentFolder = "teacher"; // Put folder name here
                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                        ?>

                    <li  {{ ($PathCurrentFolder==$currentFolder) ? 'class=active' : '' }}>
                        <a href="{{ route('teacher.teacherhome') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe3fc;</i>
                            </span>
                            <span class="nav-text">{{ __('backend.dashboard') }}</span>
                        </a>
                    </li>
                    <?php
                    $currentFolder = "childrens"; // Put folder name here
                    $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                    ?>
                    <li class=" {{ request()->is('*childrens*') ? 'active' : '' }}">
                        <a href="{{ route('childrens.index') }}" >
                            <span class="nav-icon">
                                <i class="material-icons">&#xe3fc;</i>
                            </span>
                            <span class="nav-text">{{ __('backend.childrens') }}</span>
                        </a>
                    </li>
                   
                    <li>
                        <a>
                            <span class="nav-caret">
                                <i class="fa fa-caret-down"></i>
                            </span>
                            <span class="nav-icon">
                                <i class="material-icons">&#xe1b8;</i>
                            </span>
                            <span class="nav-text">{{ __('backend.package') }}</span>
                        </a>
                        <ul class="nav-sub">
                            <?php
                            $currentFolder = "packages"; // Put folder name here
                            $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                            ?>
                            <li {{ request()->is('*packages*') ? 'active' : '' }}>
                                <a href="{{ route('TeacherPackages') }}">
                                    <span
                                        class="nav-text">{{ __('backend.package') }}</span>
                                </a>
                            </li>
                            <?php
                                $currentFolder = "transactions"; // Put folder name here
                                $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                                ?>
                            <li {{ request()->is('*transactions*') ? 'active' : '' }}>
                                <a href="#">
                                    <span
                                        class="nav-text">{{ __('backend.purchaseTransaction') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php
                        $currentFolder = "profile"; // Put folder name here
                        $PathCurrentFolder = substr($urlAfterRoot, 0, strlen($currentFolder));
                        ?>
                    <li {{ request()->is('/teacher/profile') ? 'active' : '' }}>
                        <a href="{{ route('TeacherProfile') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe3fc;</i>
                            </span>
                            <span class="nav-text">{{ __('backend.profile') }}</span>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
</div>
