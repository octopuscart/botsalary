

Admin.controller('pnlBudgetController', function ($scope, $http, $filter, $timeout) {
    $scope.pnlData = {
        "data": {"Income": [], "Expenditure": []},
        "Income": {},
        "Expenditure": {},
        "total": {"Income": 0, "Expenditure": 0},
    };

    var url = rootBaseUrl + "Api/pnl_notes_budget_edit/" + entry_month + "/" + entry_year;
    $scope.updateTotal = function () {
        var url = rootBaseUrl + "Api/pnl_notes_budget_edit/" + entry_month + "/" + entry_year;

        $http.get(url).then(function (rdata) {
            $scope.pnlData.total.Income = rdata.data.IncomeTotal;
            $scope.pnlData.total.Expenditure = rdata.data.ExpenditureTotal;

        });
    }

    $http.get(url).then(function (rdata) {
        $scope.pnlData.data.Income = rdata.data.Income;
        $scope.pnlData.data.Expenditure = rdata.data.Expenditure;
        $scope.pnlData.total.Income = rdata.data.IncomeTotal;
        $scope.pnlData.total.Expenditure = rdata.data.ExpenditureTotal;
        $timeout(function () {
            $(".editable").editable({success: function (data) {
                    $scope.updateTotal();
                }, });
        }, 2000);
    });
    $scope.calculations = function () {
        console.log($scope.pnlData.Income);
        $scope.pnlData.total.Income = 0;
        angular.forEach($scope.pnlData.Income, function (value) {
            if (value) {
                $scope.pnlData.total.Income += (value);
            }
        });
        $scope.pnlData.total.Expenditure = 0;
        angular.forEach($scope.pnlData.Expenditure, function (value) {
            if (value) {
                $scope.pnlData.total.Expenditure += (value);
            }
        });
    }

})



Admin.controller('pnlController', function ($scope, $http, $filter, $timeout) {
    $scope.pnlData = {
        "data": {},
        "Income": {},
        "Expenditure": {},
        "total": {"Income": 0, "Expenditure": 0},
    };
    var url = rootBaseUrl + "Api/pnl_notes";
    $http.get(url).then(function (rdata) {
        $scope.pnlData.data = rdata.data;
    });
    $scope.calculations = function () {
        console.log($scope.pnlData.Income);
        $scope.pnlData.total.Income = 0;
        angular.forEach($scope.pnlData.Income, function (value) {
            if (value) {
                $scope.pnlData.total.Income += (value);
            }
        });
        $scope.pnlData.total.Expenditure = 0;
        angular.forEach($scope.pnlData.Expenditure, function (value) {
            if (value) {
                $scope.pnlData.total.Expenditure += (value);
            }
        });
    }

})

Admin.controller('pnlControllerEdit', function ($scope, $http, $filter, $timeout) {
    $scope.pnlData = {
        "data": {"Income": [], "Expenditure": []},
        "Income": {},
        "Expenditure": {},
        "total": {"Income": 0, "Expenditure": 0},
    };

    var url = rootBaseUrl + "Api/pnl_notes_edit/" + entry_month + "/" + entry_year;
    $scope.updateTotal = function () {
        var url = rootBaseUrl + "Api/pnl_notes_edit/" + entry_month + "/" + entry_year;

        $http.get(url).then(function (rdata) {
            $scope.pnlData.total.Income = rdata.data.IncomeTotal;
            $scope.pnlData.total.Expenditure = rdata.data.ExpenditureTotal;

        });
    }

    $http.get(url).then(function (rdata) {
        $scope.pnlData.data.Income = rdata.data.Income;
        $scope.pnlData.data.Expenditure = rdata.data.Expenditure;
        $scope.pnlData.total.Income = rdata.data.IncomeTotal;
        $scope.pnlData.total.Expenditure = rdata.data.ExpenditureTotal;
        $timeout(function () {
            $(".editable").editable({success: function (data) {
                    $scope.updateTotal();
                }, });
        }, 2000);
    });
    $scope.calculations = function () {
        console.log($scope.pnlData.Income);
        $scope.pnlData.total.Income = 0;
        angular.forEach($scope.pnlData.Income, function (value) {
            if (value) {
                $scope.pnlData.total.Income += (value);
            }
        });
        $scope.pnlData.total.Expenditure = 0;
        angular.forEach($scope.pnlData.Expenditure, function (value) {
            if (value) {
                $scope.pnlData.total.Expenditure += (value);
            }
        });
    }

})