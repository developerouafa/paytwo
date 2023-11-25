<!-- main-header opened -->
			<div class="main-header sticky side-header nav nav-item">
				<div class="container-fluid">
					<div class="main-header-left ">
						<div class="responsive-logo">
							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo.png')}}" class="logo-1" alt="logo"></a>
							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="dark-logo-1" alt="logo"></a>
							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-2" alt="logo"></a>
							<a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="dark-logo-2" alt="logo"></a>
						</div>
						<div class="app-sidebar__toggle" data-toggle="sidebar">
							<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
							<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
						</div>
					</div>
					<div class="main-header-right">
                        <ul class="nav">
                            <li class="">
                                <div class="dropdown  nav-itemd-none d-md-flex">
                                    <a href="#" class="d-flex  nav-item nav-link pl-0 country-flag1" data-toggle="dropdown"
                                       aria-expanded="false">
                                        @if (App::getLocale() == 'ar')
                                            <span class="avatar country-Flag mr-0 align-self-center bg-transparent">
                                                <i class="flag-icon flag-icon-us"></i>
                                            </span>
                                            <strong
                                                class="mr-2 ml-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }}
                                            </strong>
                                        @else
                                            <span class="avatar country-Flag mr-0 align-self-center bg-transparent">
                                                <i class="flag-icon flag-icon-sa"></i>
                                            </span>
                                            <strong
                                                class="mr-2 ml-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }}
                                            </strong>
                                        @endif
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                               href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                @if($properties['native'] == "English")
                                                    <i class="flag-icon flag-icon-us"></i>
                                                @elseif($properties['native'] == "العربية")
                                                    <i class="flag-icon flag-icon-sa"></i>
                                                @endif
                                                {{ $properties['native'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                        </ul>
						<div class="nav nav-item  navbar-nav-right ml-auto">
							<div class="nav-link" id="bs-example-navbar-collapse-1">
								<form class="navbar-form" role="search">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Search">
										<span class="input-group-btn">
											<button type="reset" class="btn btn-default">
												<i class="fas fa-times"></i>
											</button>
											<button type="submit" class="btn btn-default nav-link resp-btn">
												<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
											</button>
										</span>
									</div>
								</form>
							</div>
							<div class="dropdown nav-item main-header-notification">
								<a class="new nav-link" href="#">
								<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                    @if (auth()->user()->unreadNotifications->count() > 0)
                                        <span class="pulse-danger"></span>
                                    @else
                                        <span class="pulse"></span>
                                    @endif
                                </a>
                                {{-- Notification Invoice --}}
                                <div class="dropdown-menu">
									<div class="menu-header-content bg-primary text-right">
										<div class="d-flex">
                                            <span class="badge-pill badge-warning">
                                                <a href="{{route('Notification.Readclient')}}" > markallread </a>
                                            </span>
										</div>
										<p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 pt-2 tx-12">
                                            <h6 style="color: yellow" id="notifications_count">
                                                {{__('Dashboard/main-header_trans.youhave')}}
                                                ({{auth()->user()->unreadNotifications->count()}}) {{__('Dashboard/main-header_trans.unreadntf')}}
                                            </h6>
                                        </p>
									</div>
									<div class="main-notification-list Notification-scroll" id="unreadNotifications">
                                        @forelse (auth()->user()->unreadNotifications as $notification)
                                            @if ($notification->type == 'App\Notifications\clienttouser')
                                                <a class="d-flex p-3 border-bottom" href="{{route('clienttouser',$notification->data['invoice_id'])}}">
                                                    <div class="notifyimg bg-pink">
                                                        <i class="mdi mdi-currency-usd ml-1"></i>
                                                    </div>
                                                    <div class="mr-3 ml-3">
                                                        <h5 class="notification-label mb-1">{{$notification->data['message']}}</h5>
                                                        <div class="notification-subtext">{{$notification->created_at->diffForHumans()}}</div>
                                                    </div>
                                                    <div class="mr-auto">
                                                        <i class="las la-angle-left text-left text-muted"></i>
                                                    </div>
                                                </a>
                                            @endif
                                            @if ($notification->type == 'App\Notifications\clienttouserinvoice')
                                                <a class="d-flex p-3 border-bottom" href="{{route('clienttouserinvoice',$notification->data['invoice_id'])}}">
                                                    <div class="notifyimg bg-purple">
                                                        <i class="mdi mdi-currency-usd ml-1"></i>
                                                    </div>
                                                    <div class="mr-3 ml-3">
                                                        <h5 class="notification-label mb-1">{{$notification->data['message']}}</h5>
                                                        <div class="notification-subtext">{{$notification->created_at->diffForHumans()}}</div>
                                                    </div>
                                                    <div class="mr-auto">
                                                        <i class="las la-angle-left text-left text-muted"></i>
                                                    </div>
                                                </a>
                                            @endif
                                        @empty
                                            {{__('Dashboard/main-header_trans.thereareno')}}
                                        @endforelse
									</div>
									<div class="dropdown-footer" style="cursor: pointer">
                                        <a class="nav-link pr-0" data-toggle="sidebar-left" data-target=".sidebar-left">
                                            {{__('Dashboard/main-header_trans.viewall')}}
                                        </a>
									</div>
								</div>
							</div>
							<div class="nav-item full-screen fullscreen-button">
								<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
							</div>
							<div class="dropdown main-profile-menu nav nav-item nav-link">
                                <?php
                                    use App\Models\User;
                                    $imageuser = User::query()->select('id')->where('id', '=', Auth::user()->id)->with('image')->get();
                                ?>
                                @foreach ($imageuser as $img)
                                    @if (empty($img->image->image))
                                        <a class="profile-user d-flex" href=""><img alt="" src="{{URL::asset('assets/img/faces/6.jpg')}}"></a>
                                    @else
                                        <a class="profile-user d-flex" href=""><img src="{{URL::asset('storage/'.$img->image->image)}}"></a>
                                    @endif
                                @endforeach
								<div class="dropdown-menu">
									<div class="main-header-profile bg-primary p-3">
										<div class="d-flex wd-100p">
                                            @foreach ($imageuser as $img)
                                                @if (empty($img->image->image))
                                                    <div class="main-img-user"><img alt="" src="{{URL::asset('assets/img/faces/6.jpg')}}" class=""></div>
                                                @else
                                                    <div class="main-img-user"><img alt="" src="{{URL::asset('storage/'.$img->image->image)}}" class=""></div>
                                                @endif
                                            @endforeach
											<div class="mr-3 my-auto">
												<h6>{{Auth::user()->name}} </h6>
											</div>
										</div>
									</div>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bx bx-user-circle"></i>{{__('Dashboard/profile.Update Profile')}}</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();"><i class="bx bx-log-out"></i>{{__('Dashboard/login_trans.logout')}}</a>
                                        </form>
								</div>
							</div>
							<div class="dropdown main-header-message right-toggle">
								<a class="nav-link pr-0" data-toggle="sidebar-left" data-target=".sidebar-left">
									<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
<!-- /main-header -->
