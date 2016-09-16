<div class="container control-container">
    <div class="control-head">
        <h3 ng-show="vm.edit">编辑列表数据</h3><h3 ng-show="!vm.edit">新增列表数据</h3>
    </div>
    <div class="form-group flex-wrap">
        <label class="control-label">姓名:</label>
        <input type="text" class="form-control" ng-model="vm.item.name" placeholder="姓名">
    </div>
    <div class="form-group flex-wrap">
        <label class="control-label">移动电话:</label>
        <input type="text" class="form-control" ng-model="vm.item.tel" placeholder="移动电话">
    </div>
    <div class="form-group flex-wrap">
        <label class="control-label">投资金额:</label>
        <input type="text" class="form-control" ng-model="vm.item.money" placeholder="金额">
    </div>
    <div class="form-group flex-wrap">
        <label class="control-label">邀请码:</label>
        <input type="text" class="form-control" ng-model="vm.item.invite_code" placeholder="邀请码">
    </div>
    <div class="form-group flex-wrap">
        <label class="control-label">兑换码:</label>
        <input type="text" class="form-control" ng-model="vm.item.conversion_code" placeholder="兑换码">
    </div>
    <div class="form-group flex-wrap">
        <label class="control-label">备注:</label>
        <input type="text" class="form-control" ng-model="vm.item.BD" placeholder="备注">
    </div>
    <div class="form-group flex-wrap">
        <label class="control-label">登记时间:</label>
        <input type="text" class="form-control" ng-model="vm.item.create_time" placeholder="登记时间">
    </div>
    <div class="modal-footer" id="save">
        <button type="button" class="btn btn-primary" ng-click="vm.ajaxTmpl()">确定</button>
        <button type="button" class="btn btn-default"  ng-click="vm.cancel()">取消</button>
    </div>
</div>