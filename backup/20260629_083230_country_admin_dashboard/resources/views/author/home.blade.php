@extends('author.layouts.main')
@section('content')

	<div class="layout-content">

                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">Dashboard</h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active">Main</li>
                            </ol>
                        </div>
                        	<center ><h1 style=" font-weight: 900; color: red; font-size: 55px; ">Coming Soon</h1></center>
                        <div class="row">
                            <!-- 1st row Start -->
                            <div class="col-lg-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="">
                                                        <h2 class="mb-2"> 256 </h2>
                                                        <p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p>
                                                    </div>
                                                    <div class="lnr lnr-leaf display-4 text-primary"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="">
                                                        <h2 class="mb-2">8451</h2>
                                                        <p class="text-muted mb-0"><span class="badge badge-success">20%</span> Stock</p>
                                                    </div>
                                                    <div class="lnr lnr-chart-bars display-4 text-success"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="">
                                                        <h2 class="mb-2"> 31% <small></small></h2>
                                                        <p class="text-muted mb-0">New <span class="badge badge-danger">20%</span> Customer</p>
                                                    </div>
                                                    <div class="lnr lnr-rocket display-4 text-danger"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="">
                                                        <h2 class="mb-2">158</h2>
                                                        <p class="text-muted mb-0"><span class="badge badge-warning">$143.45</span> Profit</p>
                                                    </div>
                                                    <div class="lnr lnr-cart display-4 text-warning"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="card d-flex w-100 mb-4">
                                            <div class="row no-gutters row-bordered row-border-light h-100">
                                                <div class="d-flex col-md-6 align-items-center">
                                                    <div class="card-body">
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                                <i class="lnr lnr-users text-primary display-4"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="mb-0 text-muted">Unique <span class="text-primary">Visitors</span></h6>
                                                                <h4 class="mt-3 mb-0">652<i class="ion ion-md-arrow-round-down ml-3 text-danger"></i></h4>
                                                            </div>
                                                        </div>
                                                        <p class="mb-0 text-muted">36% From Last 6 Months</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex col-md-6 align-items-center">
                                                    <div class="card-body">
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                                <i class="lnr lnr-magic-wand text-primary display-4"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6 class="mb-0 text-muted">Monthly <span class="text-primary">Earnings</span></h6>
                                                                <h4 class="mt-3 mb-0">5963<i class="ion ion-md-arrow-round-up ml-3 text-success"></i></h4>
                                                            </div>
                                                        </div>
                                                        <p class="mb-0 text-muted">36% From Last 6 Months</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="card mb-4">
                                    <div class="card-header with-elements">
                                        <h6 class="card-header-title mb-0">Statistics</h6>
                                        <div class="card-header-elements ml-auto">
                                            <label class="text m-0">
                                                <span class="text-light text-tiny font-weight-semibold align-middle">SHOW STATS</span>
                                                <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2"><input type="checkbox" class="switcher-input" checked=""><span class="switcher-indicator"><span class="switcher-yes"></span><span class="switcher-no"></span></span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="statistics-chart-1" style="height: 300px; position: relative;"><div dir="ltr" class="resize-sensor" style="pointer-events: none; position: absolute; inset: 0px; overflow: hidden; z-index: -1; visibility: hidden; max-width: 100%;"><div class="resize-sensor-expand" style="pointer-events: none; position: absolute; left: 0px; top: 0px; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden; max-width: 100%;"><div style="position: absolute; left: 0px; top: 0px; transition: all 0s ease 0s; width: 879px; height: 310px;"></div></div><div class="resize-sensor-shrink" style="pointer-events: none; position: absolute; left: 0px; top: 0px; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden; max-width: 100%;"><div style="position: absolute; left: 0; top: 0; transition: 0s; width: 200%; height: 200%"></div></div></div><div style="width: 100%; height: 100%; position: relative; left: 0.078125px; top: 0.25px;"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" role="group" style="width: 100%; height: 100%; overflow: visible;"><desc>JavaScript chart by amCharts</desc><defs><clipPath id="id-27"><rect width="869" height="300"></rect></clipPath><linearGradient id="gradient-id-50" x1="1%" x2="99%" y1="59%" y2="41%"><stop stop-color="#474758" offset="0"></stop><stop stop-color="#474758" stop-opacity="1" offset="0.75"></stop><stop stop-color="#3cabff" stop-opacity="1" offset="0.755"></stop></linearGradient><filter id="filter-id-56" width="200%" height="200%" x="-50%" y="-50%"></filter><filter id="filter-id-75" width="200%" height="200%" x="-50%" y="-50%"></filter><clipPath id="id-110"><path d="M0,0 L794,0 L794,232 L0,232 L0,0"></path></clipPath><clipPath id="id-127"><path d="M0,0 L794,0 L794,232 L0,232 L0,0"></path></clipPath><clipPath id="id-326"><rect width="794" height="232"></rect></clipPath><filter id="filter-id-29" width="200%" height="200%" x="-50%" y="-50%"><feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5"></feGaussianBlur><feOffset result="offsetBlur" dx="1" dy="1"></feOffset><feFlood flood-color="#000000" flood-opacity="0.5"></feFlood><feComposite in2="offsetBlur" operator="in"></feComposite><feMerge><feMergeNode></feMergeNode><feMergeNode in="SourceGraphic"></feMergeNode></feMerge></filter><filter id="filter-id-47" width="120%" height="120%" x="-10%" y="-10%"><feColorMatrix type="saturate" values="0"></feColorMatrix></filter><filter id="filter-id-112" width="200%" height="200%" x="-50%" y="-50%"><feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5"></feGaussianBlur><feOffset result="offsetBlur" dx="1" dy="1"></feOffset><feFlood flood-color="#000000" flood-opacity="0.5"></feFlood><feComposite in2="offsetBlur" operator="in"></feComposite><feMerge><feMergeNode></feMergeNode><feMergeNode in="SourceGraphic"></feMergeNode></feMerge></filter><filter id="filter-id-129" width="200%" height="200%" x="-50%" y="-50%"><feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="1.5"></feGaussianBlur><feOffset result="offsetBlur" dx="1" dy="1"></feOffset><feFlood flood-color="#000000" flood-opacity="0.5"></feFlood><feComposite in2="offsetBlur" operator="in"></feComposite><feMerge><feMergeNode></feMergeNode><feMergeNode in="SourceGraphic"></feMergeNode></feMerge></filter><filter id="filter-id-122" width="200%" height="200%" x="-50%" y="-50%"><feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="8"></feGaussianBlur><feOffset result="offsetBlur" dx="1" dy="15"></feOffset><feFlood flood-color="#ff4a00" flood-opacity="0.5"></feFlood><feComposite in2="offsetBlur" operator="in"></feComposite><feMerge><feMergeNode></feMergeNode><feMergeNode in="SourceGraphic"></feMergeNode></feMerge></filter><filter id="filter-id-128" width="200%" height="200%" x="-50%" y="-50%"><feGaussianBlur result="blurOut" in="SourceGraphic" stdDeviation="8"></feGaussianBlur><feOffset result="offsetBlur" dx="1" dy="15"></feOffset><feFlood flood-color="#ff4a00" flood-opacity="0.5"></feFlood><feComposite in2="offsetBlur" operator="in"></feComposite><feMerge><feMergeNode></feMergeNode><feMergeNode in="SourceGraphic"></feMergeNode></feMerge></filter></defs><g><g fill="#ffffff" fill-opacity="0"><rect width="869" height="300"></rect></g><g><g role="region" clip-path="url(#id-27)" opacity="1" aria-label="Chart"><g transform="translate(15,15)"><g><g><g><g><g><g><g style="touch-action: none; user-select: none; -webkit-user-drag: none;" transform="translate(45,0)"><g fill="#ffffff" fill-opacity="0"><rect width="794" height="232"></rect></g><g><g><g><g fill-opacity="0" stroke-opacity="0" stroke="#000000" stroke-width="1" transform="translate(0,348)" display="none"><path d=" M0,0  L-5,0 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0.15" fill="none" transform="translate(0,348)" display="none"><path d=" M0,0  L794,0 " transform="translate(-0.5,-0.5)"></path></g><g fill="#000000" fill-opacity="0" style="pointer-events: none;" display="none"><path d="M0,232 L0,232 L794,232 L794,232 L0,232"></path></g><g fill-opacity="0" stroke-opacity="0" stroke="#000000" stroke-width="1" transform="translate(0,290)" display="none"><path d=" M0,0  L-5,0 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0.15" fill="none" transform="translate(0,290)" display="none"><path d=" M0,0  L794,0 " transform="translate(-0.5,-0.5)"></path></g><g fill="#000000" fill-opacity="0" style="pointer-events: none;"><path d="M0,232 L0,232 L794,232 L794,232 L0,232"></path></g><g fill-opacity="0" stroke-opacity="0" stroke="#000000" stroke-width="1" transform="translate(0,232)"><path d=" M0,0  L-5,0 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0.15" fill="none" transform="translate(0,232)"><path d=" M0,0  L794,0 " transform="translate(-0.5,-0.5)"></path></g><g fill="#000000" fill-opacity="0" style="pointer-events: none;" display="none"><path d="M0,174 L0,232 L794,232 L794,174 L0,174"></path></g><g fill-opacity="0" stroke-opacity="0" stroke="#000000" stroke-width="1" transform="translate(0,174)"><path d=" M0,0  L-5,0 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0.15" fill="none" transform="translate(0,174)"><path d=" M0,0  L794,0 " transform="translate(-0.5,-0.5)"></path></g><g fill="#000000" fill-opacity="0" style="pointer-events: none;"><path d="M0,116 L0,174 L794,174 L794,116 L0,116"></path></g><g fill-opacity="0" stroke-opacity="0" stroke="#000000" stroke-width="1" transform="translate(0,116)"><path d=" M0,0  L-5,0 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0.15" fill="none" transform="translate(0,116)"><path d=" M0,0  L794,0 " transform="translate(-0.5,-0.5)"></path></g><g fill="#000000" fill-opacity="0" style="pointer-events: none;" display="none"><path d="M0,58 L0,116 L794,116 L794,58 L0,58"></path></g><g fill-opacity="0" stroke-opacity="0" stroke="#000000" stroke-width="1" transform="translate(0,58)"><path d=" M0,0  L-5,0 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0.15" fill="none" transform="translate(0,58)"><path d=" M0,0  L794,0 " transform="translate(-0.5,-0.5)"></path></g><g fill="#000000" fill-opacity="0" style="pointer-events: none;"><path d="M0,0 L0,58 L794,58 L794,0 L0,0"></path></g><g fill-opacity="0" stroke-opacity="0" stroke="#000000" stroke-width="1"><path d=" M0,0  L-5,0 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0.15" fill="none"><path d=" M0,0  L794,0 " transform="translate(-0.5,-0.5)"></path></g><g fill="#000000" fill-opacity="0" style="pointer-events: none;" display="none"><path d="M0,0 L0,0 L794,0 L794,0 L0,0"></path></g><g fill-opacity="0" stroke-opacity="0" stroke="#000000" stroke-width="1" transform="translate(0,-58)" display="none"><path d=" M0,0  L-5,0 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0.15" fill="none" transform="translate(0,-58)" display="none"><path d=" M0,0  L794,0 " transform="translate(-0.5,-0.5)"></path></g><g fill="#000000" fill-opacity="0" style="pointer-events: none;"><path d="M0,0 L0,0 L794,0 L794,0 L0,0"></path></g></g></g><g><g><g fill-opacity="0" stroke-opacity="0" stroke="#000000" stroke-width="1" transform="translate(56.715419999999995,232)"><path d=" M0,0  L0,5 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0" fill="none" transform="translate(56.715419999999995,0)"><path d=" M0,0  L0,232 " transform="translate(-0.5,-0.5)"></path></g><g fill="#000000" fill-opacity="0" opacity="0" style="pointer-events: none;" display="none"><path d="M0,0 L0,232 L226.85374000000002,232 L226.85374000000002,0 L0,0"></path></g><g fill-opacity="0" stroke-opacity="0" stroke="#000000" stroke-width="1" display="none" transform="translate(850.7154199999999,232)"><path d=" M0,0  L0,5 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0" fill="none" display="none" transform="translate(850.7154199999999,0)"><path d=" M0,0  L0,232 " transform="translate(-0.5,-0.5)"></path></g><g fill="#000000" fill-opacity="0" opacity="1" style="pointer-events: none;"><path d="M794,0 L794,232 L794,232 L794,0 L794,0"></path></g><g fill-opacity="0" stroke-opacity="0" stroke="#000000" stroke-width="1" transform="translate(283.56916,232)"><path d=" M0,0  L0,5 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0" fill="none" transform="translate(283.56916,0)"><path d=" M0,0  L0,232 " transform="translate(-0.5,-0.5)"></path></g><g fill="#000000" fill-opacity="0" opacity="1" style="pointer-events: none;"><path d="M226.85374000000002,0 L226.85374000000002,232 L453.71542,232 L453.71542,0 L226.85374000000002,0"></path></g><g fill-opacity="0" stroke-opacity="0" stroke="#000000" stroke-width="1" transform="translate(510.43084,232)"><path d=" M0,0  L0,5 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0" fill="none" transform="translate(510.43084,0)"><path d=" M0,0  L0,232 " transform="translate(-0.5,-0.5)"></path></g><g fill="#000000" fill-opacity="0" opacity="0" style="pointer-events: none;" display="none"><path d="M453.71542,0 L453.71542,232 L680.56916,232 L680.56916,0 L453.71542,0"></path></g><g fill-opacity="0" stroke-opacity="0" stroke="#000000" stroke-width="1" transform="translate(737.28458,232)"><path d=" M0,0  L0,5 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0" fill="none" transform="translate(737.28458,0)"><path d=" M0,0  L0,232 " transform="translate(-0.5,-0.5)"></path></g><g fill="#000000" fill-opacity="0" opacity="1" style="pointer-events: none;"><path d="M680.56916,0 L680.56916,232 L794,232 L794,0 L680.56916,0"></path></g></g></g><g><g><g role="group" stroke-opacity="1" fill-opacity="0" fill="#c4c2c3" stroke="#c4c2c3" aria-label="iphone" stroke-width="4" stroke-dasharray="10" id="id-105"><g><g clip-path="url(#id-110)"><g><g><g><g fill="#c4c2c3" fill-opacity="0" stroke="#c4c2c3" stroke-opacity="1" stroke-width="4" stroke-dasharray="10" style="pointer-events: none;"><g><g stroke-opacity="0"><path></path></g><g fill-opacity="0"><path d=" M56.5154,231.8  M56.7154,232  C79.4027,231.9994 124.7732,174.0002 170.1463,174 C215.5193,173.9998 238.1961,208.8001 283.5692,208.8 C328.9422,208.7999 351.6254,162.4 397,162.4 C442.3746,162.4 465.0578,208.8 510.4308,208.8 C555.8039,208.8 578.4807,162.3999 623.8537,162.4 C669.2268,162.4001 714.5973,220.3994 737.2846,220.4"></path></g></g></g></g></g></g></g><g></g></g></g><g role="group" stroke-opacity="1" fill-opacity="0" fill="#ff4a00" stroke="#ff4a00" aria-label="itouch" stroke-width="4" filter="url(#filter-id-122)" id="id-122"><g><g clip-path="url(#id-127)"><g><g><g><g fill="#ff4a00" fill-opacity="0" stroke="#ff4a00" stroke-opacity="1" stroke-width="4" style="pointer-events: none;"><g><g stroke-opacity="0"><path></path></g><g fill-opacity="0"><path d=" M56.5154,162.2  M56.7154,162.4  C79.4027,162.4006 124.7732,226.2005 170.1463,226.2 C215.5193,226.1995 238.1961,116.0006 283.5692,116 C328.9422,115.9994 351.6254,162.4008 397,162.4 C442.3746,162.3992 465.0578,34.7996 510.4308,34.8 C555.8039,34.8004 578.4807,202.9987 623.8537,203 C669.2268,203.0013 714.5973,162.4004 737.2846,162.4"></path></g></g></g></g></g></g></g><g></g></g></g></g></g><g clip-path="url(#id-326)"><g><g fill="#c4c2c3" stroke="#c4c2c3"><g></g></g><g filter="url(#filter-id-128)" fill="#ff4a00" stroke="#ff4a00"><g></g></g></g></g><g><g></g></g><g><g></g></g><g opacity="0" style="touch-action: none; user-select: none; -webkit-user-drag: none;" visibility="hidden"><g><g fill-opacity="0.2" fill="#000000" style="pointer-events: none;" opacity="0" visibility="hidden"><path></path></g><g stroke="#000000" fill="none" stroke-dasharray="3,3" stroke-opacity="0.4" style="pointer-events: none;" transform="translate(162.9,0)"><path d=" M0,0  L0,232 "></path></g><g stroke="#000000" fill="none" stroke-dasharray="3,3" stroke-opacity="0.4" style="pointer-events: none;" transform="translate(0,156.8)"><path d=" M0,0  L794,0 "></path></g></g></g><g role="button" focusable="true" opacity="0" visibility="hidden" transform="translate(754,-3)" aria-labelledby="id-19-title"><g fill="#6794dc" stroke="#ffffff" fill-opacity="1" stroke-opacity="0" transform="translate(0,8)"><path d="M17,0 L18,0 a17,17 0 0 1 17,17 L35,17 a17,17 0 0 1 -17,17 L17,34 a17,17 0 0 1 -17,-17 L0,17 a17,17 0 0 1 17,-17 Z"></path></g><g transform="translate(9,9)"><g stroke="#ffffff" style="pointer-events: none;" transform="translate(0,8)"><path d=" M0,0  L11,0 " transform="translate(2.5,7.5)"></path></g><g fill="#000000" style="pointer-events: none;" transform="translate(17,8)"><g display="none"></g></g></g><title id="id-19-title">Zoom Out</title></g></g></g><g><g><g><g><g fill="#000000" transform="translate(0,116) rotate(-90)"><g display="none"></g></g><g stroke="#000000" stroke-opacity="0.15" fill="none" transform="translate(45,232)"><path transform="translate(-0.5,-0.5)" d=" M0,0  L794,0 "></path></g><g transform="translate(0,0)"><g><g fill="#000000" fill-opacity="0" opacity="0" stroke-opacity="0" transform="translate(45,116)"><g transform="translate(-35,-9)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>250</tspan></text></g></g><g fill="#000000" transform="translate(45,348)" display="none"><g transform="translate(-40,-9)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>-100</tspan></text></g></g><g fill="#000000" transform="translate(45,290)" display="none"><g transform="translate(-32,-9)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>-50</tspan></text></g></g><g fill="#000000" transform="translate(45,232)"><g transform="translate(-19,-9)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>0</tspan></text></g></g><g fill="#000000" transform="translate(45,174)"><g transform="translate(-27,-9)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>50</tspan></text></g></g><g fill="#000000" transform="translate(45,116)"><g transform="translate(-35,-9)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>100</tspan></text></g></g><g fill="#000000" transform="translate(45,58)"><g transform="translate(-35,-9)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>150</tspan></text></g></g><g fill="#000000" transform="translate(45,0)"><g transform="translate(-35,-9)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>200</tspan></text></g></g><g fill="#000000" transform="translate(45,-58)" display="none"><g transform="translate(-35,-9)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>250</tspan></text></g></g></g></g><g stroke="#000000" stroke-opacity="0" fill="none" style="pointer-events: none;" transform="translate(45,0)"><path d=" M0,0  L0,232 " transform="translate(-0.5,-0.5)"></path></g></g></g></g></g><g transform="translate(839,0)"><g></g></g></g></g><g><g transform="translate(45,0)"></g></g><g transform="translate(0,232)"><g transform="translate(45,0)"><g><g><g stroke="#000000" stroke-opacity="0" fill="none" style="pointer-events: none;"><path d=" M0,0  L794,0 " transform="translate(-0.5,-0.5)"></path></g><g stroke="#000000" stroke-opacity="0.15" fill="none" display="none" transform="translate(794,-232)" opacity="0" visibility="hidden"><path transform="translate(-0.5,-0.5)" d=" M0,0  L0,232 "></path></g><g><g><g fill="#000000" fill-opacity="0" opacity="0" stroke-opacity="0" transform="translate(397,0)"><g transform="translate(-4,10)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>L</tspan></text></g></g><g fill="#000000" transform="translate(56.715419999999995,0)"><g transform="translate(-16.5,10)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>2010</tspan></text></g></g><g fill="#000000" display="none" transform="translate(850.7154199999999,0)"><g transform="translate(0,10)" display="none"></g></g><g fill="#000000" transform="translate(283.56916,0)"><g transform="translate(-16.5,10)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>2012</tspan></text></g></g><g fill="#000000" transform="translate(510.43084,0)"><g transform="translate(-16.5,10)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>2014</tspan></text></g></g><g fill="#000000" transform="translate(737.28458,0)"><g transform="translate(-16.5,10)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>2016</tspan></text></g></g></g></g><g fill="#000000" transform="translate(397,38)"><g display="none"></g></g></g></g></g></g></g></g></g></g></g></g><g><g><g filter="url(#filter-id-112)" role="tooltip" opacity="0" aria-describedby="id-105" transform="translate(230.14626,189)" visibility="hidden"><g fill="#c4c2c3" fill-opacity="0.9" stroke-width="1" stroke-opacity="1" stroke="#ffffff" style="pointer-events: none;" transform="translate(6,-15.5)"><path d="M3,0 L88,0 a3,3 0 0 1 3,3 L91,28 a3,3 0 0 1 -3,3 L3,31 a3,3 0 0 1 -3,-3 L0,28 L0,20.5 L-6,15.5 L0,10.5 L0,3 a3,3 0 0 1 3,-3"></path></g><g><g fill="#000000" style="pointer-events: none;" transform="translate(51.5,-15.5)"><g transform="translate(-33.5,7)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>iphone: </tspan><tspan style="font-weight:bold">50</tspan></text></g></g></g></g><g filter="url(#filter-id-129)" role="tooltip" opacity="0" aria-describedby="id-122" transform="translate(230.14626,241.2)" visibility="hidden"><g fill="#ff4a00" fill-opacity="0.9" stroke-width="1" stroke-opacity="1" stroke="#ffffff" style="pointer-events: none;" transform="translate(6,-24.7)"><path d="M3,0 L76,0 a3,3 0 0 1 3,3 L79,28 a3,3 0 0 1 -3,3 L3,31 a3,3 0 0 1 -3,-3 L0,28 L0,28 L-6,24.7 L0,18 L0,3 a3,3 0 0 1 3,-3"></path></g><g><g fill="#ffffff" style="pointer-events: none;" transform="translate(45.5,-24.7)"><g transform="translate(-27.5,7)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>itouch: </tspan><tspan style="font-weight:bold">5</tspan></text></g></g></g></g><g filter="url(#filter-id-29)" role="tooltip" visibility="hidden" opacity="0"><g fill="#ffffff" fill-opacity="0.9" stroke-width="1" stroke-opacity="1" stroke="#ffffff" style="pointer-events: none;" transform="translate(0,6)"><path d="M3,0 L3,0 L0,-6 L13,0 L21,0 a3,3 0 0 1 3,3 L24,10 a3,3 0 0 1 -3,3 L3,13 a3,3 0 0 1 -3,-3 L0,3 a3,3 0 0 1 3,-3"></path></g><g><g fill="#ffffff" style="pointer-events: none;" transform="translate(12,6)"><g transform="translate(0,7)" display="none"></g></g></g></g><g visibility="hidden" style="pointer-events: none;" display="none"><g fill="#ffffff" opacity="1"><rect width="869" height="300"></rect></g><g><g transform="translate(434.5,150)"><g><g stroke-opacity="1" fill="#f3f3f3" fill-opacity="0.8"><g><g><path d=" M53,0  a53,53,0,0,1,-106,0 a53,53,0,0,1,106,0 M42,0  a42,42,0,0,0,-84,0 a42,42,0,0,0,84,0 L42,0 "></path></g></g></g><g stroke-opacity="1" fill="#000000" fill-opacity="0.2"><g><g><path d=" M50,0  a50,50,0,0,1,-100,0 a50,50,0,0,1,100,0 M45,0  a45,45,0,0,0,-90,0 a45,45,0,0,0,90,0 L45,0 "></path></g></g></g><g fill="#000000" fill-opacity="0.4"><g transform="translate(-17.5,-9)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>100%</tspan></text></g></g></g></g></g></g><g opacity="0.3" aria-labelledby="id-47-title" filter="url(#filter-id-47)" style="cursor: pointer;" transform="translate(0,279)"><g fill="#ffffff" opacity="0"><rect width="66" height="21"></rect></g><g><g shape-rendering="auto" fill="none" stroke-opacity="1" stroke-width="1.7999999999999998" stroke="#3cabff"><path d=" M15,15  C17.4001,15 22.7998,15.0001 27,15 C31.2002,14.9999 33.2999,6 36,6 C38.7001,6 38.6999,10.5 40.5,10.5 C42.3001,10.5 42.2999,6 45,6 C47.7001,6 50.9999,14.9999 54,15 C57.0002,15.0001 58.7999,15 60,15"></path></g><g shape-rendering="auto" fill="none" stroke-opacity="1" stroke-width="1.7999999999999998" stroke="url(#gradient-id-50)"><path d=" M6,15  C8.2501,15 9.7498,15.0001 15,15 C20.2502,14.9999 20.7748,3.6 27,3.6 C33.2252,3.6 33.8998,14.9999 39.9,15 C45.9002,15.0001 45.9748,15 51,15 C56.0252,15 57.7499,15 60,15"></path></g></g><title id="id-47-title">Chart created using amCharts library</title></g><g role="tooltip" opacity="0" transform="translate(230.14229,247)" visibility="hidden"><g fill="#000000" fill-opacity="1" stroke-width="1" stroke-opacity="1" stroke="#000000" style="pointer-events: none;" transform="translate(-26.5,5)"><path d="M0,0 L21.5,0 L26.5,-5 L31.5,0 L53,0 a0,0 0 0 1 0,0 L53,28 a0,0 0 0 1 -0,0 L0,28 a0,0 0 0 1 -0,-0 L0,0 a0,0 0 0 1 0,-0"></path></g><g><g fill="#ffffff" style="pointer-events: none;" transform="translate(0,5)"><g transform="translate(-16.5,5)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>2011</tspan></text></g></g></g></g><g role="tooltip" opacity="0" transform="translate(60,171.8)" visibility="hidden"><g fill="#000000" fill-opacity="1" stroke-width="1" stroke-opacity="1" stroke="#000000" style="pointer-events: none;" transform="translate(-42,-14)"><path d="M0,0 L37,0 a0,0 0 0 1 0,0 L37,0 L37,9 L42,14 L37,19 L37,28 a0,0 0 0 1 -0,0 L0,28 a0,0 0 0 1 -0,-0 L0,0 a0,0 0 0 1 0,-0"></path></g><g><g fill="#ffffff" style="pointer-events: none;" transform="translate(-23.5,-14)"><g transform="translate(-8.5,5)" style="user-select: none;"><text x="0" y="18" dy="-3.6"><tspan>65</tspan></text></g></g></g></g></g></g></g></g></svg></div></div>
                                    </div>
                                </div>
                            </div>
                            <!-- 1st row Start -->
                        </div>
                        <div class="row">
                            <!-- 1st row Start -->
                            <div class="col-md-6">
                                <div class="card d-flex w-100 mb-4">
                                    <div class="row no-gutters row-bordered row-border-light h-100">
                                        <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">
                                            <div class="card-body media align-items-center text-dark">
                                                <i class="lnr lnr-diamond display-4 d-block text-primary"></i>
                                                <span class="media-body d-block ml-3"><span class="text-big mr-1 text-primary">$1584.78</span>
                                                    <br>
                                                    <small class="text-muted">Earned this month</small>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">
                                            <div class="card-body media align-items-center text-dark">
                                                <i class="lnr lnr-clock display-4 d-block text-warning"></i>
                                                <span class="media-body d-block ml-3"><span class="text-big"><span class="mr-1 text-warning">152</span>Working Hours</span>
                                                    <br>
                                                    <small class="text-muted">Spent this month</small>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">
                                            <div class="card-body media align-items-center text-dark">
                                                <i class="lnr lnr-hourglass display-4 d-block text-danger"></i>
                                                <span class="media-body d-block ml-3"><span class="text-big"><span class="mr-1 text-danger">54</span> Tasks</span>
                                                    <br>
                                                    <small class="text-muted">Completed this month</small>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">
                                            <div class="card-body media align-items-center text-dark">
                                                <i class="lnr lnr-license display-4 d-block text-success"></i>
                                                <span class="media-body d-block ml-3"><span class="text-big"><span class="mr-1 text-success">6</span> Projects</span>
                                                    <br>
                                                    <small class="text-muted">Done this month</small>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card mb-4 bg-pattern-3 bg-primary text-white">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="lnr lnr-cart display-4"></div>
                                                    <div class="ml-3">
                                                        <div class="small">Monthly sales</div>
                                                        <div class="text-large">2362</div>
                                                    </div>
                                                </div>
                                                <div id="order-chart-1" class="mt-3 chart-shadow" style="height: 70px; padding: 0px; position: relative;"><canvas class="flot-base" width="331" height="70" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 331.25px; height: 70px;"></canvas><canvas class="flot-overlay" width="331" height="70" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 331.25px; height: 70px;"></canvas></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-4 bg-pattern-3-dark">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="lnr lnr-gift display-4 text-primary"></div>
                                                    <div class="ml-3">
                                                        <div class="text-muted small">Products</div>
                                                        <div class="text-large">985</div>
                                                    </div>
                                                </div>
                                                <div id="ecom-chart-3" class="mt-3 chart-shadow-primary" style="height: 70px; padding: 0px; position: relative;"><canvas class="flot-base" width="331" height="70" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 331.25px; height: 70px;"></canvas><canvas class="flot-overlay" width="331" height="70" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 331.25px; height: 70px;"></canvas></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 1st row Start -->
                        </div>
              
                    </div>
                    <!-- [ content ] End -->

   
                    <!-- [ Layout footer ] End -->
                </div>
@endsection