<div id="aside" class="app-aside modal fade folded md nav-expand">
    <div class="left navside dark dk" layout="column">
        <div class="navbar navbar-md no-radius">
            <!-- brand -->
            <a class="navbar-brand" href="{{ route('supervisorHome') }}">
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

                    <li>
                        <a href="{{ route('supervisorHome') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe3fc;</i>
                            </span>
                            <span class="nav-text">{{ __('backend.dashboard') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('SChildrens') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe3fc;</i>
                            </span>
                            <span class="nav-text">{{ __('backend.Children') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('SFTransactions') }}">
                            <span class="nav-icon">
                                <i class="material-icons">&#xe1b8;</i>
                            </span>
                            <span class="nav-text">{{ __('cruds.FinancialTransactions.Title') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('SProfile') }}">
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
