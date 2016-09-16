<!DOCTYPE html>
<html lang="en" ng-app="userInfo">
<head>
    <meta charset="UTF-8">
    <title>操作界面</title>

    <link rel="stylesheet" href="lib/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="lib/css/angular-material.min.css" type="text/css">

    <script type="text/javascript" src="lib/js/jquery.min.js"></script>
    <script type="text/javascript" src="lib/js/angular.min.js"></script>
    <script type="text/javascript" src="lib/js/angular-aria.min.js"></script>
    <script type="text/javascript" src="lib/js/angular-animate.min.js"></script>
    <script type="text/javascript" src="lib/js/angular-material.min.js"></script>
    <script type="text/javascript" src="lib/js/angular-ui-router.min.js"></script>
    <script type="text/javascript" src="lib/js/angular-file-upload.min.js"></script>
    <script type="text/javascript" src="lib/js/ui-bootstrap-tpls-1.3.2.js"></script>
    <style>
        .flex-wrap{
            display: flex;
        }
        .form-search{
            margin:15px 0 10px 0;
            height:32px;
            width:100%;
            border:1px solid #e1e1e1;
            border-radius:15px;
            padding:5px;
        }
        .search-input-wrap{
            display:inline-block;
            margin-right: 10px;
            position:relative;
            width: 20%;
        }
        .table{
            margin-bottom: 0;
        }
        .clear{
            overflow: auto;
        }
        .icon-clear{
            cursor: pointer;
            position:absolute;
            top:35.5%;
            left:78%;
            width:20px;
            height:20px;
            background: url(images/icon_more.png) no-repeat 50% 98%;
        }
        .icon-search{
            cursor:pointer;
            position:absolute;
            top:32%;
            left:85%;
            width:30px;
            height:30px;
            background: url(images/icon_setting.png) no-repeat 50% 63%;
        }
        .btn-custom{
            height:30px;
            margin:15px 5px 0 0;
        }
        .toast{
            height:48px; min-width:130px; opacity:1; color:#000; box-shadow:none; white-space:nowrap; transition:transform 0s;
            padding:0;
        .md-toast-content{background-color:#fff;border:1px solid #ccc; border-radius:2px; }
        .material-icons{
            background:no-repeat; font-size:0;
        }
        .right-toast{left:100%; top:50%; transform:translate3d(15px,-50%,0) rotateZ(0deg); }
        .left-toast{left:-15px; top:50%; transform:translate3d(-100%,-50%,0) rotateZ(0deg); }
        .top-toast{left:50%; top:-15px; transform:translate3d(-50%,-100%,0) rotateZ(0deg); }
        .bottom-toast{left:50%; top:100%; transform:translate3d(-50%,15px,0) rotateZ(0deg); }
        .center-toast{left: 50%; top: 50%; transform :translate(-50%,-50%);}
        .danger-toast .material-icons{background-position:-18px -340px; }
        .info-toast .material-icons{background-position:-18px -285px; }
        }
        .pagination-wrap{
            float:right;
        }

        /*弹窗css*/
        .control-container{
            width:1000px
        }
        .control-head{
            height:38px;
            font-size:16px;
            border-bottom:1px solid #f2f2f2;
            margin : 0 0 10px ;
        }
        .control-label{
            width: 80px;
            padding:5px 10px 0 0;
            margin-bottom:0;
        }

        /*errorTip*/
        .errorWrap{
            background-color:#fff;
        }
        .errorTip{
            text-align:center;
            font-size:18px;
            padding:20px;
            color:#fe4f5d;
        }
    </style>
</head>
<body>
    <div class="container jumbotron" ng-controller="ctrl.userInfo">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <h1>登记用户操作表</h1>
                    <cite>Web side r&d engineers TomZhou</cite>
                </div>
                <div class="flex-wrap">
                    <div class="search-input-wrap">
                        <input type="text" class="form-search" ng-model="vm.params.title">
                        <div class="icon-clear" ng-click="vm.clear()" ng-show="vm.params.title"></div>
                        <div class="icon-search" ng-click="vm.search()"></div>
                    </div>
                    <button class="btn btn-primary btn-sm btn-custom" ng-click="vm.editCheckAll()">全选</button>
                    <button id="delete" class="btn btn-default btn-sm btn-custom" ng-click="vm.delList(vm.list)">全部删除</button>
                    <button id="save" class="btn btn-primary btn-sm btn-custom" ng-click="vm.editList()">新增数据</button>
                    <button id="upload" class="btn btn-primary btn-sm btn-custom" ng-file-select="vm.uploadExcel($files)">批量上传</button>
                    <a href="/userInfo/downloadExcel" class="btn btn-primary btn-sm btn-custom">打印表格</a>
                </div>
                <div class="thumbnail clear">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <td><strong>###</strong></td>
                                <td><strong>序号</strong></td>
                                <td><strong>姓名</strong></td>
                                <td><strong>移动电话</strong></td>
                                <td><strong>投资金额</strong></td>
                                <td><strong>邀请码</strong></td>
                                <td><strong>兑换码</strong></td>
                                <td><strong>备注</strong></td>
                                <td><strong>登记时间</strong></td>
                                <td><strong>操作</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in vm.list">
                                <td>
                                    <input class="checkbox" type="checkbox" ng-model="item.checked" aria-label="check">
                                </td>
                                <td>{{item.id}}</td>
                                <td>{{item.name}}</td>
                                <td>{{item.tel}}</td>
                                <td>{{item.money}}</td>
                                <td>{{item.invite_code}}</td>
                                <td>{{item.conversion_code}}</td>
                                <td>{{item.BD}}</td>
                                <td>{{item.create_time}}</td>
                                <td>
                                    <button id="save_{{item.id}}" class="btn btn-primary btn-sm" ng-click="vm.editList(item, $index)">编辑</button>
                                    <button id="delete_{{item.id}}" class="btn btn-default btn-sm" ng-click="vm.delList(item.id, $index)">删除</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div ng-show="vm.errorTip && !vm.list[0]" class="errorWrap">
                        <p class="errorTip">{{vm.errorTip}}</p>
                    </div>
                    <div class="pagination-wrap" ng-show="vm.page.num > 1 && vm.list[0]">
                        <uib-pagination total-items="vm.page.len" ng-model="vm.page.cur" ng-model="tag.id" boundary-links="true"
                                        max-size="vm.page.maxSize" class="pagination-sm" rotate="false"
                                        num-pages="numPages" items-per-page="vm.page.size"
                                        first-text="首页" previous-text="上一页" next-text="下一页"
                                        last-text="末页">
                        </uib-pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        angular.module('userInfo', ['ngMaterial', 'ui.bootstrap', 'angularFileUpload'])
            .run(['$templateCache', function( $templateCache ){
                $templateCache.put( "tpls/toast-tpl.html",
                    '<md-toast class="toast {{type}}-toast {{position}}-toast" ng-style="style">' +
                    '<md-icon>icon</md-icon>' +
                    '<span flex>{{msg}}</span>' +
                    '</md-toast>' );
            }])
            .factory('myUtils', ['$mdToast','$document','$mdDialog', function ($mdToast, $document, $mdDialog) {
                return {
                    toast : function( options, cbk ){
                        if ( !options.msg ) {
                            return false;
                        }
                        var mdToast = $mdToast.show({
                            templateUrl : 'tpls/toast-tpl.html',
                            parent : $document[0].querySelector( options.posId ),
                            position : options.position || 'top',
                            hideDelay : options.hideDelay || 1500,
                            controller : ['$scope', function( $scope ){
                                $scope.msg = options.msg;
                                $scope.type = options.type || 'danger';
                                $scope.position = options.position || 'top';
                                var style = {};
                                options.left && (style.left = options.left);
                                options.top && (style.top = options.top);
                                options.right && (style.right = options.right);
                                options.bottom && (style.bottom = options.bottom);
                                options.center && (style.center = options.center);
                                $scope.style = style;
                            }]
                        });
                        mdToast.then(function( data ){
                            angular.isFunction( cbk ) && cbk();
                        });
                    },
                    confirm : function ( options, cbk ) {
                        if ( !options.msg ) {
                            return false;
                        }
                        var confirm = $mdDialog.confirm()
                            .title( options.title || '提示' )
                            .content( options.msg )
                            .ariaLabel('ConfirmTip')
                            .ok( options.ok || '确定' )
                            .cancel( options.cancel || '取消'  )
                            .css( options.css || 'confirmTip' );
                        $mdDialog.show( confirm ).then(function() {
                            angular.isFunction( cbk ) && cbk( true );
                        }, function() {
                            angular.isFunction( cbk ) && cbk( false );
                        });
                    }
                }
            }])
            .controller('ctrl.userInfo', ['$scope', '$mdDialog', '$http', '$upload', 'myUtils', pageCtrl])
            .controller('ctrl.editList', ['$scope', '$mdDialog', '$http', 'item', 'myUtils', editListCtrl])
        
        function editListCtrl($scope, $mdDialog, $http, item, myUtils) {
            var vm = $scope.vm = {};
            angular.extend(vm, {
                init : function () {
                    if (item) {
                        vm.item = angular.copy(item);
                        vm.edit = true;
                    }
                },
                toastError : function (msg) {
                      myUtils.toast({
                          msg : msg,
                          posId : '#save',
                          left : '-40px',
                          bottom : '35px'
                      })
                },
                ajaxTmpl : function () {
                    var msg = '';
                    if (!vm.item.name) {
                        msg = '姓名必填';
                        vm.toastError(msg);
                        return false;
                    }
                    if (!vm.item.tel) {
                        msg = '移动电话必填';
                        vm.toastError(msg);
                        return false;
                    }
                    if (!vm.item.invite_code) {
                        msg = '邀请码必填';
                        vm.toastError(msg);
                        return false;
                    }
                    if (!vm.item.conversion_code) {
                        msg = '兑换码必填';
                        vm.toastError(msg);
                        return false;
                    }
                    var url = vm.edit ? '/userInfo/update' : '/userInfo/insert';
                    $http({
                        method : 'POST',
                        url : url,
                        params : vm.item
                    }).success(function (data) {
                        if (data && data.ErrorText || data.ErrorCode) {
                            myUtils.toast({
                                msg : data.ErrorText || '访问错误',
                                posId : '#save'
                            }, function () {
                                myUtils.cancel();
                            });
                            return false;
                        }
                        if (data && !vm.edit) {
                            myUtils.toast({
                                msg : '新增成功',
                                posId : '#save',
                                type : 'info',
                                left : '-40px',
                                bottom : '35px'
                            }, function () {
                                $mdDialog.hide(data);
                            })
                        }
                        if (data && data.success && vm.edit) {
                            myUtils.toast({
                                msg : '修改成功',
                                posId : '#save_' + vm.item.id,
                                type : 'info',
                                left : '-40px',
                                bottom : '35px'
                            }, function () {
                                $mdDialog.hide(vm.item);
                            })
                        }
                    })
                },
                cancel : function () {
                    $mdDialog.cancel();
                }
            });
            vm.init();
        }
        
        function pageCtrl($scope, $mdDialog, $http, $upload, myUtils) {
            var vm = $scope.vm = {};
            angular.extend(vm, {
                init : function () {
                    vm.params.count = vm.page.size;
                    $scope.$watch('vm.page.cur', function (page, oldPage) {
                        vm.params.page = vm.page.cur;
                        vm.getList();
                    });
                },
                params : {
                    title : ''
                },
                page : {
                    cur : 1,
                    maxSize : 3,
                    size : 20,
                    firstText :'首页',
                    previousText : '上一页',
                    nextText : '下一页',
                    lastText : '末页'
                },
                checkAll : false,
                search : function () {
                    vm.params.page = vm.page.cur = 1;
                    vm.getList();
                },
                clear : function () {
                    vm.params.title = '';
                    vm.getList();
                },
                editCheckAll : function () {
                    angular.forEach(vm.list, function (vv, kk) {
                        if (!vm.checkAll) {
                            vv.checked = true;   
                        } else {
                            vv.checked = false;
                        }
                    });
                    vm.checkAll = !vm.checkAll;
                },
                getList : function () {
                    $http({
                        method : 'GET',
                        url : '/userInfo/lists',
                        params : vm.params
                    })
                    .success(function (data) {
                        if (data && data.ErrorCode || data.ErrorText) {
                            vm.errorTip = data.ErrorText || '访问错误';
                            return false;
                        }
                        if (data.data && $.isArray(data.data) && data.data[0]) {
                            vm.list = data.data;
                            if (data.pageInfo) {
                                vm.page.len = data.pageInfo.total;
                                vm.page.num = Math.ceil( vm.page.len/vm.page.size );
                            }
                        } else {
                            vm.errorTip = '暂无数据';
                            vm.list = [];
                            vm.page.len = 0;
                            vm.page.num = 0;
                        }
                    }, function () {
                        vm.errorTip = '暂无数据';
                        vm.list = [];
                    })
                },
                editList : function (item, index) {
                    $mdDialog.show({
                        controller : 'ctrl.editList',
                        templateUrl : '/edit',
                        locals : {item : item},
                        clickOutsideToClose : true
                    }).then(function (data) {
                        if (!index && index !== 0) {
                            vm.list.unshift(data);
                        } else {
                            vm.list[index] = data;
                        }
                    })
                },
                delList : function (item, index) {
                    var ids = [];
                    var delId = '';
                    var getList = [];
                    if ($.isArray(item)) {
                        angular.forEach(item, function (vv, kk) {
                            if (vv.checked) {
                                ids.push(parseInt(vv.id));
                            }
                        });
                        delId = ids.join(',');
                    } else if (item) {
                        delId = item;
                    }
                    myUtils.confirm(
                        {msg : '确认删除这些列表数据吗'}, 
                        function (del) {
                            if (del) {
                                $http({
                                    method : 'GET',
                                    url : '/userInfo/delete',
                                    params : {id : delId}
                                }).success(function (data) {
                                    if (data && data.ErrorCode || data.ErrorTode) {
                                        myUtils.toast({
                                            msg : data.ErrorText || '访问错误',
                                            posId : '#delete',
                                            left : '-40px',
                                            bottom : '35px'
                                        })
                                    }
                                    if (data && data.success) {
                                        myUtils.toast({
                                            msg : '删除成功',
                                            posId : $.isArray(item) ? '#delete' : '#delete_' + item,
                                            type : 'info',
                                            left : '-40px',
                                            bottom : '35px'
                                        }, function () {
                                            if ($.isArray(item)) {
                                                angular.forEach(vm.list, function (vv, kk) {
                                                    if ($.inArray(vv.id, ids) < 0) {
                                                        getList.push(vv);
                                                    }
                                                    vm.list = getList;
                                                    if (vm.list.length === 0) {
                                                        vm.errorTip = '暂无数据';
                                                    }
                                                })
                                            } else {
                                                vm.list.splice(index, 1);
                                            }
                                        })
                                    }
                                }, function () {
                                    myUtils.toast({
                                        msg : '访问错误',
                                        posId : '#delete'
                                    })
                                })
                            }
                        });
                },
                uploadExcel : function ($file) {
                    var file = $file[0];
                    $upload.upload({
                        url : '/userInfo/uploadExcel',
                        file : file,
                        fileFormDataName : 'Filedata'
                    }).success(function (data) {
                        if (data && data.ErrorText || data.ErrorCode) {
                            myUtils.toast({
                                msg: '上传失败',
                                posId : '#save',
                                left : '-40px',
                                bottom : '35px'
                            })
                        }
                        if (data && data.success) {
                            myUtils.toast({
                                msg : '上传成功',
                                posId : '#save',
                                type : 'info',
                                left : '-40px',
                                bottom : '35px'
                            })
                        }
                    }, function () {
                        myUtils.toast({
                            msg: '访问错误',
                            posId : '#save'
                        })
                    })
                }
            });
            vm.init();
        }
    </script>
</body>
</html>